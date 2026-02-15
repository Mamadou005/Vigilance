<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appel;
use App\Models\Agent;

class AppelController extends Controller
{
    public function index()
    {
        $appels = Appel::with('agent')->get();
        return view('appels.index', compact('appels'));
    }

    public function create()
    {
        $agents = Agent::all();
        return view('appels.create', compact('agents'));
    }

    public function store(Request $request)
    {
        Appel::create($request->all());
        return redirect()->route('appels.index');
    }

    public function edit(Appel $appel)
    {
        $agents = Agent::all();
        return view('appels.edit', compact('appel','agents'));
    }

    public function update(Request $request, Appel $appel)
    {
        $data = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'commentaire' => 'nullable|string',
            'present' => 'nullable|boolean',
            'date_appel' => 'nullable|date',
        ]);

        // Si present est coché et date_appel vide, on met maintenant
        if (($data['present'] ?? 0) && empty($data['date_appel'])) {
            $data['date_appel'] = now();
        }

        $appel->update($data);

        return redirect()->route('appels.index')->with('success', 'Appel mis à jour !');
    }


    public function destroy(Appel $appel)
    {
        $appel->delete();
        return redirect()->route('appels.index');
    }
}
