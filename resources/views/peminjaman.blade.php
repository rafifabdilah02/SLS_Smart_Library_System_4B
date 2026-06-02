<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman - Perpustakaan Smart</title>
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
            display: flex;
            min-height: 100vh;
            color: #333;
            padding: 20px;
        }

        /* Container Utama - Glassmorphism Senada dengan Katalog */
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

        /* 🚪 SIDEBAR STYLE */
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

        .menu-item i {
            width: 25px;
            text-align: center;
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

        .page-header {
            margin-bottom: 35px;
        }

        .page-header h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #222;
        }

        /* 📊 KARTU STATISTIK ATAS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02);
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .icon-pinjam { background: #ffebee; color: #b5838d; }
        .icon-kembali { background: #e8f5e9; color: #547c11; }
        .icon-denda { background: #fff3e0; color: #ffb74d; }

        .stat-info h3 { font-size: 1.5rem; font-weight: 600; color: #222; }
        .stat-info p { font-size: 0.82rem; color: #666; }

        /* 📋 JUDUL SUB-BAGIAN */
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title span {
            width: 6px;
            height: 22px;
            background-color: #b5838d;
            border-radius: 3px;
            display: inline-block;
        }

        /* 🃏 STRIP PINJAMAN AKTIF */
        .loan-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 45px;
        }

        .loan-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            padding: 15px 25px;
            transition: all 0.3s ease;
        }

        .loan-item:hover {
            transform: translateX(5px);
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 10px 25px rgba(181, 131, 141, 0.08);
        }

        .book-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: 2;
        }

        .cover-box {
            width: 55px;
            height: 75px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            background-color: #eaeaea;
        }

        .cover-box img { width: 100%; height: 100%; object-fit: cover; }
        .details h4 { font-size: 0.95rem; font-weight: 600; color: #222; margin-bottom: 2px; }
        .details p { font-size: 0.8rem; color: #777; }

        .loan-dates {
            flex: 1;
            font-size: 0.85rem;
            color: #555;
            line-height: 1.5;
        }
        .loan-dates strong { color: #222; }

        .status-box {
            flex: 1;
            text-align: center;
        }

        .badge-days {
            font-size: 0.75rem;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 500;
            display: inline-block;
        }
        
        /* Bagian CSS yang kamu validasikan sudah masuk di sini */
        .status-lancar { background-color: #e2f0cb; color: #547c11; }
        .status-warning { background-color: #ffcad4; color: #b5838d; }
        .status-pending { background-color: #fef5d1; color: #bfa103; }

        .action-box {
            display: flex;
            justify-content: flex-end;
        }

        .btn-kembalikan {
            background: #b5838d;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-kembalikan:hover {
            background: #a3727c;
            transform: scale(1.03);
        }

        /* 📜 TABEL RIWAYAT */
        .history-wrapper {
            background: rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 22px;
            padding: 15px;
            overflow-x: auto;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.88rem;
        }

        .history-table th {
            padding: 15px;
            color: #b5838d;
            font-weight: 600;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .history-table td {
            padding: 15px;
            color: #444;
            border-bottom: 1px solid rgba(0,0,0,0.02);
        }

        .history-table tr:last-child td { border-bottom: none; }
        .badge-selesai { background: #e8f5e9; color: #2e7d32; padding: 4px 12px; border-radius: 12px; font-size: 0.72rem; font-weight: 500; }

        @media (max-width: 1000px) {
            .dashboard-container { flex-direction: column; }
            .sidebar { width: 100%; border-right: none; border-bottom: 1px solid rgba(255,255,255,0.2); }
            .loan-item { flex-direction: column; text-align: center; gap: 15px; padding: 20px; }
            .book-meta { flex-direction: column; }
            .action-box { justify-content: center; width: 100%; }
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        
        <!-- // === POTONG & GANTI AREA INI DI PEMINJAMAN.BLADE.PHP === // -->
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
                <a href="{{ route('katalog') }}"><i class="fa-solid fa-book"></i> Katalog </a>
            </li>
            <li class="menu-item {{ Request::is('peminjaman') ? 'active' : '' }}">
                <a href="{{ route('peminjaman') }}"><i class="fa-solid fa-calendar-days"></i> Peminjaman</a>
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
<!-- // === SELESAI PEMBATAS SIDEBAR === // -->

        <main class="main-content">
            
            <div class="page-header">
                <h2>Peminjaman Buku</h2>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon icon-pinjam"><i class="fa-solid fa-book-bookmark"></i></div>
                    <div class="stat-info">
                        <h3>{{ count($peminjaman_aktif) }} Buku</h3>
                        <p>Sedang Dipinjam</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-kembali"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="stat-info">
                        <h3>{{ count($riwayat_peminjaman) }} Buku</h3>
                        <p>Sudah Dikembalikan</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-denda"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                    <div class="stat-info">
                        <h3>Rp 0</h3>
                        <p>Denda Keterlambatan</p>
                    </div>
                </div>
            </div>

            <div class="section-title">
                <span></span> Buku yang Sedang Dipinjam
            </div>

            <div class="loan-list">
                @forelse($peminjaman_aktif as $loan)
                <div class="loan-item" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 15px; padding: 20px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; border: 1px solid rgba(255,255,255,0.4);">
                    
                    <div class="book-meta" style="display: flex; align-items: center; gap: 15px;">
                        <div class="cover-box">
                            <img src="{{ $loan->book->cover }}" alt="Cover" style="width: 50px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        </div>
                        <div class="details">
                            <h4 style="margin: 0 0 5px 0; color: #333;">{{ $loan->book->judul }}</h4>
                            <p style="margin: 0; size: 0.85rem; color: #666;">Oleh {{ $loan->book->penulis }}</p>
                        </div>
                    </div>
                    
                    <div class="loan-dates" style="font-size: 0.9rem; color: #444;">
                        Pinjam: <strong>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</strong><br>
                        Tenggat: <strong style="color: #b5838d;">{{ \Carbon\Carbon::parse($loan->tenggat_kembali)->format('d M Y') }}</strong>
                    </div>

                    <div class="status-box" style="text-align: center; min-width: 180px;">
                        @if($loan->status == 'Pending')
                            <span class="badge-days status-pending" style="background: #fef5d1; color: #bfa103; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block;">
                                <i class="fa-solid fa-hourglass-half"></i> Menunggu Admin
                            </span>
                        @else
                            @if($loan->sisa_hari > 3)
                                <span class="badge-days status-lancar" style="background: #d8f3dc; color: #1b4332; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block;">
                                    <i class="fa-solid fa-clock"></i> {{ $loan->sisa_hari }} Hari Lagi
                                </span>
                            @elseif($loan->sisa_hari >= 0 && $loan->sisa_hari <= 3)
                                <span class="badge-days status-warning" style="background: #ffe3e0; color: #cc3300; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block;">
                                    <i class="fa-solid fa-triangle-exclamation"></i> {{ $loan->sisa_hari == 0 ? 'Batas Hari Ini!' : $loan->sisa_hari . ' Hari Lagi!' }}
                                </span>
                            @else
                                <span class="badge-days status-terlambat" style="background: #780000; color: #ffffff; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block;">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Terlambat {{ abs($loan->sisa_hari) }} Hari
                                </span>
                            @endif
                        @endif

                        <div class="denda-value" style="margin-top: 6px;">
                            @if($loan->denda_berjalan > 0)
                                <span style="color: #780000; font-size: 0.8rem; font-weight: 700; background: rgba(120, 0, 0, 0.1); padding: 2px 8px; border-radius: 4px; display: inline-block;">
                                    Denda: Rp {{ number_format($loan->denda_berjalan, 0, ',', '.') }}
                                </span>
                            @else
                                <span style="color: #2d6a4f; font-size: 0.78rem; font-style: italic; font-weight: 500;">
                                    <i class="fa-solid fa-circle-check"></i> Bebas Denda
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="action-box" style="text-align: right;">
                        @if($loan->status == 'Pending')
                            <span style="font-size: 0.82rem; color: #bfa103; font-weight: 500; font-style: italic;">
                                <i class="fa-solid fa-clock"></i> Silahkan ambil buku di meja admin
                            </span>

                        @elseif($loan->status == 'Pending Kembali')
                            <span style="font-size: 0.82rem; color: #d48386; font-weight: 500; font-style: italic;">
                                <i class="fa-solid fa-hourglass-half"></i> Menunggu verifikasi fisik oleh admin
                            </span>

                        @else
                            <form id="form-kembali-{{ $loan->id }}" action="{{ route('buku.kembalikan', $loan->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="button" class="btn-kembalikan btn-submit-kembali" 
                                        data-id="{{ $loan->id }}" 
                                        data-judul="{{ $loan->book->judul }}" 
                                        data-sisa="{{ $loan->sisa_hari }}"
                                        data-denda="{{ $loan->denda_berjalan }}">
                                    <i class="fa-solid fa-arrow-rotate-left"></i> Kembalikan
                                </button>
                            </form>
                        @endif
                    </div>
                </div> 
                @empty
                <div style="text-align: center; padding: 40px; color: #666; background: rgba(255,255,255,0.3); border-radius: 15px; width: 100%;">
                    Kamu saat ini tidak memiliki tanggungan peminjaman buku aktif.
                </div>
                @endforelse
            </div>

            <div class="section-title">
                <span></span> Riwayat Aktivitas Peminjaman
            </div>

            <div class="history-wrapper">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status Pengembalian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat_peminjaman as $history)
                        <tr>
                            <td><strong>{{ $history->book->judul }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($history->tanggal_pinjam)->format('d M Y') }}</td>
                            
                            <td>
                                @if($history->status == 'Pending' && $history->tanggal_kembali == '1970-01-01')
                                    <span style="color: #999; font-style: italic;">Belum Diverifikasi</span>
                                @else
                                    {{ \Carbon\Carbon::parse($history->tanggal_kembali)->format('d M Y') }}
                                @endif
                            </td>
                            
                            <td>
                                @if($history->status == 'Pending' && $history->tanggal_kembali == '1970-01-01')
                                    <span class="badge-proses" style="background-color: #fef5d1; color: #bfa103; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; display: inline-block;">
                                        <i class="fa-solid fa-hourglass-half"></i> Pending (Cek Admin)
                                    </span>
                                @else
                                    <span class="badge-selesai" style="background-color: #d8f3dc; color: #1b4332; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; display: inline-block;">
                                        <i class="fa-solid fa-check-double"></i> Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #777; padding: 25px;">
                                Belum ada riwayat aktivitas peminjaman di masa lalu.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const tombolKembali = document.querySelectorAll('.btn-submit-kembali');

        tombolKembali.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                const transaksiId = this.getAttribute('data-id');
                const judulBuku = this.getAttribute('data-judul');
                const sisaHari = parseInt(this.getAttribute('data-sisa'));
                const dendaBerjalan = parseInt(this.getAttribute('data-denda'));
                const formTarget = document.getElementById(`form-kembali-${transaksiId}`);

                let teksPeringatan = '';
                
                // Integrasi pembacaan sisa waktu dan denda rupiah pada pop-up
                if (sisaHari > 0) {
                    teksPeringatan = `Kamu masih memiliki sisa waktu batas peminjaman ${sisaHari} hari lagi untuk buku ini.`;
                } else if (sisaHari === 0) {
                    teksPeringatan = `Hari ini adalah batas tenggat terakhir pengembalian buku kamu!`;
                } else {
                    // Jika denda berjalan di atas 0, informasikan kewajiban bayar di pop-up
                    const formattedDenda = new IntlNumberNumberFormat('id-ID').format(dendaBerjalan);
                    teksPeringatan = `Masa pinjam buku ini sudah terlambat ${Math.abs(sisaHari)} hari. Kamu memiliki tanggungan denda sebesar Rp ${formattedDenda}.`;
                }

                Swal.fire({
                    title: 'Yakin Ingin Mengembalikan?',
                    text: `${teksPeringatan} Apakah kamu ingin melanjutkan pengembalian buku '${judulBuku}'?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#b5838d',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya, Kembalikan',
                    cancelButtonText: 'Batal Kembalikan',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Pengembalian Buku Berhasil!',
                            text: 'Permintaan telah dicatat. Silahkan segera konfirmasi ke meja admin dan serahkan buku fisik kamu.',
                            icon: 'success',
                            confirmButtonColor: '#b5838d',
                            confirmButtonText: 'Oke, Paham'
                        }).then(() => {
                            formTarget.submit();
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: 'Pengembalian dibatalkan',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });
        });
    });
    </script>
</body>
</html>