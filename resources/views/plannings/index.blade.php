@extends('layouts.admin')

@section('content_header_title', 'Plannings Hebdomadaires')
@section('content_header_subtitle', 'Gestion des factions par secteur')

@section('content')

{{-- Header avec Recherche --}}
<div class="glass-card rounded-2xl p-6 mb-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <h3 class="text-2xl font-black text-gray-900">
            <i class="ph-bold ph-calendar-blank text-purple-600 mr-2"></i>
            {{ $nomSecteur ?? 'Planning Global' }}
        </h3>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <form action="{{ route('plannings.index') }}" method="GET" class="flex-1 md:flex-initial">
                <div class="relative">
                    <input type="text"
                           name="search"
                           value="{{ $search ?? '' }}"
                           placeholder="Trouver un site ou un agent..."
                           class="w-full md:w-80 pl-12 pr-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all font-medium">
                    <i class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
                    <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold text-sm rounded-lg transition-all">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Liste des Sites --}}
<div class="space-y-4">
    @forelse($sites as $site)
    <div x-data="{
        open: {{ (isset($nomSecteur) || isset($search)) ? 'true' : 'false' }},
        showRPEModal: false
    }" class="glass-card rounded-2xl overflow-hidden">

        {{-- Header du Site (cliquable) --}}
        <div @click="open = !open"
             class="p-4 bg-gradient-to-r from-purple-50 to-indigo-50 hover:from-purple-100 hover:to-indigo-100 cursor-pointer transition-all flex items-center justify-between">
            <div class="flex items-center gap-4 flex-1">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="ph-bold ph-bank text-white text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h5 class="text-xl font-black text-gray-900">{{ $site->nom }}</h5>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-sm font-bold text-purple-600">
                            <i class="ph-bold ph-map-pin mr-1"></i>{{ $site->secteur }}
                        </span>
                        @if($site->telephone)
                        <button @click.stop="showRPEModal = true"
                                class="px-3 py-1 bg-amber-100 hover:bg-amber-200 border-2 border-amber-300 rounded-full text-xs font-bold text-amber-700 transition-all">
                            <i class="ph-bold ph-phone-call mr-1"></i>RPE: {{ $site->telephone }}
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-gray-900 text-white text-sm font-bold rounded-full">
                    {{ $site->agents->count() }} Agents
                </span>
                <i class="ph-bold ph-caret-down text-gray-600 text-xl transition-transform duration-300"
                   :class="{ 'rotate-180': open }"></i>
            </div>
        </div>

        {{-- Modal RPE (Alpine.js) --}}
        <template x-teleport="body">
            <div x-show="showRPEModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showRPEModal = false"
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                <div @click.stop
                     x-show="showRPEModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="glass-card rounded-3xl p-8 max-w-md w-full mx-4">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="ph-bold ph-phone-call text-white text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-2">Contact RPE</h3>
                        <p class="text-gray-600 font-medium mb-4">{{ $site->nom }}</p>
                        <div class="text-4xl font-black text-purple-600">{{ $site->telephone ?? 'Non renseigné' }}</div>
                        <button @click="showRPEModal = false"
                                class="mt-6 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition-all">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </template>

        {{-- Zone de contenu (Agents avec plannings) --}}
        <div x-show="open"
             x-collapse
             class="bg-gray-50 p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($site->agents as $agent)
                <div class="glass-card rounded-xl p-4 hover:shadow-lg transition-all">
                    {{-- Header Agent --}}
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-2 flex-1">
                            <i class="ph-bold ph-user-circle text-purple-600 text-3xl"></i>
                            <div>
                                <h6 class="font-black text-gray-900 text-sm">{{ $agent->nom }} {{ $agent->prenom }}</h6>
                                <p class="text-xs font-medium text-gray-600">
                                    <i class="ph-bold ph-phone mr-1"></i>{{ $agent->telephone ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-1">
                            <a href="{{ route('plannings.create', $agent->id) }}"
                               class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors"
                               title="Créer/Modifier planning">
                                <i class="ph-bold ph-calendar-plus text-lg"></i>
                            </a>
                            @if($agent->planning)
                            <button type="button"
                                    onclick="confirmDelete({{ $agent->planning->id }})"
                                    class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors"
                                    title="Supprimer planning">
                                <i class="ph-bold ph-trash text-lg"></i>
                            </button>
                            <form action="{{ route('plannings.destroy', $agent->planning->id) }}"
                                  method="POST"
                                  id="delete-form-{{ $agent->planning->id }}"
                                  class="hidden">
                                @csrf @method('DELETE')
                            </form>
                            @endif
                        </div>
                    </div>

                    {{-- Planning Hebdomadaire --}}
                    @if($agent->planning)
                    <div class="space-y-2">
                        @foreach(['lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche'] as $index => $j)
                        @php
                            $h = "h_$j";
                            $jours_complets = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                        @endphp
                        <div class="flex items-center gap-3 p-3 rounded-lg {{ $agent->planning->$j == 'F' ? 'bg-blue-50 border-2 border-blue-200' : 'bg-gray-50 border-2 border-gray-200' }} transition-all hover:shadow-md">
                            {{-- Jour --}}
                            <div class="w-28 flex-shrink-0">
                                <span class="text-sm font-black text-gray-900">{{ $jours_complets[$index] }}</span>
                            </div>

                            {{-- Badge Statut --}}
                            @if($agent->planning->$j == 'F')
                            <div class="flex items-center gap-3 flex-1">
                                <span class="inline-flex items-center px-4 py-1.5 bg-blue-600 text-white rounded-full text-xs font-black shadow-sm">
                                    <i class="ph-bold ph-clock mr-1.5"></i> FACTION
                                </span>
                                <span class="text-sm font-bold text-blue-600">{{ $agent->planning->$h }}</span>
                            </div>
                            @else
                            <div class="flex items-center gap-3 flex-1">
                                <span class="inline-flex items-center px-4 py-1.5 bg-gray-400 text-white rounded-full text-xs font-black shadow-sm">
                                    <i class="ph-bold ph-moon mr-1.5"></i> REPOS
                                </span>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <a href="{{ route('plannings.create', $agent->id) }}"
                           class="inline-flex items-center text-sm font-bold text-purple-600 hover:text-purple-700 transition-colors">
                            <i class="ph-bold ph-plus-circle mr-2"></i>
                            Générer un planning
                        </a>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @empty
    <div class="glass-card rounded-3xl p-12 text-center">
        <i class="ph-bold ph-calendar-x text-gray-400 text-8xl mb-4"></i>
        <h3 class="text-2xl font-black text-gray-900 mb-2">Aucun site trouvé</h3>
        <p class="text-gray-600 font-medium">Modifiez votre recherche ou créez un nouveau site</p>
    </div>
    @endforelse
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Supprimer le Planning ?',
            html: '<p class="text-gray-600 font-medium">Cette action est irréversible. Le planning sera définitivement supprimé.</p>',
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
