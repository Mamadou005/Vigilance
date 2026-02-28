@extends('layouts.premium')

@section('title', 'Nouvel Agent')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Créer un nouvel agent</h1>
            <p class="text-sm text-gray-400 mt-1">Enregistrer un agent dans le système</p>
        </div>
        <a href="{{ route('agents.index') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-navy-800/50 hover:bg-navy-700/50 border border-navy-700/50 text-gray-300 hover:text-white rounded-xl font-medium transition-all duration-200">
            <i class="ph ph-arrow-left"></i>
            <span>Retour</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('agents.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Informations Personnelles -->
            <x-premium.card title="Informations Personnelles" icon="ph-user">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-premium.input
                        label="Prénom"
                        name="prenom"
                        icon="ph-user"
                        placeholder="Ex: Mohamed"
                        required
                        :error="$errors->first('prenom')"
                        :value="old('prenom')"
                    />

                    <x-premium.input
                        label="Nom"
                        name="nom"
                        icon="ph-user"
                        placeholder="Ex: DIOP"
                        required
                        :error="$errors->first('nom')"
                        :value="old('nom')"
                    />

                    <x-premium.input
                        label="Matricule"
                        name="matricule"
                        icon="ph-identification-badge"
                        placeholder="Ex: AG-2025-001"
                        required
                        :error="$errors->first('matricule')"
                        :value="old('matricule')"
                    />

                    <x-premium.input
                        label="Date de Naissance"
                        name="date_naissance"
                        type="date"
                        icon="ph-calendar"
                        :error="$errors->first('date_naissance')"
                        :value="old('date_naissance')"
                    />
                </div>
            </x-premium.card>

            <!-- Contact & Localisation -->
            <x-premium.card title="Contact & Localisation" icon="ph-phone">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-premium.input
                        label="Téléphone"
                        name="telephone"
                        type="tel"
                        icon="ph-phone"
                        placeholder="Ex: +221 77 123 45 67"
                        :error="$errors->first('telephone')"
                        :value="old('telephone')"
                    />

                    <x-premium.input
                        label="Email"
                        name="email"
                        type="email"
                        icon="ph-envelope"
                        placeholder="Ex: agent@vigilance-cos.com"
                        :error="$errors->first('email')"
                        :value="old('email')"
                    />

                    <div class="md:col-span-2">
                        <x-premium.input
                            label="Adresse"
                            name="adresse"
                            icon="ph-map-pin"
                            placeholder="Ex: Dakar, Plateau"
                            :error="$errors->first('adresse')"
                            :value="old('adresse')"
                        />
                    </div>
                </div>
            </x-premium.card>

            <!-- Affectation & Statut -->
            <x-premium.card title="Affectation & Statut" icon="ph-briefcase">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-premium.select
                        label="Site d'affectation"
                        name="site_id"
                        icon="ph-buildings"
                        placeholder="Sélectionner un site"
                        :error="$errors->first('site_id')"
                    >
                        @foreach($sites ?? [] as $site)
                            <option value="{{ $site->id }}" {{ old('site_id') == $site->id ? 'selected' : '' }}>
                                {{ $site->nom }}
                            </option>
                        @endforeach
                    </x-premium.select>

                    <x-premium.select
                        label="Statut"
                        name="statut"
                        icon="ph-check-circle"
                        placeholder="Sélectionner un statut"
                        required
                        :error="$errors->first('statut')"
                    >
                        <option value="Actif" {{ old('statut') == 'Actif' ? 'selected' : '' }}>Actif</option>
                        <option value="Repos" {{ old('statut') == 'Repos' ? 'selected' : '' }}>Repos</option>
                        <option value="Absent" {{ old('statut') == 'Absent' ? 'selected' : '' }}>Absent</option>
                    </x-premium.select>

                    <x-premium.input
                        label="Salaire de Base"
                        name="salaire_base"
                        type="number"
                        icon="ph-currency-circle-dollar"
                        placeholder="Ex: 150000"
                        :error="$errors->first('salaire_base')"
                        :value="old('salaire_base')"
                    />

                    <x-premium.input
                        label="Date d'embauche"
                        name="date_embauche"
                        type="date"
                        icon="ph-calendar-check"
                        :error="$errors->first('date_embauche')"
                        :value="old('date_embauche')"
                    />
                </div>
            </x-premium.card>

            <!-- Informations Complémentaires -->
            <x-premium.card title="Informations Complémentaires" icon="ph-note">
                <div>
                    <label for="observations" class="block text-sm font-medium text-gray-400 mb-2">
                        Observations
                    </label>
                    <textarea
                        id="observations"
                        name="observations"
                        rows="4"
                        class="w-full px-4 py-2.5 bg-navy-900/50 border border-navy-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all resize-none"
                        placeholder="Notes, remarques particulières...">{{ old('observations') }}</textarea>
                    @error('observations')
                        <p class="mt-2 text-sm text-red-400 flex items-center">
                            <i class="ph-bold ph-warning-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </x-premium.card>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('agents.index') }}"
                   class="inline-flex items-center space-x-2 px-6 py-3 bg-navy-800/50 hover:bg-navy-700/50 border border-navy-700/50 text-gray-300 hover:text-white rounded-xl font-medium transition-all duration-200">
                    <i class="ph ph-x"></i>
                    <span>Annuler</span>
                </a>

                <button type="submit"
                        class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-glow">
                    <i class="ph-bold ph-check-circle"></i>
                    <span>Enregistrer l'agent</span>
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-génération du matricule
    document.addEventListener('DOMContentLoaded', function() {
        const prenomInput = document.querySelector('[name="prenom"]');
        const nomInput = document.querySelector('[name="nom"]');
        const matriculeInput = document.querySelector('[name="matricule"]');

        function generateMatricule() {
            const prenom = prenomInput.value.substring(0, 2).toUpperCase();
            const nom = nomInput.value.substring(0, 2).toUpperCase();
            const year = new Date().getFullYear();
            const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');

            if (prenom && nom) {
                matriculeInput.value = `${prenom}${nom}-${year}-${random}`;
            }
        }

        prenomInput?.addEventListener('blur', generateMatricule);
        nomInput?.addEventListener('blur', generateMatricule);
    });
</script>
@endpush
