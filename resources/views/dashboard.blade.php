<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan - Smart Library System</title>
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
            padding: 20px;
            color: #333;
        }

        .dashboard-container {
            display: flex;
            width: 100%;
            max-width: 1400px;
            margin: auto;
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
        }

        .brand {
            text-align: center;
            margin-bottom: 40px;
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
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .content-header h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #222;
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
            background: #c0b3cb;
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
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
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
        .card-terlambat { background-color: rgba(142, 190, 224, 0.5) !important; }

        .activity-section {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 30px;
            border-radius: 22px;
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
        }

        .icon-blue { background: rgba(164, 210, 242, 0.5); color: #2b7bb3; }
        .icon-pink { background: rgba(242, 164, 153, 0.5); color: #b34b3e; }
        .icon-green { background: rgba(180, 230, 210, 0.5); color: #2e7d5c; }

        .activity-text {
            font-size: 0.9rem;
            color: #333;
        }

        .activity-time {
            font-size: 0.8rem;
            color: #777;
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
            .dashboard-container { flex-direction: column; }
            .sidebar { width: 100%; border-right: none; border-bottom: 1px solid rgba(255,255,255,0.2); }
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
                    
                    @if(Auth::user()->role === 'mahasiswa')
                        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                        </li>
                        <li class="menu-item {{ Request::is('katalog') ? 'active' : '' }}">
                            <a href="{{ route('katalog') }}"><i class="fa-solid fa-book"></i> Katalog Buku</a>
                        </li>
                        <li class="menu-item {{ Request::is('peminjaman') ? 'active' : '' }}">
                            <a href="{{ route('peminjaman') }}"><i class="fa-solid fa-calendar-days"></i> Peminjaman Saya</a>
                        </li>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <span class="sidebar-title-role">Menu Petugas</span>
                        <li class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-line"></i> Dashboard Admin</a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/verifikasi') ? 'active' : '' }}">
                            <a href="{{ route('admin.verifikasi') }}"><i class="fa-solid fa-user-check"></i> Verifikasi Sirkulasi</a>
                        </li>
                        <li class="menu-item {{ Request::is('anggota') ? 'active' : '' }}">
                            <a href="{{ route('anggota') }}"><i class="fa-solid fa-users"></i> Anggota</a>
                        </li>
                        <li class="menu-item {{ Request::is('laporan') ? 'active' : '' }}">
                            <a href="{{ route('laporan') }}"><i class="fa-solid fa-file-invoice-dollar"></i> Laporan</a>
                        </li>
                    @endif

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
                <h2>{{ Auth::user()->role === 'admin' ? 'Dashboard Utama Pustakawan' : 'Dashboard User Perpustakaan' }}</h2>
                
                <div class="search-container">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Ask AI">
                </div>

                <div class="user-profile">
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">{{ Auth::user()->role === 'admin' ? 'Pustakawan (Admin)' : 'Mahasiswa' }}</div>
                    </div>
                    <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                </div>
            </header>

            <section class="welcome-banner">
                <h3>Halo, {{ Auth::user()->name }}!</h3>
                <p>Selamat datang kembali. Yuk jelajahi dan kelola perpustakaanmu dengan mudah hari ini.</p>
            </section>

            <section class="stats-grid">

                <div class="stat-card card-total">
                    <h4>Total Master Buku</h4>
                    <div class="stat-main">
                        <i class="fa-solid fa-book-bookmark"></i>
                        <div class="number">{{ $totalBuku }}</div>
                    </div>
                    <div class="stat-sub">Judul terdaftar di database</div>
                </div>

                <div class="stat-card card-pinjam">
                    <h4>Buku Aktif Sesi Ini</h4>
                    <div class="stat-main">
                        <i class="fa-solid fa-book-reader"></i>
                        <div class="number">{{ $bukuDipinjam }}</div>
                    </div>
                    <div class="stat-sub" style="color: #bfa103; font-weight: 500;">
                        <i class="fa-solid fa-hourglass-half"></i> Termasuk Antrean Pending
                    </div>
                </div>

                <div class="stat-card card-anggota">
                    <h4>Total Anggota Sistem</h4>
                    <div class="stat-main">
                        <i class="fa-solid fa-users"></i>
                        <div class="number">{{ $totalAnggota }}</div>
                    </div>
                    <div class="stat-sub">Pengguna terautentikasi</div>
                </div>

                <div class="stat-card card-terlambat">
                    <h4>Peminjaman Terlambat</h4>
                    <div class="stat-main">
                        <i class="fa-solid fa-clock"></i>
                        <div class="number">{{ $terlambat }}</div>
                    </div>
                    <div class="stat-sub">Melebihi batas tenggat waktu</div>
                </div>

            </section> 
            
            <section class="activity-section">
                <h3>Aktivitas Terkini</h3>
                <div class="activity-list">
                    @forelse($aktivitas_terbaru as $aktivitas)
                    <div class="activity-item">
                        <div class="activity-details">
                            <div class="activity-icon-wrapper {{ $aktivitas->status == 'Dipinjam' ? 'icon-pink' : 'icon-green' }}">
                                <i class="fa-solid {{ $aktivitas->status == 'Dipinjam' ? 'fa-arrow-up-from-bracket' : 'fa-rotate-left' }}"></i>
                            </div>
                            <div class="activity-text">
                                <strong>{{ $aktivitas->user->name }}</strong> 
                                {{ $aktivitas->status == 'Dipinjam' ? 'meminjam' : 'mengembalikan' }} buku 
                                <strong>'{{ $aktivitas->book->judul }}'</strong>
                            </div>
                        </div>
                        <div class="activity-time">{{ $aktivitas->updated_at->diffForHumans() }}</div>
                    </div>
                    @empty
                    <div class="activity-text" style="text-align: center; padding: 10px; color: #777;">
                        Belum ada aktivitas sirkulasi buku baru-baru ini.
                    </div>
                    @endforelse
                </div>
            </section>

        </main>
    </div>
</body>
</html>