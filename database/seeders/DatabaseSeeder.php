<?php

namespace Database\Seeders;

use App\Models\Adherent;
use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\User;
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


