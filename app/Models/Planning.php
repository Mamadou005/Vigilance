<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Planning extends Model
{
    protected $fillable = [
        'agent_id',
        'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche',
        // AJOUT DES COLONNES HORAIRES ICI
        'h_lundi', 'h_mardi', 'h_mercredi', 'h_jeudi', 'h_vendredi', 'h_samedi', 'h_dimanche'
    ];

    /**
     * Relation vers l'agent
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }
}
