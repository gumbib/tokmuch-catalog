<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi mass assignment
     */
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'price',
        'image_icon',
        'gradient_color',
        'is_featured',
        'order'
    ];

    /**
     * Cast tipe data untuk kolom tertentu.
     * price akan otomatis dikonversi ke float, is_featured ke boolean
     */
    protected $casts = [
        'price' => 'float',
        'is_featured' => 'boolean'
    ];

    /**
     * Relasi Many-to-One: Banyak produk milik satu kategori.
     * Contoh penggunaan: $product->category->name
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Accessor untuk format harga dengan IDR.
     * Contoh penggunaan: $product->formatted_price
     */
    public function getFormattedPriceAttribute()
    {
        return 'IDR ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Scope untuk produk unggulan
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}