<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeroSlideSeeder extends Seeder
{
    public function run()
    {
        DB::table('hero_slides')->insert([
            [
                'title' => 'Noite de Verão',
                'description' => 'Uma história envolvente de paixão e mistério em uma noite quente de verão.',
                'date' => '22 Mar 2024',
                'image' => 'images/hero/slide1.jpg',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Encontro Casual',
                'description' => 'Quando o destino conspira para unir dois corações solitários.',
                'date' => '23 Mar 2024',
                'image' => 'images/hero/slide2.jpg',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Paixão Proibida',
                'description' => 'Um romance intenso que desafia todas as convenções.',
                'date' => '24 Mar 2024',
                'image' => 'images/hero/slide3.jpg',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Desejo Ardente',
                'description' => 'Uma aventura sensual que vai despertar seus sentidos.',
                'date' => '25 Mar 2024',
                'image' => 'images/hero/slide4.jpg',
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}