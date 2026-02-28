@extends('layouts.admin')

@section('content_header_title', $search ? 'Historique Complet' : ($type == 'absence' ? 'Absences & Sanctions' : 'Heures Supplémentaires'))
@section('content_header_subtitle', 'Gestion des pointages et calculs de paie')

@section('content')

{{-- Header avec Actions et Recherche --}}
<div class="glass-card rounded-2xl p-6 mb-6">
    <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
        {{-- Titre --}}
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br {{ $type == 'absence' ? 'from-red-500 to-red-600' : 'from-green-500 to-green-600' }} rounded-xl flex items-center justify-center shadow-lg">
                <i class="ph-bold {{ $type == 'absence' ? 'ph-warning-octagon' : 'ph-clock-afternoon' }} text-white text-2xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-gray-900">
                    {{ $search ? 'Historique' : ($type == 'absence' ? 'Sanctions' : 'Suppléments') }}
                </h3>
                <p class="text-sm text-gray-600 font-medium">{{ $pointages->count() }} enregistrement(s)</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 w-full lg:w-auto flex-wrap">
            {{-- Recherche --}}
            <form action="{{ route('pointages.index') }}" method="GET" class="flex-1 lg:flex-initial flex items-center gap-2">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="relative flex-1 lg:flex-initial">
                    <input type="text"
                           name="search"
                           value="{{ $search ?? '' }}"
                           placeholder="Rechercher un agent..."
                           class="w-full lg:w-64 pl-10 pr-10 py-2.5 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-{{ $type == 'absence' ? 'red' : 'green' }}-100 focus:border-{{ $type == 'absence' ? 'red' : 'green' }}-500 transition-all font-medium text-sm">
                    <i class="ph-bold ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    @if($search)
                    <a href="{{ route('pointages.index', ['type' => $type]) }}"
                       class="absolute right-2 top-1/2 -translate-y-1/2 p-1 hover:bg-gray-100 rounded-lg transition-colors"
                       title="Effacer la recherche">
                        <i class="ph-bold ph-x text-gray-500"></i>
                    </a>
                    @endif
                </div>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 text-sm whitespace-nowrap">
                    <i class="ph-bold ph-magnifying-glass mr-2"></i>
                    Rechercher
                </button>
            </form>

            {{-- Bouton Saisir --}}
            <button x-data @click="$dispatch('open-modal')"
                    class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 text-sm">
                <i class="ph-bold ph-plus-circle mr-2"></i>
                Saisir
            </button>

            {{-- Export Excel --}}
            <a href="{{ route('pointages.export', ['type' => $type, 'search' => $search, 'month' => request('month'), 'year' => request('year')]) }}"
               class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 text-sm">
                <i class="ph-bold ph-file-xls mr-2"></i>
                Excel
            </a>

            {{-- Toggle Absence/Supplément --}}
            <div class="inline-flex rounded-xl overflow-hidden shadow-lg border-2 border-gray-200">
                <a href="{{ route('pointages.index', ['type' => 'absence']) }}"
                   class="px-4 py-2.5 font-bold text-sm transition-all {{ $type == 'absence' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    Absences
                </a>
                <a href="{{ route('pointages.index', ['type' => 'supplementaire']) }}"
                   class="px-4 py-2.5 font-bold text-sm transition-all {{ $type == 'supplementaire' ? 'bg-gradient-to-r from-green-500 to-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    Suppléments
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Filtres Mois/Année --}}
<div class="glass-card rounded-2xl p-5 mb-6">
    <form action="{{ route('pointages.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
        <input type="hidden" name="type" value="{{ $type }}">
        <input type="hidden" name="search" value="{{ $search }}">

        {{-- Filtre Mois --}}
        <div class="flex-1">
            <label class="block text-sm font-bold text-gray-700 mb-2">
                <i class="ph-bold ph-calendar-blank text-purple-600 mr-1"></i>
                Mois
            </label>
            <select name="month"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all">
                <option value="">Tous les mois (Vue globale)</option>
                @foreach(range(1, 12) as $m)
                @php $mVal = sprintf('%02d', $m); @endphp
                <option value="{{ $mVal }}" {{ request('month') == $mVal ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Filtre Année --}}
        <div class="flex-1">
            <label class="block text-sm font-bold text-gray-700 mb-2">
                <i class="ph-bold ph-calendar text-indigo-600 mr-1"></i>
                Année
            </label>
            <select name="year"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all">
                <option value="">Toutes les années</option>
                @foreach($years as $y)
                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>

        {{-- Boutons --}}
        <div class="flex items-center gap-2 flex-1 md:flex-initial">
            <button type="submit"
                    class="flex-1 md:flex-initial inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
                <i class="ph-bold ph-funnel mr-2"></i>
                Filtrer
            </button>
            <a href="{{ route('pointages.index', ['type' => $type]) }}"
               class="inline-flex items-center justify-center p-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all"
               title="Réinitialiser">
                <i class="ph-bold ph-arrow-counter-clockwise text-xl"></i>
            </a>
        </div>
    </form>
