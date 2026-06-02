<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Mengizinkan kolom ini diisi secara massal (Tambahkan 'status' di sini)
    protected $fillable = ['judul', 'penulis', 'genre', 'status', 'stok', 'cover'];

    // Relasi: Satu buku bisa memiliki banyak riwayat transaksi peminjaman
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}