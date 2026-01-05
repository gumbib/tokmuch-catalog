<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Menjalankan seeder untuk mengisi produk.
     * Setiap kategori hanya punya SATU produk, tapi dengan multiple sample images.
     * Produk pertama (is_featured = true) akan muncul di homepage.
     * Produk lainnya adalah sample images yang muncul di halaman detail.
     */
    public function run(): void
    {
        // ========================================
        // KATEGORI: LUKIS PENSIL
        // Produk: Sketsa Wajah Custom
        // ========================================
        $lukisPensil = Category::where('slug', 'lukis-pensil')->first();
        $sketsaWajahSamples = [
            [
                'title' => 'Sketsa Wajah Custom',
                'description' => '',
                'price' => 150000,
                'image_icon' => 'products/lukis-pensil-1.jpg',
                'gradient_color' => 'linear-gradient(135deg, #4ECDC4 0%, #A8DADC 100%)',
                'is_featured' => true, // Sample pertama featured di homepage
                'order' => 1
            ],
            [
                'title' => 'Sketsa Wajah Custom',
                'description' => '',
                'price' => 150000,
                'image_icon' => 'products/lukis-pensil-2.jpg',
                'gradient_color' => 'linear-gradient(135deg, #4ECDC4 0%, #A8DADC 100%)',
                'is_featured' => false,
                'order' => 2
            ],
            [
                'title' => 'Sketsa Wajah Custom',
                'description' => '',
                'price' => 150000,
                'image_icon' => 'products/lukis-pensil-3.jpg',
                'gradient_color' => 'linear-gradient(135deg, #4ECDC4 0%, #A8DADC 100%)',
                'is_featured' => false,
                'order' => 3
            ],
            [
                'title' => 'Sketsa Wajah Custom',
                'description' => '',
                'price' => 150000,
                'image_icon' => 'products/lukis-pensil-4.jpg',
                'gradient_color' => 'linear-gradient(135deg, #4ECDC4 0%, #A8DADC 100%)',
                'is_featured' => false,
                'order' => 4
            ],
        ];

        foreach ($sketsaWajahSamples as $sample) {
            Product::create(array_merge($sample, ['category_id' => $lukisPensil->id]));
        }

        // ========================================
        // KATEGORI: LUKIS Acrylic
        // Produk: Lukisan acrylic
        // ========================================
        $lukisAcrylic = Category::where('slug', 'lukis-acrylic')->first();
        $acrylicSamples = [
            [
                'title' => 'Lukis Acrylic',
                'description' => '',
                'price' => 100000,
                'image_icon' => 'products/sketsa-3.jpeg',
                'gradient_color' => 'linear-gradient(135deg, #4ECDC4 0%, #A8DADC 100%)',
                'is_featured' => true,
                'order' => 1
            ],
            [
                'title' => 'Lukis Acrylic',
                'description' => '',
                'price' => 100000,
                'image_icon' => 'products/sketsa-1.jpeg',
                'gradient_color' => 'linear-gradient(135deg, #4ECDC4 0%, #A8DADC 100%)',
                'is_featured' => false,
                'order' => 2
            ],
        ];

        foreach ($acrylicSamples as $sample) {
            Product::create(array_merge($sample, ['category_id' => $lukisAcrylic->id]));
        }

        // ========================================
        // KATEGORI: CUSTOM JAKET
        // Produk: Jaket Design Eksklusif
        // ========================================
        $customJaket = Category::where('slug', 'custom-jaket')->first();
        
        // Multiple sample images untuk Hoodie Custom
        $hoodieSamples = [
            [
                'title' => 'Jaket Levis Custom Lukis',
                'description' => '',
                'price' => 175000,
                'image_icon' => 'products/custom-hoodie-1.png',
                'gradient_color' => 'linear-gradient(135deg, #FFE66D 0%, #F4A261 100%)',
                'is_featured' => true, // Featured di homepage
                'order' => 1
            ],
            [
                'title' => 'Jaket Levis Custom Lukis',
                'description' => '',
                'price' => 175000,
                'image_icon' => 'products/custom-hoodie-2.png',
                'gradient_color' => 'linear-gradient(135deg, #FFE66D 0%, #F4A261 100%)',
                'is_featured' => false,
                'order' => 2
            ],
        ];

        foreach ($hoodieSamples as $sample) {
            Product::create(array_merge($sample, ['category_id' => $customJaket->id]));
        }

        // ========================================
        // KATEGORI: CUSTOM TAS TOTEBAG
        // Produk: Totebag Custom Print
        // ========================================
        $customTas = Category::where('slug', 'custom-tas-totebag')->first();
        
        // Multiple sample images untuk Totebag Custom Print
        $totebagSamples = [
            [
                'title' => 'Totebag Custom Lukis',
                'description' => '',
                'price' => 20000,
                'image_icon' => 'products/custom-totebag-1.png',
                'gradient_color' => 'linear-gradient(135deg, #F4A261 0%, #FF6B6B 100%)',
                'is_featured' => true, // Featured di homepage
                'order' => 1
            ],
            [
                'title' => 'Totebag Custom Lukis',
                'description' => '',
                'price' => 20000,
                'image_icon' => 'products/custom-totebag-2.png',
                'gradient_color' => 'linear-gradient(135deg, #F4A261 0%, #FF6B6B 100%)',
                'is_featured' => false,
                'order' => 2
            ],
            [
                'title' => 'Totebag Custom Lukis',
                'description' => '',
                'price' => 20000,
                'image_icon' => 'products/custom-totebag-3.jpeg',
                'gradient_color' => 'linear-gradient(135deg, #F4A261 0%, #FF6B6B 100%)',
                'is_featured' => false,
                'order' => 3
            ],
            [
                'title' => 'Totebag Custom Lukis',
                'description' => '',
                'price' => 20000,
                'image_icon' => 'products/custom-totebag-4.jpeg',
                'gradient_color' => 'linear-gradient(135deg, #F4A261 0%, #FF6B6B 100%)',
                'is_featured' => false,
                'order' => 4
            ],
        ];

        foreach ($totebagSamples as $sample) {
            Product::create(array_merge($sample, ['category_id' => $customTas->id]));
        }
    }
}