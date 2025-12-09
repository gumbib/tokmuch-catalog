<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migration untuk membuat tabel categories.
     * Tabel ini menyimpan informasi kategori produk seperti nama, deskripsi, dan range harga.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary key auto increment
            $table->string('name'); // Nama kategori (contoh: "Lukis Pensil")
            $table->string('slug')->unique(); // URL-friendly name (contoh: "lukis-pensil")
            $table->text('description')->nullable(); // Deskripsi kategori
            $table->string('icon')->nullable(); // Icon emoji atau path image
            $table->string('price_range'); // Range harga (contoh: "IDR 150.000")
            $table->string('gradient_color')->nullable(); // Warna gradient untuk styling
            $table->integer('order')->default(0); // Urutan tampilan kategori
            $table->timestamps(); // created_at dan updated_at otomatis
        });
    }

    /**
     * Rollback migration - menghapus tabel categories
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};