<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adherent extends Model
{
    protected $table = 'adherents';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'date_inscription',
    ];

    public function emprunts(): HasMany
    {
        return $this->hasMany(Emprunt::class);
    }

    public function empruntsEnCours()
    {
        return $this->emprunts()->whereNull('date_retour_effective');
    }

    public function aRetard()
    {
        return $this->empruntsEnCours()
            ->where('date_retour_prevue', '<', now()->toDateString())
            ->exists();
    }

    public function nombreEmpruntsEnCours()
    {
        return $this->empruntsEnCours()->count();
    }
}