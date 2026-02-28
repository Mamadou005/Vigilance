@extends('layouts.admin')

@section('content_header_title', 'Créer un Utilisateur')
@section('content_header_subtitle', 'Ajouter un nouvel utilisateur au système')

@section('content')

<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="ph-bold ph-user-plus text-white text-2xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-gray-100">
                    Nouvel Utilisateur
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Remplissez le formulaire ci-dessous</p>
            </div>
        </div>
    </div>

    {{-- Formulaire --}}
    <div class="glass-card rounded-2xl overflow-hidden shadow-xl">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-900 p-4">
            <h4 class="text-lg font-black text-white flex items-center">
                <i class="ph-bold ph-note-pencil text-indigo-400 mr-2 text-2xl"></i>
                Informations de l'utilisateur
            </h4>
        </div>

        {{-- Form --}}
        <div class="p-6 bg-white dark:bg-gray-800">
            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Nom --}}
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-user mr-1"></i>
                        Nom complet
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-medium focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition-all @error('name') border-red-500 @enderror"
                           placeholder="Ex: Jean Dupont"
                           required>
                    @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium">
                        <i class="ph-bold ph-warning-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-envelope mr-1"></i>
                        Adresse email
                    </label>
                    <input type="email"
                           name="email"
                           id="email"
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-medium focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition-all @error('email') border-red-500 @enderror"
                           placeholder="Ex: jean.dupont@exemple.com"
                           required>
                    @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium">
                        <i class="ph-bold ph-warning-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Rôle --}}
                <div>
                    <label for="role" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-shield-check mr-1"></i>
                        Rôle
                    </label>
                    <select name="role"
                            id="role"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-medium focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition-all @error('role') border-red-500 @enderror"
                            required>
                        <option value="">-- Sélectionnez un rôle --</option>
                        <option value="agent" {{ old('role') === 'agent' ? 'selected' : '' }}>Agent</option>
                        <option value="responsable" {{ old('role') === 'responsable' ? 'selected' : '' }}>Responsable</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                    @error('role')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium">
                        <i class="ph-bold ph-warning-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-lock mr-1"></i>
                        Mot de passe
                    </label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-medium focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition-all @error('password') border-red-500 @enderror"
                           placeholder="••••••••"
                           required>
                    @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium">
                        <i class="ph-bold ph-warning-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Confirmation mot de passe --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-lock-key mr-1"></i>
                        Confirmer le mot de passe
                    </label>
                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-medium focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition-all"
                           placeholder="••••••••"
                           required>
                </div>

                {{-- Boutons --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t-2 border-gray-200 dark:border-gray-700">
                    <a href="{{ route('users.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-bold rounded-xl transition-all">
                        <i class="ph-bold ph-x mr-2 text-lg"></i>
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
                        <i class="ph-bold ph-check mr-2 text-lg"></i>
                        Créer l'utilisateur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
