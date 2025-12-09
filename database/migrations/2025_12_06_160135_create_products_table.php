<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel products yang menyimpan detail setiap karya/produk.
     * Setiap produk terhubung ke satu kategori melalui foreign key.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id') // Foreign key ke tabel categories
                  ->constrained() // Otomatis reference ke table categories(id)
                  ->onDelete('cascade'); // Jika kategori dihapus, produk juga terhapus
            $table->string('title'); // Judul produk
            $table->text('description'); // Deskripsi detail produk
            $table->decimal('price', 10, 2); // Harga dengan format: 9999999.99
            $table->string('image_icon')->nullable(); // Icon atau placeholder image
            $table->string('gradient_color')->nullable(); // Custom gradient per produk
            $table->boolean('is_featured')->default(false); // Produk unggulan
            $table->integer('order')->default(0); // Urutan tampilan dalam kategori
            $table->timestamps();
        });
    }

    /**
     * Rollback - hapus tabel products
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};