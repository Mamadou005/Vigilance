@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center align-items-center py-5">
    <div class="glass-card p-5 shadow-lg" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(25px); border-radius: 45px; border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 550px; color: white;">
        <div class="text-center mb-4">
            <i class="ph ph-phone-plus h1 text-primary"></i>
            <h2 class="fw-bold text-shadow mt-2">Nouveau Pointage</h2>
        </div>

        <form action="{{ route('appels.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-12">
                <label class="small text-uppercase opacity-75 fw-bold">Sélectionner l'Agent</label>
                <select name="agent_id" class="form-select bg-transparent text-white border-white-25 rounded-3 py-2">
                    @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" class="text-dark">{{ $agent->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Date de l'appel</label>
                <input type="date" name="date_appel" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-6 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Statut Présence</label>
                <select name="present" class="form-select bg-transparent text-white border-white-25 rounded-3 py-2">
                    <option value="1" class="text-dark">✅ Présent</option>
                    <option value="0" class="text-dark">❌ Absent</option>
                </select>
            </div>
            <div class="col-12 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Commentaire / Observations</label>
                <textarea name="commentaire" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" rows="3" placeholder="Rien à signaler..."></textarea>
            </div>

            <div class="col-12 d-flex justify-content-between mt-5">
                <a href="{{ route('appels.index') }}" class="btn btn-outline-light rounded-pill px-4">Retour</a>
                <button type="submit" class="btn btn-primary rounded-pill px-5 shadow fw-bold">ENREGISTRER</button>
            </div>
        </form>
    </div>
</div>
@endsection
