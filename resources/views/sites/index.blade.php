@extends('layouts.admin')

@section('content_header_title', 'Gestion des Sites')
@section('content_header_subtitle', 'Liste complète des sites et banques')

@section('content')

{{-- Header avec Recherche --}}
<div class="glass-card rounded-2xl p-6 mb-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <h3 class="text-2xl font-black text-gray-900">
            <i class="ph-bold ph-buildings text-cyan-600 mr-2"></i>
            Sites & Banques
        </h3>

        <div class="flex items-center gap-3 w-full md:w-auto">
            {{-- Barre de Recherche --}}
            <form action="{{ route('sites.index') }}" method="GET" class="flex-1 md:flex-initial">
                <div class="relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Rechercher un site..."
                           class="w-full md:w-80 pl-12 pr-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-cyan-100 focus:border-cyan-500 transition-all font-medium">
                    <i class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
                    <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-bold text-sm rounded-lg transition-all">
                        Rechercher
                    </button>
                </div>
            </form>

            {{-- Bouton Ajouter --}}
            <a href="{{ route('sites.create') }}"
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 whitespace-nowrap">
                <i class="ph-bold ph-plus-circle mr-2 text-xl"></i>
                Nouveau Site
            </a>
        </div>
    </div>
</div>

{{-- Grille des Sites --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($sites as $site)
    <div class="glass-card rounded-2xl overflow-hidden hover:shadow-2xl hover:scale-105 transition-all duration-300">
        {{-- Header Card --}}
        <div class="bg-gradient-to-br from-cyan-600 to-blue-700 p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <i class="ph-bold ph-bank text-white text-4xl"></i>
                </div>
                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full uppercase border border-white/30">
                    {{ $site->secteur ?? 'N/A' }}
                </span>
            </div>

            <h5 class="text-xl font-black text-white mb-2">{{ $site->nom }}</h5>
            <p class="text-cyan-100 text-sm font-medium flex items-center">
                <i class="ph-bold ph-map-pin mr-2"></i>
                {{ Str::limit($site->adresse ?? 'Adresse non spécifiée', 40) }}
            </p>
        </div>

        {{-- Stats Card --}}
        <div class="p-6 bg-white">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="text-center p-3 bg-blue-50 rounded-xl border-2 border-blue-200">
                    <div class="text-3xl font-black text-blue-600 mb-1">{{ $site->agents->count() }}</div>
                    <div class="text-xs font-bold text-gray-600 uppercase tracking-wide">Agents</div>
                </div>
                <div class="text-center p-3 bg-purple-50 rounded-xl border-2 border-purple-200">
                    <div class="text-3xl font-black text-purple-600 mb-1">
                        @if($site->secteur == 'Secteur 1 (Ville)')
                            1
                        @elseif($site->secteur == 'Secteur 2 (Banlieu)')
                            2
                        @elseif($site->secteur == 'Secteur 3 (Region)')
                            3
                        @else
                            -
                        @endif
                    </div>
                    <div class="text-xs font-bold text-gray-600 uppercase tracking-wide">Secteur</div>
                </div>
            </div>

            @if($site->telephone)
            <div class="flex items-center text-gray-700 mb-3 p-2 bg-emerald-50 rounded-lg">
                <i class="ph-bold ph-phone text-emerald-600 mr-3 text-lg"></i>
                <span class="text-sm font-medium">{{ $site->telephone }}</span>
            </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="grid grid-cols-3 gap-px bg-gray-200">
            <a href="{{ route('sites.edit', $site->id) }}"
               class="bg-white hover:bg-blue-50 p-3 flex flex-col items-center justify-center transition-colors group">
                <i class="ph-bold ph-pencil-simple text-blue-600 text-xl mb-1"></i>
                <span class="text-xs font-bold text-gray-700 uppercase">Modifier</span>
            </a>

            <a href="{{ route('plannings.site', ['secteur' => $site->secteur]) }}"
               class="bg-white hover:bg-purple-50 p-3 flex flex-col items-center justify-center transition-colors group">
                <i class="ph-bold ph-calendar-check text-purple-600 text-xl mb-1"></i>
                <span class="text-xs font-bold text-gray-700 uppercase">Planning</span>
            </a>

            <button onclick="confirmDelete({{ $site->id }})"
                    class="bg-white hover:bg-red-50 p-3 flex flex-col items-center justify-center transition-colors group">
                <i class="ph-bold ph-trash text-red-600 text-xl mb-1"></i>
                <span class="text-xs font-bold text-gray-700 uppercase">Supprimer</span>
            </button>
        </div>

        <form action="{{ route('sites.destroy', $site->id) }}" method="POST" id="delete-form-{{ $site->id }}" class="hidden">
            @csrf @method('DELETE')
        </form>
    </div>
    @empty
    <div class="col-span-full glass-card rounded-3xl p-12 text-center">
        <i class="ph-bold ph-buildings text-gray-400 text-8xl mb-4"></i>
        <h3 class="text-2xl font-black text-gray-900 mb-2">Aucun site trouvé</h3>
        <p class="text-gray-600 font-medium mb-6">Commencez par ajouter votre premier site de surveillance</p>
        <a href="{{ route('sites.create') }}"
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
            <i class="ph-bold ph-plus-circle mr-2"></i>
            Ajouter un Site
        </a>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if(method_exists($sites, 'hasPages') && $sites->hasPages())
<div class="mt-8 flex justify-center">
    {{ $sites->links() }}
</div>
@endif

@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Supprimer ce Site ?',
            html: '<p class="text-gray-600 font-medium">Cette action est irréversible. Tous les agents affectés seront désaffectés.</p>',
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
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
@endpush
