@extends('layouts.premium')

@section('title', 'Gestion des Agents')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Gestion des Agents</h1>
            <p class="text-sm text-gray-400 mt-1">{{ $agents->total() ?? 0 }} agents au total</p>
        </div>
        <a href="{{ route('agents.create') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
            <i class="ph-bold ph-plus-circle"></i>
            <span>Nouvel Agent</span>
        </a>
    </div>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="glass-effect rounded-2xl p-6 border border-navy-800/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $totalAgents ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-blue-600/20 rounded-xl flex items-center justify-center">
                    <i class="ph-bold ph-users-three text-blue-400 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-2xl p-6 border border-emerald-500/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-emerald-400 uppercase tracking-wider">Actifs</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $statsAgents['Actif'] ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center">
                    <i class="ph-bold ph-check-circle text-emerald-400 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-2xl p-6 border border-amber-500/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-amber-400 uppercase tracking-wider">En Repos</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $statsAgents['Repos'] ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500/20 to-amber-600/20 rounded-xl flex items-center justify-center">
                    <i class="ph-bold ph-moon text-amber-400 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-2xl p-6 border border-red-500/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-red-400 uppercase tracking-wider">Absents</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $statsAgents['Absent'] ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-red-500/20 to-red-600/20 rounded-xl flex items-center justify-center">
                    <i class="ph-bold ph-warning text-red-400 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass-effect rounded-2xl p-6 mb-6 border border-navy-800/50">
        <form method="GET" action="{{ route('agents.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-400 mb-2">Rechercher</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-500"></i>
                    </div>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Nom, prénom, matricule..."
                           class="w-full pl-10 pr-4 py-2.5 bg-navy-900/50 border border-navy-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Statut</label>
                <select name="statut"
                        class="w-full px-4 py-2.5 bg-navy-900/50 border border-navy-700/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                    <option value="">Tous les statuts</option>
                    <option value="Actif" {{ request('statut') == 'Actif' ? 'selected' : '' }}>Actif</option>
                    <option value="Repos" {{ request('statut') == 'Repos' ? 'selected' : '' }}>Repos</option>
                    <option value="Absent" {{ request('statut') == 'Absent' ? 'selected' : '' }}>Absent</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex items-end">
                <button type="submit"
                        class="w-full px-4 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-medium transition-all duration-200 transform hover:scale-105">
                    <i class="ph-bold ph-funnel mr-2"></i>
                    Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Agents Table -->
    <div class="glass-effect rounded-2xl overflow-hidden border border-navy-800/50">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-navy-800/50 bg-navy-900/30">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">Liste des Agents</h3>
                <div class="flex items-center space-x-2 text-sm text-gray-400">
                    <i class="ph ph-users-three"></i>
                    <span>{{ $agents->total() ?? 0 }} agents</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-navy-900/50 border-b border-navy-800/50 sticky top-0">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Agent</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Site</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Salaire</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-800/30">
                    @forelse($agents as $agent)
                        <tr class="hover:bg-navy-800/30 transition-colors duration-200">
                            <!-- Agent Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">{{ strtoupper(substr($agent->prenom, 0, 1) . substr($agent->nom, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-white">{{ $agent->prenom }} {{ $agent->nom }}</p>
                                        <p class="text-xs text-gray-400">{{ $agent->matricule }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Contact -->
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <p class="text-gray-300">{{ $agent->telephone ?? 'N/A' }}</p>
                                </div>
                            </td>

                            <!-- Site -->
                            <td class="px-6 py-4">
                                @if($agent->site)
                                    <div class="flex items-center space-x-2">
                                        <i class="ph ph-bank text-primary-400"></i>
                                        <span class="text-sm text-gray-300">{{ $agent->site->nom }}</span>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-500">Non assigné</span>
                                @endif
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4">
                                @php
                                    $badgeType = match($agent->statut) {
                                        'Actif' => 'success',
                                        'Repos' => 'warning',
                                        'Absent' => 'danger',
                                        default => 'inactive',
                                    };
                                    $badgeIcon = match($agent->statut) {
                                        'Actif' => 'ph-check-circle',
                                        'Repos' => 'ph-moon',
                                        'Absent' => 'ph-warning',
                                        default => 'ph-circle',
                                    };
                                @endphp
                                <x-premium.badge :type="$badgeType" :icon="$badgeIcon">
                                    {{ $agent->statut }}
                                </x-premium.badge>
                            </td>

                            <!-- Salaire -->
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-300">{{ number_format($agent->salaire_base ?? 0, 0, ',', ' ') }} F</span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('agents.show', $agent) }}"
                                       class="p-2 bg-primary-500/10 hover:bg-primary-500/20 border border-primary-500/20 text-primary-400 rounded-lg transition-colors duration-200"
                                       title="Voir">
                                        <i class="ph ph-eye"></i>
                                    </a>
                                    <a href="{{ route('agents.edit', $agent) }}"
                                       class="p-2 bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/20 text-amber-400 rounded-lg transition-colors duration-200"
                                       title="Modifier">
                                        <i class="ph ph-pencil-simple"></i>
                                    </a>
                                    <form method="POST" action="{{ route('agents.destroy', $agent) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet agent ?')"
                                                class="p-2 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 rounded-lg transition-colors duration-200"
                                                title="Supprimer">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12">
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-navy-800/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="ph-bold ph-users-three text-gray-500 text-3xl"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Aucun agent trouvé</h3>
                                    <p class="text-gray-400 mb-4">Commencez par ajouter votre premier agent</p>
                                    <a href="{{ route('agents.create') }}"
                                       class="inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-medium transition-all duration-200">
                                        <i class="ph-bold ph-plus-circle"></i>
                                        <span>Ajouter un agent</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($agents->hasPages())
            <div class="px-6 py-4 border-t border-navy-800/50 bg-navy-900/30">
                {{ $agents->links() }}
            </div>
        @endif
    </div>
@endsection
