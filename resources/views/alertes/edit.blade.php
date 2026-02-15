@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center align-items-center py-5">
    {{-- Largeur augmentée à 850px pour accueillir tous les champs confortablement --}}
    <div class="glass-card p-5 shadow-lg" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(25px); border-radius: 45px; border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 850px; color: white;">

        <div class="text-center mb-4">
            <i class="ph ph-note-pencil h1 text-warning"></i>
            <h2 class="fw-bold text-shadow mt-2">Mise à jour Alerte</h2>
            <p class="small text-warning text-uppercase fw-bold">{{ $alerte->site->nom ?? 'Site Inconnu' }} - {{ $alerte->type_incident }}</p>
        </div>

        <form action="{{ route('alertes.update', $alerte->id) }}" method="POST" class="row g-3">
            @csrf @method('PUT')

            {{-- SECTION : INFOS DE BASE (ISSUES DU CREATE) --}}
            <div class="col-md-6">
                <label class="small text-uppercase opacity-75 fw-bold">Nature de l'incident</label>
                <input type="text" name="type_incident" value="{{ $alerte->type_incident }}" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" required>
            </div>

            <div class="col-md-6">
                <label class="small text-uppercase opacity-75 fw-bold">Intervenant (Agent COS)</label>
                <input type="text" name="intervenant_nom" value="{{ $alerte->intervenant_nom }}" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" required>
            </div>

            <div class="col-md-6 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Heure de l'incident</label>
                <input type="time" name="heure_incident" value="{{ $alerte->heure_incident }}" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" required>
            </div>

            <div class="col-md-6 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Arrivée Brigade</label>
                <input type="time" name="heure_arrivee_brigade" value="{{ $alerte->heure_arrivee_brigade }}" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2">
            </div>

            <hr class="my-4 opacity-25">

            {{-- SECTION : STATUT ET RAPPORT FINAL --}}
            <div class="col-12">
                <label class="small text-uppercase opacity-75 fw-bold">Statut du traitement</label>
                <select name="statut" class="form-select bg-transparent text-white border-white-25 rounded-3 py-2">
                    <option value="non_traite" {{ $alerte->statut == 'non_traite' ? 'selected' : '' }} class="text-dark">🔴 NON TRAITÉ</option>
                    <option value="en_cours" {{ $alerte->statut == 'en_cours' ? 'selected' : '' }} class="text-dark">🟡 EN COURS</option>
                    <option value="resolu" {{ $alerte->statut == 'resolu' ? 'selected' : '' }} class="text-dark">🟢 RÉSOLU</option>
                </select>
            </div>

            <div class="col-12 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Rapport final / Mise à jour</label>
                <textarea name="observations" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" rows="5">{{ $alerte->observations }}</textarea>
            </div>

            {{-- BOUTONS D'ACTION --}}
            <div class="col-12 d-flex justify-content-between mt-5">
                <a href="{{ route('alertes.index') }}" class="btn btn-outline-light rounded-pill px-5 fw-bold">ANNULER</a>
                <button type="submit" class="btn btn-warning rounded-pill px-5 fw-bold text-dark shadow-lg">ENREGISTRER</button>
            </div>
        </form>
    </div>
</div>

<style>
    .border-white-25 { border: 1px solid rgba(255,255,255,0.25) !important; }
    .text-shadow { text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
    .form-control:focus, .form-select:focus {
        background-color: rgba(255,255,255,0.05) !important;
        border-color: #ffc107 !important;
        color: white !important;
        box-shadow: none;
    }
</style>
@endsection
