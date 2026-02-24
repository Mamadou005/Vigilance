@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="glass-card p-5 shadow-lg mx-auto text-white" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border-radius: 30px; max-width: 800px; border: 1px solid rgba(255,255,255,0.2);">
        <h2 class="fw-bold text-center mb-5"><i class="ph ph-warning-octagon me-2 text-danger"></i>NOUVEAU RAPPORT D'INCIDENT</h2>

        <form action="{{ route('alertes.store') }}" method="POST" class="row g-4">
            @csrf
            <div class="col-md-6">
                <label class="form-label small fw-bold text-uppercase">Site de la Banque</label>
                <select name="site_id" class="form-select bg-dark text-white border-0 py-2" required>
                    <option value="">-- Choisir Site --</option>
                    @foreach($sites as $site)
                    <option value="{{ $site->id }}">{{ $site->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold text-uppercase">Type d'incident</label>
                <input type="text" name="type_incident" class="form-control bg-dark text-white border-0 py-2" placeholder="Ex: Intrusion" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-uppercase">Heure Incident</label>
                <input type="time" name="heure_incident" class="form-control bg-dark text-white border-0 py-2" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-uppercase">Arrivée Brigade</label>
                <input type="time" name="heure_arrivee_brigade" class="form-control bg-dark text-white border-0 py-2">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-uppercase">Intervenant COS</label>
                <input type="text" name="intervenant_nom" class="form-control bg-dark text-white border-0 py-2" required>
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold text-uppercase">Observations détailléss</label>
                <textarea name="observations" class="form-control bg-dark text-white border-0 py-2" rows="4"></textarea>
            </div>
            <div class="col-12 d-flex justify-content-between mt-4">
                <a href="{{ route('alertes.index') }}" class="btn btn-outline-light rounded-pill px-4">Annuler</a>
                <button type="submit" class="btn btn-danger rounded-pill px-5 fw-bold shadow">LANCER L'ALERTE</button>
            </div>
        </form>
    </div>
</div>
@endsection
