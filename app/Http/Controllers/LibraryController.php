<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Events\PeminjamanBaruEvent;

class LibraryController extends Controller
{
    // 1. PROSES OTENTIKASI: LOGIN OTOMATIS (Username untuk Admin, Email untuk Mahasiswa)
    public function prosesLogin(Request $request)
    {
        $request->validate([
            'login_input' => ['required', 'string'], // Menggunakan satu input field di form HTML
            'password'    => ['required', 'string'],
        ]);

        // Cek apakah inputan berbentuk email atau username biasa
        $fieldType = filter_var($request->login_input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Susun credentials pasangannya
        $credentials = [
            $fieldType => $request->login_input,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Pengalihan jalur (Redirect) berbasis Role setelah berhasil masuk
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Lempar ke Dashboard Admin
            }
            
            return redirect()->intended('dashboard'); // Lempar ke Dashboard Mahasiswa
        }

        return redirect()->back()->withErrors([
            'login_error' => 'Kombinasi Email/Username atau Password salah.',
        ])->withInput($request->only('login_input'));
    }

    // 2. PROSES LOGOUT
    public function prosesLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    // 3. HALAMAN DASHBOARD MAHASISWA
    public function dashboard()
    {
        $totalBuku = Book::count();
        $totalAnggota = User::count(); 
        $hariIni = Carbon::today();

        $bukuDipinjam = Borrowing::whereIn('status', ['Dipinjam', 'Pending'])->count();

        $terlambat = Borrowing::where('status', 'Dipinjam')
            ->where('tenggat_kembali', '<', $hariIni->toDateString())
            ->count();

        $aktivitas_terbaru = Borrowing::with(['user', 'book'])
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        return view('dashboard', compact('totalBuku', 'bukuDipinjam', 'totalAnggota', 'terlambat', 'aktivitas_terbaru'));
    }

    // 4. HALAMAN KATALOG
    public function katalog(Request $request)
    {
        $search = $request->input('search');
        $query = Book::query();

        if ($search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
        }

        $booksGrouped = $query->get()->groupBy('genre');
        return view('katalog', compact('booksGrouped'));
    }

    // 5. HALAMAN PEMINJAMAN MAHASISWA (Dengan Hitungan Denda Pasif & Sisa Hari)
    public function peminjaman()
    {
        $userId = Auth::id(); 
        $hariIni = Carbon::today();
        $tarifDendaPerHari = 1000; 

        // KOTAK ATAS: Buku aktif di tangan (Belum diajukan pulang lewat tanggal dummy 1970)
        $peminjaman_aktif = Borrowing::where('user_id', $userId)
            ->whereIn('status', ['Dipinjam', 'Pending'])
            ->whereNull('tanggal_kembali') 
            ->with('book')
            ->get()
            ->map(function($loan) use ($hariIni, $tarifDendaPerHari) {
                $tenggat = Carbon::parse($loan->tenggat_kembali);
                $loan->sisa_hari = $hariIni->diffInDays($tenggat, false);
                
                if ($loan->status == 'Dipinjam' && $hariIni->gt($tenggat)) {
                    $loan->denda_berjalan = $hariIni->diffInDays($tenggat) * $tarifDendaPerHari;
                } else {
                    $loan->denda_berjalan = 0;
                }
                return $loan;
            });

        $totalDenda = $peminjaman_aktif->sum('denda_berjalan');

        // TABEL BAWAH: Riwayat Selesai ATAU Antrean Cek Fisik (Pending + 1970)
        $riwayat_peminjaman = Borrowing::where('user_id', $userId)
            ->where(function($query) {
                $query->where('status', 'Selesai')
                      ->orWhere(function($q) {
                          $q->where('status', 'Pending')->whereNotNull('tanggal_kembali');
                      });
            })
            ->with('book')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('peminjaman', compact('peminjaman_aktif', 'riwayat_peminjaman', 'totalDenda'));
    }