</div>

{{-- Tableau des Pointages --}}
<div class="glass-card rounded-2xl overflow-hidden shadow-xl">
    {{-- Header du tableau --}}
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4">
        <h4 class="text-lg font-black text-white flex items-center">
            <i class="ph-bold ph-table text-{{ $type == 'absence' ? 'red' : 'green' }}-400 mr-2 text-2xl"></i>
            Détails des Pointages
        </h4>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr class="text-center font-black uppercase">
                    <th class="px-4 py-3 text-left border-r border-gray-200">Agent</th>
                    <th class="px-3 py-3 border-r border-gray-200">Site</th>
                    <th class="px-3 py-3 border-r border-gray-200">Salaire Base</th>
                    <th class="px-3 py-3 border-r border-gray-200">Modification</th>
                    <th class="px-3 py-3 bg-blue-50 border-r border-blue-200 text-blue-700">Net à Payer</th>
                    <th class="px-3 py-3 border-r border-gray-200">Date</th>
                    <th class="px-3 py-3 border-r border-gray-200">{{ $type == 'absence' ? 'Motif' : 'Agent Remplacé' }}</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pointages as $p)
                @php
                // Utiliser le salaire enregistré dans le pointage (historique) ou le salaire actuel de l'agent
                $salaireBase = $p->salaire_base ?? $p->agent->salaire_base ?? 0;

                // Calculer les totaux du mois de ce pointage pour cet agent
                $moisPointage = \Carbon\Carbon::parse($p->date_pointage)->month;
                $anneePointage = \Carbon\Carbon::parse($p->date_pointage)->year;

                $sanctionsMois = $p->agent->pointages()
                    ->where('type', 'absence')
                    ->whereMonth('date_pointage', $moisPointage)
                    ->whereYear('date_pointage', $anneePointage)
                    ->sum('montant');

                $supplementsMois = $p->agent->pointages()
                    ->where('type', 'supplementaire')
                    ->whereMonth('date_pointage', $moisPointage)
                    ->whereYear('date_pointage', $anneePointage)
                    ->sum('montant');

                // Net à payer : Salaire de base - sanctions + suppléments du mois
                $netCalculé = $salaireBase - $sanctionsMois + $supplementsMois;
                @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 font-bold text-gray-900 border-r border-gray-200">
                        {{ $p->agent->nom }} {{ $p->agent->prenom }}
                    </td>
                    <td class="px-3 py-3 text-center border-r border-gray-200">
                        <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">
                            {{ Str::limit($p->site->nom ?? 'N/A', 12) }}
                        </span>
                    </td>
                    <td class="px-3 py-3 text-center font-bold text-gray-600 border-r border-gray-200">
                        {{ number_format($salaireBase, 0, ',', ' ') }} F
                    </td>
                    <td class="px-3 py-3 text-center border-r border-gray-200">
                        <span class="font-black text-{{ $p->type == 'absence' ? 'red' : 'green' }}-600">
                            {{ $p->type == 'absence' ? '- ' : '+ ' }}{{ number_format($p->montant, 0, ',', ' ') }} F
                        </span>
                    </td>
                    <td class="px-3 py-3 text-center font-black text-blue-700 bg-blue-50 border-r border-blue-200">
                        {{ number_format($netCalculé, 0, ',', ' ') }} F
                    </td>
                    <td class="px-3 py-3 text-center text-gray-700 font-medium border-r border-gray-200">
                        {{ \Carbon\Carbon::parse($p->date_pointage)->format('d/m/Y') }}
                    </td>
                    <td class="px-3 py-3 text-gray-600 italic border-r border-gray-200">
                        {{ $p->type == 'absence' ? ($p->motif ?? 'N/A') : ($p->agent_remplace ?? 'N/A') }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('pointages.edit', $p->id) }}"
                               class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors">
                                <i class="ph-bold ph-pencil text-lg"></i>
                            </a>
                            <button type="button"
                                    onclick="confirmDelete({{ $p->id }})"
                                    class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                                <i class="ph-bold ph-trash text-lg"></i>
                            </button>
                            <form action="{{ route('pointages.destroy', $p->id) }}"
                                  method="POST"
                                  id="delete-form-{{ $p->id }}"
                                  class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <i class="ph-bold ph-folder-open text-gray-400 text-6xl mb-4"></i>
                        <p class="text-gray-600 font-medium">Aucun enregistrement trouvé pour cette sélection.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Alpine.js --}}
