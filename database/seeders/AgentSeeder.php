<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agent;

class AgentSeeder extends Seeder
{
    public function run()
    {
        $agents = [
            ['nom' => 'Diallo', 'prenom' => 'Mamadou', 'statut' => 'Présent'],
            ['nom' => 'Sow', 'prenom' => 'Aissatou', 'statut' => 'Absent'],
            ['nom' => 'Fall', 'prenom' => 'Cheikh', 'statut' => 'Congé'],
            ['nom' => 'Ngom', 'prenom' => 'Fatou', 'statut' => 'Permission'],
            ['nom' => 'Cissé', 'prenom' => 'Aliou', 'statut' => 'Démissionné'],
        ];

        foreach($agents as $agent){
            Agent::create($agent);
        }
    }
}
