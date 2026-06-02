<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sirkulasi - Smart Library System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { background: url("{{ asset('images/yaya5.png') }}") no-repeat center center fixed; background-size: cover; min-height: 100vh; display: flex; padding: 20px; color: #333; }
        
        .dashboard-container { display: flex; width: 100%; max-width: 1400px; margin: auto; background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 30px; overflow: hidden; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05); }
        .sidebar { width: 260px; background: rgba(255, 255, 255, 0.2); padding: 40px 20px; display: flex; flex-direction: column; justify-content: space-between; border-right: 1px solid rgba(255, 255, 255, 0.2); }
        .brand { text-align: center; margin-bottom: 40px; }
        .brand i { font-size: 2.5rem; color: #bc8a93; margin-bottom: 10px; }
        .brand h1 { font-size: 1.4rem; color: #b5838d; font-weight: 600; }
        .menu-list { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .menu-item a { display: flex; align-items: center; gap: 15px; padding: 12px 20px; color: #555; text-decoration: none; font-weight: 500; border-radius: 12px; transition: 0.3s; }
        .menu-item.active a, .menu-item a:hover { background: rgba(255, 255, 255, 0.6); color: #b5838d; }
        .logout-btn { color: #d48386 !important; background: none; border: none; width: 100%; cursor: pointer; font-size: 1rem; text-align: left; }
        
        .main-content { flex: 1; padding: 40px; overflow-y: auto; }
        .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .content-header h2 { font-size: 1.8rem; font-weight: 600; color: #222; }
        
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; }
        .user-name { font-weight: 600; font-size: 0.95rem; }
        .user-role { font-size: 0.8rem; color: #666; }
        .avatar { width: 40px; height: 40px; border-radius: 50%; background: #b5838d; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; text-transform: uppercase; }

        .table-section { background: rgba(255, 255, 255, 0.4); border: 1px solid rgba(255, 255, 255, 0.4); padding: 30px; border-radius: 22px; margin-bottom: 30px; }
        .table-section h3 { font-size: 1.1rem; margin-bottom: 20px; color: #222; font-weight: 600; }
        
        .custom-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; }
        .custom-table th { padding: 15px; color: #555; font-weight: 600; border-bottom: 2px solid rgba(255,255,255,0.3); }
        .custom-table td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.2); vertical-align: middle; }
        
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 500; display: inline-block; }
        .badge-warning { background: rgba(254, 245, 209, 1); color: #bfa103; border: 1px solid rgba(191, 161, 3, 0.3); }
        .badge-info { background: rgba(218, 237, 254, 1); color: #1e70cd; border: 1px solid rgba(30, 112, 205, 0.3); }
        
        .btn-action { background: #b5838d; color: white; border: none; padding: 8px 16px; border-radius: 10px; cursor: pointer; font-weight: 500; font-size: 0.8rem; transition: 0.3s; display: flex; align-items: center; gap: 8px; }
        .btn-action:hover { background: #a2707a; box-shadow: 0 4px 12px rgba(181, 131, 141, 0.2); }
        .sidebar-title-role { font-size: 0.72rem; text-transform: uppercase; color: rgba(0,0,0,0.4); padding: 10px 20px 5px 20px; display: block; font-weight: 700; letter-spacing: 0.5px; }
    </style>
</head>
<body>

    <div class="dashboard-container">
        
        <aside class="sidebar">
            <div class="top-sidebar">
                <div class="brand">
                    <i class="fa-solid fa-book-open"></i>
                    <h1>Perpustakaan Smart</h1>
                </div>
                <ul class="menu-list">
                    <span class="sidebar-title-role">Menu Petugas</span>
                    <li class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-line"></i> Dashboard Admin</a>
                    </li>
                    <li class="menu-item {{ Request::is('admin/verifikasi') ? 'active' : '' }}">
                        <a href="{{ route('admin.verifikasi') }}"><i class="fa-solid fa-user-check"></i> Verifikasi Sirkulasi</a>
                    </li>
                    <li class="menu-item {{ Request::is('admin/katalog') ? 'active' : '' }}">
                        <a href="{{ route('admin.katalog') }}"><i class="fa-solid fa-book-medical"></i> Katalog Admin</a>
                    </li>
                    <li class="menu-item {{ Request::is('anggota') ? 'active' : '' }}">
                        <a href="{{ route('anggota') }}"><i class="fa-solid fa-users"></i> Anggota</a>
                    </li>
                    <li class="menu-item {{ Request::is('laporan') ? 'active' : '' }}">
                        <a href="{{ route('laporan') }}"><i class="fa-solid fa-file-invoice-dollar"></i> Laporan</a>
                    </li>
                </ul>
            </div>
            
            <ul class="menu-list">
                <li class="menu-item">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-btn">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </li>
            </ul>
        </aside>

        <main class="main-content">
            
            <header class="content-header">
                <h2>Verifikasi & Validasi Sirkulasi Fisik</h2>
                <div class="user-profile">
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Pustakawan (Admin)</div>
                    </div>
                    <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                </div>
            </header>

            <div class="table-section">
                <h3> Antrean Pengambilan Buku Fisik (Penyerahan ke Mahasiswa)</h3>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pesan</th>
                            <th>Status Data</th>
                            <th>Tindakan Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($antrean_ambil as $ambil)
                        <tr>
                            <td><strong>{{ $ambil->user->name }}</strong></td>
                            <td>{{ $ambil->book->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($ambil->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
                            <td><span class="badge badge-info"><i class="fa-solid fa-hourglass-half"></i> Menunggu Diambil</span></td>
                            <td>
                                <button class="btn-action" onclick="prosesAksi('setujui', {{ $ambil->id }}, '{{ $ambil->user->name }}', '{{ $ambil->book->judul }}')">
                                    <i class="fa-solid fa-hand-holding-book"></i> Serahkan Buku
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #777; padding: 20px;">Tidak ada antrean pengambilan buku hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-section">
                <h3> Antrean Pengembalian Buku Fisik (Pengecekan Kondisi Rak)</h3>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>Judul Buku</th>
                            <th>Tenggat Seharusnya</th>
                            <th>Status Data</th>
                            <th>Tindakan Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($antrean_kembali as $kembali)
                        <tr>
                            <td><strong>{{ $kembali->user->name }}</strong></td>
                            <td>{{ $kembali->book->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($kembali->tenggat_kembali)->translatedFormat('d F Y') }}</td>
                            <td><span class="badge badge-warning"><i class="fa-solid fa-box-archive"></i> Cek Fisik Rak</span></td>
                            <td>
                                <button class="btn-action" style="background: #2e7d5c;" onclick="prosesAksi('konfirmasi', {{ $kembali->id }}, '{{ $kembali->user->name }}', '{{ $kembali->book->judul }}')">
                                    <i class="fa-solid fa-square-check"></i> Masukkan ke Rak
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #777; padding: 20px;">Tidak ada pengajuan pengembalian buku fisik untuk divalidasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>

    <script>
        function prosesAksi(tipe, id, namaUser, judulBuku) {
            let url = '';
            let judulKonfirmasi = '';
            let teksKonfirmasi = '';
            
            if(tipe === 'setujui') {
                url = `/admin/setujui-pinjam/${id}`;
                judulKonfirmasi = 'Konfirmasi Penyerahan Buku';
                teksKonfirmasi = `Apakah Anda yakin ingin menyerahkan fisik buku "${judulBuku}" kepada ${namaUser}?`;
            } else {
                url = `/api/admin/konfirmasi-kembali/${id}`;
                judulKonfirmasi = 'Validasi Pengembalian Rak';
                teksKonfirmasi = `Pastikan buku "${judulBuku}" milik ${namaUser} sudah diperiksa kondisi fisik fisiknya sebelum masuk ke rak.`;
            }

            // IMPLEMENTASI POP-UP ANIMASI MEWAH SWEETALERT2
            Swal.fire({
                title: judulKonfirmasi,
                text: teksKonfirmasi,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#b5838d',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, Validasikan!',
                cancelButtonText: 'Batal',
                background: 'rgba(255, 255, 255, 0.95)',
                backdrop: 'rgba(0,0,0,0.2)'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Diverifikasi!',
                                text: data.message,
                                confirmButtonColor: '#b5838d',
                                background: 'rgba(255, 255, 255, 0.95)'
                            }).then(() => {
                                window.location.reload(); // Refresh halaman agar item langsung terhapus dari antrean berjalan
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Validasi',
                                text: data.message,
                                confirmButtonColor: '#b5838d'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gangguan Koneksi',
                            text: 'Gagal menghubungi server database.',
                            confirmButtonColor: '#b5838d'
                        });
                    });
                }
            });
        }
    </script>
</body>
</html>