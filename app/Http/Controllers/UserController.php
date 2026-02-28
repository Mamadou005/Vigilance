<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        // Accessible uniquement aux admins
        $this->authorize('create', User::class);
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Accessible uniquement aux admins
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,responsable,agent'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user)
    {
        // Accessible uniquement aux admins
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Accessible uniquement aux admins
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,responsable,agent'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        // Accessible uniquement aux admins
        $this->authorize('delete', $user);

        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}
