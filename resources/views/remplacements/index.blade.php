@extends('layouts.admin')

@section('content_header_title', 'Suivi et Relevés')
@section('content_header_subtitle', 'Gestion des remplacements par catégorie')

@section('content')

@php
$categories = [
    'Postes Vides' => ['icon' => 'ph-layout', 'color' => 'red'],
    'Permissions' => ['icon' => 'ph-hand-palm', 'color' => 'blue'],
    'Repos Medical' => ['icon' => 'ph-first-aid', 'color' => 'amber'],
    'Mise a Pied' => ['icon' => 'ph-warning-octagon', 'color' => 'gray'],
    'Certificat de deces' => ['icon' => 'ph-users-three', 'color' => 'purple'],
    'ADS a Depointer' => ['icon' => 'ph-user-minus', 'color' => 'indigo'],
    'Permutation entre agents' => ['icon' => 'ph-arrows-left-right', 'color' => 'green']
];
$currentCat = request('categorie', 'Postes Vides');
@endphp

{{-- Navigation par Catégories --}}
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 mb-6">
    @foreach($categories as $name => $style)
    <a href="{{ route('remplacements.index', ['categorie' => $name]) }}"
       class="glass-card rounded-xl p-4 flex flex-col items-center justify-center h-24 transition-all hover:scale-105 hover:shadow-lg {{ $currentCat == $name ? 'ring-4 ring-'.$style['color'].'-500 bg-'.$style['color'].'-50' : '' }}">
        <i class="ph-bold {{ $style['icon'] }} text-{{ $style['color'] }}-600 text-3xl mb-2"></i>
        <span class="text-[10px] font-black text-gray-900 text-center uppercase leading-tight">{{ $name }}</span>
    </a>
    @endforeach
</div>

