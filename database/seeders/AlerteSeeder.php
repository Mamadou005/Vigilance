<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alerte;
use App\Models\Agent;

class AlerteSeeder extends Seeder
{
    public function run()
    {
        $types = ['Intrusion','Incendie','Panne','Autre'];

        // Récupérer tous les agents
        $agents = Agent::all();

        foreach($types as $index => $type){
            // Assigner un agent différent pour chaque alerte
            $agent = $agents[$index % $agents->count()];

            Alerte::create([
                'type' => $type,
                'site' => 'Site de démonstration',
                'date_alerte' => now(),
                'traitee' => false,
                'rapport' => 'Rapport de démonstration',
                'agent_id' => $agent->id, // lien vers un agent
            ]);
        }
    }
}
