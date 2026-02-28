<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agent;
use App\Models\Alerte;
use App\Models\Pointage;
use App\Models\Site;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    public function index()
    {
        // Statistiques des utilisateurs par rôle
        $usersByRole = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->get()
            ->pluck('total', 'role')
            ->toArray();

        // Statistiques des agents par statut
        $agentsByStatus = Agent::select('statut', DB::raw('count(*) as total'))
            ->groupBy('statut')
            ->get()
            ->pluck('total', 'statut')
            ->toArray();

        // Alertes traitées vs non traitées
        $alertesStats = [
            'traitees' => Alerte::where('traitee', true)->count(),
            'non_traitees' => Alerte::where('traitee', false)->count(),
        ];

        // Évolution des pointages par mois (6 derniers mois)
        // SQLite utilise strftime au lieu de MONTH/YEAR
        $pointagesParMois = Pointage::select(
                DB::raw("strftime('%m', date_pointage) as mois"),
                DB::raw("strftime('%Y', date_pointage) as annee"),
                DB::raw('count(*) as total')
            )
            ->where('date_pointage', '>=', now()->subMonths(6))
            ->groupBy('annee', 'mois')
            ->orderBy('annee', 'asc')
            ->orderBy('mois', 'asc')
            ->get();

        // Statistiques des absences et supplémentaires
        $pointagesTypes = Pointage::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type')
            ->toArray();

        // Agents par site
        $agentsParSite = Site::withCount('agents')->get();

        // Statistiques générales
        $statsGenerales = [
            'total_utilisateurs' => User::count(),
            'total_agents' => Agent::count(),
            'total_sites' => Site::count(),
            'total_alertes' => Alerte::count(),
            'total_pointages' => Pointage::count(),
        ];

        return view('statistiques.index', compact(
            'usersByRole',
            'agentsByStatus',
            'alertesStats',
            'pointagesParMois',
            'pointagesTypes',
            'agentsParSite',
            'statsGenerales'
        ));
    }
}
