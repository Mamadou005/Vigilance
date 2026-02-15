@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center py-4">
    <div class="glass-card p-5 shadow-lg" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(25px); border-radius: 45px; border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 650px; color: white;">
        <div class="text-center mb-4">
            <i class="ph ph-pencil-line h1 text-info"></i>
            <h2 class="fw-bold text-shadow mt-2">Modifier le Site / Banque</h2>
        </div>

        <form action="{{ route('sites.update', $site->id) }}" method="POST" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-md-12">
                <label class="small text-uppercase opacity-75 fw-bold mb-1">Nom du Site</label>
                <input type="text" name="nom" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" value="{{ $site->nom }}" required>
            </div>

            <div class="col-md-6">
                <label class="small text-uppercase opacity-75 fw-bold mb-1">Secteur</label>
                <select name="secteur" class="form-select bg-transparent text-white border-white-25 rounded-3 py-2">
                    <option value="Secteur 1 (Ville)" {{ $site->secteur == 'Secteur 1 (Ville)' ? 'selected' : '' }} class="text-dark">Secteur 1 (Ville)</option>
                    <option value="Secteur 2 (Banlieu)" {{ $site->secteur == 'Secteur 2 (Banlieu)' ? 'selected' : '' }} class="text-dark">Secteur 2 (Banlieue)</option>
                    <option value="Secteur 3 (Region)" {{ $site->secteur == 'Secteur 3 (Region)' ? 'selected' : '' }} class="text-dark">Secteur 3 (Région)</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="small text-uppercase opacity-75 fw-bold mb-1">Téléphone RPE</label>
                <input type="text" name="telephone" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" value="{{ $site->telephone }}">
            </div>

            <div class="col-12">
                <label class="small text-uppercase opacity-75 fw-bold mb-1">Adresse</label>
                <textarea name="adresse" class="form-control bg-transparent text-white border-white-25 rounded-3" rows="2">{{ $site->adresse }}</textarea>
            </div>

            <div class="col-12 d-flex justify-content-between mt-5">
                <a href="{{ route('sites.index') }}" class="btn btn-outline-light rounded-pill px-4">Retour</a>
                <button type="submit" class="btn btn-primary rounded-pill px-5 shadow fw-bold">ENREGISTRER LES MODIFS</button>
            </div>
        </form>
    </div>
</div>
@endsection
