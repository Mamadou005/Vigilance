@extends('layouts.admin')

@section('content_header_title', 'Modifier Pointage')
@section('content_header_subtitle', 'Mise à jour des informations du pointage')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass-card rounded-3xl p-8 lg:p-10" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                    <i class="ph-bold ph-pencil-circle text-white text-4xl"></i>
                </div>
                <h2 class="text-3xl font-black text-gray-900 mb-2">Modifier le Pointage</h2>
                <p class="text-gray-600 font-medium">Mise à jour des informations</p>
            </div>

            <!-- Form -->
            <form action="{{ route('pointages.update', $pointage->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Agent (readonly) -->
                <div>
                    <label for="agent_nom" class="block text-sm font-bold text-gray-900 mb-2">
                        <i class="ph-bold ph-user-circle mr-1 text-blue-600"></i>
                        Agent
                    </label>
                    <input type="text"
                           id="agent_nom"
                           value="{{ $pointage->agent->nom }} {{ $pointage->agent->prenom }}"
                           readonly
                           class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-xl text-gray-600 font-medium cursor-not-allowed">
                </div>

                <!-- Date & Montant -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_pointage" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-calendar mr-1 text-purple-600"></i>
                            Date du Pointage
                        </label>
                        <input type="date"
                               id="date_pointage"
                               name="date_pointage"
                               value="{{ \Carbon\Carbon::parse($pointage->date_pointage)->format('Y-m-d') }}"
                               required
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all font-medium">
                        @error('date_pointage')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="montant" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-currency-circle-dollar mr-1 text-green-600"></i>
                            Montant (F CFA)
                        </label>
                        <input type="number"
                               id="montant"
                               name="montant"
                               value="{{ old('montant', $pointage->montant) }}"
                               required
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all font-medium">
                        @error('montant')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Motif ou Agent Remplacé -->
                @if($pointage->type == 'absence')
                <div>
                    <label for="motif" class="block text-sm font-bold text-gray-900 mb-2">
                        <i class="ph-bold ph-warning-octagon mr-1 text-red-600"></i>
                        Motif / Sanction
                    </label>
                    <input type="text"
                           id="motif"
                           name="motif"
                           value="{{ old('motif', $pointage->motif) }}"
                           class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all font-medium"
                           placeholder="Ex: Absence injustifiée, Retard">
                    @error('motif')
                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                            <i class="ph-bold ph-warning-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                @else
                <div>
                    <label for="agent_remplace" class="block text-sm font-bold text-gray-900 mb-2">
                        <i class="ph-bold ph-arrows-left-right mr-1 text-indigo-600"></i>
                        Agent Remplacé
                    </label>
                    <select id="agent_remplace"
                            name="agent_remplace"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all font-medium">
                        <option value="">-- Aucun agent remplacé --</option>
                        @foreach($agents as $agent)
                        <option value="{{ $agent->nom }} {{ $agent->prenom }}"
                                {{ old('agent_remplace', $pointage->agent_remplace) == $agent->nom . ' ' . $agent->prenom ? 'selected' : '' }}>
                            {{ $agent->nom }} {{ $agent->prenom }}
                        </option>
                        @endforeach
                    </select>
                    @error('agent_remplace')
                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                            <i class="ph-bold ph-warning-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                @endif

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t-2 border-gray-200">
                    <a href="{{ route('pointages.index', ['type' => $pointage->type]) }}"
                       class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all">
                        <i class="ph-bold ph-arrow-left mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105">
                        <i class="ph-bold ph-floppy-disk mr-2"></i>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
