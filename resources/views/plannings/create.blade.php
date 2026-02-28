@extends('layouts.admin')

@section('content_header_title', 'Nouveau Planning')
@section('content_header_subtitle', 'Définir la faction hebdomadaire')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="glass-card rounded-3xl p-8 lg:p-10" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <a href="javascript:history.back()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="ph-bold ph-arrow-left text-gray-600 text-2xl"></i>
                    </a>
                    <div>
                        <h2 class="text-3xl font-black text-gray-900">Faction de {{ $agent->nom }} {{ $agent->prenom }}</h2>
                        <p class="text-gray-600 font-medium">Définissez les jours et horaires de travail</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('plannings.store', $agent->id) }}" method="POST" class="space-y-4">
                @csrf

                @foreach($jours as $jour)
                <div class="glass-card rounded-xl p-4 hover:shadow-md transition-all">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <!-- Jour -->
                        <div>
                            <label class="text-sm font-black text-gray-900 uppercase tracking-wide">
                                <i class="ph-bold ph-calendar-blank mr-2 text-blue-600"></i>
                                {{ ucfirst($jour) }}
                            </label>
                        </div>

                        <!-- Type (Faction/Repos) -->
                        <div>
                            <select name="jours[{{ $jour }}]"
                                    class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                                <option value="F" {{ $planning && $planning->$jour == 'F' ? 'selected' : '' }}>📋 Faction</option>
                                <option value="R" {{ $planning && $planning->$jour == 'R' ? 'selected' : '' }}>😴 Repos</option>
                            </select>
                        </div>

                        <!-- Horaire -->
                        <div>
                            <select name="heures[{{ $jour }}]"
                                    class="w-full px-4 py-2 bg-white border-2 border-gray-300 rounded-lg text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                <option value="">-- Horaire --</option>
                                <option value="07h-19h" {{ $planning && $planning->{"h_$jour"} == '07h-19h' ? 'selected' : '' }}>☀️ 07h-19h (Jour)</option>
                                <option value="19h-07h" {{ $planning && $planning->{"h_$jour"} == '19h-07h' ? 'selected' : '' }}>🌙 19h-07h (Nuit)</option>
                                <option value="07h-15h" {{ $planning && $planning->{"h_$jour"} == '07h-15h' ? 'selected' : '' }}>🌅 07h-15h (Matin)</option>
                                <option value="15h-23h" {{ $planning && $planning->{"h_$jour"} == '15h-23h' ? 'selected' : '' }}>🌆 15h-23h (Soir)</option>
                                <option value="23h-07h" {{ $planning && $planning->{"h_$jour"} == '23h-07h' ? 'selected' : '' }}>🌃 23h-07h (Nuit)</option>
                            </select>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t-2 border-gray-200 mt-6">
                    <a href="{{ route('plannings.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all">
                        <i class="ph-bold ph-arrow-left mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105">
                        <i class="ph-bold ph-floppy-disk mr-2"></i>
                        Enregistrer le Planning
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
