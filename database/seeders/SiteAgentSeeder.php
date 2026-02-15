<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Site;
use App\Models\Agent;

class SiteAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1️⃣ Créer des sites
        $sites = ['Dakar', 'Thies', 'Saint-Louis', 'Kaolack'];

        foreach ($sites as $siteName) {
            Site::create(['nom' => $siteName]);
        }

        $allSites = Site::all();

        // 2️⃣ Créer des agents avec des sites assignés
        $agents = [
            ['nom' => 'Kane', 'prenom' => 'Seydou', 'statut' => 'Présent'],
            ['nom' => 'Fall', 'prenom' => 'Aminata', 'statut' => 'Présent'],
            ['nom' => 'Diop', 'prenom' => 'Ousmane', 'statut' => 'Absent'],
            ['nom' => 'Sow', 'prenom' => 'Mamadou', 'statut' => 'Présent'],
            ['nom' => 'Ba', 'prenom' => 'Fatou', 'statut' => 'Absent'],
            ['nom' => 'Diallo', 'prenom' => 'Moussa', 'statut' => 'Présent'],
            ['nom' => 'Thiam', 'prenom' => 'Awa', 'statut' => 'Absent'],
        ];

        foreach ($agents as $agentData) {
            Agent::create([
                'nom' => $agentData['nom'],
                'prenom' => $agentData['prenom'],
                'statut' => $agentData['statut'],
                'site_id' => $allSites->random()->id,
            ]);
        }
    }
}
