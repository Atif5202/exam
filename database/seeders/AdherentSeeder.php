<?php

namespace Database\Seeders;

use App\Models\Adherent;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdherentSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $adherents = [
            ['nom' => 'Rakoto', 'prenom' => 'Atif', 'email' => 'atif.rakoto@example.com', 'telephone' => '0123456789', 'date_inscription' => '2025-01-15'],
            ['nom' => 'Mpidrana', 'prenom' => 'Zoky', 'email' => 'zoky.mpidrana@example.com', 'telephone' => '0234567890', 'date_inscription' => '2025-03-10'],
            ['nom' => 'Bernard', 'prenom' => 'Paul', 'email' => 'paul.bernard@example.com', 'telephone' => '0345678901', 'date_inscription' => '2025-06-20'],
            ['nom' => 'Thomas', 'prenom' => 'Sophie', 'email' => 'sophie.thomas@example.com', 'telephone' => '0456789012', 'date_inscription' => '2025-08-05'],
            ['nom' => 'Petit', 'prenom' => 'Lucas', 'email' => 'lucas.petit@example.com', 'telephone' => '0567890123', 'date_inscription' => '2025-09-12'],
        ];

        foreach ($adherents as $a) {
            Adherent::create($a);
        }
    }
}