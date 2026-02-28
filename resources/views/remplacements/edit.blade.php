@extends('layouts.admin')

@section('content_header_title', 'Modifier un Remplacement')
@section('content_header_subtitle', 'Mise à jour des informations de la relève')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-3xl overflow-hidden shadow-2xl">

        {{-- Header avec icône (Amber pour modification) --}}
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-8 text-center">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="ph-bold ph-pencil-simple text-white text-5xl"></i>
            </div>
            <h2 class="text-3xl font-black text-white mb-2">Modifier la Relève</h2>
            <p class="text-amber-100 font-medium">Mettez à jour les informations du remplacement en cours</p>
        </div>

        {{-- Formulaire --}}
        <div class="p-8 bg-white">
            <form action="{{ route('remplacements.update', $remplacement) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Ligne 1: Agent Remplacé + Poste/Site --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ph-bold ph-user-minus text-red-600 mr-1"></i>
                            Agent Remplacé
                        </label>
                        <input type="text"
                               name="agent_remplace_nom"
                               value="{{ $remplacement->agent_remplace_nom }}"
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ph-bold ph-bank text-blue-600 mr-1"></i>
                            Poste / Site
                        </label>
                        <input type="text"
                               name="poste_nom"
                               value="{{ $remplacement->poste_nom }}"
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all"
                               required>
                    </div>
                </div>

                {{-- Ligne 2: Motif --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="ph-bold ph-note text-purple-600 mr-1"></i>
                        Motif (Raison du remplacement)
                    </label>
                    <textarea name="motif"
                              rows="3"
                              class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all resize-none">{{ $remplacement->motif }}</textarea>
                </div>

                {{-- Ligne 3: Agent Remplaçant + Site d'Affectation --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ph-bold ph-user-plus text-green-600 mr-1"></i>
                            Agent Remplaçant
                        </label>
                        <input type="text"
                               name="agent_remplacant_nom"
                               value="{{ $remplacement->agent_remplacant_nom }}"
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ph-bold ph-map-pin text-indigo-600 mr-1"></i>
                            Site d'Affectation
                        </label>
                        <input type="text"
                               name="site_affectation"
                               value="{{ $remplacement->site_affectation }}"
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all">
                    </div>
                </div>

                {{-- Ligne 4: Numéro Wave + Date de Début --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ph-bold ph-barcode text-cyan-600 mr-1"></i>
                            Numéro Wave
                        </label>
                        <input type="text"
                               name="n_wave"
                               value="{{ $remplacement->n_wave }}"
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ph-bold ph-calendar-blank text-rose-600 mr-1"></i>
                            Date de Début
                        </label>
                        <input type="date"
                               name="date_debut"
                               value="{{ $remplacement->date_debut }}"
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all">
                    </div>
                </div>

                {{-- Boutons d'action --}}
                <div class="flex items-center justify-between pt-6 border-t-2 border-gray-100">
                    <a href="{{ route('remplacements.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all">
                        <i class="ph-bold ph-arrow-left mr-2"></i>
                        Retour
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
                        <i class="ph-bold ph-check-circle mr-2"></i>
                        Mettre à Jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
