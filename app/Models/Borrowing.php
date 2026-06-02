<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'tanggal_pinjam',
        'tenggat_kembali',
        'tanggal_kembali',
        'status'
    ];

    // 👤 RELASI KE MODEL USER (Mahasiswa yang meminjam)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 📚 RELASI KE MODEL BOOK (Buku yang dipinjam)
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}