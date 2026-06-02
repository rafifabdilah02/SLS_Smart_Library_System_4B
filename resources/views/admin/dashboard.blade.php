<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utama Pustakawan - Smart Library System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: url("{{ asset('images/yaya5.png') }}") no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #333;
        }

        .dashboard-container {
            display: flex;
            width: 100%;
            max-width: 1400px;
            height: calc(100vh - 40px);
            background: rgba(255, 255, 255, 0.25); 
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        }

        .sidebar {
            width: 260px;
            background: rgba(255, 255, 255, 0.2); 
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            flex-shrink: 0;
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand i {
            font-size: 2.5rem;
            color: #bc8a93;
            margin-bottom: 10px;
        }

        .brand h1 {
            font-size: 1.4rem;
            color: #b5838d;
            font-weight: 600;
        }

        .menu-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 20px;
            color: #555;
            text-decoration: none;
            font-weight: 500;
            border-radius: 12px;
            transition: 0.3s;
        }

        .menu-item.active a, .menu-item a:hover {
            background: rgba(255, 255, 255, 0.6);
            color: #b5838d;
        }

        .logout-btn {
            color: #d48386 !important;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
            font-size: 1rem;
            text-align: left;
        }

        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-shrink: 0;
        }

        .content-header h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #222;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .search-container {
            position: relative;
            width: 300px;
        }

        .search-container input {
            width: 100%;
            padding: 10px 20px 10px 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.6);
            outline: none;
            font-size: 0.88rem;
        }

        .search-container i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #666;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #b5838d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }

        .welcome-banner {
            background: url("{{ asset('images/yaya4.png') }}") no-repeat center center;
            background-size: cover;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 45px 40px;
            border-radius: 25px;
            margin-bottom: 30px;
            min-height: 160px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.02);
            flex-shrink: 0;
        }

        .welcome-banner h3 {
            font-size: 2rem;
            color: #222;
            font-weight: 600;
            margin-bottom: 8px;
            padding-left: 150px;
        }

        .welcome-banner p {
            color: #444;
            font-size: 0.95rem;
            padding-left: 150px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
            flex-shrink: 0;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 22px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.01);
        }

        .stat-card h4 {
            font-size: 0.85rem;
            color: #444;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .stat-main {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .stat-main i {
            font-size: 2rem;
            color: #555;
        }

        .stat-main .number {
            font-size: 2.2rem;
            font-weight: 600;
            color: #222;
        }

        .stat-sub {
            font-size: 0.8rem;
            color: #666;
        }

        .card-total { background-color: rgba(242, 164, 153, 0.4) !important; }
        .card-pinjam { background-color: rgba(164, 210, 242, 0.4) !important; }
        .card-anggota { background-color: rgba(242, 196, 184, 0.4) !important; }
        .card-terlambat { background-color: rgba(224, 142, 142, 0.5) !important; }

        .activity-section {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 30px;
            border-radius: 22px;
            flex: 1;
            min-height: 250px;
        }

        .activity-section h3 {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: #222;
            font-weight: 600;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .activity-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .activity-details {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .activity-icon-wrapper {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .icon-blue { background: rgba(164, 210, 242, 0.5); color: #2b7bb3; }
        .icon-pink { background: rgba(242, 164, 153, 0.5); color: #b34b3e; }
        .icon-green { background: rgba(180, 230, 210, 0.5); color: #2e7d5c; }
        .icon-orange { background: rgba(254, 245, 209, 1); color: #bfa103; }

        .activity-text {
            font-size: 0.9rem;
            color: #333;
        }

        .activity-time {
            font-size: 0.8rem;
            color: #777;
            flex-shrink: 0;
        }

        .sidebar-title-role {
            font-size: 0.72rem;
            text-transform: uppercase;
            color: rgba(0,0,0,0.4);
            padding: 10px 20px 5px 20px;
            display: block;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        @media (max-width: 1000px) {
            .dashboard-container { flex-direction: column; height: auto; }
            .sidebar { width: 100%; border-right: none; border-bottom: 1px solid rgba(255,255,255,0.2); }
            .main-content { max-height: none; }
            .welcome-banner h3, .welcome-banner p { padding-left: 0; text-align: center; }
            .welcome-banner { background: #fcaaa4; }
        }
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
                <h2>Dashboard Utama Pustakawan</h2>
                
                <div class="header-right">
                    <div class="search-container">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" placeholder="Search Console">
                    </div>

                    <div class="user-profile">
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">Pustakawan (Admin)</div>
                        </div>
                        <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    </div>
                </div>
            </header>

            <section class="welcome-banner">
                <h3>Selamat Tugas, {{ Auth::user()->name }}!</h3>
                <p>Menara kontrol siap. Pantau pergerakan sirkulasi buku fisik dan tertibkan keterlambatan hari ini.</p>
            </section>

            @if($terlambat > 0)
            <div class="alert-box" style="background: rgba(120, 0, 0, 0.1); border: 1px solid rgba(120, 0, 0, 0.3); padding: 15px 25px; border-radius: 15px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
                <span style="color: #780000; font-size: 0.9rem; font-weight: 500;">
                    <i class="fa-solid fa-circle-exclamation"></i> Sistem mendeteksi <strong>{{ $terlambat }}</strong> akun mahasiswa memegang buku melewati batas tenggat kembali!
                </span>
                <a href="{{ route('laporan') }}" style="font-size: 0.85rem; color: #780000; font-weight: 600; text-decoration: none;">Tinjau Denda <i class="fa-solid fa-chevron-right"></i></a>
            </div>
            @endif

            <section class="stats-grid">
                <div class="stat-card card-total">
                    <h4>Total Master Buku</h4>
                    <div class="stat-main">
                        <i class="fa-solid fa-book-bookmark"></i>
                        <div class="number">{{ $totalBuku }}</div>
                    </div>
                    <div class="stat-sub">Judul terdaftar global</div>
                </div>

                <div class="stat-card card-pinjam">
                    <h4>Buku Aktif Sesi Ini</h4>
                    <div class="stat-main">
                        <i class="fa-solid fa-book-reader"></i>
                        <div class="number">{{ $bukuDipinjam }}</div>
                    </div>
                    <div class="stat-sub">Dipinjam & antrean verifikasi</div>
                </div>

                <div class="stat-card card-anggota">
                    <h4>Total Anggota Sistem</h4>
                    <div class="stat-main">
                        <i class="fa-solid fa-users"></i>
                        <div class="number">{{ $totalAnggota }}</div>
                    </div>
                    <div class="stat-sub">Mahasiswa terautentikasi</div>
                </div>

                <div class="stat-card card-terlambat" style="background-color: {{ $terlambat > 0 ? 'rgba(242, 164, 164, 0.6)' : 'rgba(224, 190, 190, 0.3)' }} !important;">
                    <h4>Peminjaman Terlambat</h4>
                    <div class="stat-main">
                        <i class="fa-solid fa-clock" style="color: {{ $terlambat > 0 ? '#780000' : '#555' }};"></i>
                        <div class="number" style="color: {{ $terlambat > 0 ? '#780000' : '#222' }};">{{ $terlambat }}</div>
                    </div>
                    <div class="stat-sub">Melebihi tenggat kembali resmi</div>
                </div>
            </section>

            <section class="activity-section">
                <h3>Log Aktivitas Sirkulasi Global Terkini</h3>
                <div class="activity-list">
                    @forelse($aktivitas_terbaru as $aktivitas)
                    <div class="activity-item">
                        <div class="activity-details">
                            <div class="activity-icon-wrapper 
                                @if($aktivitas->status == 'Dipinjam') icon-pink 
                                @elseif($aktivitas->status == 'Pending') icon-orange
                                @else icon-green @endif">
                                <i class="fa-solid 
                                    @if($aktivitas->status == 'Dipinjam') fa-arrow-up-from-bracket 
                                    @elseif($aktivitas->status == 'Pending') fa-hourglass-half
                                    @else fa-rotate-left @endif"></i>
                            </div>
                            <div class="activity-text">
                                <strong>{{ $aktivitas->user->name }}</strong> 
                                @if($aktivitas->status == 'Dipinjam')
                                    <span style="color: #b34b3e;">resmi memegang</span>
                                @elseif($aktivitas->status == 'Pending')
                                    <span style="color: #bfa103;">mengajukan antrean sirkulasi</span>
                                @else
                                    <span style="color: #2e7d5c;">sukses mengembalikan</span>
                                @endif
                                buku <strong>'{{ $aktivitas->book->judul }}'</strong>
                            </div>
                        </div>
                        <div class="activity-time">{{ $aktivitas->updated_at->diffForHumans() }}</div>
                    </div>
                    @empty
                    <div class="activity-text" style="text-align: center; padding: 10px; color: #777;">
                        Belum ada riwayat pergerakan buku baru-baru ini.
                    </div>
                    @endforelse
                </div>
            </section>

        </main>
    </div>

    @vite(['resources/js/app.js'])

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.Echo.channel('public-sirkulasi-channel')
                .listen('.peminjaman.baru', (data) => {
                    
                    const namaMahasiswa = data.borrowing.user.name;
                    const judulBuku = data.borrowing.book.judul;

                    alert(`Notifikasi Cerdas: Pengguna bernama ${namaMahasiswa} baru saja mengajukan peminjaman buku "${judulBuku}"!`);
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                });
        });
    </script>
</body>
</html>