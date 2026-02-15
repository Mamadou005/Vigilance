<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Pointage;
use App\Models\Alerte;
use App\Models\Remplacement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $moisActuel = now()->month;

        // On récupère les sites avec leurs agents
        $sites = Site::with('agents')->get();

        // Effectif total des agents
        $statsAgents = $sites->pluck('agents')->flatten()->count();

        // Vérifie bien que la colonne 'statut' existe en base de données
        $alertesNonTraitees = Alerte::where('statut', 'non_traite')->count();

        $remplacementsEnCours = Remplacement::where('statut', 'en_cours')->count();

        $totalSanctions = Pointage::where('type', 'absence')
            ->whereMonth('date_pointage', $moisActuel)
            ->sum('montant');

        $nbRemplacements = Pointage::where('type', 'supplementaire')
            ->whereMonth('date_pointage', $moisActuel)
            ->count();

        return view('dashboard', compact(
            'sites',
            'statsAgents',
            'alertesNonTraitees',
            'remplacementsEnCours',
            'totalSanctions',
            'nbRemplacements'
        ));
    }
}
