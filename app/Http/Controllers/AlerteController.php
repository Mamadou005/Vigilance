<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alerte;
use App\Models\Site;
use Barryvdh\DomPDF\Facade\Pdf; // Importation de la bibliothèque PDF

class AlerteController extends Controller
{
    public function index()
    {
        $alertes = Alerte::with('site')->orderBy('created_at', 'desc')->get();
        return view('alertes.index', compact('alertes'));
    }

    public function create()
    {
        $sites = Site::all();
        return view('alertes.create', compact('sites'));
    }

    public function store(Request $request)
    {
        Alerte::create([
            'site_id' => $request->site_id,
            'type_incident' => $request->type_incident,
            'heure_incident' => $request->heure_incident,
            'heure_arrivee_brigade' => $request->heure_arrivee_brigade,
            'intervenant_nom' => $request->intervenant_nom,
            'observations' => $request->observations,
            'statut' => 'non_traite',
            'traitee' => 0
        ]);

        return redirect()->route('alertes.index')->with('success', 'Incident signalé.');
    }

    public function show(Alerte $alerte)
    {
        $alerte->load('site');
        return view('alertes.show', compact('alerte'));
    }

    // NOUVELLE MÉTHODE POUR LE PDF
    public function downloadPDF($id)
    {
        $alerte = Alerte::with('site')->findOrFail($id);

        // Charge la vue spécifique au format PDF
        $pdf = Pdf::loadView('alertes.pdf', compact('alerte'));

        // Télécharge le fichier avec un nom dynamique
        return $pdf->download('Rapport_Intervention_#' . $alerte->id . '.pdf');
    }

    public function edit(Alerte $alerte)
    {
        return view('alertes.edit', compact('alerte'));
    }

    public function update(Request $request, Alerte $alerte)
    {
        $alerte->update($request->all());
        return redirect()->route('alertes.index');
    }

    public function destroy(Alerte $alerte)
    {
        $alerte->delete();
        return redirect()->route('alertes.index');
    }
}
