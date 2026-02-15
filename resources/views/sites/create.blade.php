@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center py-5">
    <div class="glass-card p-5 shadow-lg" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(25px); border-radius: 40px; border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 550px; color: white;">

        <div class="text-center mb-4">
            <i class="ph ph-bank h1 text-primary"></i>
            <h2 class="fw-bold text-shadow mt-2">Nouveau Site / Banque</h2>
            <p class="small opacity-75">Enregistrez un point de surveillance par secteur</p>
        </div>

        <form action="{{ route('sites.store') }}" method="POST">
            @csrf

            {{-- Champ Nom du Site --}}
            <div class="mb-4">
                <label class="form-label fw-bold small text-uppercase opacity-75">Nom du Site ou de la Banque</label>
                <input type="text" name="nom" class="form-control bg-transparent text-white border-white-25 rounded-pill py-2 px-4 shadow-sm" placeholder="ex: BOA - Siège Ville" required>
            </div>

            {{-- Champ Secteur (Crucial pour ton organisation) --}}
            <div class="mb-4">
                <label class="form-label fw-bold small text-uppercase opacity-75">Secteur Géographique</label>
                <select name="secteur" class="form-select bg-dark text-white border-white-25 rounded-pill py-2 px-4 shadow-sm" required>
                    <option value="" disabled selected>Choisir un secteur...</option>
                    <option value="Secteur 1 (Ville)">Secteur 1 (Ville)</option>
                    <option value="Secteur 2 (Banlieu)">Secteur 2 (Banlieu)</option>
                    <option value="Secteur 3 (Region)">Secteur 3 (Region)</option>
                </select>
                <div class="form-text text-white-50 small mt-1">Cela permet de regrouper les plannings par zone.</div>
            </div>

            {{-- Champ Adresse --}}
            <div class="mb-4">
                <label class="form-label fw-bold small text-uppercase opacity-75">Adresse précise</label>
                <textarea name="adresse" class="form-control bg-transparent text-white border-white-25 rounded-4 px-4 py-2" rows="2" placeholder="Rue, quartier..."></textarea>
            </div>

            <div class="d-flex justify-content-between mt-5">
                <a href="{{ route('sites.index') }}" class="btn btn-outline-light rounded-pill px-4">ANNULER</a>
                <button type="submit" class="btn btn-primary rounded-pill px-5 shadow fw-bold">CRÉER LE SITE</button>
            </div>
        </form>
    </div>
</div>

<style>
    .border-white-25 { border-color: rgba(255,255,255,0.25) !important; }
    .form-select option { background-color: #212529; color: white; }
    .text-shadow { text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
</style>
@endsection
