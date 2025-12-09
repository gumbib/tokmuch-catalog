<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Urutan penting: Category dulu, baru Product (karena foreign key)
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,      // Settings dulu
            CategorySeeder::class,     // Kategori dulu
            ProductSeeder::class,      // Produk setelah kategori
            TestimonialSeeder::class,  // Testimonial terakhir
        ]);
    }
}