@extends('layouts.admin')

@section('content_header_title', 'Nouveau Remplacement')
@section('content_header_subtitle', 'Organiser un remplacement d\'agent')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-3xl overflow-hidden shadow-2xl">

        {{-- Header avec icône --}}
        <div class="bg-gradient-to-br from-green-600 to-green-700 p-8 text-center">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="ph-bold ph-arrows-left-right text-white text-5xl"></i>
            </div>
            <h2 class="text-3xl font-black text-white mb-2">Organiser un Remplacement</h2>
            <p class="text-green-100 font-medium">Sélectionnez les agents et renseignez les détails du remplacement</p>
        </div>

        {{-- Formulaire --}}
        <div class="p-8 bg-white">
            <form action="{{ route('remplacements.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Ligne 1: Agent Absent + Agent Remplaçant --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ph-bold ph-user-minus text-red-600 mr-1"></i>
                            Agent Absent
                        </label>
                        <select name="agent_absent_id"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all"
                                required>
                            <option value="">-- Sélectionner l'agent absent --</option>
                            @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->nom }} {{ $agent->prenom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ph-bold ph-user-plus text-green-600 mr-1"></i>
                            Agent Remplaçant
                        </label>
                        <select name="agent_remplacant_id"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all"
                                required>
                            <option value="">-- Sélectionner le remplaçant --</option>
                            @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->nom }} {{ $agent->prenom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Ligne 2: Date & Type de mouvement --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ph-bold ph-calendar-blank text-blue-600 mr-1"></i>
                            Date & Heure du Remplacement
                        </label>
                        <input type="datetime-local"
                               name="date_remplacement"
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="ph-bold ph-tag text-purple-600 mr-1"></i>
                            Type de Mouvement
                        </label>
                        <select name="statut"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all">
                            <option value="heures supplémentaires">Heures supplémentaires</option>
                            <option value="changement de faction">Changement de faction</option>
                            <option value="surplus">Surplus</option>
                        </select>
                    </div>
                </div>

                {{-- Ligne 3: Commentaire --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="ph-bold ph-note text-amber-600 mr-1"></i>
                        Commentaire / Justification
                    </label>
                    <textarea name="commentaire"
                              rows="4"
                              class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all resize-none"
                              placeholder="Détails supplémentaires sur le remplacement..."></textarea>
                </div>

                {{-- Boutons d'action --}}
                <div class="flex items-center justify-between pt-6 border-t-2 border-gray-100">
                    <a href="{{ route('remplacements.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all">
                        <i class="ph-bold ph-x mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
                        <i class="ph-bold ph-check-circle mr-2"></i>
                        Valider le Remplacement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