    // 6. FITUR MAHASISWA: AJAX PINJAM BUKU (Masa Karantina 1 Hari)
    public function pinjamBuku($id)
    {
        $userId = Auth::id(); 
        $buku = Book::findOrFail($id);

        if ($buku->stok <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, stok fisik buku "' . $buku->judul . '" di rak sudah habis!'
            ], 400);
        }

        // Validasi Karantina 24 Jam
        $karantinaAktif = Borrowing::where('user_id', $userId)
            ->where('book_id', $id)
            ->where('status', 'Selesai')
            ->where('tanggal_kembali', '>=', now()->subDays(1)->format('Y-m-d'))
            ->exists();

        if ($karantinaAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Buku ini baru saja kamu kembalikan. Sistem memberlakukan masa karantina 1 hari untuk pengecekan admin sebelum kamu bisa meminjam judul yang sama kembali!'
            ], 400);
        }

        $sudahPinjam = Borrowing::where('user_id', $userId)
            ->where('book_id', $id)
            ->whereIn('status', ['Pending', 'Dipinjam'])
            ->exists();

        if ($sudahPinjam) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah memesan atau memiliki transaksi aktif untuk judul buku ini!'
            ], 400);
        }

        $buku->decrement('stok'); 
        if ($buku->stok == 0) {
            $buku->update(['status' => 'Dipinjam']);
        }

        // Proses simpan data transaksi ke database MySQL
        $borrowing = Borrowing::create([
            'user_id' => $userId,
            'book_id' => $buku->id,
            'tanggal_pinjam' => now()->format('Y-m-d'),
            'tenggat_kembali' => now()->addDays(14)->format('Y-m-d'), 
            'status' => 'Pending' 
        ]);

        // JANTUNG REAL-TIME: Pancarkan sinyal reservasi baru ke udara seketika!
        event(new PeminjamanBaruEvent($borrowing));

        return response()->json([
            'success' => true,
            'message' => 'Permintaan pinjam "' . $buku->judul . '" berhasil!'
        ]);
    }

    // 7. FITUR MAHASISWA: AJUKAN PENGEMBALIAN BUKU (Kunci Antrean 1970)
    public function kembalikanBuku($id)
    {
        $peminjaman = Borrowing::findOrFail($id);
        $peminjaman->update([
            'status' => 'Pending',
            'tanggal_kembali' => '1970-01-01' 
        ]);

        return redirect()->back();
    }

    // 8. FITUR ADMIN: VERIFIKASI FISIK BUKU SUDAH DI RAK
    public function konfirmasiPengembalianFisik($id)
    {
        $peminjaman = Borrowing::findOrFail($id);

        if (!($peminjaman->status === 'Pending' && $peminjaman->tanggal_kembali === '1970-01-01')) {
            return response()->json([
                'success' => false, 
                'message' => 'Transaksi tidak dalam posisi pengajuan pengembalian fisik.'
            ], 400);
        }

        $peminjaman->update([
            'status' => 'Selesai',
            'tanggal_kembali' => now()->format('Y-m-d')
        ]);

        $buku = Book::findOrFail($peminjaman->book_id);
        $buku->increment('stok');
        $buku->update(['status' => 'Tersedia']);

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi berhasil! Status selesai dan stok pulih.'
        ], 200);
    }

    // 9. HALAMAN DASHBOARD UTAMA ADMIN (Mengirim data statistik lengkap)
    public function adminDashboard()
    {
        $totalBuku = Book::count();
        $totalAnggota = User::count(); 
        $hariIni = \Carbon\Carbon::today();

        // Menghitung seluruh buku yang sedang dipinjam atau pending di sistem perpustakaan
        $bukuDipinjam = Borrowing::whereIn('status', ['Dipinjam', 'Pending'])->count();

        // Menghitung berapa banyak transaksi global yang sudah melewati tenggat
        $terlambat = Borrowing::where('status', 'Dipinjam')
            ->where('tenggat_kembali', '<', $hariIni->toDateString())
            ->count();

        // Mengambil 3 aktivitas sirkulasi terbaru dari mahasiswa mana saja (Global)
        $aktivitas_terbaru = Borrowing::with(['user', 'book'])
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        return view('admin.dashboard', compact('totalBuku', 'bukuDipinjam', 'totalAnggota', 'terlambat', 'aktivitas_terbaru'));
    }

    // 12. HALAMAN KATALOG MASTER BUKU (SISI ADMIN)
    public function katalogAdmin()
    {
        // Mengambil semua koleksi buku dan dikelompokkan berdasarkan genre
        $booksGrouped = Book::all()->groupBy('genre');
        
        return view('admin.katalog', compact('booksGrouped'));
    }

    // // 📝 UPDATE_STOK_ADMIN: Aksi Cepat Mengubah Jumlah Buku di Rak

    public function updateStokBuku(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        $buku = Book::findOrFail($id);
        
        // Update jumlah stok fisik dan sesuaikan status ketersediaan secara otomatis
        $buku->update([
            'stok' => $request->stok,
            'status' => $request->stok > 0 ? 'Tersedia' : 'Habis'
        ]);

        return response()->json([
            'success' => true,
            'message' => "Stok buku '{$buku->judul}' berhasil diperbarui menjadi {$request->stok} buah!"
        ]);
    }

    // // 🔎 CUT_HERE_VERIFIKASI_ADMIN: Pengolah Data Antrean Sirkulasi Buku

    public function verifikasiSirkulasi()
    {
        // 📥 Ambil antrean pengambilan buku (Status Pending, tanggal_kembali masih kosong)
        $antrean_ambil = \App\Models\Borrowing::where('status', 'Pending')
            ->whereNull('tanggal_kembali')
            ->with(['user', 'book'])
            ->get();

        // 📤 Ambil antrean pengembalian buku fisik (Status Pending, dikunci tanggal dummy 1970-01-01)
        $antrean_kembali = \App\Models\Borrowing::where('status', 'Pending')
            ->where('tanggal_kembali', '1970-01-01')
            ->with(['user', 'book'])
            ->get();

        return view('admin.verifikasi', compact('antrean_ambil', 'antrean_kembali'));
    }

    // // 📥 SERAHKAN_BUKU_FISIK: Aksi Tombol Mengubah Pending -> Dipinjam

    public function setujuiPeminjaman($id)
    {
        $peminjaman = \App\Models\Borrowing::findOrFail($id);

        if ($peminjaman->status !== 'Pending') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi ini tidak sedang dalam antrean pengambilan.'
            ], 400);
        }

        // Ubah status transaksi menjadi resmi 'Dipinjam' oleh mahasiswa
        $peminjaman->update([
            'status' => 'Dipinjam',
            'tanggal_pinjam' => now()->format('Y-m-d'),
            'tenggat_kembali' => now()->addDays(14)->format('Y-m-d')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Buku fisik berhasil diserahkan! Status kini resmi "Dipinjam".'
        ], 200);
    }

    // // 👥 ANGGOTA MANAGEMENT: Mengelola Basis Data Akun Mahasiswa Riil         // //

    public function anggotaAdmin()
    {
        // 1. Ambil semua user yang memiliki role 'mahasiswa' dari database
        $mahasiswa = \App\Models\User::where('role', 'mahasiswa')
            ->withCount(['borrowings' => function($query) {
                // Menghitung jumlah peminjaman yang berstatus aktif 'Dipinjam' saja
                $query->where('status', 'Dipinjam');
            }])
            ->get();

        // 2. Lempar data mahasiswa ke halaman view anggota admin
        return view('admin.anggota', compact('mahasiswa'));
    }

    // 📊 LAPORAN & DENDA: Audit Sirkulasi & Perhitungan Denda Otomatis  

    public function laporanAdmin()
    {
        // 1. Ambil semua transaksi yang SUKSES dikembalikan oleh mahasiswa (Status Selesai)
        $riwayat_selesai = \App\Models\Borrowing::where('status', 'Selesai')
            ->with(['user', 'book'])
            ->orderBy('updated_at', 'desc')
            ->get();

        // 2. Ambil semua transaksi aktif (Dipinjam) yang SUDAH MELEBIHI TENGGAT HARI INI (Kritis/Terlambat)
        $riwayat_terlambat = \App\Models\Borrowing::where('status', 'Dipinjam')
            ->where('tenggat_kembali', '<', now()->format('Y-m-d'))
            ->with(['user', 'book'])
            ->get();

        // Ketetapan tarif denda perpustakaan kelompokmu (Misal: Rp 1.000 per hari keterlambatan)
        $tarif_denda = 1000;

        return view('admin.laporan', compact('riwayat_selesai', 'riwayat_terlambat', 'tarif_denda'));
    }

    // 📊 13. ENDPOINT OTOMASI N8N: Menyaring akun mahasiswa H-1 tenggat kembali
    public function cekTenggatPeminjaman()
    {
        // Menghitung parameter tanggal besok hari secara dinamis menggunakan Carbon
        $besokHari = \Carbon\Carbon::tomorrow()->toDateString();

        // Mengambil semua data transaksi yang statusnya masih 'Dipinjam'
        // dan memiliki tanggal tenggat_kembali tepat pada hari besok (Sisa 1 Hari)
        $dataKritis = \App\Models\Borrowing::with(['user', 'book'])
            ->where('status', 'Dipinjam')
            ->where('tenggat_kembali', $besokHari)
            ->get()
            ->map(function ($loan) {
                // Menyusun payload data bersih agar mudah dibaca oleh Node n8n
                return [
                    'id_transaksi'    => $loan->id,
                    'nama_mahasiswa'  => $loan->user->name,
                    'email_mahasiswa' => $loan->user->email,
                    'judul_buku'      => $loan->book->judul,
                    'tenggat_kembali' => \Carbon\Carbon::parse($loan->tenggat_kembali)->format('d-m-Y'),
                    'sisa_hari'       => 1,
                ];
            });

        // Mengembalikan data saringan dalam bentuk format JSON bersih ke platform n8n
        return response()->json([
            'success'     => true,
            'total_data'  => $dataKritis->count(),
            'data_pemicu' => $dataKritis
        ], 200);
    }

} 