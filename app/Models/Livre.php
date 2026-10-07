<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Livre extends Model
{
    protected $table = 'livres';

    protected $fillable = [
        'titre',
        'auteur',
        'isbn',
        'categorie',
        'annee',
        'quantite_totale',
        'quantite_disponible',
    ];

    public function emprunts(): HasMany
    {
        return $this->hasMany(Emprunt::class);
    }

    public function empruntsEnCours()
    {
        return $this->emprunts()->whereNull('date_retour_effective');
    }
}