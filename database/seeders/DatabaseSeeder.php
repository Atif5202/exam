<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            LivreSeeder::class,
            AdherentSeeder::class,
            EmpruntSeeder::class,
            BibliothecaireSeeder::class,
        ]);
    }
}


