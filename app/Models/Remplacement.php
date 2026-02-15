<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remplacement extends Model
{
    use HasFactory;

    protected $table = 'remplacements';

    // Mise à jour pour correspondre aux colonnes du fichier Excel
    protected $fillable = [
        'agent_remplace_nom',
        'poste_nom',
        'motif',
        'agent_remplacant_nom',
        'site_affectation',
        'n_wave',
        'date_debut',
        'categorie'
    ];

    /**
     * Note : Nous gardons les relations au cas où vous utiliseriez
     * des IDs plus tard, mais pour le mode Excel, on utilise les noms.
     */
    public function agentAbsent()
    {
        return $this->belongsTo(Agent::class, 'agent_absent_id');
    }

    public function agentRemplacant()
    {
        return $this->belongsTo(Agent::class, 'agent_remplacant_id');
    }
}
