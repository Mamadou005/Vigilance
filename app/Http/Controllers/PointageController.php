<?php

namespace App\Http\Controllers;

use App\Models\Pointage;
use App\Models\Agent;
use App\Models\Site;
use App\Exports\PointagesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class PointageController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'absence');
        $search = $request->query('search');

        $query = Pointage::with(['agent' => function($q) {
            $q->withSum(['pointages as total_sanctions' => function($sq) {
                $sq->where('type', 'absence');
            }], 'montant')
                ->withSum(['pointages as total_supplements' => function($sq) {
                    $sq->where('type', 'supplementaire');
                }], 'montant');
        }, 'site']);

        // Si une recherche est effectuée, on affiche TOUT l'historique de l'agent
        if ($search) {
            $query->whereHas('agent', function($q) use ($search) {
                $q->where('nom', 'LIKE', "%{$search}%")
                    ->orWhere('prenom', 'LIKE', "%{$search}%");
            });
        } else {
            $query->where('type', $type);
        }

        $pointages = $query->orderBy('date_pointage', 'desc')->get();

        return view('pointages.index', compact('pointages', 'type', 'search'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'date_pointage' => 'required|date',
            'type' => 'required|in:absence,supplementaire',
            'montant' => 'nullable|integer',
            'salaire_base' => 'nullable|integer', // Nouveau champ validé
            'motif' => 'nullable|string|max:255',
            'nb_jours' => 'nullable|integer|min:1',
            'agent_remplace' => 'nullable|string|max:255',
        ]);

        $agent = Agent::findOrFail($request->agent_id);

        // Mise à jour du salaire de base de l'agent si saisi dans le formulaire
        if ($request->has('salaire_base')) {
            $agent->update(['salaire_base' => $request->salaire_base]);
        }

        Pointage::create([
            'agent_id' => $request->agent_id,
            'site_id' => $agent->site_id,
            'date_pointage' => $request->date_pointage,
            'type' => $request->type,
            'montant' => $request->montant,
            'motif' => $request->motif,
            'nb_jours' => $request->nb_jours ?? 1,
            'agent_remplace' => $request->agent_remplace,
        ]);

        return redirect()->back()->with('success', "Opération effectuée avec succès.");
    }

    public function edit($id)
    {
        $pointage = Pointage::with('agent')->findOrFail($id);
        return view('pointages.edit', compact('pointage'));
    }

    public function update(Request $request, $id)
    {
        $pointage = Pointage::findOrFail($id);
        $request->validate([
            'date_pointage' => 'required|date',
            'montant' => 'nullable|integer',
        ]);
        $pointage->update($request->all());
        return redirect()->route('pointages.index', ['type' => $pointage->type])
            ->with('success', "Pointage mis à jour avec succès.");
    }

    public function destroy($id)
    {
        $pointage = Pointage::findOrFail($id);
        $type = $pointage->type;
        $pointage->delete();
        return redirect()->route('pointages.index', ['type' => $type])
            ->with('success', "L'enregistrement a été supprimé.");
    }

    public function export(Request $request)
    {
        $type = $request->query('type', 'absence');
        $fileName = $type == 'absence' ? 'Rapport_Absences_Sanctions.xlsx' : 'Rapport_Heures_Supplementaires.xlsx';
        return Excel::download(new PointagesExport($type), $fileName);
    }
}
