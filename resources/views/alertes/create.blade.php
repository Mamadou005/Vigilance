@extends('layouts.admin')

@section('content_header_title', 'Nouvelle Alerte')
@section('content_header_subtitle', 'Enregistrer un nouveau rapport d\'incident')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-3xl p-8 lg:p-10" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                    <i class="ph-bold ph-warning-octagon text-white text-4xl"></i>
                </div>
                <h2 class="text-3xl font-black text-gray-900 mb-2">Nouveau Rapport d'Incident</h2>
                <p class="text-gray-600 font-medium">Enregistrez les détails de l'alerte et de l'intervention</p>
            </div>

            <!-- Form -->
            <form action="{{ route('alertes.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Site & Type d'incident -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="site_id" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-bank mr-1 text-red-600"></i>
                            Site de la Banque
                        </label>
                        <select id="site_id"
                                name="site_id"
                                required
                                class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all font-medium">
                            <option value="">-- Choisir Site --</option>
                            @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ old('site_id') == $site->id ? 'selected' : '' }}>{{ $site->nom }}</option>
                            @endforeach
                        </select>
                        @error('site_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="type_incident" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-warning mr-1 text-amber-600"></i>
                            Type d'Incident
                        </label>
                        <input type="text"
                               id="type_incident"
                               name="type_incident"
                               value="{{ old('type_incident') }}"
                               required
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all font-medium"
                               placeholder="Ex: Intrusion, Vol, Agression">
                        @error('type_incident')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Horaires -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="heure_incident" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-clock mr-1 text-blue-600"></i>
                            Heure de l'Incident
                        </label>
                        <input type="time"
                               id="heure_incident"
                               name="heure_incident"
                               value="{{ old('heure_incident') }}"
                               required
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium">
                        @error('heure_incident')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="heure_arrivee_brigade" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-siren mr-1 text-purple-600"></i>
                            Arrivée Brigade
                        </label>
                        <input type="time"
                               id="heure_arrivee_brigade"
                               name="heure_arrivee_brigade"
                               value="{{ old('heure_arrivee_brigade') }}"
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all font-medium">
                        @error('heure_arrivee_brigade')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="intervenant_nom" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-user-focus mr-1 text-emerald-600"></i>
                            Intervenant COS
                        </label>
                        <input type="text"
                               id="intervenant_nom"
                               name="intervenant_nom"
                               value="{{ old('intervenant_nom') }}"
                               required
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all font-medium"
                               placeholder="Nom de l'intervenant">
                        @error('intervenant_nom')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Observations -->
                <div>
                    <label for="observations" class="block text-sm font-bold text-gray-900 mb-2">
                        <i class="ph-bold ph-note-pencil mr-1 text-indigo-600"></i>
                        Observations Détaillées
                    </label>
                    <textarea id="observations"
                              name="observations"
                              rows="5"
                              class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all font-medium resize-none"
                              placeholder="Décrivez les circonstances, actions menées, résultat de l'intervention...">{{ old('observations') }}</textarea>
                    @error('observations')
                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                            <i class="ph-bold ph-warning-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Statut -->
                <div>
                    <label for="statut" class="block text-sm font-bold text-gray-900 mb-2">
                        <i class="ph-bold ph-check-circle mr-1 text-green-600"></i>
                        Statut de l'Incident
                    </label>
                    <select id="statut"
                            name="statut"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all font-medium">
                        <option value="non_traite" {{ old('statut') == 'non_traite' ? 'selected' : '' }}>🔴 Non Traité</option>
                        <option value="en_cours" {{ old('statut') == 'en_cours' ? 'selected' : '' }}>🟡 En Cours</option>
                        <option value="resolu" {{ old('statut') == 'resolu' ? 'selected' : '' }}>🟢 Résolu</option>
                    </select>
                    @error('statut')
                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                            <i class="ph-bold ph-warning-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t-2 border-gray-200">
                    <a href="{{ route('alertes.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all">
                        <i class="ph-bold ph-arrow-left mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105">
                        <i class="ph-bold ph-bell-ringing mr-2"></i>
                        Lancer l'Alerte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
