<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan model ini
     */
    protected $table = 'customer_addresses';

    /**
     * Kolom-kolom yang boleh diisi mass assignment
     */
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'address',
        'province_id',
        'province_name',
        'city_id',
        'city_name',
        'subdistrict_id',
        'subdistrict_name',
        'postal_code',
        'product_name',
        'product_price',
        'product_weight',
        'shipping_courier',
        'shipping_service',
        'shipping_cost',
        'payment_method',
        'shipping_etd',
        'total_amount',
        'notes',
        'status',
    ];

    /**
     * Cast tipe data untuk kolom tertentu
     */
    protected $casts = [
        'product_price' => 'float',
        'product_weight' => 'integer',
        'shipping_cost' => 'float',
        'total_amount' => 'float',
    ];

    /**
     * Helper method untuk format harga dengan Rupiah
     */
    public function getFormattedProductPriceAttribute()
    {
        return 'Rp ' . number_format($this->product_price, 0, ',', '.');
    }

    /**
     * Helper method untuk format ongkir dengan Rupiah
     */
    public function getFormattedShippingCostAttribute()
    {
        return 'Rp ' . number_format($this->shipping_cost, 0, ',', '.');
    }

    /**
     * Helper method untuk format total dengan Rupiah
     */
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

        /**
     * Helper method untuk mendapatkan alamat lengkap dalam satu string
     * Berguna untuk ditampilkan di WhatsApp message atau invoice
     */
    public function getFullAddressAttribute()
    {
        $parts = [
            $this->address,
            $this->subdistrict_name,
            $this->city_name,
            $this->province_name,
        ];

        if ($this->postal_code) {
            $parts[] = $this->postal_code;
        }

        return implode(', ', array_filter($parts));
    }
}

