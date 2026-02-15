<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Appel;
use App\Models\Agent;

class AppelSeeder extends Seeder
{
    public function run()
    {
        $agents = Agent::all();

        foreach($agents as $agent){
            Appel::create([
                'agent_id' => $agent->id,
                'date_appel' => now(),
                'present' => $agent->statut === 'Présent' ? true : false,
                'commentaire' => 'Test de démonstration',
            ]);
        }
    }
}
