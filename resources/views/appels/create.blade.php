@extends('layouts.admin')

@section('content_header_title', 'Nouveau Pointage')
@section('content_header_subtitle', 'Enregistrer un nouvel appel téléphonique')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass-card rounded-3xl p-8 lg:p-10" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                    <i class="ph-bold ph-phone-plus text-white text-4xl"></i>
                </div>
                <h2 class="text-3xl font-black text-gray-900 mb-2">Nouveau Pointage Téléphonique</h2>
                <p class="text-gray-600 font-medium">Enregistrez un appel de vérification</p>
            </div>

            <!-- Form -->
            <form action="{{ route('appels.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Agent -->
                <div>
                    <label for="agent_id" class="block text-sm font-bold text-gray-900 mb-2">
                        <i class="ph-bold ph-user-circle mr-1 text-blue-600"></i>
                        Sélectionner l'Agent
                    </label>
                    <select id="agent_id"
                            name="agent_id"
                            required
                            class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium">
                        <option value="">-- Choisir un agent --</option>
                        @foreach($agents as $agent)
                        <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                            {{ $agent->nom }} {{ $agent->prenom }}
                        </option>
                        @endforeach
                    </select>
                    @error('agent_id')
                        <p class="mt-2 text-sm text-red-600 flex items-center font-medium">
                            <i class="ph-bold ph-warning-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
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
                               value="{{ old('date_appel', date('Y-m-d')) }}"
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
                            <option value="1" {{ old('present', '1') == '1' ? 'selected' : '' }}>✅ Présent</option>
                            <option value="0" {{ old('present') == '0' ? 'selected' : '' }}>❌ Absent</option>
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
                        <i class="ph-bold ph-note-pencil mr-1 text-amber-600"></i>
                        Commentaire / Observations
                    </label>
                    <textarea id="commentaire"
                              name="commentaire"
                              rows="4"
                              class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all font-medium resize-none"
                              placeholder="Rien à signaler...">{{ old('commentaire') }}</textarea>
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
                        Retour
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105">
                        <i class="ph-bold ph-floppy-disk mr-2"></i>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
