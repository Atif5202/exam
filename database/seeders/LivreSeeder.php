<?php

namespace Database\Seeders;

use App\Models\Livre;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LivreSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $livres = [
['titre' => 'Sari-nofy', 'auteur' => 'Jean-Joseph Rabearivelo', 'isbn' => '978-2-84280-119-9', 'categorie' => 'Poésie', 'annee' => 2006, 'quantite_totale' => 3, 'quantite_disponible' => 3],

['titre' => 'Risika sy Rahitsikitsika', 'auteur' => 'Ravelo, Rivo Randremba', 'isbn' => '978-2-916362-32-8', 'categorie' => 'Jeunesse', 'annee' => 2010, 'quantite_totale' => 2, 'quantite_disponible' => 2],

['titre' => 'Maria Vakansy any Alaotra', 'auteur' => 'Marie-Michèle Rakotoanosy', 'isbn' => '978-2-916362-00-7', 'categorie' => 'Jeunesse', 'annee' => 2010, 'quantite_totale' => 2, 'quantite_disponible' => 2],

['titre' => 'Maria Nahita ranomasina voalohany', 'auteur' => 'Marie-Michèle Rakotoanosy, Rado', 'isbn' => '978-2-916362-01-4', 'categorie' => 'Jeunesse', 'annee' => 2010, 'quantite_totale' => 1, 'quantite_disponible' => 1],

['titre' => 'Rapeto sy Jejy voatavo', 'auteur' => 'Marthe Rasoanantenaina, Roddy', 'isbn' => '978-2-916362-03-8', 'categorie' => 'Jeunesse', 'annee' => 2010, 'quantite_totale' => 2, 'quantite_disponible' => 2],

['titre' => 'Any am-pianarana', 'auteur' => 'Marie-Michèle Rakotoanosy', 'isbn' => '978-2-916362-10-6', 'categorie' => 'Éducation', 'annee' => 2010, 'quantite_totale' => 1, 'quantite_disponible' => 1],

['titre' => 'Loko sy soratra', 'auteur' => 'Marie-Michèle Rakotoanosy, Fetra', 'isbn' => '978-2-916362-12-0', 'categorie' => 'Éducation', 'annee' => 2010, 'quantite_totale' => 1, 'quantite_disponible' => 1],

['titre' => 'Loko sy marika', 'auteur' => 'Marie-Michèle Rakotoanosy, Fetra', 'isbn' => '978-2-916362-11-3', 'categorie' => 'Éducation', 'annee' => 2010, 'quantite_totale' => 2, 'quantite_disponible' => 2],

['titre' => 'Antalaha le 26 juin 1960', 'auteur' => 'Cyprienne Toazara', 'isbn' => '978-2-916362-31-1', 'categorie' => 'Roman jeunesse', 'annee' => 2010, 'quantite_totale' => 3, 'quantite_disponible' => 3],

['titre' => 'Nadika tamin’ny Alina', 'auteur' => 'Jean-Joseph Rabearivelo', 'isbn' => '978-2-84280-125-0', 'categorie' => 'Poésie', 'annee' => 2007, 'quantite_totale' => 2, 'quantite_disponible' => 2],        ];

        foreach ($livres as $l) {
            Livre::create($l);
        }
    }
}