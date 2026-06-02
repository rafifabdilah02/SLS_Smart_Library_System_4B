<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan & Audit Denda - Smart Library System</title>
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
        .avatar { width: 40px; height: 40px; border-radius: 50%; background: #b5838d; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; text-transform: uppercase; }

        .report-section { background: rgba(255, 255, 255, 0.4); border: 1px solid rgba(255, 255, 255, 0.4); padding: 30px; border-radius: 22px; margin-bottom: 35px; }
        .report-section h3 { font-size: 1.1rem; margin-bottom: 20px; color: #222; font-weight: 600; }
        
        .custom-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; }
        .custom-table th { padding: 15px; color: #555; font-weight: 600; border-bottom: 2px solid rgba(255,255,255,0.3); }
        .custom-table td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.2); vertical-align: middle; }
        
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 500; display: inline-block; }
        .badge-danger { background: rgba(242, 164, 164, 0.5); color: #780000; border: 1px solid rgba(120,0,0,0.2); }
        .badge-success { background: #e2f0cb; color: #547c11; border: 1px solid rgba(84, 124, 17, 0.2); }
        .sidebar-title-role { font-size: 0.72rem; text-transform: uppercase; color: rgba(0,0,0,0.4); padding: 10px 20px 5px 20px; display: block; font-weight: 700; letter-spacing: 0.5px; }

        /* 🌟 PERBAIKAN DAN SINKRONISASI CSS LAYOUT KHUSUS CETAK DOKUMEN PDF */
        @media print {
            body { background: white !important; color: black !important; padding: 0; margin: 0; }
            .sidebar, button, .user-profile, .sidebar-title-role { display: none !important; }
            .dashboard-container { background: none !important; backdrop-filter: none !important; -webkit-backdrop-filter: none !important; border: none !important; box-shadow: none !important; overflow: visible !important; display: block !important; }
            .main-content { padding: 0 !important; width: 100% !important; overflow: visible !important; }
            .report-section { background: white !important; border: 1px solid #ddd !important; border-radius: 0 !important; padding: 20px !important; box-shadow: none !important; page-break-inside: avoid; margin-bottom: 20px !important; }
            .custom-table th { border-bottom: 2px solid #000 !important; color: #000 !important; }
            .custom-table td { border-bottom: 1px solid #eee !important; color: #111 !important; }
            .badge-success { background: none !important; color: black !important; border: 1px solid #000 !important; font-weight: bold; }
            .badge-danger { background: none !important; color: red !important; border: 1px solid red !important; font-weight: bold; }
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
                    <li class="menu-item {{ Request::is('admin/anggota') ? 'active' : '' }}">
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
                <div style="display: flex; align-items: center; gap: 20px;">
                    <h2>Laporan Audit Sirkulasi & Finansial</h2>
                    <button onclick="window.print()" style="background: white; color: #b5838d; border: 1px solid rgba(181, 131, 141, 0.4); padding: 8px 16px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 0.82rem; display: flex; align-items: center; gap: 8px; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                        <i class="fa-solid fa-print"></i> Cetak Dokumen PDF
                    </button>
                </div>
                <div class="user-profile">
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Pustakawan (Admin)</div>
                    </div>
                    <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                </div>
            </header>

            <div class="report-section" style="border-left: 5px solid #780000;">
                <h3 style="color: #780000;"><i class="fa-solid fa-circle-exclamation"></i> Peminjaman Kritis Melebihi Batas Tenggat (Denda Berjalan)</h3>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>Judul Buku</th>
                            <th>Tenggat Seharusnya</th>
                            <th>Hari Terlewat</th>
                            <th>Kalkulasi Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat_terlambat as $telat)
                            @php
                                $hari_terlambat = \Carbon\Carbon::parse($telat->tenggat_kembali)->diffInDays(now(), false);
                                $total_denda = ceil($hari_terlambat) * $tarif_denda;
                            @endphp
                            <tr>
                                <td><strong>{{ $telat->user->name }}</strong></td>
                                <td>'{{ $telat->book->judul }}'</td>
                                <td>{{ \Carbon\Carbon::parse($telat->tenggat_kembali)->translatedFormat('d F Y') }}</td>
                                <td><span class="badge badge-danger">{{ ceil($hari_terlambat) }} Hari</span></td>
                                <td><strong style="color: #780000;">Rp {{ number_format($total_denda, 0, ',', '.') }}</strong></td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #777; padding: 25px;">
                                <i class="fa-solid fa-circle-check" style="color: #547c11;"></i> Hebat! Tidak ada mahasiswa yang menunggak sirkulasi hari ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="report-section">
                <h3><i class="fa-solid fa-clock-rotate-left"></i> Arsip Log Transaksi Sirkulasi Selesai</h3>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Dikembalikan</th>
                            <th>Status Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat_selesai as $selesai)
                        <tr>
                            <td><strong>{{ $selesai->user->name }}</strong></td>
                            <td>{{ $selesai->book->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($selesai->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($selesai->tanggal_kembali)->translatedFormat('d F Y') }}</td>
                            <td><span class="badge badge-success"><i class="fa-solid fa-check-double"></i> Selesai</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #777; padding: 25px;">Belum ada riwayat transaksi masa lalu yang dinyatakan selesai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</body>
</html>