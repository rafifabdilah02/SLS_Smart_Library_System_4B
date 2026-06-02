<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LibrarySirkulasiTest extends TestCase
{
    use RefreshDatabase; 

    protected $admin;
    protected $mahasiswa;
    protected $buku;

    /**
     * SETUP URUTAN DATA AWAL SEBELUM EMULASI TEST
     */
    protected function setUp(): void
    {
        parent::setUp();

        // 1. Buat Dummy Akun Admin (Menggunakan Hash::make resmi)
        $this->admin = User::create([
            'name' => 'Petugas Admin',
            'username' => 'admin_perpus',
            'email' => 'admin@sls.com',
            'password' => Hash::make('admin123'), 
            'role' => 'admin'
        ]);

        // 2. Buat Dummy Akun Mahasiswa
        $this->mahasiswa = User::create([
            'name' => 'Amanda Putri',
            'username' => 'amanda_putri',
            'email' => 'putriauliyaamanda22@gmail.com',
            'password' => Hash::make('123456789'), 
            'role' => 'mahasiswa'
        ]);

        // 3. Buat Dummy Koleksi Buku
        $this->buku = Book::create([
            'judul' => 'Harry Potter dan Batu Bertuah',
            'penulis' => 'J.K. Rowling',
            'genre' => 'Fantasy',
            'stok' => 3,
            'status' => 'Tersedia',
            'cover' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f'
        ]);
    }

    /**
     * 🔐 TEST 1: AUTENTIKASI MULTI-IDENTITAS (LOGIN MAHASISWA VIA EMAIL)
     */
    public function test_mahasiswa_bisa_login_menggunakan_email()
    {
        $response = $this->post('/login', [
            'login_input' => 'putriauliyaamanda22@gmail.com',
            'password' => '123456789'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard'); 
        $this->assertAuthenticatedAs($this->mahasiswa);
    }

    /**
     * 🔐 TEST 2: AUTENTIKASI MULTI-IDENTITAS (LOGIN ADMIN VIA USERNAME)
     */
    public function test_admin_bisa_login_menggunakan_username()
    {
        $response = $this->post('/login', [
            'login_input' => 'admin_perpus',
            'username'    => 'admin_perpus',
            'email'       => 'admin_perpus',
            'password' => 'admin123'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.dashboard')); 
        $this->assertAuthenticatedAs($this->admin);
    }

    /**
     * 🟢 TEST 3: TRANSAKSI PINJAM BUKU SISI MAHASISWA
     */
    public function test_mahasiswa_bisa_memesan_buku_dan_memotong_stok()
    {
        $response = $this->actingAs($this->mahasiswa)
            ->postJson(route('buku.pinjam', $this->buku->id));

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('books', [
            'id' => $this->buku->id,
            'stok' => 2
        ]);
    }

    /**
     * 🟡 TEST 4: PENGAJUAN PENGEMBALIAN BUKU FISIK (STATE 1970)
     */
    public function test_mahasiswa_mengajukan_kembali_masuk_antrean_tanpa_bocor_stok()
    {
        $loan = Borrowing::create([
            'user_id' => $this->mahasiswa->id,
            'book_id' => $this->buku->id,
            'tanggal_pinjam' => '2026-05-20',
            'tenggat_kembali' => '2026-06-03',
            'status' => 'Dipinjam'
        ]);

        $this->buku->update(['stok' => 2]);

        $response = $this->actingAs($this->mahasiswa)
            ->post(route('buku.kembalikan', $loan->id));

        $response->assertStatus(302);

        $this->assertDatabaseHas('borrowings', [
            'id' => $loan->id,
            'status' => 'Pending',
            'tanggal_kembali' => '1970-01-01'
        ]);

        $this->assertEquals(2, Book::find($this->buku->id)->stok);
    }

    /**
     * 🔵 TEST 5: KETUKAN PALU VERIFIKASI ADMIN (END-POINT GLOBAL/API)
     */
    public function test_admin_konfirmasi_buku_fisik_maka_transaksi_selesai_dan_stok_pulih()
    {
        $loan = Borrowing::create([
            'user_id' => $this->mahasiswa->id,
            'book_id' => $this->buku->id,
            'tanggal_pinjam' => '2026-05-20',
            'tenggat_kembali' => '2026-06-03',
            'status' => 'Pending',
            'tanggal_kembali' => '1970-01-01'
        ]);
        
        $this->buku->update(['stok' => 2]);

        $response = $this->actingAs($this->admin)
                         ->postJson(route('admin.konfirmasi.kembali', $loan->id));

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('borrowings', [
            'id' => $loan->id,
            'status' => 'Selesai',
            'tanggal_kembali' => now()->format('Y-m-d')
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $this->buku->id,
            'stok' => 3
        ]);
    }
}