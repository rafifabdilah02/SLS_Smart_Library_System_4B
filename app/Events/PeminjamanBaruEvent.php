<?php

namespace App\Events;

use App\Models\Borrowing;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// implements ShouldBroadcast wajib ada agar Laravel tahu event ini harus dipancarkan ke luar server
class PeminjamanBaruEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $borrowing;

    public function __construct(Borrowing $borrowing)
    {
        // Memuat data transaksi sirkulasi beserta relasi user dan book agar namanya ikut terbawa
        $this->borrowing = $borrowing->load(['user', 'book']);
    }

    public function broadcastOn(): array
    {
        // Menentukan nama saluran komunikasi publik bebas hambatan
        return [
            new Channel('public-sirkulasi-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        // Nama alias event saat didengarkan oleh JavaScript di frontend nanti
        return 'peminjaman.baru';
    }
}