<div x-data="{ showModal: false, selectedSalaire: 0 }" @open-modal.window="showModal = true">
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
                 class="glass-card rounded-3xl p-8 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-black text-gray-900">
                        <i class="ph-bold ph-{{ $type == 'absence' ? 'warning-octagon' : 'clock-afternoon' }} text-{{ $type == 'absence' ? 'red' : 'green' }}-600 mr-2"></i>
                        Saisie : {{ $type == 'absence' ? 'Sanction' : 'Supplément' }}
                    </h3>
                    <button @click="showModal = false"
                            type="button"
                            class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors">
                        <i class="ph-bold ph-x text-gray-500 text-2xl"></i>
                    </button>
                </div>

                {{-- Form --}}
                <form action="{{ route('pointages.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">

                    {{-- Agent --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-user-circle text-blue-600 mr-1"></i>
                            Sélectionner l'Agent
                        </label>
                        <select name="agent_id"
                                @change="selectedSalaire = $el.options[$el.selectedIndex].dataset.salaire"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all"
                                required>
                            <option value="">-- Choisir un agent --</option>
                            @foreach(\App\Models\Agent::orderBy('nom')->get() as $agent)
                            <option value="{{ $agent->id }}" data-salaire="{{ $agent->salaire_base ?? 0 }}">
                                {{ $agent->nom }} {{ $agent->prenom }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Salaire Base --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-currency-circle-dollar text-purple-600 mr-1"></i>
                            Salaire de Base (F CFA)
                        </label>
                        <input type="number"
                               name="salaire_base"
                               x-model="selectedSalaire"
                               placeholder="Saisir le salaire de base"
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-purple-700 placeholder-gray-400 font-black focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all"
                               required>
                    </div>

                    {{-- Date & Montant --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">
                                <i class="ph-bold ph-calendar text-indigo-600 mr-1"></i>
                                Date du Pointage
                            </label>
                            <input type="date"
                                   name="date_pointage"
                                   value="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all"
                                   required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">
                                <i class="ph-bold ph-money text-{{ $type == 'absence' ? 'red' : 'green' }}-600 mr-1"></i>
                                Montant (F CFA)
                            </label>
                            <input type="number"
                                   name="montant"
                                   value="{{ $type == 'absence' ? '' : 5000 }}"
                                   class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-{{ $type == 'absence' ? 'red' : 'green' }}-100 focus:border-{{ $type == 'absence' ? 'red' : 'green' }}-500 transition-all"
                                   required>
                        </div>
                    </div>

                    {{-- Motif ou Agent Remplacé --}}
                    @if($type == 'absence')
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-note-pencil text-amber-600 mr-1"></i>
                            Motif de l'absence
                        </label>
                        <input type="text"
                               name="motif"
                               placeholder="Ex: Retard, Abandon de poste..."
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 font-medium focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all">
                    </div>
                    @else
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-arrows-left-right text-emerald-600 mr-1"></i>
                            Agent Remplacé
                        </label>
                        <select name="agent_remplace"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all">
                            <option value="">-- Aucun agent remplacé --</option>
                            @foreach(\App\Models\Agent::orderBy('nom')->orderBy('prenom')->get() as $agent)
                            <option value="{{ $agent->nom }} {{ $agent->prenom }}">{{ $agent->nom }} {{ $agent->prenom }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex items-center justify-between pt-6 border-t-2 border-gray-200">
                        <button type="button"
                                @click="showModal = false"
                                class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all">
                            <i class="ph-bold ph-x mr-2"></i>
                            Annuler
                        </button>
                        <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-{{ $type == 'absence' ? 'red' : 'green' }}-500 to-{{ $type == 'absence' ? 'red' : 'green' }}-600 hover:from-{{ $type == 'absence' ? 'red' : 'green' }}-600 hover:to-{{ $type == 'absence' ? 'red' : 'green' }}-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105">
                            <i class="ph-bold ph-floppy-disk mr-2"></i>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Supprimer ce Pointage ?',
            html: '<p class="text-gray-600 font-medium">Cette action est irréversible. Le pointage sera définitivement supprimé.</p>',
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
