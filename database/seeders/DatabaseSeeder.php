<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            HeroSlideSeeder::class,
            ContentSeeder::class,
            ActorSeeder::class,
            CreatorSeeder::class,
        ]);
    }
}