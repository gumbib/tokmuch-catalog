<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel settings untuk konfigurasi website.
     * Menggunakan key-value pair untuk fleksibilitas.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Key pengaturan (contoh: "whatsapp_number")
            $table->text('value')->nullable(); // Value pengaturan
            $table->string('type')->default('text'); // Tipe data: text, textarea, number, etc
            $table->string('group')->nullable(); // Grouping pengaturan
            $table->timestamps();
        });
    }

    /**
     * Rollback - hapus tabel settings
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};