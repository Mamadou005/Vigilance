<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    protected $fillable = [
        'agent_id', 'site_id', 'date_pointage', 'type',
        'montant', 'motif', 'nb_jours', 'agent_remplace'
    ];

    public function agent() { return $this->belongsTo(Agent::class); }
    public function site() { return $this->belongsTo(Site::class); }
}
