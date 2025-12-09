<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara mass assignment.
     * Ini penting untuk keamanan, hanya kolom ini yang bisa diisi via create() atau update()
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'price_range',
        'gradient_color',
        'order'
    ];

    /**
     * Relasi One-to-Many: Satu kategori memiliki banyak produk.
     * Contoh penggunaan: $category->products
     */
    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('order');
    }

    /**
     * Scope untuk query kategori yang diurutkan.
     * Contoh penggunaan: Category::ordered()->get()
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}