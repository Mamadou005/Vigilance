<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    /**
     * Les attributs qui peuvent être assignés en masse.
     * * 'salaire_base' est essentiel pour le calcul du Salaire AS et du Net.
     */
    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'statut',
        'site_id',
        'salaire_base'
    ];

    /**
     * Relation avec le Site (Un agent appartient à un site).
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Relation avec le Planning (Un agent a un planning hebdomadaire).
     */
    public function planning()
    {
        return $this->hasOne(Planning::class);
    }

    /**
     * Relation avec les Pointages (Un agent peut avoir plusieurs sanctions ou suppléments).
     */
    public function pointages()
    {
        return $this->hasMany(Pointage::class);
    }
}
