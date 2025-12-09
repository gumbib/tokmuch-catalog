<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'author_name' => 'Sarah Amanda',
                'content' => 'Hasilnya melebihi ekspektasi! Lukisan pensil yang saya pesan sangat detail dan realistis. Senang sekali bisa dapat kado istimewa untuk pasangan saya. Recommended banget!',
                'rating' => 5,
                'is_active' => true,
                'order' => 1
            ],
            [
                'author_name' => 'Rizky Pratama',
                'content' => 'Custom jaket untuk komunitas kami dikerjakan dengan sangat profesional. Desainnya keren dan kualitas cat lukisannya nya awet. Pasti bakal order lagi untuk batch berikutnya!',
                'rating' => 5,
                'is_active' => true,
                'order' => 2
            ],
            [
                'author_name' => 'Diana Putri',
                'content' => 'Totebag custom untuk merchandise bisnis saya ternyata sangat bagus dan harga nya terjangkau. Pelayanan nya juga cepat dan ramah. Terima kasih TOKMUCH!',
                'rating' => 5,
                'is_active' => true,
                'order' => 3
            ],
            [
                'author_name' => 'Farhan Malik',
                'content' => 'Pertama kali order custom jaket disini dan langsung jatuh cinta sama hasilnya. Detail design nya rapi banget dan bahan nya juga comfortable dipake sehari-hari.',
                'rating' => 5,
                'is_active' => true,
                'order' => 4
            ],
            [
                'author_name' => 'Soleh Pambudi',
                'content' => 'Lukisan pensil untuk hadiah anniversary pacar saya bener-bener bikin dia terharu. Detailnya amazing dan pengerjaan nya cepat. Worth it banget!',
                'rating' => 5,
                'is_active' => true,
                'order' => 5
            ],
            [
                'author_name' => 'Budi Santoso',
                'content' => 'Totebag custom yang saya pesan jadi favorit baru untuk belanja ke pasar. Desain nya unik dan bahan nya kuat. Pelayanan admin nya juga fast response banget!',
                'rating' => 5,
                'is_active' => true,
                'order' => 6
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}