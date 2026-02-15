@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center align-items-center py-5">
    <div class="glass-card p-5 shadow-lg" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(25px); border-radius: 45px; border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 550px; color: white;">
        <div class="text-center mb-4">
            <i class="ph ph-note-pencil h1 text-warning"></i>
            <h2 class="fw-bold text-shadow mt-2">Modifier le Pointage</h2>
        </div>

        <form action="{{ route('appels.update', $appel->id) }}" method="POST" class="row g-3">
            @csrf @method('PUT')

            <div class="col-12">
                <label class="small text-uppercase opacity-75 fw-bold">Agent</label>
                <input type="text" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" value="{{ $appel->agent->nom }}" readonly opacity-50>
                <input type="hidden" name="agent_id" value="{{ $appel->agent_id }}">
            </div>

            <div class="col-md-6 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Statut Présence</label>
                <select name="present" class="form-select bg-transparent text-white border-white-25 rounded-3 py-2">
                    <option value="1" {{ $appel->present ? 'selected' : '' }} class="text-dark">✅ Présent</option>
                    <option value="0" {{ !$appel->present ? 'selected' : '' }} class="text-dark">❌ Absent</option>
                </select>
            </div>

            <div class="col-md-6 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Date</label>
                <input type="date" name="date_appel" value="{{ $appel->date_appel }}" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2">
            </div>

            <div class="col-12 mt-3">
                <label class="small text-uppercase opacity-75 fw-bold">Commentaire</label>
                <textarea name="commentaire" class="form-control bg-transparent text-white border-white-25 rounded-3 py-2" rows="3">{{ $appel->commentaire }}</textarea>
            </div>

            <div class="col-12 d-flex justify-content-between mt-5">
                <a href="{{ route('appels.index') }}" class="btn btn-outline-light rounded-pill px-4">Annuler</a>
                <button type="submit" class="btn btn-warning rounded-pill px-5 shadow fw-bold text-dark">METTRE À JOUR</button>
            </div>
        </form>
    </div>
</div>
@endsection
