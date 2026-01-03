<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel untuk menyimpan alamat pelanggan
     */
    public function up(): void
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            
            // Data pelanggan
            $table->string('customer_name'); // Nama penerima
            $table->string('customer_phone'); // Nomor HP
            $table->string('customer_email')->nullable(); // Email (optional)
            
            // Data alamat lengkap
            $table->text('address'); // Alamat lengkap
            $table->string('province_id'); // ID provinsi dari RajaOngkir
            $table->string('province_name'); // Nama provinsi
            $table->string('city_id'); // ID kota dari RajaOngkir
            $table->string('city_name'); // Nama kota
            $table->string('subdistrict_id'); // ID Kecamatan
            $table->string('subdistrict_name'); // Nama Kecamatan
            $table->string('postal_code')->nullable(); // Kode pos
            
            // Data produk yang dipesan
            $table->string('product_name'); // Nama produk yang dipesan
            $table->decimal('product_price', 10, 2); // Harga produk
            $table->integer('product_weight')->default(500); // Berat dalam gram
            
            // Data shipping yang dipilih
            $table->string('shipping_courier')->nullable(); // JNE, TIKI, POS, dll
            $table->string('shipping_service')->nullable(); // REG, YES, OKE, dll
            $table->decimal('shipping_cost', 10, 2)->nullable(); // Ongkir
            $table->string('shipping_etd')->nullable(); // Estimasi waktu (2-3 hari)
            
            // Total dan catatan
            $table->decimal('total_amount', 10, 2)->nullable(); // Total = produk + ongkir
            $table->text('notes')->nullable(); // Catatan tambahan dari customer
            
            // Status order
            $table->enum('status', ['pending', 'confirmed', 'shipping', 'delivered', 'cancelled'])
                  ->default('pending');
            
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Hapus tabel jika rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};