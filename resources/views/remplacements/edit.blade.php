@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center py-4">
    <div class="glass-card p-5 shadow-lg" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(25px); border-radius: 45px; width: 100%; max-width: 800px; color: white;">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-shadow mt-2">Modifier la Relève</h2>
        </div>

        <form action="{{ route('remplacements.update', $remplacement) }}" method="POST" class="row g-4">
            @csrf @method('PUT')

            <div class="col-md-6">
                <label class="small text-uppercase fw-bold opacity-75">Agent Remplacé</label>
                <input type="text" name="agent_remplace_nom" class="form-control bg-transparent text-white border-white-25" value="{{ $remplacement->agent_remplace_nom }}" required>
            </div>

            <div class="col-md-6">
                <label class="small text-uppercase fw-bold opacity-75">Poste / Site</label>
                <input type="text" name="poste_nom" class="form-control bg-transparent text-white border-white-25" value="{{ $remplacement->poste_nom }}" required>
            </div>

            <div class="col-12">
                <label class="small text-uppercase fw-bold opacity-75">Motif (Raison)</label>
                <textarea name="motif" class="form-control bg-transparent text-white border-white-25" rows="2">{{ $remplacement->motif }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="small text-uppercase fw-bold opacity-75">Agent Remplaçant</label>
                <input type="text" name="agent_remplacant_nom" class="form-control bg-transparent text-white border-white-25" value="{{ $remplacement->agent_remplacant_nom }}" required>
            </div>

            {{-- COLONNE SITE D'AFFECTATION AJOUTÉE --}}
            <div class="col-md-6">
                <label class="small text-uppercase fw-bold opacity-75">Site d'Affectation</label>
                <input type="text" name="site_affectation" class="form-control bg-transparent text-white border-white-25" value="{{ $remplacement->site_affectation }}">
            </div>

            <div class="col-md-6">
                <label class="small text-uppercase fw-bold opacity-75">Numéro Wave</label>
                <input type="text" name="n_wave" class="form-control bg-transparent text-white border-white-25" value="{{ $remplacement->n_wave }}">
            </div>

            {{-- COLONNE DATE AJOUTÉE --}}
            <div class="col-md-6">
                <label class="small text-uppercase fw-bold opacity-75">Date de Début</label>
                <input type="date" name="date_debut" class="form-control bg-transparent text-white border-white-25" value="{{ $remplacement->date_debut }}">
            </div>

            <div class="col-12 d-flex justify-content-between mt-5">
                <a href="{{ route('remplacements.index') }}" class="btn btn-outline-light rounded-pill px-4">Retour</a>
                <button type="submit" class="btn btn-warning rounded-pill px-5 fw-bold text-dark shadow">METTRE À JOUR</button>
            </div>
        </form>
    </div>
</div>
@endsection
