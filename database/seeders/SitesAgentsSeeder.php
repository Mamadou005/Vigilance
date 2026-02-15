<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Site;
use App\Models\Agent;

class SitesAgentsSeeder extends Seeder
{
    public function run()
    {
        // Supprimer les enregistrements existants sans provoquer d'erreur de clé étrangère
        Agent::query()->delete();
        Site::query()->delete();

        // Créer les sites
        $sitesData = [
            ['nom' => 'Dakar'],
            ['nom' => 'Thies'],
            ['nom' => 'Saint-Louis'],
            ['nom' => 'Kaolack'],
        ];

        $sites = [];
        foreach ($sitesData as $data) {
            $sites[] = Site::create($data);
        }

        // Créer des agents pour chaque site
        $agentsData = [
            ['nom' => 'Kane', 'prenom' => 'Seydou', 'statut' => 'Présent', 'site_id' => $sites[0]->id],
            ['nom' => 'Mbaye', 'prenom' => 'Abdoulaye', 'statut' => 'Présent', 'site_id' => $sites[1]->id],
            ['nom' => 'Fall', 'prenom' => 'Aminata', 'statut' => 'Présent', 'site_id' => $sites[2]->id],
            ['nom' => 'Diop', 'prenom' => 'Ousmane', 'statut' => 'Absent', 'site_id' => $sites[3]->id],
            ['nom' => 'Sow', 'prenom' => 'Mamadou', 'statut' => 'Présent', 'site_id' => $sites[0]->id],
            ['nom' => 'Ba', 'prenom' => 'Fatou', 'statut' => 'Absent', 'site_id' => $sites[1]->id],
            ['nom' => 'Diallo', 'prenom' => 'Moussa', 'statut' => 'Présent', 'site_id' => $sites[2]->id],
            ['nom' => 'Thiam', 'prenom' => 'Awa', 'statut' => 'Absent', 'site_id' => $sites[3]->id],
        ];

        foreach ($agentsData as $agent) {
            Agent::create($agent);
        }
    }
}
