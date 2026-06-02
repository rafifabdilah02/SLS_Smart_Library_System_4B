<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perpustakaan</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: url("{{ asset('images/yaya6.png') }}") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            min-height: 100vh;
            color: #333;
            padding: 20px;
        }

        /* Container Utama - Efek Kaca Transparan (Glassmorphism) */
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

        /* 📋 SIDEBAR STYLE */
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
        }

        /* 🏛️ MAIN CONTENT CONTAINER */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            max-height: 90vh;
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .report-header h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #222;
        }

        /* 📊 KARTU STATISTIK (STAT CARDS) */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 18px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fff;
        }

        .bg-books { background-color: #fcaaa4; }
        .bg-loans { background-color: #92c5f2; }
        .bg-return { background-color: #b388ff; }
        .bg-members { background-color: #ff8a80; }

        .stat-info h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #222;
        }

        .stat-info p {
            font-size: 0.8rem;
            color: #666;
            font-weight: 500;
        }

        /* 📅 BUTTON CETAK LAPORAN */
        .btn-print {
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 10px 20px;
            border-radius: 12px;
            color: #b5838d;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }

        .btn-print:hover {
            background: #b5838d;
            color: #fff;
            box-shadow: 0 5px 15px rgba(181, 131, 141, 0.3);
        }

        /* 📄 AREA KOTAK LAPORAN & GRAFIK (GLASSMORPHISM SECTION) */
        .report-section {
            background: rgba(255, 255, 255, 0.35);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title span {
            width: 5px;
            height: 18px;
            background-color: #b5838d;
            border-radius: 3px;
            display: inline-block;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .report-table th {
            background: rgba(255, 255, 255, 0.5);
            padding: 14px 16px;
            color: #444;
            font-weight: 600;
            font-size: 0.9rem;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
        }

        .report-table td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            color: #555;
            font-size: 0.88rem;
        }

        .report-table tr:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Status Badges */
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }

        .badge-success { background-color: #e2f0cb; color: #547c11; }
        .badge-warning { background-color: #ffcad4; color: #b5838d; }

        /* Responsif Layar */
        @media (max-width: 1000px) {
            .dashboard-container { flex-direction: column; }
            .sidebar { width: 100%; border-right: none; border-bottom: 1px solid rgba(255, 255, 255, 0.2); }
            .main-content { max-height: none; }
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
            
            <div class="report-header">
                <h2>Dashboard Laporan</h2>
                <button class="btn-print" onclick="window.print()">
                    <i class="fa-solid fa-print"></i> Cetak Laporan
                </button>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-books"><i class="fa-solid fa-book"></i></div>
                    <div class="stat-info">
                        <h3>1,240</h3>
                        <p>Total Buku</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-loans"><i class="fa-solid fa-arrow-up-from-bracket"></i></div>
                    <div class="stat-info">
                        <h3>85</h3>
                        <p>Sedang Dipinjam</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-return"><i class="fa-solid fa-arrow-down-to-bracket"></i></div>
                    <div class="stat-info">
                        <h3>142</h3>
                        <p>Selesai Bulan Ini</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-members"><i class="fa-solid fa-users"></i></div>
                    <div class="stat-info">
                        <h3>320</h3>
                        <p>Anggota Aktif</p>
                    </div>
                </div>
            </div>

            <div class="report-section" style="margin-bottom: 40px;">
                <div class="section-title">
                    <span></span> Tren Peminjaman Buku (6 Bulan Terakhir)
                </div>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="peminjamanChart"></canvas>
                </div>
            </div>

            <div class="report-section">
                <div class="section-title">
                    <span></span> Riwayat Aktivitas Peminjaman Terbaru
                </div>
                
                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>ID Pinjam</th>
                                <th>Nama Anggota</th>
                                <th>Judul Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#PJ-0042</td>
                                <td>Putri Auliya</td>
                                <td>Game Development & C++ Basics</td>
                                <td>24 Mei 2026</td>
                                <td>31 Mei 2026</td>
                                <td><span class="badge badge-warning">Dipinjam</span></td>
                            </tr>
                            <tr>
                                <td>#PJ-0041</td>
                                <td>Ahmad Fauzi</td>
                                <td>Harry Potter dan Batu Bertuah</td>
                                <td>18 Mei 2026</td>
                                <td>25 Mei 2026</td>
                                <td><span class="badge badge-success">Kembali</span></td>
                            </tr>
                            <tr>
                                <td>#PJ-0040</td>
                                <td>Siti Aminah</td>
                                <td>Artificial Intelligence & Deep Learning</td>
                                <td>15 Mei 2026</td>
                                <td>22 Mei 2026</td>
                                <td><span class="badge badge-success">Kembali</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('peminjamanChart').getContext('2d');
            
            // Render grafik interaktif bertema pastel transparan
            const peminjamanChart = new Chart(ctx, {
                type: 'line', 
                data: {
                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'], 
                    datasets: [{
                        label: 'Jumlah Buku Dipinjam',
                        data: [65, 78, 120, 142, 95, 115], 
                        backgroundColor: 'rgba(181, 131, 141, 0.2)', 
                        borderColor: 'rgba(181, 131, 141, 1)', 
                        borderWidth: 3,
                        pointBackgroundColor: '#b5838d',
                        tension: 0.4, 
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#333',
                                font: { family: 'Poppins', size: 12 }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.15)' },
                            ticks: { color: '#555', font: { family: 'Poppins' } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#555', font: { family: 'Poppins' } }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>