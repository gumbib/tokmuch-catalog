<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Menjalankan seeder untuk mengisi tabel categories.
     * Gradient colors sudah disesuaikan dengan dark warm palette.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Lukis Pensil',
                'slug' => 'lukis-pensil',
                'description' => 'Karya seni lukisan menggunakan pensil dengan detail tinggi pada media kertas A4',
                'icon' => '✏️',
                'price_range' => 'IDR 150.000 (A4)',
                // Gradient dengan warm tones yang subtle
                'gradient_color' => 'linear-gradient(135deg, rgba(255, 111, 97, 0.15) 0%, rgba(218, 165, 32, 0.15) 100%)',
                'order' => 1
            ],
            [
                'name' => 'Custom Jaket',
                'slug' => 'custom-jaket',
                'description' => 'Custom design pada berbagai jenis jaket dengan sablon atau bordir berkualitas premium',
                'icon' => '🧥',
                'price_range' => 'IDR 100.000 - 200.000',
                // Gradient coral to orange dengan opacity rendah
                'gradient_color' => 'linear-gradient(135deg, rgba(255, 111, 97, 0.2) 0%, rgba(255, 69, 0, 0.15) 100%)',
                'order' => 2
            ],
            [
                'name' => 'Custom Tas Totebag',
                'slug' => 'custom-tas-totebag',
                'description' => 'Tas totebag dengan design custom, ramah lingkungan dan stylish untuk penggunaan sehari-hari',
                'icon' => '👜',
                'price_range' => 'IDR 15.000 - 25.000',
                // Gradient yellow to coral dengan opacity rendah
                'gradient_color' => 'linear-gradient(135deg, rgba(218, 165, 32, 0.15) 0%, rgba(255, 111, 97, 0.15) 100%)',
                'order' => 3
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}