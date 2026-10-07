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
            ['titre' => 'Le Petit Prince', 'auteur' => 'Antoine de Saint-Exupery', 'isbn' => '978-2-0814-0000-0', 'categorie' => 'Roman', 'annee' => 1943, 'quantite_totale' => 3, 'quantite_disponible' => 3],
            ['titre' => '1984', 'auteur' => 'George Orwell', 'isbn' => '978-2-0703-0000-0', 'categorie' => 'Science-fiction', 'annee' => 1949, 'quantite_totale' => 2, 'quantite_disponible' => 2],
            ['titre' => 'L\'Étranger', 'auteur' => 'Albert Camus', 'isbn' => '978-2-0702-0000-0', 'categorie' => 'Roman', 'annee' => 1942, 'quantite_totale' => 2, 'quantite_disponible' => 2],
            ['titre' => 'Le Comte de Monte-Cristo', 'auteur' => 'Alexandre Dumas', 'isbn' => '978-2-2530-0000-0', 'categorie' => 'Roman', 'annee' => 1845, 'quantite_totale' => 1, 'quantite_disponible' => 1],
            ['titre' => 'Les Misérables', 'auteur' => 'Victor Hugo', 'isbn' => '978-2-2531-0000-0', 'categorie' => 'Roman', 'annee' => 1862, 'quantite_totale' => 2, 'quantite_disponible' => 2],
            ['titre' => 'La Guerre des Mondes', 'auteur' => 'H.G. Wells', 'isbn' => '978-2-0703-0001-0', 'categorie' => 'Science-fiction', 'annee' => 1898, 'quantite_totale' => 1, 'quantite_disponible' => 1],
            ['titre' => 'Jane Eyre', 'auteur' => 'Charlotte Brontë', 'isbn' => '978-2-2530-0001-0', 'categorie' => 'Roman', 'annee' => 1847, 'quantite_totale' => 1, 'quantite_disponible' => 1],
            ['titre' => 'Crime et Châtiment', 'auteur' => 'Fiodor Dostoïevski', 'isbn' => '978-2-0703-0002-0', 'categorie' => 'Roman', 'annee' => 1866, 'quantite_totale' => 2, 'quantite_disponible' => 2],
            ['titre' => 'Le Hobbit', 'auteur' => 'J.R.R. Tolkien', 'isbn' => '978-2-2662-0000-0', 'categorie' => 'Fantasy', 'annee' => 1937, 'quantite_totale' => 3, 'quantite_disponible' => 3],
            ['titre' => 'Dune', 'auteur' => 'Frank Herbert', 'isbn' => '978-2-2662-0001-0', 'categorie' => 'Science-fiction', 'annee' => 1965, 'quantite_totale' => 2, 'quantite_disponible' => 2],
        ];

        foreach ($livres as $l) {
            Livre::create($l);
        }
    }
}