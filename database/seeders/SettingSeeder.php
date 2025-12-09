<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_title',
                'value' => 'TOKMUCH',
                'type' => 'text',
                'group' => 'general'
            ],
            [
                'key' => 'site_tagline',
                'value' => 'E-Katalog Interaktif Tokmuch',
                'type' => 'text',
                'group' => 'general'
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '6285701888105',
                'type' => 'text',
                'group' => 'contact'
            ],
            [
                'key' => 'about_title',
                'value' => 'Halo! Saya Yulianto Wibowo 👋',
                'type' => 'text',
                'group' => 'about'
            ],
            [
                'key' => 'about_description',
                'value' => 'Tokmuch merupakan sebuah brand kreatif yang berdiri sejak tahun 2019. Nama Tokmuch merupakan singkatan dari Toko Muchtarom, yang diambil dari nama Muchtarom, ayah dari pemilik (owner) brand Tokmuch. Nama ini dipilih sebagai bentuk penghormatan sekaligus identitas yang memiliki nilai personal bagi pendirinya. Tokmuch bergerak di bidang seni lukis dan produk kreatif berbasis custom. Brand ini memproduksi sekaligus menjual berbagai produk seni dengan sentuhan lukisan manual yang unik dan bernilai estetika tinggi. Rata-rata produk yang dijual di Tokmuch merupakan barang handmade 100%, yang dikerjakan langsung secara manual dengan mengutamakan ketelitian, kreativitas, dan kualitas seni.',
                'type' => 'textarea',
                'group' => 'about'
            ],
            [
                'key' => 'hero_title',
                'value' => 'Selamat Datang!',
                'type' => 'text',
                'group' => 'hero'
            ],
            [
                'key' => 'hero_description',
                'value' => 'E-Katalog Interaktif Tokmuch - Custom Jaket, Tas, dan Lukis Pensil Media Kertas',
                'type' => 'textarea',
                'group' => 'hero'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}