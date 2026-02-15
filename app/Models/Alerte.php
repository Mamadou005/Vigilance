<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    use HasFactory;

    protected $table = 'alertes';

    protected $fillable = [
        'site_id',
        'type_incident',
        'heure_incident',
        'heure_arrivee_brigade',
        'intervenant_nom',
        'statut',
        'observations',
        'traitee', // Gardé pour le dashboard
        'date_alerte'
    ];

    public function site() {
        return $this->belongsTo(Site::class);
    }

    /**
     * Relation avec l'agent (si tu souhaites garder le lien avec ton ancienne table agent)
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
