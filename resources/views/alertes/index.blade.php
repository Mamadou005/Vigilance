@extends('layouts.admin')

@section('content_header_title', 'Journal des Alertes')
@section('content_header_subtitle', 'Rapports d\'incidents et interventions Brigade')

@section('content')

{{-- Header avec Recherche --}}
<div class="glass-card rounded-2xl p-6 mb-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <h3 class="text-2xl font-black text-gray-900">
            <i class="ph-bold ph-warning-octagon text-red-600 mr-2"></i>
            Journal des Alertes
        </h3>

        <div class="flex items-center gap-3 w-full md:w-auto">
            {{-- Barre de Recherche --}}
            <form action="{{ route('alertes.index') }}" method="GET" class="flex-1 md:flex-initial">
                <div class="relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Rechercher une alerte..."
                           class="w-full md:w-80 pl-12 pr-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all font-medium">
                    <i class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
                    <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold text-sm rounded-lg transition-all">
                        Rechercher
                    </button>
                </div>
            </form>

            {{-- Bouton Ajouter --}}
            <a href="{{ route('alertes.create') }}"
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 whitespace-nowrap">
                <i class="ph-bold ph-plus-circle mr-2 text-xl"></i>
                Nouvel Incident
            </a>
        </div>
    </div>
</div>

