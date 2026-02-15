@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center py-4">
    <div class="glass-card p-5 shadow-lg" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(25px); border-radius: 45px; border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 650px; color: white;">
        <div class="text-center mb-4">
            <i class="ph ph-arrows-left-right h1 text-primary"></i>
            <h2 class="fw-bold text-shadow mt-2">Organiser un Remplacement</h2>
        </div>

        <form action="{{ route('remplacements.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label class="small text-uppercase opacity-75 fw-bold">Agent Absent</label>
                <select name="agent_absent_id" class="form-select bg-transparent text-white border-white-25 rounded-3 py-2" required>
                    @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" class="text-dark">{{ $agent->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="small text-uppercase opacity-75 fw-bold">Agent Remplaçant</label>
                <select name="agent_remplacant_id" class="form-select bg-transparent text-white border-white-25 rounded-3 py-2" required>
                    @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" class="text-dark">{{ $agent->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Date & Heure</label>
                <input type="datetime-local" name="date_remplacement" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" required>
            </div>
            <div class="col-md-6 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Type de mouvement</label>
                <select name="statut" class="form-select bg-transparent text-white border-white-25 rounded-3 py-2">
                    <option value="heures supplémentaires" class="text-dark">Heures supplémentaires</option>
                    <option value="changement de faction" class="text-dark">Changement de faction</option>
                    <option value="surplus" class="text-dark">Surplus</option>
                </select>
            </div>
            <div class="col-12 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Commentaire / Justification</label>
                <textarea name="commentaire" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" rows="3"></textarea>
            </div>

            <div class="col-12 d-flex justify-content-between mt-5">
                <a href="{{ route('remplacements.index') }}" class="btn btn-outline-light rounded-pill px-4">Annuler</a>
                <button type="submit" class="btn btn-primary rounded-pill px-5 shadow fw-bold">VALIDER LE REMPLACEMENT</button>
            </div>
        </form>
    </div>
</div>
@endsection
