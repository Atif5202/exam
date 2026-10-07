<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Emprunt extends Model
{
    protected $table = 'emprunts';

    protected $fillable = [
        'livre_id',
        'adherent_id',
        'date_emprunt',
        'date_retour_prevue',
        'date_retour_effective',
    ];

    protected $casts = [
        'date_emprunt' => 'date',
        'date_retour_prevue' => 'date',
        'date_retour_effective' => 'date',
    ];

    public function livre(): BelongsTo
    {
        return $this->belongsTo(Livre::class);
    }

    public function adherent(): BelongsTo
    {
        return $this->belongsTo(Adherent::class);
    }

    public function estEnRetard(): bool
    {
        if ($this->date_retour_effective !== null) {
            return false;
        }
        return $this->date_retour_prevue->lt(now()->toDateString());
    }
}