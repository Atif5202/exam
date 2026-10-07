<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BibliothecaireSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'bibliothecaire@example.com'],
            [
                'name' => 'Bibliothecaire',
                'email' => 'bibliothecaire@example.com',
                'password' => bcrypt('bibliothecaire'),
            ]
        );
    }
}