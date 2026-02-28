@extends('layouts.premium')

@section('title', 'Dashboard')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">VIGILANCE COS</h1>
            <p class="text-sm text-gray-400 mt-1">
                {{ Auth::user()->role == 'responsable' ? 'Direction & Administration' : 'Supervision COS 24h/24' }}
            </p>
        </div>
    </div>
@endsection

@section('content')
    <!-- Quick Actions -->
    <div class="mb-8">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('agents.index') }}" class="group glass-effect rounded-2xl p-6 hover:bg-navy-800/50 transition-all duration-200 transform hover:scale-105">
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-200">
                        <i class="ph-bold ph-users-four text-white text-2xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-300 group-hover:text-white transition-colors">Agents</span>
                </div>
            </a>

            <a href="{{ route('sites.index') }}" class="group glass-effect rounded-2xl p-6 hover:bg-navy-800/50 transition-all duration-200 transform hover:scale-105">
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-200">
                        <i class="ph-bold ph-buildings text-white text-2xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-300 group-hover:text-white transition-colors">Sites</span>
                </div>
            </a>

            <a href="{{ route('alertes.index') }}" class="group glass-effect rounded-2xl p-6 hover:bg-navy-800/50 transition-all duration-200 transform hover:scale-105">
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-200">
                        <i class="ph-bold ph-megaphone text-white text-2xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-300 group-hover:text-white transition-colors">Alertes</span>
                </div>
            </a>

            <a href="{{ route('appels.index') }}" class="group glass-effect rounded-2xl p-6 hover:bg-navy-800/50 transition-all duration-200 transform hover:scale-105">
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-200">
                        <i class="ph-bold ph-phone-call text-white text-2xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-300 group-hover:text-white transition-colors">Appels</span>
                </div>
            </a>

            <a href="{{ route('plannings.index') }}" class="group glass-effect rounded-2xl p-6 hover:bg-navy-800/50 transition-all duration-200 transform hover:scale-105">
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-200">
                        <i class="ph-bold ph-calendar-check text-white text-2xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-300 group-hover:text-white transition-colors">Planning</span>
                </div>
            </a>

            <a href="{{ route('remplacements.index') }}" class="group glass-effect rounded-2xl p-6 hover:bg-navy-800/50 transition-all duration-200 transform hover:scale-105">
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-200">
                        <i class="ph-bold ph-arrows-clockwise text-white text-2xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-300 group-hover:text-white transition-colors">Relèves</span>
                </div>
            </a>
        </div>
    </div>

    <!-- HR Stats: Sanctions & Heures Supplémentaires -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Sanctions Card -->
        <div class="relative overflow-hidden glass-effect rounded-2xl p-6 border border-red-500/20">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-500/20 to-transparent rounded-full blur-3xl"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs font-semibold text-red-400 uppercase tracking-wider">Sanctions du Mois</p>
                        <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($totalSanctions ?? 0, 0, ',', ' ') }} <span class="text-lg text-gray-400">F CFA</span></h3>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500/20 to-red-600/20 rounded-2xl flex items-center justify-center">
                        <i class="ph-bold ph-warning-octagon text-red-400 text-3xl"></i>
                    </div>
                </div>
                <a href="{{ route('pointages.index', ['type' => 'absence']) }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 rounded-xl text-red-400 text-sm font-medium transition-all duration-200 group">
                    <span>Ouvrir le rapport</span>
                    <i class="ph ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Heures Supplémentaires Card -->
        <div class="relative overflow-hidden glass-effect rounded-2xl p-6 border border-cyan-500/20">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-500/20 to-transparent rounded-full blur-3xl"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs font-semibold text-cyan-400 uppercase tracking-wider">Heures Supplémentaires</p>
                        <h3 class="text-3xl font-bold text-white mt-2">{{ $nbRemplacements ?? 0 }} <span class="text-lg text-gray-400">Missions</span></h3>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-500/20 to-cyan-600/20 rounded-2xl flex items-center justify-center">
                        <i class="ph-bold ph-clock-user text-cyan-400 text-3xl"></i>
                    </div>
                </div>
                <a href="{{ route('pointages.index', ['type' => 'supplementaire']) }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-cyan-500/10 hover:bg-cyan-500/20 border border-cyan-500/20 rounded-xl text-cyan-400 text-sm font-medium transition-all duration-200 group">
                    <span>Ouvrir le rapport</span>
                    <i class="ph ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    @if(Auth::user()->role == 'responsable')
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Effectif Total -->
            <div class="relative overflow-hidden glass-effect rounded-2xl p-6 group hover:border-blue-500/30 border border-navy-800/50 transition-all duration-200">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-500/10 to-transparent rounded-full blur-2xl"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-blue-600/20 rounded-xl flex items-center justify-center">
                            <i class="ph-bold ph-users-three text-blue-400 text-2xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-blue-500/10 text-blue-400 rounded-lg text-xs font-semibold">AGENTS</span>
                    </div>
                    <h3 class="text-4xl font-bold text-white mb-1">{{ array_sum($statsAgents ?? []) }}</h3>
                    <p class="text-sm text-gray-400 uppercase tracking-wide">Effectif Total</p>
                </div>
            </div>

            <!-- Alertes Critiques -->
            <div class="relative overflow-hidden glass-effect rounded-2xl p-6 group hover:border-red-500/30 border border-navy-800/50 transition-all duration-200">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-red-500/10 to-transparent rounded-full blur-2xl"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500/20 to-red-600/20 rounded-xl flex items-center justify-center">
                            <i class="ph-bold ph-warning-octagon text-red-400 text-2xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-red-500/10 text-red-400 rounded-lg text-xs font-semibold animate-pulse">URGENT</span>
                    </div>
                    <h3 class="text-4xl font-bold text-white mb-1">{{ $alertesNonTraitees ?? 0 }}</h3>
                    <p class="text-sm text-gray-400 uppercase tracking-wide">Alertes Critiques</p>
                </div>
            </div>

            <!-- Remplacements -->
            <div class="relative overflow-hidden glass-effect rounded-2xl p-6 group hover:border-amber-500/30 border border-navy-800/50 transition-all duration-200">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-500/10 to-transparent rounded-full blur-2xl"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-500/20 to-amber-600/20 rounded-xl flex items-center justify-center">
                            <i class="ph-bold ph-arrows-clockwise text-amber-400 text-2xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-amber-500/10 text-amber-400 rounded-lg text-xs font-semibold">EN COURS</span>
                    </div>
                    <h3 class="text-4xl font-bold text-white mb-1">{{ $remplacementsEnCours ?? 0 }}</h3>
                    <p class="text-sm text-gray-400 uppercase tracking-wide">Suivi Remplacements</p>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Sites par secteur + Actions Rapides -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Sites par Secteur (2/3) -->
            <div class="lg:col-span-2 glass-effect rounded-2xl overflow-hidden border border-navy-800/50">
                <div class="px-6 py-4 border-b border-navy-800/50 bg-navy-900/30">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <i class="ph-bold ph-map-trifold text-primary-400 mr-3"></i>
                        Occupation par Secteurs
                    </h3>
                </div>

                <div class="p-6 max-h-[500px] overflow-y-auto">
                    @forelse($sites->groupBy('secteur') as $secteurNom => $sitesDuSecteur)
                        <div class="mb-6 last:mb-0">
                            <div class="flex items-center justify-between mb-3 px-4 py-2 bg-navy-800/30 rounded-xl">
                                <span class="text-sm font-bold text-gray-300 uppercase tracking-wider">
                                    {{ $secteurNom ?: 'Sans Secteur' }}
                                </span>
                                <span class="px-3 py-1 bg-primary-500/10 text-primary-400 rounded-lg text-xs font-semibold">
                                    {{ $sitesDuSecteur->count() }} Sites
                                </span>
                            </div>

                            <div class="space-y-2">
                                @foreach($sitesDuSecteur as $site)
                                    <div class="flex items-center justify-between px-4 py-3 bg-navy-900/20 hover:bg-navy-800/30 rounded-xl transition-colors duration-200">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500/20 to-primary-600/20 rounded-lg flex items-center justify-center">
                                                <i class="ph-bold ph-bank text-primary-400"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-300">{{ $site->nom }}</span>
                                        </div>
                                        <span class="px-3 py-1 bg-primary-500/10 text-primary-400 rounded-lg text-xs font-semibold">
                                            {{ $site->agents->count() }} Agents
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-navy-800/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="ph-bold ph-buildings text-gray-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-400">Aucun site enregistré</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Actions Rapides (1/3) -->
            <div class="glass-effect rounded-2xl p-6 border border-navy-800/50 h-fit">
                <h3 class="text-lg font-bold text-white mb-6 flex items-center">
                    <i class="ph-bold ph-lightning text-amber-400 mr-3"></i>
                    Actions Rapides
                </h3>

                <div class="space-y-3">
                    <a href="{{ route('agents.create') }}" class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 rounded-xl text-white font-medium transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-glow group">
                        <span class="flex items-center space-x-3">
                            <i class="ph-bold ph-plus-circle text-xl"></i>
                            <span>Enregistrer un Agent</span>
                        </span>
                        <i class="ph ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('sites.create') }}" class="flex items-center justify-between px-4 py-3 bg-navy-800/50 hover:bg-navy-700/50 border border-navy-700/50 rounded-xl text-gray-300 hover:text-white font-medium transition-all duration-200 group">
                        <span class="flex items-center space-x-3">
                            <i class="ph-bold ph-buildings text-xl"></i>
                            <span>Ajouter un Site</span>
                        </span>
                        <i class="ph ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('alertes.create') }}" class="flex items-center justify-between px-4 py-3 bg-navy-800/50 hover:bg-navy-700/50 border border-navy-700/50 rounded-xl text-gray-300 hover:text-white font-medium transition-all duration-200 group">
                        <span class="flex items-center space-x-3">
                            <i class="ph-bold ph-warning text-xl"></i>
                            <span>Signaler un Incident</span>
                        </span>
                        <i class="ph ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <!-- Mini Stats -->
                <div class="mt-6 pt-6 border-t border-navy-800/50">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-3">Activité du jour</p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">Agents actifs</span>
                            <span class="font-semibold text-emerald-400">{{ $statsAgents['Actif'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">En repos</span>
                            <span class="font-semibold text-gray-300">{{ $statsAgents['Repos'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- Vue Agent: Console de Supervision -->
        <div class="max-w-4xl mx-auto">
            <div class="relative overflow-hidden glass-effect rounded-3xl p-8 lg:p-12 text-center border border-primary-500/20">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-transparent"></div>
                <div class="relative">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center mx-auto mb-6 transform rotate-3 shadow-glow">
                        <i class="ph-bold ph-shield-check text-white text-4xl"></i>
                    </div>

                    <h2 class="text-3xl font-bold text-white mb-4">CONSOLE DE SUPERVISION</h2>
                    <p class="text-gray-400 mb-8">Surveillance et gestion des opérations 24h/24</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="p-6 bg-navy-900/30 hover:bg-navy-800/30 rounded-2xl transition-colors duration-200 border border-navy-800/50">
                            <i class="ph-bold ph-warning-octagon text-red-400 text-3xl mb-3"></i>
                            <h5 class="text-lg font-bold text-white mb-2">Alertes</h5>
                            <p class="text-sm text-gray-400">Vérifiez les rapports de site</p>
                        </div>
                        <div class="p-6 bg-navy-900/30 hover:bg-navy-800/30 rounded-2xl transition-colors duration-200 border border-navy-800/50">
                            <i class="ph-bold ph-users-four text-emerald-400 text-3xl mb-3"></i>
                            <h5 class="text-lg font-bold text-white mb-2">Effectif</h5>
                            <p class="text-sm text-gray-400">Pointage agents 24h/24</p>
                        </div>
                    </div>

                    <a href="{{ route('alertes.create') }}" class="inline-flex items-center space-x-3 px-8 py-4 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 rounded-xl text-white font-bold text-lg transition-all duration-200 transform hover:scale-105 shadow-premium-lg">
                        <i class="ph-bold ph-megaphone text-xl"></i>
                        <span>SIGNALER UN INCIDENT</span>
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection
