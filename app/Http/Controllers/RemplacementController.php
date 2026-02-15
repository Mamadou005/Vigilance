<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remplacement;
use App\Models\Agent;

class RemplacementController extends Controller
{
    public function index(Request $request)
    {
        $categorie = $request->query('categorie', 'Postes Vides');

        $remplacements = Remplacement::where('categorie', $categorie)
            ->orderBy('date_debut', 'desc')
            ->get();

        return view('remplacements.index', compact('remplacements', 'categorie'));
    }

    public function store(Request $request)
    {
        // Validation : Seuls les 3 premiers sont obligatoires pour gagner du temps
        $request->validate([
            'agent_remplace_nom' => 'required|string|max:255',
            'poste_nom' => 'required|string|max:255',
            'motif' => 'required|string', // Rendu obligatoire selon ta demande
            'agent_remplacant_nom' => 'nullable|string|max:255', // OPTIONNEL
            'site_affectation' => 'nullable|string|max:255',    // OPTIONNEL
            'n_wave' => 'nullable|string|max:20',              // OPTIONNEL
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

        return redirect()->back()->with('success', 'La ligne a été ajoutée. Vous pourrez compléter le remplaçant plus tard !');
    }

    public function edit(Remplacement $remplacement)
    {
        return view('remplacements.edit', compact('remplacement'));
    }

    public function update(Request $request, Remplacement $remplacement)
    {
        $request->validate([
            'agent_remplace_nom' => 'required|string',
            'poste_nom' => 'required|string',
            'agent_remplacant_nom' => 'nullable|string', // Modifié ici aussi
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
