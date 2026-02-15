<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alerte;
use App\Models\Site;

class AlerteController extends Controller
{
    public function index()
    {
        // On charge la relation site pour éviter l'affichage JSON
        $alertes = Alerte::with('site')->orderBy('created_at', 'desc')->get();
        return view('alertes.index', compact('alertes'));
    }

    public function create()
    {
        // On envoie les sites pour la liste déroulante
        $sites = Site::all();
        return view('alertes.create', compact('sites'));
    }

    public function store(Request $request)
    {
        // Enregistrement avec les nouveaux noms de colonnes
        Alerte::create([
            'site_id' => $request->site_id,
            'type_incident' => $request->type_incident,
            'heure_incident' => $request->heure_incident,
            'heure_arrivee_brigade' => $request->heure_arrivee_brigade,
            'intervenant_nom' => $request->intervenant_nom,
            'observations' => $request->observations,
            'statut' => 'non_traite',
            'traitee' => 0 // Pour la compatibilité Dashboard
        ]);

        return redirect()->route('alertes.index')->with('success', 'Incident signalé.');
    }

    public function show(Alerte $alerte)
    {
        $alerte->load('site');
        return view('alertes.show', compact('alerte'));
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
