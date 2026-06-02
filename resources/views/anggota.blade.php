<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota - Perpustakaan Smart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { 
            background: url("{{ asset('images/yaya5.png') }}") no-repeat center center fixed; 
            background-size: cover; display: flex; min-height: 100vh; color: #333; padding: 20px; 
        }
        .dashboard-container { 
            display: flex; width: 100%; max-width: 1400px; margin: auto; background: rgba(255, 255, 255, 0.25); 
            backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 30px; overflow: hidden; 
        }
        /* Sidebar diperkuat z-index agar selalu di atas */
        .sidebar { 
            width: 260px; background: rgba(255, 255, 255, 0.2); padding: 40px 20px; display: flex; 
            flex-direction: column; justify-content: space-between; border-right: 1px solid rgba(255, 255, 255, 0.2);
            position: relative; z-index: 10; 
        }
        .brand { text-align: center; margin-bottom: 40px; }
        .brand i { font-size: 2.5rem; color: #bc8a93; margin-bottom: 10px; }
        .brand h1 { font-size: 1.4rem; color: #b5838d; font-weight: 600; }
        .menu-list { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .menu-item a { display: flex; align-items: center; gap: 15px; padding: 12px 20px; color: #555; text-decoration: none; font-weight: 500; border-radius: 12px; transition: 0.3s; }
        .menu-item.active a, .menu-item a:hover { background: rgba(255, 255, 255, 0.6); color: #b5838d; }
        .main-content { flex: 1; padding: 40px; overflow-y: auto; max-height: 90vh; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .btn-tambah { background: #b5838d; color: white; padding: 10px 20px; border-radius: 15px; text-decoration: none; border: none; cursor: pointer; transition: 0.3s; }
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: rgba(255, 255, 255, 0.4); border-radius: 20px; padding: 20px; text-align: center; border: 1px solid rgba(255, 255, 255, 0.4); }
        .member-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }
        .member-card { background: rgba(255, 255, 255, 0.45); border-radius: 25px; padding: 25px; text-align: center; transition: 0.4s; }
        .avatar-wrapper { width: 90px; height: 90px; border-radius: 50%; margin: 0 auto 15px; border: 2px dashed #b5838d; overflow: hidden; }
        .avatar-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        .card-actions { display: flex; justify-content: center; gap: 10px; margin-top: 15px; }
        .btn-icon { width: 35px; height: 35px; border-radius: 10px; border: none; background: white; color: #b5838d; cursor: pointer; }
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
            <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            </li>
            <li class="menu-item {{ Request::is('katalog') ? 'active' : '' }}">
                <a href="{{ route('katalog') }}"><i class="fa-solid fa-book"></i> Katalog</a>
            </li>
            <li class="menu-item {{ Request::is('peminjaman') ? 'active' : '' }}">
                <a href="{{ route('peminjaman') }}"><i class="fa-solid fa-calendar-days" style="width: 20px; text-align: center;"></i> Peminjaman</a>
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
            <a href="{{ url('/login') }}" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </li>
    </ul>
</aside>
        <main class="main-content">
            <div class="header-flex">
                <h2>Manajemen Anggota</h2>
                <button class="btn-tambah" onclick="alert('Fitur tambah segera hadir!')">
                    <i class="fa-solid fa-user-plus"></i> Tambah Anggota
                </button>
            </div>

            <div class="stats-row">
                <div class="stat-card"><h4>{{ count($data_anggota) }}</h4><p>Total Anggota</p></div>
                <div class="stat-card"><h4>{{ collect($data_anggota)->where('status', 'Aktif')->count() }}</h4><p>Anggota Aktif</p></div>
                <div class="stat-card"><h4>0</h4><p>Permintaan Baru</p></div>
            </div>

            <div class="member-grid">
                @forelse($data_anggota as $member)
                <div class="member-card">
                    <div class="avatar-wrapper"><img src="{{ $member['avatar'] }}" alt="Profile"></div>
                    <h3>{{ $member['nama'] }}</h3>
                    <p style="color:#b5838d; font-size: 0.8rem;">{{ $member['nim'] }}</p>
                    <p style="font-size: 0.8rem; color: #777;">{{ $member['jurusan'] }}</p>
                    <div class="card-actions">
                        <button class="btn-icon"><i class="fa-solid fa-eye"></i></button>
                        <button class="btn-icon"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn-icon"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
                @empty
                    <p>Belum ada data anggota.</p>
                @endforelse
            </div>
        </main>
    </div>
</body>
</html>