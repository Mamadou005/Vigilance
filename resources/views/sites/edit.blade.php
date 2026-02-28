@extends('layouts.admin')

@section('content_header_title', 'Modifier Site')
@section('content_header_subtitle', 'Mise à jour des informations du site')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="glass-card rounded-3xl p-8 lg:p-10" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                    <i class="ph-bold ph-pencil-line text-white text-4xl"></i>
                </div>
                <h2 class="text-3xl font-black text-gray-900 mb-2">Modifier le Site</h2>
                <p class="text-gray-600 font-medium">Mise à jour des informations du site</p>
            </div>

            <!-- Form -->
            <form action="{{ route('sites.update', $site->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nom du Site -->
                <div>
                    <label for="nom" class="block text-sm font-bold text-gray-900 mb-2">
                        <i class="ph-bold ph-bank mr-1 text-cyan-600"></i>
                        Nom du Site ou de la Banque
                    </label>
                    <input type="text"
                           id="nom"
                           name="nom"
                           value="{{ old('nom', $site->nom) }}"
                           required
                           class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-cyan-100 focus:border-cyan-500 transition-all font-medium"
                           placeholder="Ex: BOA - Siège Ville">
                    @error('nom')
                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                            <i class="ph-bold ph-warning-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Secteur & Téléphone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="secteur" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-map-trifold mr-1 text-purple-600"></i>
                            Secteur Géographique
                        </label>
                        <select id="secteur"
                                name="secteur"
                                required
                                class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all font-medium">
                            <option value="Secteur 1 (Ville)" {{ $site->secteur == 'Secteur 1 (Ville)' ? 'selected' : '' }}>Secteur 1 (Ville)</option>
                            <option value="Secteur 2 (Banlieu)" {{ $site->secteur == 'Secteur 2 (Banlieu)' ? 'selected' : '' }}>Secteur 2 (Banlieue)</option>
                            <option value="Secteur 3 (Region)" {{ $site->secteur == 'Secteur 3 (Region)' ? 'selected' : '' }}>Secteur 3 (Région)</option>
                        </select>
                        @error('secteur')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="telephone" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-phone mr-1 text-emerald-600"></i>
                            Téléphone RPE
                        </label>
                        <input type="text"
                               id="telephone"
                               name="telephone"
                               value="{{ old('telephone', $site->telephone) }}"
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all font-medium"
                               placeholder="Ex: 77 000 00 00">
                        @error('telephone')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Adresse -->
                <div>
                    <label for="adresse" class="block text-sm font-bold text-gray-900 mb-2">
                        <i class="ph-bold ph-map-pin mr-1 text-blue-600"></i>
                        Adresse Précise
                    </label>
                    <textarea id="adresse"
                              name="adresse"
                              rows="3"
                              class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium resize-none"
                              placeholder="Rue, quartier, ville...">{{ old('adresse', $site->adresse) }}</textarea>
                    @error('adresse')
                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                            <i class="ph-bold ph-warning-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t-2 border-gray-200">
                    <a href="{{ route('sites.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all">
                        <i class="ph-bold ph-arrow-left mr-2"></i>
                        Retour
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105">
                        <i class="ph-bold ph-floppy-disk mr-2"></i>
                        Enregistrer les Modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
