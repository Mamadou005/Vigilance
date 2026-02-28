@extends('layouts.admin')

@section('content_header_title', 'Modifier Pointage')
@section('content_header_subtitle', 'Mise à jour de l\'appel téléphonique')

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
                    <i class="ph-bold ph-note-pencil text-white text-4xl"></i>
                </div>
                <h2 class="text-3xl font-black text-gray-900 mb-2">Modifier le Pointage</h2>
                <p class="text-gray-600 font-medium">Mise à jour des informations de l'appel</p>
            </div>

            <!-- Form -->
            <form action="{{ route('appels.update', $appel->id) }}" method="POST" class="space-y-6">
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
                           value="{{ $appel->agent->nom }} {{ $appel->agent->prenom }}"
                           readonly
                           class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-xl text-gray-600 font-medium cursor-not-allowed">
                    <input type="hidden" name="agent_id" value="{{ $appel->agent_id }}">
                </div>

                <!-- Date & Présence -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_appel" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-calendar mr-1 text-purple-600"></i>
                            Date de l'Appel
                        </label>
                        <input type="date"
                               id="date_appel"
                               name="date_appel"
                               value="{{ old('date_appel', $appel->date_appel) }}"
                               required
                               class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all font-medium">
                        @error('date_appel')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="present" class="block text-sm font-bold text-gray-900 mb-2">
                            <i class="ph-bold ph-check-circle mr-1 text-green-600"></i>
                            Statut Présence
                        </label>
                        <select id="present"
                                name="present"
                                required
                                class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all font-medium">
                            <option value="1" {{ $appel->present ? 'selected' : '' }}>✅ Présent</option>
                            <option value="0" {{ !$appel->present ? 'selected' : '' }}>❌ Absent</option>
                        </select>
                        @error('present')
                            <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                                <i class="ph-bold ph-warning-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Commentaire -->
                <div>
                    <label for="commentaire" class="block text-sm font-bold text-gray-900 mb-2">
                        <i class="ph-bold ph-note-pencil mr-1 text-indigo-600"></i>
                        Commentaire / Observations
                    </label>
                    <textarea id="commentaire"
                              name="commentaire"
                              rows="4"
                              class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all font-medium resize-none"
                              placeholder="Rien à signaler...">{{ old('commentaire', $appel->commentaire) }}</textarea>
                    @error('commentaire')
                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                            <i class="ph-bold ph-warning-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t-2 border-gray-200">
                    <a href="{{ route('appels.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all">
                        <i class="ph-bold ph-arrow-left mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105">
                        <i class="ph-bold ph-floppy-disk mr-2"></i>
                        Mettre à Jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
