<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - Perpustakaan Smart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { background: url("{{ asset('images/yaya5.png') }}") no-repeat center center fixed; background-size: cover; display: flex; min-height: 100vh; color: #333; padding: 20px; }
        .dashboard-container { display: flex; width: 100%; max-width: 1400px; margin: auto; background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 30px; overflow: hidden; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05); }
        .sidebar { width: 260px; background: rgba(255, 255, 255, 0.2); padding: 40px 20px; display: flex; flex-direction: column; justify-content: space-between; border-right: 1px solid rgba(255, 255, 255, 0.2); }
        .brand { text-align: center; margin-bottom: 40px; }
        .brand i { font-size: 2.5rem; color: #bc8a93; margin-bottom: 10px; }
        .brand h1 { font-size: 1.4rem; color: #b5838d; font-weight: 600; }
        .menu-list { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .menu-item a { display: flex; align-items: center; gap: 15px; padding: 12px 20px; color: #555; text-decoration: none; font-weight: 500; border-radius: 12px; transition: 0.3s; }
        .menu-item.active a, .menu-item a:hover { background: rgba(255, 255, 255, 0.6); color: #b5838d; }
        .logout-btn { color: #d48386 !important; }
        .main-content { flex: 1; padding: 40px; overflow-y: auto; max-height: 90vh; }
        .catalog-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        .catalog-header h2 { font-size: 1.8rem; font-weight: 600; color: #222; }
        .search-container { position: relative; width: 320px; }
        .search-container input { width: 100%; padding: 10px 20px 10px 40px; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.5); background: rgba(255, 255, 255, 0.6); outline: none; font-size: 0.88rem; color: #333; transition: 0.3s; }
        .search-container input:focus { background: rgba(255, 255, 255, 0.9); border-color: rgba(255, 255, 255, 0.8); }
        .search-container i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #888; }
        
        .genre-section { margin-bottom: 45px; }
        .genre-title { font-size: 1.25rem; font-weight: 600; color: #222; margin-bottom: 18px; display: flex; align-items: center; gap: 10px; }
        .genre-title span { width: 6px; height: 22px; border-radius: 3px; display: inline-block; background-color: #b5838d; }
        
        .book-slider { display: flex; gap: 20px; overflow-x: auto; padding: 10px 15px 20px 15px; position: relative; }
        .book-slider::-webkit-scrollbar { height: 8px; }
        .book-slider::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.02); border-radius: 10px; }
        .book-slider::-webkit-scrollbar-thumb { background: rgba(181, 131, 141, 0.3); border-radius: 10px; }

        .book-card {
            min-width: 190px; max-width: 190px;
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4); border-radius: 18px;
            padding: 15px; text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02);
            transition: all 0.4s ease;
            position: relative;
        }
        .book-card:hover { transform: translateY(-5px); background: rgba(255, 255, 255, 0.75); }
        
        .book-cover-wrapper { width: 100%; height: 210px; border-radius: 12px; overflow: hidden; margin-bottom: 12px; box-shadow: 0 6px 12px rgba(0,0,0,0.06); display: flex; align-items: center; justify-content: center; }
        .book-cover { width: 100%; height: 100%; object-fit: cover; }
        .book-title { font-size: 0.92rem; font-weight: 600; color: #222; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align: left; }
        .book-author { font-size: 0.78rem; color: #777; text-align: left; margin-bottom: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        
        .book-footer { 
            display: flex; justify-content: space-between; align-items: center; 
            padding-top: 8px; border-top: 1px solid rgba(0, 0, 0, 0.04);
            position: relative; z-index: 99;
        }
        .book-status { font-size: 0.72rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
        .status-tersedia { background-color: #e2f0cb; color: #547c11; }
        .status-dipinjam { background-color: #ffcad4; color: #b5838d; }
        
        .btn-pinjam { background: none; border: none; color: #92c5f2; cursor: pointer; font-size: 1.2rem; transition: 0.2s; display: inline-block; }
        .btn-pinjam:hover { color: #4fa1cf; transform: scale(1.15); }
        @media (max-width: 1000px) { .dashboard-container { flex-direction: column; } .sidebar { width: 100%; border-right: none; border-bottom: 1px solid rgba(255,255,255,0.2); } }
    </style>
</head>
<body>

    <div class="dashboard-container">
        
        <!-- // ======================================================== // -->
        <!-- // 🧭 KOREKSI SIDEBAR FIXED: Hanya Menampilkan 3 Menu Mahasiswa// -->
        <!-- // ======================================================== // -->
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

        <main class="main-content">
            <div class="catalog-header">
                <h2>Katalog Buku</h2>
                <form action="{{ route('katalog') }}" method="GET" class="search-container">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul buku atau penulis...">
                </form>
            </div>

            @forelse($booksGrouped as $genreName => $books)
            <div class="genre-section">
                <div class="genre-title">
                    <span></span> {{ $genreName }}
                </div>
                <div class="book-slider">
                    @foreach($books as $book)
                    <div class="book-card">
                        <div class="book-cover-wrapper">
                            <img class="book-cover" src="{{ $book->cover }}" alt="Cover Buku">
                        </div>
                        <div class="book-title" title="{{ $book->judul }}">{{ $book->judul }}</div>
                        <div class="book-author">{{ $book->penulis }}</div>
                        
                        <div class="book-footer">
                            <div style="display: flex; flex-direction: column; gap: 2px; text-align: left;">
                                
                                @if($book->stok > 0)
                                    @php
                                        $transaksiUser = $book->borrowings()
                                                            ->where('user_id', Auth::id())
                                                            ->whereIn('status', ['Pending', 'Dipinjam'])
                                                            ->first();
                                    @endphp

                                    @if($transaksiUser)
                                        @if($transaksiUser->status == 'Pending')
                                            <span class="book-status-label book-status" style="background-color: #fef5d1; color: #bfa103; font-size: 0.7rem;">Dipesan</span>
                                        @else
                                            <span class="book-status-label book-status status-dipinjam" style="font-size: 0.7rem;">Dipinjam</span>
                                        @endif
                                    @else
                                        <span class="book-status-label book-status status-tersedia" style="font-size: 0.7rem;">Tersedia</span>
                                    @endif
                                    
                                    <small style="color: #666; font-size: 0.75rem; font-weight: 500; margin-top: 2px;">
                                        Stok: <strong>{{ $book->stok }} Buku</strong>
                                    </small>

                                @else
                                    <span class="book-status-label book-status" style="font-size: 0.7rem; background-color: #eaeaea; color: #777;">Habis</span>
                                    <small style="color: #d48386; font-size: 0.75rem; font-weight: 500; margin-top: 2px;">Di rak: 0 Buku</small>
                                @endif

                            </div>
                            
                            <div class="action-wrapper">
                                @if($book->stok > 0 && !$book->borrowings()->where('user_id', Auth::id())->whereIn('status', ['Pending', 'Dipinjam'])->exists())
                                    <button type="button" class="btn-pinjam btn-trigger-pinjam" data-id="{{ $book->id }}" data-judul="{{ $book->judul }}" title="Pinjam Buku">
                                        <i class="fa-solid fa-circle-plus"></i>
                                    </button>
                                @else
                                    <button class="btn-pinjam" title="Tidak Tersedia" style="opacity: 0.25; cursor: not-allowed;" disabled>
                                        <i class="fa-solid fa-circle-plus"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 50px; color: #666;">
                <i class="fa-solid fa-book-open" style="font-size: 3rem; color: #bc8a93; margin-bottom: 15px;"></i>
                <p>Buku "<strong>{{ request('search') }}</strong>" tidak ditemukan.</p>
            </div>
            @endforelse
        </main>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. ANIMASI SLIDER GENRE
        const sliders = document.querySelectorAll('.book-slider');
        sliders.forEach(slider => {
            let scrollSpeed = 0.6; 
            let autoScrollInterval;
            let isHovered = false;

            function startAutoScroll() {
                autoScrollInterval = setInterval(() => {
                    if (!isHovered) {
                        slider.scrollLeft += scrollSpeed;
                        if (slider.scrollLeft >= (slider.scrollWidth - slider.clientWidth - 1)) {
                            slider.scrollLeft = 0;
                        }
                    }
                }, 20); 
            }
            slider.addEventListener('mouseenter', () => { isHovered = true; });
            slider.addEventListener('mouseleave', () => { isHovered = false; });
            startAutoScroll();
        });

        // 2. EKSEKUSI AJAX SIRKULASI & SWEETALERT2
        const buttons = document.querySelectorAll('.btn-trigger-pinjam');
        
        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const bookId = this.getAttribute('data-id');
                const bookTitle = this.getAttribute('data-judul');
                const footerContainer = this.closest('.book-footer');
                const statusLabel = footerContainer.querySelector('.book-status-label');
                const actionWrapper = footerContainer.querySelector('.action-wrapper');

                Swal.fire({
                    title: 'Konfirmasi Peminjaman',
                    text: `Apakah kamu yakin ingin meminjam buku "${bookTitle}"? Batas sirkulasi peminjaman adalah 14 hari.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#b5838d', 
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya, Ajukan!',
                    cancelButtonText: 'Kembali Memilih',
                    background: 'rgba(255, 255, 255, 0.95)',
                    backdrop: `rgba(0,0,0,0.15)`
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/pinjam-buku/${bookId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pengajuan Berhasil!',
                                    text: data.message,
                                    confirmButtonColor: '#b5838d',
                                    background: 'rgba(255, 255, 255, 0.95)'
                                });

                                // // ======================================================== // //
                                // // 🌟 KOREKSI REALTIME STATE: Mengubah ke Kuning (Dipesan)   // //
                                // // ======================================================== // //
                                statusLabel.textContent = 'Dipesan';
                                statusLabel.style.backgroundColor = '#fef5d1';
                                statusLabel.style.color = '#bfa103';
                                statusLabel.className = 'book-status-label book-status';
                                actionWrapper.innerHTML = `
                                    <button class="btn-pinjam" title="Sedang Dipesan" style="opacity: 0.3; cursor: not-allowed;" disabled>
                                        <i class="fa-solid fa-circle-plus"></i>
                                    </button>
                                `;
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message,
                                    confirmButtonColor: '#b5838d'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Sistem Sibuk',
                                text: 'Gagal menghubungi database.',
                                confirmButtonColor: '#b5838d'
                            });
                        });
                    }
                });
            });
        });
    });
</script>
</body>
</html>