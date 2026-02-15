@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center align-items-center py-5">
    {{-- Conteneur Glassmorphism Premium --}}
    <div class="glass-card p-5 shadow-lg" style="background: rgba(20, 24, 28, 0.95); backdrop-filter: blur(25px); border-radius: 40px; border: 1px solid rgba(255,255,255,0.1); width: 100%; max-width: 600px; color: white;">

        <div class="text-center mb-5">
            <div class="icon-circle bg-warning d-inline-flex p-3 rounded-circle mb-3 shadow-glow" style="box-shadow: 0 0 20px rgba(255, 193, 7, 0.3);">
                <i class="ph ph-user-focus h1 mb-0 text-dark"></i>
            </div>
            <h2 class="fw-bold text-shadow">Mise à jour Agent</h2>
            <p class="text-white-50 small">Modification des informations de l'agent pour le COS</p>
        </div>

        {{-- Formulaire avec route ID explicite et méthode PUT --}}
        <form action="{{ route('agents.update', $agent->id) }}" method="POST" class="row g-4">
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label class="small text-uppercase opacity-75 fw-bold mb-2">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $agent->nom) }}" class="form-control bg-white-10 text-white border-0 rounded-3 py-3 px-4 shadow-sm" required>
            </div>

            <div class="col-md-6">
                <label class="small text-uppercase opacity-75 fw-bold mb-2">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom', $agent->prenom) }}" class="form-control bg-white-10 text-white border-0 rounded-3 py-3 px-4 shadow-sm" required>
            </div>

            <div class="col-md-12">
                <label class="small text-uppercase opacity-75 fw-bold mb-2">Statut Actuel</label>
                <select name="statut" class="form-select bg-white-10 text-white border-0 rounded-3 py-3 px-4 shadow-sm">
                    <option value="Présent" {{ $agent->statut == 'Présent' ? 'selected' : '' }} class="text-dark">Présent</option>
                    <option value="Absent" {{ $agent->statut == 'Absent' ? 'selected' : '' }} class="text-dark">Absent</option>
                    <option value="Repos" {{ $agent->statut == 'Repos' ? 'selected' : '' }} class="text-dark">Repos</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="small text-uppercase opacity-75 fw-bold mb-2 text-white">Numéro de Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone', $agent->telephone) }}" class="form-control bg-white-10 text-white border-0 rounded-3 py-3 px-4">
            </div>

            <div class="col-md-12">
                <label class="small text-uppercase opacity-75 fw-bold mb-2">Site d'Affectation</label>
                <select name="site_id" class="form-select bg-white-10 text-white border-0 rounded-3 py-3 px-4 shadow-sm">
                    @foreach($sites as $site)
                    <option value="{{ $site->id }}" {{ $agent->site_id == $site->id ? 'selected' : '' }} class="text-dark">
                        {{ $site->nom }} ({{ $site->secteur }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 d-flex justify-content-between align-items-center mt-5">
                <a href="{{ route('agents.index') }}" class="text-white-50 text-decoration-none fw-bold small">
                    <i class="ph ph-arrow-left me-1"></i> ANNULER
                </a>
                <button type="submit" class="btn btn-warning rounded-pill px-5 py-3 shadow-glow fw-bold text-uppercase border-0 text-dark">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .bg-white-10 { background: rgba(255,255,255,0.08); transition: 0.3s; }
    .bg-white-10:focus { background: rgba(255,255,255,0.15); box-shadow: 0 0 10px rgba(0, 210, 255, 0.2) !important; color: white; }
    .shadow-glow { box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3); }
    .form-select option { background: #1a1e21; color: white; }
</style>
@endsection