{{-- Conteneur global avec Alpine.js --}}
<div x-data="{ showModal: false, searchAgent: '', searchRemplacant: '', selectedAgent: '', selectedRemplacant: '' }">
    {{-- Bouton Saisir Relève --}}
    <div class="flex justify-end mb-6">
        <button @click="showModal = true"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
            <i class="ph-bold ph-keyboard mr-2 text-xl"></i>
            Saisir Relève
        </button>
    </div>

    {{-- Tableau des Remplacements --}}
    <div class="glass-card rounded-2xl overflow-hidden">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="ph-bold ph-table text-amber-500 text-2xl"></i>
            <h3 class="text-lg font-black text-white uppercase">Suivi et Relevé des Agents ({{ $currentCat }})</h3>
        </div>
        <span class="px-4 py-2 bg-red-600 text-white text-sm font-black rounded-full">{{ $remplacements->count() }} Lignes</span>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-xs">
            <thead class="bg-gray-100 text-gray-700">
                <tr class="text-center font-black uppercase">
                    <th class="px-3 py-3 border-r border-gray-200">Statut</th>
                    <th class="px-3 py-3 border-r border-gray-200">Agent Remplacé</th>
                    <th class="px-3 py-3 border-r border-gray-200">Poste (Site)</th>
                    <th class="px-3 py-3 border-r border-gray-200">Motif (Raison)</th>
                    <th class="px-3 py-3 border-r border-gray-200">Remplaçant</th>
                    <th class="px-3 py-3 border-r border-gray-200">Site Affectation</th>
                    <th class="px-3 py-3 border-r border-gray-200">N° Wave</th>
                    <th class="px-3 py-3 border-r border-gray-200">Date Début</th>
                    <th class="px-3 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($remplacements as $r)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-3 py-3 text-center border-r border-gray-200">
                        @if($r->agent_remplacant_nom)
                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                            <i class="ph-bold ph-check-circle mr-1"></i>Fait
                        </span>
                        @else
                        <span class="inline-flex items-center px-2 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">
                            <i class="ph-bold ph-clock mr-1"></i>En attente
                        </span>
                        @endif
                    </td>
                    <td class="px-3 py-3 font-bold text-red-600 border-r border-gray-200">{{ $r->agent_remplace_nom }}</td>
                    <td class="px-3 py-3 font-bold text-blue-600 border-r border-gray-200">{{ $r->poste_nom }}</td>
                    <td class="px-3 py-3 text-gray-600 italic border-r border-gray-200">{{ Str::limit($r->motif, 50) }}</td>
                    <td class="px-3 py-3 font-bold {{ !$r->agent_remplacant_nom ? 'text-gray-400 italic' : 'text-gray-900' }} border-r border-gray-200">
                        {{ $r->agent_remplacant_nom ?? 'À trouver...' }}
                    </td>
                    <td class="px-3 py-3 text-gray-700 border-r border-gray-200">{{ $r->site_affectation ?? '---' }}</td>
                    <td class="px-3 py-3 text-center font-bold text-gray-900 border-r border-gray-200">{{ $r->n_wave ?? '---' }}</td>
                    <td class="px-3 py-3 text-center text-gray-700">{{ \Carbon\Carbon::parse($r->date_debut)->format('d/m/Y') }}</td>
                    <td class="px-3 py-3">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('remplacements.edit', $r->id) }}"
                               class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors">
                                <i class="ph-bold ph-pencil text-lg"></i>
                            </a>
                            <button type="button"
                                    onclick="confirmDelete({{ $r->id }})"
                                    class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                                <i class="ph-bold ph-trash text-lg"></i>
                            </button>
                            <form action="{{ route('remplacements.destroy', $r->id) }}" method="POST" id="delete-form-{{ $r->id }}" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center">
                        <i class="ph-bold ph-folder-open text-gray-400 text-6xl mb-4"></i>
                        <p class="text-gray-600 font-medium">Aucun enregistrement trouvé.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Saisie (Alpine.js) --}}
    <template x-teleport="body">
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showModal = false"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.stop
                 x-show="showModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="glass-card rounded-3xl p-8 max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto">

                {{-- Header --}}
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="ph-bold ph-keyboard text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900">Saisie d'une Relève Agent</h3>
                    <p class="text-gray-600 font-medium">Catégorie : {{ $currentCat }}</p>
                </div>

                {{-- Form --}}
                <form action="{{ route('remplacements.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="categorie" value="{{ $currentCat }}">

                    {{-- Agent Remplacé & Poste --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="agent_remplace_nom" class="block text-sm font-bold text-gray-900 mb-2">
                                <i class="ph-bold ph-user-minus mr-1 text-red-600"></i>
                                Agent Remplacé (Obligatoire)
                            </label>
                            <select id="agent_remplace_nom"
                                    name="agent_remplace_nom"
                                    required
                                    x-model="selectedAgent"
                                    @change="$nextTick(() => { const option = $el.options[$el.selectedIndex]; if(option.dataset.site) document.getElementById('poste_nom').value = option.dataset.site; })"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all font-medium">
                                <option value="">-- Sélectionner un agent --</option>
                                @foreach($agents as $agent)
                                <option value="{{ $agent->nom }} {{ $agent->prenom }}" data-site="{{ $agent->site->nom ?? '' }}">
                                    {{ $agent->nom }} {{ $agent->prenom }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="poste_nom" class="block text-sm font-bold text-gray-900 mb-2">
                                <i class="ph-bold ph-bank mr-1 text-blue-600"></i>
                                Poste / Site (Obligatoire)
                            </label>
                            <select id="poste_nom"
                                    name="poste_nom"
                                    required
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium">
                                <option value="">-- Sélectionner un site --</option>
                                @foreach($sites as $site)
                                <option value="{{ $site->nom }}">{{ $site->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Motif --}}
                    <div>
                        <label for="motif" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-note-pencil mr-1 text-amber-600"></i>
                            Motif (Obligatoire)
                        </label>
                        <textarea id="motif"
                                  name="motif"
                                  rows="3"
                                  required
                                  class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all font-medium resize-none"
                                  placeholder="Ex: Permission exceptionnelle..."></textarea>
                    </div>

                    <div class="border-t-2 border-gray-200 pt-6">
                        <p class="text-sm font-black text-purple-600 uppercase mb-4">
                            <i class="ph-bold ph-info mr-1"></i>
                            Informations de la Relève (Optionnel)
                        </p>

                        {{-- Agent Remplaçant & Site Affectation --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="agent_remplacant_nom" class="block text-sm font-bold text-gray-900 mb-2">
                                    <i class="ph-bold ph-user-plus mr-1 text-green-600"></i>
                                    Agent Remplaçant
                                </label>
                                <select id="agent_remplacant_nom"
                                        name="agent_remplacant_nom"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all font-medium">
                                    <option value="">À trouver plus tard...</option>
                                    @foreach($agents as $agent)
                                    <option value="{{ $agent->nom }} {{ $agent->prenom }}">{{ $agent->nom }} {{ $agent->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="site_affectation" class="block text-sm font-bold text-gray-900 mb-2">
                                    <i class="ph-bold ph-map-pin mr-1 text-indigo-600"></i>
                                    Site d'Affectation
                                </label>
                                <select id="site_affectation"
                                        name="site_affectation"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all font-medium">
                                    <option value="">Même site</option>
                                    @foreach($sites as $site)
                                    <option value="{{ $site->nom }}">{{ $site->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- N° Wave & Date --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="n_wave" class="block text-sm font-bold text-gray-900 mb-2">
                                    <i class="ph-bold ph-phone mr-1 text-cyan-600"></i>
                                    Numéro Wave
                                </label>
                                <input type="text"
                                       id="n_wave"
                                       name="n_wave"
                                       class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-cyan-100 focus:border-cyan-500 transition-all font-medium"
                                       placeholder="00 00 00 00">
                            </div>

                            <div>
                                <label for="date_debut" class="block text-sm font-bold text-gray-900 mb-2">
                                    <i class="ph-bold ph-calendar mr-1 text-purple-600"></i>
                                    Date de Début
                                </label>
                                <input type="date"
                                       id="date_debut"
                                       name="date_debut"
                                       value="{{ date('Y-m-d') }}"
                                       required
                                       class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all font-medium">
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-between pt-6 border-t-2 border-gray-200">
                        <button type="button"
                                @click="showModal = false"
                                class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all">
                            <i class="ph-bold ph-x mr-2"></i>
                            Annuler
                        </button>
                        <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105">
                            <i class="ph-bold ph-floppy-disk mr-2"></i>
                            Enregistrer dans {{ $currentCat }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
    </div>
</div>
{{-- Fin du conteneur Alpine.js --}}

@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Supprimer cette ligne ?',
            html: '<p class="text-gray-600 font-medium">Cette action est irréversible !</p>',
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
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
