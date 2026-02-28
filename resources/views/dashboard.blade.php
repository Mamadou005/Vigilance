@extends('layouts.admin')

@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', Auth::user()->role == 'responsable' ? 'Direction & Administration' : 'Supervision COS 24h/24')

@section('content')

{{-- Navigation Rapide --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
    <div x-show="show" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <a href="{{ route('agents.index') }}" class="glass-card rounded-2xl p-6 flex flex-col items-center justify-center space-y-3 hover:shadow-2xl hover:scale-105 transition-all duration-300 group">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <i class="ph-bold ph-users-four text-white text-3xl"></i>
            </div>
            <span class="text-sm font-bold text-gray-900 uppercase tracking-wide">Agents</span>
        </a>
    </div>

    <div x-show="show" x-transition:enter="transition ease-out duration-500 delay-75" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <a href="{{ route('sites.index') }}" class="glass-card rounded-2xl p-6 flex flex-col items-center justify-center space-y-3 hover:shadow-2xl hover:scale-105 transition-all duration-300 group">
            <div class="w-16 h-16 bg-gradient-to-br from-cyan-400 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <i class="ph-bold ph-buildings text-white text-3xl"></i>
            </div>
            <span class="text-sm font-bold text-gray-900 uppercase tracking-wide">Sites</span>
        </a>
    </div>

    <div x-show="show" x-transition:enter="transition ease-out duration-500 delay-150" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <a href="{{ route('alertes.index') }}" class="glass-card rounded-2xl p-6 flex flex-col items-center justify-center space-y-3 hover:shadow-2xl hover:scale-105 transition-all duration-300 group">
            <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <i class="ph-bold ph-megaphone text-white text-3xl"></i>
            </div>
            <span class="text-sm font-bold text-gray-900 uppercase tracking-wide">Alertes</span>
        </a>
    </div>

    <div x-show="show" x-transition:enter="transition ease-out duration-500 delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <a href="{{ route('appels.index') }}" class="glass-card rounded-2xl p-6 flex flex-col items-center justify-center space-y-3 hover:shadow-2xl hover:scale-105 transition-all duration-300 group">
            <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <i class="ph-bold ph-phone-call text-white text-3xl"></i>
            </div>
            <span class="text-sm font-bold text-gray-900 uppercase tracking-wide">Appels</span>
        </a>
    </div>

    <div x-show="show" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <a href="{{ route('plannings.index') }}" class="glass-card rounded-2xl p-6 flex flex-col items-center justify-center space-y-3 hover:shadow-2xl hover:scale-105 transition-all duration-300 group">
            <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <i class="ph-bold ph-calendar-check text-white text-3xl"></i>
            </div>
            <span class="text-sm font-bold text-gray-900 uppercase tracking-wide">Planning</span>
        </a>
    </div>

    <div x-show="show" x-transition:enter="transition ease-out duration-500 delay-[400ms]" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <a href="{{ route('remplacements.index') }}" class="glass-card rounded-2xl p-6 flex flex-col items-center justify-center space-y-3 hover:shadow-2xl hover:scale-105 transition-all duration-300 group">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <i class="ph-bold ph-arrows-clockwise text-white text-3xl"></i>
            </div>
            <span class="text-sm font-bold text-gray-900 uppercase tracking-wide">Relèves</span>
        </a>
    </div>
</div>

{{-- Pointages & RH --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    {{-- Sanctions --}}
    <div class="glass-card rounded-2xl p-6 border-l-4 border-red-500 hover:shadow-2xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-2">Sanctions du Mois</p>
                <h2 class="text-4xl font-black text-gray-900 mb-4">
                    {{ number_format($totalSanctions ?? 0, 0, ',', ' ') }}
                    <span class="text-lg text-gray-600 font-medium">F CFA</span>
                </h2>
                <a href="{{ route('pointages.index', ['type' => 'absence']) }}"
                   class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all">
                    <i class="ph-bold ph-file-text mr-2"></i>
                    Ouvrir le Rapport
                </a>
            </div>
            <div class="w-20 h-20 bg-red-100 rounded-2xl flex items-center justify-center">
                <i class="ph-bold ph-warning-octagon text-red-600 text-5xl"></i>
            </div>
        </div>
    </div>

    {{-- Heures Supplémentaires --}}
    <div class="glass-card rounded-2xl p-6 border-l-4 border-cyan-500 hover:shadow-2xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-2">Heures Supplémentaires</p>
                <h2 class="text-4xl font-black text-gray-900 mb-4">
                    {{ $nbRemplacements ?? 0 }}
                    <span class="text-lg text-gray-600 font-medium">Missions</span>
                </h2>
                <a href="{{ route('pointages.index', ['type' => 'supplementaire']) }}"
                   class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-bold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all">
                    <i class="ph-bold ph-file-text mr-2"></i>
                    Ouvrir le Rapport
                </a>
            </div>
            <div class="w-20 h-20 bg-cyan-100 rounded-2xl flex items-center justify-center">
                <i class="ph-bold ph-clock-user text-cyan-600 text-5xl"></i>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->role == 'responsable')
{{-- Statistiques Responsable --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- Effectif Total --}}
    <div class="glass-card rounded-2xl p-6 hover:shadow-2xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="ph-bold ph-users-three text-blue-600 text-3xl"></i>
            </div>
            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full uppercase">Actifs</span>
        </div>
        <h3 class="text-4xl font-black text-gray-900 mb-2">{{ array_sum($statsAgents ?? []) ?? '0' }}</h3>
        <p class="text-sm font-bold text-gray-600 uppercase tracking-wide">Effectif Total</p>
    </div>

    {{-- Alertes Critiques --}}
    <div class="glass-card rounded-2xl p-6 hover:shadow-2xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="ph-bold ph-warning-octagon text-red-600 text-3xl"></i>
            </div>
            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full uppercase">Urgent</span>
        </div>
        <h3 class="text-4xl font-black text-gray-900 mb-2">{{ $alertesNonTraitees ?? '0' }}</h3>
        <p class="text-sm font-bold text-gray-600 uppercase tracking-wide">Alertes Critiques</p>
    </div>

    {{-- Remplacements --}}
    <div class="glass-card rounded-2xl p-6 hover:shadow-2xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center">
                <i class="ph-bold ph-arrows-clockwise text-amber-600 text-3xl"></i>
            </div>
            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full uppercase">En cours</span>
        </div>
        <h3 class="text-4xl font-black text-gray-900 mb-2">{{ $remplacementsEnCours ?? '0' }}</h3>
        <p class="text-sm font-bold text-gray-600 uppercase tracking-wide">Suivi Remplacements</p>
    </div>
</div>

{{-- Occupation & Actions --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Occupation par Secteurs --}}
    <div class="lg:col-span-2">
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-black text-white uppercase tracking-wide flex items-center">
                    <i class="ph-bold ph-map-trifold mr-3 text-2xl"></i>
                    Occupation par Secteurs
                </h3>
            </div>
            <div class="p-6 space-y-4 max-h-96 overflow-y-auto">
                @foreach($sites->groupBy('secteur') as $secteurNom => $sitesDuSecteur)
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-3 pb-2 border-b-2 border-gray-200">
                        <span class="px-4 py-2 bg-gray-900 text-white text-xs font-black uppercase rounded-xl">
                            {{ $secteurNom ?: 'SANS SECTEUR' }}
                        </span>
                        <span class="text-sm font-bold text-gray-600">{{ $sitesDuSecteur->count() }} Sites</span>
                    </div>
                    <div class="space-y-2">
                        @foreach($sitesDuSecteur as $site)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-blue-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="ph-bold ph-bank text-blue-600 text-xl"></i>
                                <span class="font-bold text-gray-900">{{ $site->nom }}</span>
                            </div>
                            <span class="px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full">
                                {{ $site->agents->count() }} Agents
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Actions Rapides --}}
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-xl font-black text-gray-900 mb-6 flex items-center">
            <i class="ph-bold ph-lightning text-blue-600 mr-3 text-2xl"></i>
            Actions Rapides
        </h3>
        <div class="space-y-3">
            <a href="{{ route('agents.create') }}"
               class="block px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-center rounded-xl shadow-lg hover:shadow-xl transition-all">
                <i class="ph-bold ph-user-plus mr-2"></i>
                Enregistrer un Agent
            </a>
            <a href="{{ route('sites.create') }}"
               class="block px-6 py-3 bg-white border-2 border-gray-900 hover:bg-gray-900 text-gray-900 hover:text-white font-bold text-center rounded-xl transition-all">
                <i class="ph-bold ph-building-office mr-2"></i>
                Ajouter un Site
            </a>
            <a href="{{ route('alertes.create') }}"
               class="block px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold text-center rounded-xl shadow-lg hover:shadow-xl transition-all">
                <i class="ph-bold ph-warning-circle mr-2"></i>
                Signaler une Alerte
            </a>
            <a href="{{ route('plannings.index') }}"
               class="block px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold text-center rounded-xl shadow-lg hover:shadow-xl transition-all">
                <i class="ph-bold ph-calendar-check mr-2"></i>
                Gérer Planning
            </a>
        </div>
    </div>
</div>

@else
{{-- Vue Agent --}}
<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-3xl p-12 text-center">
        <div class="w-24 h-24 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-2xl">
            <i class="ph-bold ph-shield-check text-white text-6xl"></i>
        </div>
        <h2 class="text-4xl font-black text-gray-900 mb-4">Console de Supervision</h2>
        <p class="text-lg text-gray-600 mb-8 font-medium">Système de surveillance et de gestion des opérations 24h/24</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="p-6 bg-red-50 border-2 border-red-200 rounded-2xl hover:shadow-xl transition-all">
                <i class="ph-bold ph-warning-octagon text-red-600 text-5xl mb-4"></i>
                <h5 class="text-xl font-black text-gray-900 mb-2">Alertes</h5>
                <p class="text-gray-600 font-medium">Vérifiez les rapports de site</p>
            </div>
            <div class="p-6 bg-emerald-50 border-2 border-emerald-200 rounded-2xl hover:shadow-xl transition-all">
                <i class="ph-bold ph-users-four text-emerald-600 text-5xl mb-4"></i>
                <h5 class="text-xl font-black text-gray-900 mb-2">Effectif</h5>
                <p class="text-gray-600 font-medium">Pointage agents 24h/24</p>
            </div>
        </div>

        <a href="{{ route('alertes.create') }}"
           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-black text-lg rounded-2xl shadow-2xl hover:shadow-3xl hover:scale-105 transition-all">
            <i class="ph-bold ph-megaphone mr-3 text-2xl"></i>
            Signaler un Incident
        </a>
    </div>
</div>
@endif

@endsection
