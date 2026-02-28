@extends('layouts.admin')

@section('content_header_title', 'Nouvel Agent')
@section('content_header_subtitle', 'Enregistrer un nouvel agent de sécurité')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="glass-card rounded-3xl p-8 lg:p-10" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                    <i class="ph-bold ph-user-plus text-white text-4xl"></i>
                </div>
                <h2 class="text-3xl font-black text-gray-900 mb-2">Ajouter un Agent</h2>
                <p class="text-gray-600 font-medium">Enregistrez les informations du nouvel agent</p>
            </div>

            <!-- Form -->
            <form action="{{ route('agents.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nom & Prénom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nom" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-user mr-1 text-blue-600"></i>
                            Nom
                        </label>
                        <input type="text"
                               id="nom"
                               name="nom"
                               value="{{ old('nom') }}"
                               required
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium"
                               placeholder="Ex: DIOP">
                        @error('nom')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="prenom" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-user mr-1 text-blue-600"></i>
                            Prénom
                        </label>
                        <input type="text"
                               id="prenom"
                               name="prenom"
                               value="{{ old('prenom') }}"
                               required
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium"
                               placeholder="Ex: Mohamed">
                        @error('prenom')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="telephone" class="block text-sm font-bold text-gray-900 mb-2">
                        <i class="ph-bold ph-phone mr-1 text-emerald-600"></i>
                        Numéro de Téléphone
                    </label>
                    <input type="text"
                           id="telephone"
                           name="telephone"
                           value="{{ old('telephone') }}"
                           class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all font-medium"
                           placeholder="Ex: 77 000 00 00">
                    @error('telephone')
                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                            <i class="ph-bold ph-warning-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Statut -->
                <div>
                    <label for="statut" class="block text-sm font-bold text-gray-900 mb-2">
                        <i class="ph-bold ph-check-circle mr-1 text-amber-600"></i>
                        Statut Initial
                    </label>
                    <select id="statut"
                            name="statut"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all font-medium">
                        <option value="Présent">✅ Présent</option>
                        <option value="Absent">❌ Absent</option>
                        <option value="Congé">🏖️ Congé</option>
                    </select>
                    @error('statut')
                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                            <i class="ph-bold ph-warning-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Site d'Affectation -->
                <div>
                    <label for="site_id" class="block text-sm font-bold text-gray-900 mb-2">
                        <i class="ph-bold ph-bank mr-1 text-purple-600"></i>
                        Site d'Affectation
                    </label>
                    <select id="site_id"
                            name="site_id"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all font-medium">
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}">{{ $site->nom }}</option>
                        @endforeach
                    </select>
                    @error('site_id')
                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                            <i class="ph-bold ph-warning-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t-2 border-gray-200">
                    <a href="{{ route('agents.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all">
                        <i class="ph-bold ph-arrow-left mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105">
                        <i class="ph-bold ph-check-circle mr-2"></i>
                        Enregistrer l'Agent
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
