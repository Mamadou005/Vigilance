<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appel extends Model
{
    use HasFactory;

    // Force Laravel à utiliser le nom exact de la table
    protected $table = 'appels'; // <-- à adapter si le nom est différent dans MySQL

    protected $fillable = [
        'agent_id',
        'date_appel',
        'present',
        'commentaire',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
