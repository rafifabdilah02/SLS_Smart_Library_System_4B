<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Anggota - Smart Library System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
        .avatar-admin { width: 40px; height: 40px; border-radius: 50%; background: #b5838d; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; text-transform: uppercase; }

        .table-section { background: rgba(255, 255, 255, 0.4); border: 1px solid rgba(255, 255, 255, 0.4); padding: 30px; border-radius: 22px; }
        
        .custom-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; }
        .custom-table th { padding: 15px; color: #555; font-weight: 600; border-bottom: 2px solid rgba(255,255,255,0.3); }
        .custom-table td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.2); vertical-align: middle; }
        
        .member-profile-td { display: flex; align-items: center; gap: 12px; }
        
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 500; display: inline-block; }
        .badge-active { background: #e2f0cb; color: #547c11; border: 1px solid rgba(84, 124, 17, 0.2); }
        
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
                    <li class="menu-item {{ Request::is('admin/anggota') || Request::is('anggota') ? 'active' : '' }}">
                        <a href="{{ route('anggota') }}"><i class="fa-solid fa-users"></i> Anggota</a>
                    </li>
                    <li class="menu-item {{ Request::is('admin/laporan') || Request::is('laporan') ? 'active' : '' }}">
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
                <h2>Manajemen Data Anggota Aktif</h2>
                <div class="user-profile">
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Pustakawan (Admin)</div>
                    </div>
                    <div class="avatar-admin">{{ substr(Auth::user()->name, 0, 1) }}</div>
                </div>
            </header>

            <div class="table-section">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Identitas Mahasiswa</th>
                            <th>Username / NIM</th>
                            <th>Program Studi</th>
                            <th>Buku Pegangan Aktif</th>
                            <th>Status Akses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswa as $mhs)
                        <tr>
                            <td>
                                <div class="member-profile-td">
                                    <div class="member-avatar" style="width: 40px; height: 40px; border-radius: 50%; background: #bc8a93; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.9rem; text-transform: uppercase; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                                        {{ substr($mhs->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #222;">{{ $mhs->name }}</div>
                                        <div style="font-size: 0.78rem; color: #666;">{{ $mhs->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><code>{{ $mhs->username }}</code></td>
                            <td>Informatics Engineering</td>
                            <td>
                                <span style="font-weight: 600; color: {{ $mhs->borrowings_count > 0 ? '#b34b3e' : '#333' }};">
                                    {{ $mhs->borrowings_count }} Buku
                                </span>
                                <small style="color: #666; display: block; font-size: 0.72rem;">Maksimal kuota: 3</small>
                            </td>
                            <td>
                                <span class="badge badge-active"><i class="fa-solid fa-circle-check"></i> Aktif</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #777; padding: 30px;">
                                <i class="fa-solid fa-user-slash" style="font-size: 2rem; display: block; margin-bottom: 10px; color: #bc8a93;"></i>
                                Belum ada data mahasiswa yang terdaftar di database perpustakaan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</body>
</html>