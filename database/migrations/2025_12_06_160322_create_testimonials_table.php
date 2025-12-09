<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel testimonials untuk menyimpan review pelanggan.
     * Data ini akan ditampilkan di section testimonials.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('author_name'); // Nama pelanggan
            $table->text('content'); // Isi testimoni
            $table->integer('rating')->default(5); // Rating 1-5 bintang
            $table->boolean('is_active')->default(true); // Status tampil/hide
            $table->integer('order')->default(0); // Urutan tampilan
            $table->timestamps();
        });
    }

    /**
     * Rollback - hapus tabel testimonials
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};