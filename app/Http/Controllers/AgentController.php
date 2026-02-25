<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Site;
use Illuminate\Http\Request;
use App\Exports\AgentsExport;
use Maatwebsite\Excel\Facades\Excel;

class AgentController extends Controller
{
    /**
     * Export Excel des agents par site ou globalement.
     */
    public function exportExcel($siteId = null)
    {
        $filename = 'agents_site_' . ($siteId ?? 'tous') . '.xlsx';
        return Excel::download(new AgentsExport($siteId), $filename);
    }

    /**
     * Liste des agents avec support de recherche.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $agentsQuery = Agent::with('site', 'planning');

        if ($search) {
            $agentsQuery->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('statut', 'like', "%{$search}%");
            });
        }

        $agents = $agentsQuery->get();
        $sitesGrouped = $agents->groupBy(fn($agent) => $agent->site?->nom ?? 'Site inconnu');

        return view('agents.index', compact('agents', 'sitesGrouped'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create(Request $request)
    {
        $sites = Site::all();
        $selectedSiteId = $request->get('site_id');
        return view('agents.create', compact('sites', 'selectedSiteId'));
    }

    /**
     * Enregistre un nouvel agent.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'statut' => 'required|string|max:50', // La migration autorise désormais 'Repos'
            'site_id' => 'nullable|exists:sites,id',
            'telephone' => 'nullable|string|max:20',
        ]);

        Agent::create($validated);

        return redirect()->route('agents.index')->with('success', 'Agent ajouté avec succès !');
    }

    /**
     * Prépare les données pour la vue 'agents.edit'.
     */
    public function edit(Agent $agent)
    {
        $sites = Site::all();
        return view('agents.edit', compact('agent', 'sites'));
    }

    /**
     * Met à jour les informations de l'agent.
     */
    public function update(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'statut' => 'required|string|max:50',
            'site_id' => 'nullable|exists:sites,id',
            'telephone' => 'nullable|string|max:20',
        ]);

        $agent->update($validated);

        return redirect()->route('agents.index')->with('success', 'Agent mis à jour avec succès !');
    }

    /**
     * Supprime définitivement un agent.
     */
    public function destroy(Agent $agent)
    {
        $agent->delete();
        return redirect()->route('agents.index')->with('success', 'Agent supprimé avec succès !');
    }
}
