@extends('layouts.admin')

@section('content_header_title', 'Rapport d\'Incident')
@section('content_header_subtitle', 'Détails complets de l\'alerte')

@section('content')

{{-- Bouton Retour --}}
<div class="mb-6">
    <a href="{{ route('alertes.index') }}"
       class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all">
        <i class="ph-bold ph-arrow-left mr-2 text-xl"></i>
        Retour au Journal
    </a>
</div>

<div class="max-w-5xl mx-auto">
    <div class="glass-card rounded-3xl overflow-hidden" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            {{-- Header du Rapport --}}
            <div class="bg-gradient-to-br from-red-600 to-red-700 p-8">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <i class="ph-bold ph-warning-octagon text-white text-3xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-black text-white">Rapport d'Intervention #{{ $alerte->id }}</h2>
                                <p class="text-red-100 text-sm font-medium">
                                    <i class="ph-bold ph-calendar mr-1"></i>
                                    Émis le {{ $alerte->created_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        @php
                        $statusConfig = [
                            'non_traite' => ['bg' => 'bg-white/20', 'text' => 'text-white', 'border' => 'border-white/30', 'icon' => 'ph-x-circle'],
                            'en_cours' => ['bg' => 'bg-amber-500/90', 'text' => 'text-white', 'border' => 'border-amber-600', 'icon' => 'ph-clock'],
                            'resolu' => ['bg' => 'bg-emerald-500/90', 'text' => 'text-white', 'border' => 'border-emerald-600', 'icon' => 'ph-check-circle']
                        ];
                        $config = $statusConfig[$alerte->statut] ?? $statusConfig['non_traite'];
                        @endphp
                        <span class="inline-flex items-center px-6 py-3 {{ $config['bg'] }} {{ $config['text'] }} border-2 {{ $config['border'] }} text-sm font-black rounded-full uppercase shadow-lg backdrop-blur-sm">
                            <i class="ph-bold {{ $config['icon'] }} mr-2 text-lg"></i>
                            {{ str_replace('_', ' ', $alerte->statut) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Corps du Rapport --}}
            <div class="p-8 bg-white">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    {{-- Colonne Gauche : Localisation & Chronologie --}}
                    <div class="space-y-6">
                        <div class="pb-4 border-b-2 border-gray-200">
                            <h3 class="text-xl font-black text-gray-900 uppercase flex items-center gap-2 mb-4">
                                <i class="ph-bold ph-map-trifold text-blue-600 text-2xl"></i>
                                Localisation & Chronologie
                            </h3>
                        </div>

                        <div class="glass-card rounded-xl p-5 border-2 border-blue-200">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">Site Concerné</label>
                            <div class="flex items-center gap-3">
                                <i class="ph-bold ph-bank text-blue-600 text-3xl"></i>
                                <span class="text-2xl font-black text-gray-900">{{ $alerte->site->nom ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="glass-card rounded-xl p-4 border-2 border-purple-200">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">
                                    <i class="ph-bold ph-clock text-purple-600 mr-1"></i>
                                    Heure Incident
                                </label>
                                <span class="text-2xl font-black text-purple-600">{{ $alerte->heure_incident ?? '--:--' }}</span>
                            </div>

                            <div class="glass-card rounded-xl p-4 border-2 border-red-200">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">
                                    <i class="ph-bold ph-siren text-red-600 mr-1"></i>
                                    Arrivée Brigade
                                </label>
                                <span class="text-2xl font-black text-red-600">{{ $alerte->heure_arrivee_brigade ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Colonne Droite : Nature & Intervention --}}
                    <div class="space-y-6">
                        <div class="pb-4 border-b-2 border-gray-200">
                            <h3 class="text-xl font-black text-gray-900 uppercase flex items-center gap-2 mb-4">
                                <i class="ph-bold ph-warning text-amber-600 text-2xl"></i>
                                Nature & Intervention
                            </h3>
                        </div>

                        <div class="glass-card rounded-xl p-5 border-2 border-red-200">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">Type d'Incident</label>
                            <div class="flex items-center gap-3">
                                <i class="ph-bold ph-warning-octagon text-red-600 text-3xl"></i>
                                <span class="text-2xl font-black text-red-600">{{ $alerte->type_incident }}</span>
                            </div>
                        </div>

                        <div class="glass-card rounded-xl p-5 border-2 border-emerald-200">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">Agent Intervenant (COS)</label>
                            <div class="flex items-center gap-3">
                                <i class="ph-bold ph-user-focus text-emerald-600 text-3xl"></i>
                                <span class="text-xl font-black text-gray-900">{{ $alerte->intervenant_nom }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Observations Détaillées --}}
                <div class="glass-card rounded-2xl p-6 bg-gradient-to-br from-indigo-50 to-purple-50 border-l-4 border-indigo-600">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="ph-bold ph-note-pencil text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-black text-gray-900 uppercase mb-3">Observations Détaillées & Causes</h4>
                            <p class="text-gray-700 font-medium leading-relaxed whitespace-pre-line">{{ $alerte->observations ?: 'Aucune observation détaillée n\'a été saisie pour ce rapport.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer avec Actions --}}
            <div class="bg-gray-50 px-8 py-6 border-t-2 border-gray-200">
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <button onclick="window.print()"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-800 hover:to-gray-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
                        <i class="ph-bold ph-printer mr-2 text-xl"></i>
                        Imprimer
                    </button>

                    <a href="{{ route('alertes.pdf', $alerte->id) }}"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
                        <i class="ph-bold ph-file-pdf mr-2 text-xl"></i>
                        Télécharger PDF
                    </a>

                    <a href="{{ route('alertes.edit', $alerte->id) }}"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
                        <i class="ph-bold ph-pencil-simple mr-2 text-xl"></i>
                        Modifier le Statut
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
