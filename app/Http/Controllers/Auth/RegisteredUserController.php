<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue d'enregistrement.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Gère la demande d'enregistrement entrante.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:responsable,agent'], // Validation du statut
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Enregistre le rôle choisi
        ]);

        event(new Registered($user));

        // Suppression de Auth::login($user) pour ne pas connecter l'utilisateur immédiatement.

        // Redirection vers la page de connexion avec un message flash de succès
        return redirect()->route('login')->with('status', 'Compte créé avec succès ! Connectez-vous maintenant.');
    }
}
