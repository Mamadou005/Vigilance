@extends('layouts.admin')

@section('content_header_title', 'Gestion des Agents')
@section('content_header_subtitle', 'Liste complète des agents de sécurité')

@section('content')

{{-- Header avec Recherche --}}
<div class="glass-card rounded-2xl p-6 mb-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <h3 class="text-2xl font-black text-gray-900">
            <i class="ph-bold ph-users-three text-blue-600 mr-2"></i>
            Liste des Agents
        </h3>

        <div class="flex items-center gap-3 w-full md:w-auto">
            {{-- Barre de Recherche --}}
            <form action="{{ route('agents.index') }}" method="GET" class="flex-1 md:flex-initial">
                <div class="relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Rechercher un agent..."
                           class="w-full md:w-80 pl-12 pr-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium">
                    <i class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
                    <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-lg transition-all">
                        Rechercher
                    </button>
                </div>
            </form>

            {{-- Bouton Ajouter --}}
            <a href="{{ route('agents.create') }}"
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 whitespace-nowrap">
                <i class="ph-bold ph-plus-circle mr-2 text-xl"></i>
                Nouvel Agent
            </a>
        </div>
    </div>
</div>

{{-- Grille des Agents --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($agents as $agent)
    <div class="glass-card rounded-2xl overflow-hidden hover:shadow-2xl hover:scale-105 transition-all duration-300"
         x-data="{ showModal: false }">
        {{-- Header Card --}}
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <i class="ph-bold ph-user-circle text-blue-600 text-4xl"></i>
                </div>
                <div class="flex items-center space-x-2">
                    @if($agent->statut == 'Présent')
                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse shadow-lg shadow-emerald-500/50"></div>
                        <span class="text-xs font-bold text-emerald-400 uppercase">Présent</span>
                    @else
                        <div class="w-3 h-3 bg-red-500 rounded-full shadow-lg shadow-red-500/50"></div>
                        <span class="text-xs font-bold text-red-400 uppercase">{{ $agent->statut }}</span>
                    @endif
                </div>
            </div>

            <h5 class="text-xl font-black text-white mb-1">{{ $agent->nom }} {{ $agent->prenom }}</h5>
            <p class="text-gray-400 text-sm font-medium flex items-center">
                <i class="ph-bold ph-fingerprint mr-2"></i>
                Matricule: {{ $agent->matricule ?? 'N/A' }}
            </p>
        </div>

        {{-- Info Card --}}
        <div class="p-4 bg-white space-y-2">
            <div class="flex items-center text-gray-700">
                <i class="ph-bold ph-bank text-purple-600 mr-3 text-lg"></i>
                <span class="text-sm font-medium">{{ $agent->site->nom ?? 'Non affecté' }}</span>
            </div>
            <div class="flex items-center text-gray-700">
                <i class="ph-bold ph-phone text-emerald-600 mr-3 text-lg"></i>
                <span class="text-sm font-medium">{{ $agent->telephone ?? 'N/A' }}</span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="grid grid-cols-3 gap-px bg-gray-200">
            <a href="{{ route('agents.edit', $agent->id) }}"
               class="bg-white hover:bg-blue-50 p-3 flex flex-col items-center justify-center transition-colors group">
                <i class="ph-bold ph-pencil-simple text-blue-600 text-xl mb-1"></i>
                <span class="text-xs font-bold text-gray-700 uppercase">Modifier</span>
            </a>

            <button @click="showModal = true"
                    class="bg-white hover:bg-cyan-50 p-3 flex flex-col items-center justify-center transition-colors group">
                <i class="ph-bold ph-fingerprint text-cyan-600 text-xl mb-1"></i>
                <span class="text-xs font-bold text-gray-700 uppercase">Pointer</span>
            </button>

            <button onclick="confirmDelete({{ $agent->id }})"
                    class="bg-white hover:bg-red-50 p-3 flex flex-col items-center justify-center transition-colors group">
                <i class="ph-bold ph-trash text-red-600 text-xl mb-1"></i>
                <span class="text-xs font-bold text-gray-700 uppercase">Supprimer</span>
            </button>
        </div>

        <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" id="delete-form-{{ $agent->id }}" class="hidden">
            @csrf @method('DELETE')
        </form>

        {{-- Modal Pointage avec Alpine.js --}}
        <template x-teleport="body">
            <div x-show="showModal"
                 x-cloak
                 class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
                 style="display: none;"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">

                {{-- Backdrop --}}
                <div @click="showModal = false"
                     class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

                {{-- Modal Content --}}
                <div @click.stop
                     class="relative glass-card rounded-3xl max-w-md w-full p-8 shadow-2xl"
                     style="max-height: 90vh; overflow-y: auto;"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95">

                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-black text-gray-900">
                            <i class="ph-bold ph-fingerprint text-cyan-600 mr-2"></i>
                            Pointage Agent
                        </h3>
                        <button @click="showModal = false"
                                type="button"
                                class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors">
                            <i class="ph-bold ph-x text-gray-500 text-2xl"></i>
                        </button>
                    </div>

                    {{-- Info Agent --}}
                    <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200">
                        <p class="text-sm font-black text-gray-900 flex items-center">
                            <i class="ph-bold ph-user-circle text-blue-600 mr-2 text-lg"></i>
                            {{ $agent->nom }} {{ $agent->prenom }}
                        </p>
                        <p class="text-xs text-gray-600 mt-2 flex items-center">
                            <i class="ph-bold ph-bank text-purple-600 mr-2"></i>
                            {{ $agent->site->nom ?? 'Non affecté' }}
                        </p>
                    </div>

                    @if(!$agent->site_id)
                    <div class="mb-4 p-4 bg-amber-50 rounded-xl border-2 border-amber-200">
                        <p class="text-sm font-bold text-amber-800 flex items-center">
                            <i class="ph-bold ph-warning text-amber-600 mr-2 text-lg"></i>
                            Attention : Agent sans site affecté
                        </p>
                        <p class="text-xs text-amber-700 mt-1">
                            Veuillez d'abord affecter un site à cet agent avant de faire un pointage.
                        </p>
                    </div>
                    @endif

                    {{-- Formulaire --}}
                    <form action="{{ route('pointages.store') }}" method="POST" class="space-y-5" x-data="{ typePointage: 'absence' }">
                        @csrf
                        <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                        @if($agent->site_id)
                            <input type="hidden" name="site_id" value="{{ $agent->site_id }}">
                        @endif
                        <input type="hidden" name="date_pointage" value="{{ date('Y-m-d') }}">

                        {{-- Type de pointage --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">
                                <i class="ph-bold ph-list-bullets text-blue-600 mr-1"></i>
                                Nature du Pointage
                            </label>
                            <select name="type"
                                    x-model="typePointage"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium">
                                <option value="absence">🚫 Absence / Sanction</option>
                                <option value="supplementaire">⏰ Heures Supplémentaires</option>
                            </select>
                        </div>

                        {{-- Champs pour Absence --}}
                        <div x-show="typePointage === 'absence'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="space-y-4">

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">
                                        <i class="ph-bold ph-money text-red-600 mr-1"></i>
                                        Montant (F CFA)
                                    </label>
                                    <input type="number"
                                           name="montant"
                                           class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all font-medium"
                                           placeholder="5000">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">
                                        <i class="ph-bold ph-calendar-x text-red-600 mr-1"></i>
                                        Nb de Jours
                                    </label>
                                    <input type="number"
                                           name="nb_jours"
                                           value="1"
                                           class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all font-medium">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">
                                    <i class="ph-bold ph-warning-circle text-amber-600 mr-1"></i>
                                    Motif de l'absence
                                </label>
                                <input type="text"
                                       name="motif"
                                       class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all font-medium"
                                       placeholder="Ex: URGENCE, NON JUSTIFIÉ...">
                            </div>
                        </div>

                        {{-- Champs pour Heures Supplémentaires --}}
                        <div x-show="typePointage === 'supplementaire'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0">
                            <label class="block text-sm font-bold text-gray-900 mb-2">
                                <i class="ph-bold ph-user-switch text-emerald-600 mr-1"></i>
                                Agent Remplacé
                            </label>
                            <select name="agent_remplace"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all font-medium">
                                <option value="">-- Aucun agent remplacé --</option>
                                @foreach($agents as $a)
                                <option value="{{ $a->nom }} {{ $a->prenom }}">{{ $a->nom }} {{ $a->prenom }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Bouton Submit --}}
                        <div class="pt-4">
                            @if($agent->site_id)
                                <button type="submit"
                                        class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-lg rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105">
                                    <i class="ph-bold ph-check-circle mr-2 text-xl"></i>
                                    Valider le Pointage
                                </button>
                            @else
                                <a href="{{ route('agents.edit', $agent->id) }}"
                                   class="w-full px-6 py-4 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold text-lg rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105 inline-flex items-center justify-center">
                                    <i class="ph-bold ph-pencil mr-2 text-xl"></i>
                                    Affecter un Site
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
    @empty
    <div class="col-span-full glass-card rounded-3xl p-12 text-center">
        <i class="ph-bold ph-users-slash text-gray-400 text-8xl mb-4"></i>
        <h3 class="text-2xl font-black text-gray-900 mb-2">Aucun agent trouvé</h3>
        <p class="text-gray-600 font-medium mb-6">Commencez par ajouter votre premier agent</p>
        <a href="{{ route('agents.create') }}"
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
            <i class="ph-bold ph-plus-circle mr-2"></i>
            Ajouter un Agent
        </a>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if(method_exists($agents, 'hasPages') && $agents->hasPages())
<div class="mt-8 flex justify-center">
    {{ $agents->links() }}
</div>
@endif

@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Supprimer cet Agent ?',
            html: '<p class="text-gray-600 font-medium">Cette action est irréversible. Toutes les données seront perdues.</p>',
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