{{-- Grille des Alertes --}}
<div class="grid grid-cols-1 gap-4">
    @forelse($alertes as $alerte)
    <div class="glass-card rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300">
        <div class="flex flex-col md:flex-row">
            {{-- Colonne Gauche: Info Incident --}}
            <div class="bg-gradient-to-br from-red-600 to-red-700 p-6 md:w-1/3">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="ph-bold ph-warning-octagon text-white text-4xl"></i>
                    </div>
                    @php
                    $statusClass = [
                        'non_traite' => 'bg-white/20 text-white border-white/30',
                        'en_cours' => 'bg-amber-500/90 text-white border-amber-600',
                        'resolu' => 'bg-emerald-500/90 text-white border-emerald-600'
                    ][$alerte->statut] ?? 'bg-white/20 text-white border-white/30';
                    @endphp
                    <span class="px-3 py-1 {{ $statusClass }} text-xs font-bold rounded-full uppercase border backdrop-blur-sm">
                        {{ str_replace('_', ' ', $alerte->statut) }}
                    </span>
                </div>

                <h5 class="text-xl font-black text-white mb-2">{{ $alerte->type_incident }}</h5>
                <p class="text-red-100 text-sm font-medium flex items-center mb-3">
                    <i class="ph-bold ph-bank mr-2"></i>
                    {{ $alerte->site->nom ?? 'Site non spécifié' }}
                </p>
                <p class="text-red-100 text-sm font-medium flex items-center">
                    <i class="ph-bold ph-calendar mr-2"></i>
                    {{ $alerte->created_at->format('d/m/Y') }}
                </p>
            </div>

            {{-- Colonne Centrale: Détails --}}
            <div class="p-6 bg-white flex-1">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                    <div class="text-center p-3 bg-red-50 rounded-xl border-2 border-red-200">
                        <div class="text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Heure Incident</div>
                        <div class="text-lg font-black text-red-600">{{ $alerte->heure_incident ?? '--:--' }}</div>
                    </div>
                    <div class="text-center p-3 bg-blue-50 rounded-xl border-2 border-blue-200">
                        <div class="text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Arrivée Brigade</div>
                        <div class="text-lg font-black text-blue-600">{{ $alerte->heure_arrivee_brigade ?? 'N/A' }}</div>
                    </div>
                    <div class="text-center p-3 bg-purple-50 rounded-xl border-2 border-purple-200">
                        <div class="text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Intervenant</div>
                        <div class="text-sm font-black text-purple-600">{{ Str::limit($alerte->intervenant_nom, 15) }}</div>
                    </div>
                </div>

                @if($alerte->observations)
                <div class="bg-gray-50 rounded-xl p-3 border-2 border-gray-200">
                    <div class="text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Observations</div>
                    <p class="text-sm text-gray-700 font-medium">{{ Str::limit($alerte->observations, 100) }}</p>
                </div>
                @endif
            </div>

            {{-- Colonne Droite: Actions --}}
            <div class="flex md:flex-col gap-px bg-gray-200 md:w-20">
                <a href="{{ route('alertes.show', $alerte->id) }}"
                   class="bg-white hover:bg-blue-50 p-4 flex flex-col items-center justify-center transition-colors group flex-1">
                    <i class="ph-bold ph-eye text-blue-600 text-2xl mb-1"></i>
                    <span class="text-xs font-bold text-gray-700 uppercase">Voir</span>
                </a>

                <a href="{{ route('alertes.pdf', $alerte->id) }}"
                   class="bg-white hover:bg-green-50 p-4 flex flex-col items-center justify-center transition-colors group flex-1">
                    <i class="ph-bold ph-file-pdf text-green-600 text-2xl mb-1"></i>
                    <span class="text-xs font-bold text-gray-700 uppercase">PDF</span>
                </a>

                <a href="{{ route('alertes.edit', $alerte->id) }}"
                   class="bg-white hover:bg-amber-50 p-4 flex flex-col items-center justify-center transition-colors group flex-1">
                    <i class="ph-bold ph-pencil-simple text-amber-600 text-2xl mb-1"></i>
                    <span class="text-xs font-bold text-gray-700 uppercase">Modifier</span>
                </a>

                <button onclick="confirmDelete({{ $alerte->id }}, '{{ addslashes($alerte->site->nom ?? 'cette alerte') }}')"
                        class="bg-white hover:bg-red-50 p-4 flex flex-col items-center justify-center transition-colors group flex-1">
                    <i class="ph-bold ph-trash text-red-600 text-2xl mb-1"></i>
                    <span class="text-xs font-bold text-gray-700 uppercase">Supprimer</span>
                </button>
            </div>
        </div>

        <form action="{{ route('alertes.destroy', $alerte->id) }}" method="POST" id="delete-form-{{ $alerte->id }}" class="hidden">
            @csrf @method('DELETE')
        </form>
    </div>
    @empty
    <div class="glass-card rounded-3xl p-12 text-center">
        <i class="ph-bold ph-warning-octagon text-gray-400 text-8xl mb-4"></i>
        <h3 class="text-2xl font-black text-gray-900 mb-2">Aucun incident enregistré</h3>
        <p class="text-gray-600 font-medium mb-6">Le journal des alertes est vide pour le moment</p>
        <a href="{{ route('alertes.create') }}"
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
            <i class="ph-bold ph-plus-circle mr-2"></i>
            Créer une Alerte
        </a>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if(method_exists($alertes, 'hasPages') && $alertes->hasPages())
<div class="mt-8 flex justify-center">
    {{ $alertes->links() }}
</div>
@endif

@endsection

@push('scripts')
<script>
    function confirmDelete(id, siteName) {
        Swal.fire({
            title: 'Supprimer ce Rapport ?',
            html: '<p class="text-gray-600 font-medium">Voulez-vous vraiment supprimer ce rapport pour <strong>' + siteName + '</strong> ?</p>',
            icon: 'warning',
            iconColor: '#f59e0b',
            showCancelButton: true,
            confirmButtonText: '<i class="ph-bold ph-trash mr-2"></i>Oui, supprimer',
            cancelButtonText: '<i class="ph-bold ph-x mr-2"></i>Annuler',
            background: '#ffffff',
            color: '#111827',
            customClass: {
                popup: 'rounded-3xl shadow-2xl border-2 border-gray-200',
                title: 'text-2xl font-black text-gray-900 pt-6',
                htmlContainer: 'text-gray-600',
                confirmButton: 'px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 mx-2',
                cancelButton: 'px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all mx-2'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'animate__animated animate__fadeInDown animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
