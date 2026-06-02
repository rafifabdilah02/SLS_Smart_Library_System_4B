<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('borrowings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
    $table->foreignId('book_id')->constrained()->onDelete('cascade'); 
    $table->date('tanggal_pinjam');
    $table->date('tenggat_kembali');
    $table->date('tanggal_kembali')->nullable(); 
    
    // PERBAIKAN: Tambahkan 'Pending' ke dalam daftar enum dan jadikan sebagai default
    $table->enum('status', ['Pending', 'Dipinjam', 'Selesai'])->default('Pending');
    
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
