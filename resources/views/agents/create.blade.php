@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center align-items-center py-5">
    <div class="glass-card p-5 shadow-lg" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(25px); border-radius: 45px; border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 550px; color: white;">
        <div class="text-center mb-4">
            <i class="ph ph-user-plus h1 text-primary"></i>
            <h2 class="fw-bold text-shadow mt-2">Ajouter un Agent</h2>
        </div>

        <form action="{{ route('agents.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label class="small text-uppercase opacity-75 fw-bold">Nom</label>
                <input type="text" name="nom" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" required>
            </div>
            <div class="col-md-6">
                <label class="small text-uppercase opacity-75 fw-bold">Prénom</label>
                <input type="text" name="prenom" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" required>
            </div>
            <div class="col-12 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Statut Initial</label>
                <select name="statut" class="form-select bg-transparent text-white border-white-25 rounded-3 py-2">
                    <option value="Présent" class="text-dark">✅ Présent</option>
                    <option value="Absent" class="text-dark">❌ Absent</option>
                    <option value="Congé" class="text-dark">🏖️ Congé</option>
                </select>
            </div>
            <div class="col-12 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Site d'Affectation</label>
                <select name="site_id" class="form-select bg-transparent text-white border-white-25 rounded-3 py-2">
                    @foreach($sites as $site)
                    <option value="{{ $site->id }}" class="text-dark">{{ $site->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <label class="small text-uppercase opacity-75 fw-bold mb-2 text-white">Numéro de Téléphone</label>
                <input type="text" name="telephone" class="form-control bg-white-10 text-black border-0 rounded-3 py-3 px-4" placeholder="Ex: 77 000 00 00">
            </div>
            <div class="col-12 d-flex justify-content-between mt-5">
                <a href="{{ route('agents.index') }}" class="btn btn-outline-light rounded-pill px-4">Annuler</a>
                <button type="submit" class="btn btn-primary rounded-pill px-5 shadow fw-bold text-uppercase">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
