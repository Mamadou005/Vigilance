@extends('layouts.admin')

@section('content_header_title', 'Statistiques et Suivi')
@section('content_header_subtitle', 'Tableau de bord analytique avec diagrammes')

@section('content')

{{-- Statistiques Générales --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
    {{-- Total Utilisateurs --}}
    <div class="glass-card rounded-2xl p-6 hover:shadow-xl transition-all">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Utilisateurs</p>
                <h3 class="text-3xl font-black text-gray-900 dark:text-gray-100 mt-2">{{ $statsGenerales['total_utilisateurs'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                <i class="ph-bold ph-identification-card text-white text-2xl"></i>
            </div>
        </div>
    </div>

    {{-- Total Agents --}}
    <div class="glass-card rounded-2xl p-6 hover:shadow-xl transition-all">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Agents</p>
                <h3 class="text-3xl font-black text-gray-900 dark:text-gray-100 mt-2">{{ $statsGenerales['total_agents'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center">
                <i class="ph-bold ph-identification-card text-white text-2xl"></i>
            </div>
        </div>
    </div>

    {{-- Total Sites --}}
    <div class="glass-card rounded-2xl p-6 hover:shadow-xl transition-all">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Sites</p>
                <h3 class="text-3xl font-black text-gray-900 dark:text-gray-100 mt-2">{{ $statsGenerales['total_sites'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                <i class="ph-bold ph-bank text-white text-2xl"></i>
            </div>
        </div>
    </div>

    {{-- Total Alertes --}}
    <div class="glass-card rounded-2xl p-6 hover:shadow-xl transition-all">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Alertes</p>
                <h3 class="text-3xl font-black text-gray-900 dark:text-gray-100 mt-2">{{ $statsGenerales['total_alertes'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-600 rounded-xl flex items-center justify-center">
                <i class="ph-bold ph-warning-octagon text-white text-2xl"></i>
            </div>
        </div>
    </div>

    {{-- Total Pointages --}}
    <div class="glass-card rounded-2xl p-6 hover:shadow-xl transition-all">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Pointages</p>
                <h3 class="text-3xl font-black text-gray-900 dark:text-gray-100 mt-2">{{ $statsGenerales['total_pointages'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-xl flex items-center justify-center">
                <i class="ph-bold ph-calendar-check text-white text-2xl"></i>
            </div>
        </div>
    </div>
</div>

{{-- Graphiques --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- Utilisateurs par Rôle --}}
    <div class="glass-card rounded-2xl overflow-hidden shadow-xl">
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-900 p-4">
            <h4 class="text-lg font-black text-white flex items-center">
                <i class="ph-bold ph-chart-pie text-indigo-400 mr-2 text-2xl"></i>
                Utilisateurs par Rôle
            </h4>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800">
            <canvas id="usersByRoleChart" height="250"></canvas>
        </div>
    </div>

    {{-- Agents par Statut --}}
    <div class="glass-card rounded-2xl overflow-hidden shadow-xl">
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-900 p-4">
            <h4 class="text-lg font-black text-white flex items-center">
                <i class="ph-bold ph-chart-donut text-blue-400 mr-2 text-2xl"></i>
                Agents par Statut
            </h4>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800">
            <canvas id="agentsByStatusChart" height="250"></canvas>
        </div>
    </div>
</div>

{{-- Graphiques ligne 2 --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- Alertes Traitées vs Non Traitées --}}
    <div class="glass-card rounded-2xl overflow-hidden shadow-xl">
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-900 p-4">
            <h4 class="text-lg font-black text-white flex items-center">
                <i class="ph-bold ph-chart-bar text-red-400 mr-2 text-2xl"></i>
                Statut des Alertes
            </h4>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800">
            <canvas id="alertesChart" height="250"></canvas>
        </div>
    </div>

    {{-- Types de Pointages --}}
    <div class="glass-card rounded-2xl overflow-hidden shadow-xl">
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-900 p-4">
            <h4 class="text-lg font-black text-white flex items-center">
                <i class="ph-bold ph-chart-bar-horizontal text-yellow-400 mr-2 text-2xl"></i>
                Types de Pointages
            </h4>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800">
            <canvas id="pointagesTypesChart" height="250"></canvas>
        </div>
    </div>
</div>

{{-- Agents par Site --}}
<div class="glass-card rounded-2xl overflow-hidden shadow-xl mb-6">
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-900 p-4">
        <h4 class="text-lg font-black text-white flex items-center">
            <i class="ph-bold ph-chart-line text-green-400 mr-2 text-2xl"></i>
            Répartition des Agents par Site
        </h4>
    </div>
    <div class="p-6 bg-white dark:bg-gray-800">
        <canvas id="agentsParSiteChart" height="100"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Configuration des couleurs
    const colors = {
        indigo: 'rgb(99, 102, 241)',
        purple: 'rgb(168, 85, 247)',
        blue: 'rgb(59, 130, 246)',
        cyan: 'rgb(6, 182, 212)',
        green: 'rgb(34, 197, 94)',
        yellow: 'rgb(234, 179, 8)',
        red: 'rgb(239, 68, 68)',
        orange: 'rgb(249, 115, 22)',
        gray: 'rgb(107, 114, 128)',
    };

    // Utilisateurs par Rôle (Doughnut)
    const usersByRoleCtx = document.getElementById('usersByRoleChart').getContext('2d');
    new Chart(usersByRoleCtx, {
        type: 'doughnut',
        data: {
            labels: ['Admin', 'Responsable', 'Agent'],
            datasets: [{
                data: [
                    {{ $usersByRole['admin'] ?? 0 }},
                    {{ $usersByRole['responsable'] ?? 0 }},
                    {{ $usersByRole['agent'] ?? 0 }}
                ],
                backgroundColor: [colors.red, colors.blue, colors.gray],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 12, weight: 'bold' },
                        padding: 15
                    }
                }
            }
        }
    });

    // Agents par Statut (Pie)
    const agentsByStatusCtx = document.getElementById('agentsByStatusChart').getContext('2d');
    new Chart(agentsByStatusCtx, {
        type: 'pie',
        data: {
            labels: ['Actif', 'En congé', 'Suspendu', 'Inactif'],
            datasets: [{
                data: [
                    {{ $agentsByStatus['actif'] ?? 0 }},
                    {{ $agentsByStatus['en_conge'] ?? 0 }},
                    {{ $agentsByStatus['suspendu'] ?? 0 }},
                    {{ $agentsByStatus['inactif'] ?? 0 }}
                ],
                backgroundColor: [colors.green, colors.yellow, colors.orange, colors.gray],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 12, weight: 'bold' },
                        padding: 15
                    }
                }
            }
        }
    });

    // Alertes (Bar)
    const alertesCtx = document.getElementById('alertesChart').getContext('2d');
    new Chart(alertesCtx, {
        type: 'bar',
        data: {
            labels: ['Traitées', 'Non Traitées'],
            datasets: [{
                label: 'Nombre d\'alertes',
                data: [{{ $alertesStats['traitees'] }}, {{ $alertesStats['non_traitees'] }}],
                backgroundColor: [colors.green, colors.red],
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { weight: 'bold' }
                    }
                },
                x: {
                    ticks: {
                        font: { weight: 'bold' }
                    }
                }
            }
        }
    });

    // Types de Pointages (Horizontal Bar)
    const pointagesTypesCtx = document.getElementById('pointagesTypesChart').getContext('2d');
    new Chart(pointagesTypesCtx, {
        type: 'bar',
        data: {
            labels: ['Absence', 'Supplémentaire', 'Retard'],
            datasets: [{
                label: 'Nombre de pointages',
                data: [
                    {{ $pointagesTypes['absence'] ?? 0 }},
                    {{ $pointagesTypes['supplementaire'] ?? 0 }},
                    {{ $pointagesTypes['retard'] ?? 0 }}
                ],
                backgroundColor: [colors.red, colors.blue, colors.yellow],
                borderRadius: 8,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { weight: 'bold' }
                    }
                },
                y: {
                    ticks: {
                        font: { weight: 'bold' }
                    }
                }
            }
        }
    });

    // Agents par Site (Bar)
    const agentsParSiteCtx = document.getElementById('agentsParSiteChart').getContext('2d');
    new Chart(agentsParSiteCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($agentsParSite->pluck('nom_site')) !!},
            datasets: [{
                label: 'Nombre d\'agents',
                data: {!! json_encode($agentsParSite->pluck('agents_count')) !!},
                backgroundColor: colors.indigo,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { weight: 'bold' }
                    }
                },
                x: {
                    ticks: {
                        font: { weight: 'bold' }
                    }
                }
            }
        }
    });
</script>
@endpush
