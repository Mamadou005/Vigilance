<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remplacement;
use App\Models\Agent;
use App\Models\Site;

class RemplacementController extends Controller
{
    public function index(Request $request)
    {
        $categorie = $request->query('categorie', 'Postes Vides');

        $remplacements = Remplacement::where('categorie', $categorie)
            ->orderBy('date_debut', 'desc')
            ->get();

        // CHARGEMENT ESSENTIEL : with('site') permet de récupérer le site de l'agent
        $agents = Agent::with('site')->orderBy('nom')->get();
        $sites = Site::orderBy('nom')->get();

        return view('remplacements.index', compact('remplacements', 'categorie', 'agents', 'sites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agent_remplace_nom' => 'required|string|max:255',
            'poste_nom' => 'required|string|max:255',
            'motif' => 'required|string',
            'agent_remplacant_nom' => 'nullable|string|max:255',
            'site_affectation' => 'nullable|string|max:255',
            'n_wave' => 'nullable|string|max:20',
            'date_debut' => 'required|date',
            'categorie' => 'nullable|string'
        ]);

        Remplacement::create([
            'agent_remplace_nom' => $request->agent_remplace_nom,
            'poste_nom' => $request->poste_nom,
            'motif' => $request->motif,
            'agent_remplacant_nom' => $request->agent_remplacant_nom,
            'site_affectation' => $request->site_affectation,
            'n_wave' => $request->n_wave,
            'date_debut' => $request->date_debut,
            'categorie' => $request->categorie ?? 'Postes Vides',
        ]);

        return redirect()->back()->with('success', 'La ligne a été ajoutée avec succès !');
    }

    public function edit(Remplacement $remplacement)
    {
        $agents = Agent::with('site')->orderBy('nom')->get();
        $sites = Site::orderBy('nom')->get();
        return view('remplacements.edit', compact('remplacement', 'agents', 'sites'));
    }

    public function update(Request $request, Remplacement $remplacement)
    {
        $request->validate([
            'agent_remplace_nom' => 'required|string',
            'poste_nom' => 'required|string',
            'date_debut' => 'required|date',
        ]);

        $remplacement->update($request->all());

        return redirect()->route('remplacements.index', ['categorie' => $remplacement->categorie])
            ->with('success', 'Ligne mise à jour !');
    }

    public function destroy(Remplacement $remplacement)
    {
        $categorie = $remplacement->categorie;
        $remplacement->delete();
        return redirect()->route('remplacements.index', ['categorie' => $categorie])
            ->with('success', 'Ligne supprimée.');
    }
}
