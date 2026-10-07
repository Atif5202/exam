<?php

namespace Database\Seeders;

use App\Models\Adherent;
use App\Models\Emprunt;
use App\Models\Livre;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmpruntSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $livre1 = Livre::where('isbn', '978-2-0814-0000-0')->first();
        $livre2 = Livre::where('isbn', '978-2-0703-0000-0')->first();
        $livre3 = Livre::where('isbn', '978-2-0702-0000-0')->first();

        $adherent1 = Adherent::where('email', 'atif.rakoto@example.com')->first();
        $adherent2 = Adherent::where('email', 'zoky.mpidrana@example.com')->first();

        Emprunt::create([
            'livre_id' => $livre1->id,
            'adherent_id' => $adherent1->id,
            'date_emprunt' => now()->subDays(20)->toDateString(),
            'date_retour_prevue' => now()->subDays(6)->toDateString(),
            'date_retour_effective' => null,
        ]);
        $livre1->decrement('quantite_disponible');

        Emprunt::create([
            'livre_id' => $livre2->id,
            'adherent_id' => $adherent2->id,
            'date_emprunt' => now()->subDays(5)->toDateString(),
            'date_retour_prevue' => now()->addDays(9)->toDateString(),
            'date_retour_effective' => null,
        ]);
        $livre2->decrement('quantite_disponible');

        Emprunt::create([
            'livre_id' => $livre3->id,
            'adherent_id' => $adherent1->id,
            'date_emprunt' => now()->subDays(3)->toDateString(),
            'date_retour_prevue' => now()->addDays(11)->toDateString(),
            'date_retour_effective' => null,
        ]);
        $livre3->decrement('quantite_disponible');
    }
}