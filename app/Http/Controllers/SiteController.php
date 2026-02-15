<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Affiche la liste des sites avec support de la recherche.
     */
    public function index(Request $request)
    {
        // Récupération de la saisie utilisateur
        $search = $request->query('search');

        // Filtrage dynamique par nom, secteur ou adresse
        $sites = Site::with('agents')
            ->when($search, function ($query) use ($search) {
                $query->where('nom', 'like', "%{$search}%")
                    ->orWhere('secteur', 'like', "%{$search}%")
                    ->orWhere('adresse', 'like', "%{$search}%");
            })
            ->get();

        return view('sites.index', compact('sites', 'search'));
    }

    public function create()
    {
        return view('sites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'secteur' => 'required|in:Secteur 1 (Ville),Secteur 2 (Banlieu),Secteur 3 (Region)',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20'
        ]);

        $site = Site::create($request->all());

        return redirect()->route('sites.index')
            ->with('success', "Le site {$site->nom} a été ajouté avec succès.");
    }

    public function edit(Site $site)
    {
        return view('sites.edit', compact('site'));
    }

    public function update(Request $request, Site $site)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'secteur' => 'required|in:Secteur 1 (Ville),Secteur 2 (Banlieu),Secteur 3 (Region)',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20'
        ]);

        $site->update($request->all());

        return redirect()->route('sites.index')
            ->with('success', "Le site {$site->nom} a été mis à jour avec succès.");
    }

    public function destroy(Site $site)
    {
        $site->delete();
        return redirect()->back()->with('success', 'Le site a été supprimé avec succès.');
    }
}
