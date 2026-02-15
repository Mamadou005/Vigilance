<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    // Fillable mis à jour pour inclure le téléphone RPE
    protected $fillable = ['nom', 'secteur', 'adresse', 'telephone'];

    /**
     * Relation avec les agents pour le calcul des statistiques
     */
    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class);
    }
}
