<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Remplacement;
use App\Models\Agent;

class RemplacementSeeder extends Seeder
{
    public function run()
    {
        $agents = Agent::whereIn('statut',['Absent','Congé'])->get();
        $remplacants = Agent::where('statut','Présent')->get();

        foreach($agents as $index => $agent){
            $remplacant = $remplacants[$index % $remplacants->count()];
            Remplacement::create([
                'agent_absent_id' => $agent->id,
                'agent_remplacant_id' => $remplacant->id,
                'date_remplacement' => now(),
                'commentaire' => 'Remplacement de démonstration',
            ]);
        }
    }
}
