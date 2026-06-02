<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 👑 1. Akun Admin Perpustakaan (Masuk Pakai Username)
        User::create([
            'name'     => 'Petugas Pustakawan',
            'username' => 'admin_perpus', // Login menggunakan ini!
            'email'    => 'admin@sls.com',
            'password' => bcrypt('admin123'),
            'role'     => 'admin',
        ]);

        // 🟢 2. Akun Mahasiswa (Masuk Pakai Email)
        $user = User::create([
            'name'     => 'Amanda Putri',
            'username' => 'amanda_putri',
            'email'    => 'putriauliyaamanda22@gmail.com', // Login menggunakan ini!
            'password' => bcrypt('123456789'),
            'role'     => 'mahasiswa',
        ]);

        // 📚 2. Data Master Buku Berdasarkan Manifestasi Frontend
        $booksData = [
            // GENRE 1: FIKSI & NOVEL POPULER
            ['judul' => 'Ancika: Dia yang Bersamaku Tahun 1995', 'penulis' => 'Pidi Baiq', 'genre' => '1. Kelompok Fiksi (Cerita Rekaan)', 'cover' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=400'],
            ['judul' => 'The Architecture of Love', 'penulis' => 'Ika Natassa', 'genre' => '1. Kelompok Fiksi (Cerita Rekaan)', 'cover' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=400'],
            ['judul' => 'Harry Potter dan Batu Bertuah', 'penulis' => 'J.K. Rowling', 'genre' => '1. Kelompok Fiksi (Cerita Rekaan)', 'cover' => 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=400'],
            ['judul' => 'The Lord of the Rings', 'penulis' => 'J.R.R. Tolkien', 'genre' => '1. Kelompok Fiksi (Cerita Rekaan)', 'cover' => 'https://images.unsplash.com/photo-1495640388908-05fa85288e61?q=80&w=400'],
            ['judul' => 'Dune (Bagian Pertama)', 'penulis' => 'Frank Herbert', 'genre' => '1. Kelompok Fiksi (Cerita Rekaan)', 'cover' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?q=80&w=400'],
            ['judul' => 'Supernova: Ksatria, Puteri, & Bintang Jatuh', 'penulis' => 'Dee Lestari', 'genre' => '1. Kelompok Fiksi (Cerita Rekaan)', 'cover' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=400'],
            ['judul' => 'Pembunuhan di Orient Express', 'penulis' => 'Agatha Christie', 'genre' => '1. Kelompok Fiksi (Cerita Rekaan)', 'cover' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?q=80&w=400'],
            ['judul' => 'Katarsis', 'penulis' => 'Anastasia Aemilia', 'genre' => '1. Kelompok Fiksi (Cerita Rekaan)', 'cover' => 'https://images.unsplash.com/photo-1509248961158-e54f6934749c?q=80&w=400'],
            ['judul' => 'KKN di Desa Penari', 'penulis' => 'SimpleMan', 'genre' => '1. Kelompok Fiksi (Cerita Rekaan)', 'cover' => 'https://images.unsplash.com/photo-1514894780887-121968d00567?q=80&w=400'],
            ['judul' => 'Gadis Kretek', 'penulis' => 'Ratih Kumala', 'genre' => '1. Kelompok Fiksi (Cerita Rekaan)', 'cover' => 'https://images.unsplash.com/photo-1476275466078-4007374efbbe?q=80&w=400'],

            // GENRE 2: TEKNOLOGI & GAME DEVELOPMENT
            ['judul' => 'Mastering C++ & SDL2 Game Development', 'penulis' => 'GameDev Academy', 'genre' => '2. Game Development & C++', 'cover' => 'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?q=80&w=400'],
            ['judul' => 'Game Programming Patterns', 'penulis' => 'Robert Nystrom', 'genre' => '2. Game Development & C++', 'cover' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=400'],
            ['judul' => 'Introduction to Computer Graphics', 'penulis' => 'Dr. Alan Watt', 'genre' => '2. Game Development & C++', 'cover' => 'https://images.unsplash.com/photo-1508921912186-1d1a45ebb3c1?q=80&w=400'],
            ['judul' => 'Beginning C++ Through Game Programming', 'penulis' => 'Michael Dawson', 'genre' => '2. Game Development & C++', 'cover' => 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=400'],
            ['judul' => 'WebAssembly: Up and Running', 'penulis' => 'Gerard Gallant', 'genre' => '2. Game Development & C++', 'cover' => 'https://images.unsplash.com/photo-1607799279861-4dd421887fb3?q=80&w=400'],
            ['judul' => 'SDL2 Game Development Essentials', 'penulis' => 'Shaun Mitchell', 'genre' => '2. Game Development & C++', 'cover' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?q=80&w=400'],
            ['judul' => 'Clean Code', 'penulis' => 'Robert C. Martin', 'genre' => '2. Game Development & C++', 'cover' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=400'],
            ['judul' => 'Design Patterns in C++', 'penulis' => 'Dmitri Nesteruk', 'genre' => '2. Game Development & C++', 'cover' => 'https://images.unsplash.com/photo-1627398242454-45a1465c2079?q=80&w=400'],
            ['judul' => 'The C++ Programming Language', 'penulis' => 'Bjarne Stroustrup', 'genre' => '2. Game Development & C++', 'cover' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=400'],
            ['judul' => 'Interactive Computer Graphics with WebGL', 'penulis' => 'Edward Angel', 'genre' => '2. Game Development & C++', 'cover' => 'https://images.unsplash.com/photo-1581291518655-9523c932dedf?q=80&w=400'],
        ];

        // Looping untuk menyimpan data buku secara massal ke SQLite
        foreach ($booksData as $bookItem) {
            Book::create([
                'judul' => $bookItem['judul'],
                'penulis' => $bookItem['penulis'],
                'genre' => $bookItem['genre'],
                'status' => 'Tersedia', 
                'stok' => 3,            
                'cover' => $bookItem['cover'],
            ]);
        }

        // 3. Sinkronisasi Data Transaksi Peminjaman Riil Amanda
        $hpBook = Book::where('judul', 'like', '%Harry Potter%')->first();
        if ($hpBook) {
            $hpBook->update([
                'stok' => 2,
                'status' => 'Tersedia' 
            ]); 

            Borrowing::create([
                'user_id' => $user->id,
                'book_id' => $hpBook->id,
                'tanggal_pinjam' => '2026-05-20',
                'tenggat_kembali' => '2026-06-03',
                'status' => 'Dipinjam',
            ]);
        }

        // 4. Sinkronisasi Data Riwayat Aktivitas Peminjaman (Selesai di Masa Lalu)
        $supernovaBook = Book::where('judul', 'like', '%Supernova%')->first();
        if ($supernovaBook) {
            Borrowing::create([
                'user_id' => $user->id,
                'book_id' => $supernovaBook->id,
                'tanggal_pinjam' => '2026-04-10',
                'tenggat_kembali' => '2026-04-24',
                'tanggal_kembali' => '2026-04-24',
                'status' => 'Selesai',
            ]);
        }
    }
}