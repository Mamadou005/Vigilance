<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Planning;
use App\Models\Site;
use Illuminate\Http\Request;

class PlanningController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sites = Site::with(['agents.planning'])
            ->when($search, function ($query) use ($search) {
                $query->where('nom', 'like', "%{$search}%")
                    ->orWhereHas('agents', function ($q) use ($search) {
                        $q->where('nom', 'like', "%{$search}%")
                            ->orWhere('prenom', 'like', "%{$search}%");
                    });
            })
            ->get();

        return view('plannings.index', compact('sites', 'search'));
    }

    public function site(Request $request)
    {
        $nomSecteur = $request->query('secteur');
        $sites = Site::where('secteur', $nomSecteur)
            ->with(['agents.planning'])
            ->get();

        return view('plannings.index', compact('sites', 'nomSecteur'));
    }

    // NOUVELLE MÉTHODE POUR LA SAISIE RAPIDE RPE
    public function updateRPE(Request $request, Site $site)
    {
        $request->validate([
            'telephone' => 'required|string|max:255',
        ]);

        $site->update([
            'telephone' => $request->telephone
        ]);

        return redirect()->back()->with('success', "Numéro RPE mis à jour.");
    }

    public function create($agentId)
    {
        $agent = Agent::findOrFail($agentId);
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        $planning = $agent->planning;
        return view('plannings.create', compact('agent', 'jours', 'planning'));
    }

    public function store(Request $request, $agentId)
    {
        $request->validate([
            'jours.*' => 'required|in:F,R',
            'heures.*' => 'nullable|string',
        ]);

        $data = [];
        foreach (['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'] as $j) {
            $data[$j] = $request->jours[$j] ?? 'R';
            $data["h_$j"] = $request->heures[$j] ?? null;
        }

        Planning::updateOrCreate(['agent_id' => $agentId], $data);
        return redirect()->route('plannings.index')->with('success', "Planning mis à jour.");
    }
}
