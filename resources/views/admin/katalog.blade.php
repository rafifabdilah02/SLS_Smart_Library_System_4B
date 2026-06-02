<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Master Admin - Smart Library System</title>
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

        .genre-section { background: rgba(255, 255, 255, 0.4); border: 1px solid rgba(255, 255, 255, 0.4); padding: 30px; border-radius: 22px; margin-bottom: 35px; }
        .genre-title { font-size: 1.2rem; margin-bottom: 20px; color: #222; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .genre-title span { width: 6px; height: 22px; border-radius: 3px; display: inline-block; background-color: #b5838d; }
        
        .custom-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; }
        .custom-table th { padding: 15px; color: #555; font-weight: 600; border-bottom: 2px solid rgba(255,255,255,0.3); }
        .custom-table td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.2); vertical-align: middle; }
        
        .book-info-td { display: flex; align-items: center; gap: 15px; }
        .mini-cover { width: 45px; height: 65px; object-fit: cover; border-radius: 6px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 500; display: inline-block; }
        .badge-success { background: #e2f0cb; color: #547c11; border: 1px solid rgba(84, 124, 17, 0.2); }
        .badge-danger { background: #ffcad4; color: #b5838d; border: 1px solid rgba(181, 131, 141, 0.2); }
        
        .btn-edit-stok { background: #b5838d; color: white; border: none; padding: 8px 14px; border-radius: 10px; cursor: pointer; font-weight: 500; font-size: 0.8rem; transition: 0.3s; display: flex; align-items: center; gap: 6px; }
        .btn-edit-stok:hover { background: #a2707a; box-shadow: 0 4px 12px rgba(181, 131, 141, 0.2); }
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
            
            <header class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 20px;">
                <h2>Master Inventaris Katalog Buku</h2>
                
                <div class="search-box" style="position: relative; flex: 1; max-width: 400px; margin-left: auto; margin-right: 20px;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #bc8a93;"></i>
                    <input type="text" id="katalogSearch" onkeyup="filterKatalog()" placeholder="Cari judul buku atau penulis..." style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.5); background: rgba(255,255,255,0.6); backdrop-filter: blur(5px); font-size: 0.9rem; color: #333; outline: none; transition: 0.3s;">
                </div>

                <div class="user-profile">
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Pustakawan (Admin)</div>
                    </div>
                    <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                </div>
            </header>

            @forelse($booksGrouped as $genreName => $books)
            <div class="genre-section">
                <div class="genre-title">
                    <span></span> Kategori Genre: {{ $genreName }}
                </div>
                
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Detail Cover & Judul Buku</th>
                            <th>Nama Penulis</th>
                            <th>Stok Rak</th>
                            <th>Status Data</th>
                            <th>Tindakan Operasional</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                        <tr>
                            <td>
                                <div class="book-info-td">
                                    <img src="{{ $book->cover }}" class="mini-cover" alt="Cover">
                                    <div>
                                        <strong style="color: #222; font-size: 0.95rem;">{{ $book->judul }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $book->penulis }}</td>
                            <td><strong>{{ $book->stok }} Eksampler</strong></td>
                            <td>
                                @if($book->stok > 0)
                                    <span class="badge badge-success">Tersedia</span>
                                @else
                                    <span class="badge badge-danger">Habis</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn-edit-stok" onclick="quickEditStok({{ $book->id }}, '{{ $book->judul }}', {{ $book->stok }})">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit Stok
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @empty
            <div class="genre-section" style="text-align: center; padding: 40px; color: #777;">
                <i class="fa-solid fa-box-open" style="font-size: 3rem; color: #bc8a93; margin-bottom: 15px;"></i>
                <p>Belum ada master data buku terdaftar di dalam sistem database.</p>
            </div>
            @endforelse

        </main>
    </div>

    <script>
        // 1. FUNGSI UNTUK MODAL QUICK EDIT STOK BUKU VIA AJAX
        function quickEditStok(id, judul, stokSekarang) {
            Swal.fire({
                title: 'Update Stok Fisik Rak',
                text: `Masukkan jumlah ketersediaan unit terbaru untuk buku "${judul}":`,
                input: 'number',
                inputAttributes: {
                    min: 0,
                    step: 1
                },
                inputValue: stokSekarang,
                showCancelButton: true,
                confirmButtonColor: '#b5838d',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Simpan Stok Baru',
                cancelButtonText: 'Batal',
                background: 'rgba(255, 255, 255, 0.95)',
                backdrop: 'rgba(0,0,0,0.2)',
                inputValidator: (value) => {
                    if (!value || value < 0) {
                        return 'Jumlah stok tidak boleh kosong atau minus!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Pengiriman kuota angka stok baru via AJAX Post request
                    fetch(`/admin/katalog/update-stok/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            stok: result.value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Stok Terupdate!',
                                text: data.message,
                                confirmButtonColor: '#b5838d',
                                background: 'rgba(255, 255, 255, 0.95)'
                            }).then(() => {
                                window.location.reload(); // Reload ringan untuk menyegarkan angka tabel
                            });
                        } else {
                            Swal.fire('Gagal', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Eror', 'Gagal memperbarui data ke server.', 'error');
                    });
                }
            });
        }

        // 2. ⚡ FUNGSI PENCARIAN KATALOG LIVE SEARCH (Sudah Dikeluarkan & Berdiri Sendiri)
        function filterKatalog() {
            let input = document.getElementById("katalogSearch").value.toLowerCase();
            let tableRows = document.querySelectorAll(".custom-table tbody tr");

            tableRows.forEach(row => {
                // Mengambil text judul dari kolom td pertama (Detail Cover & Judul Buku)
                let judulBuku = row.querySelector("td").innerText.toLowerCase();
                // Mengambil text nama penulis dari kolom td kedua
                let penulisBuku = row.querySelector("td:nth-child(2)").innerText.toLowerCase();
                
                if (judulBuku.includes(input) || penulisBuku.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>