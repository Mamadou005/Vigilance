@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="glass-card p-5 border-0 shadow-lg mx-auto" style="background: rgba(20, 24, 28, 0.9); backdrop-filter: blur(15px); border-radius: 25px; max-width: 600px;">
        <h2 class="fw-bold text-white mb-4">
            <i class="ph ph-pencil-circle me-2 text-info"></i>
            Modifier le Pointage
        </h2>

        <form action="{{ route('pointages.update', $pointage->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="text-white-50 small fw-bold text-uppercase">Agent</label>
                <input type="text" class="form-control bg-dark text-white border-0" value="{{ $pointage->agent->nom }} {{ $pointage->agent->prenom }}" readonly>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="text-white-50 small fw-bold text-uppercase">Date</label>
                    <input type="date" name="date_pointage" class="form-control" value="{{ \Carbon\Carbon::parse($pointage->date_pointage)->format('Y-m-d') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="text-white-50 small fw-bold text-uppercase">Montant (F CFA)</label>
                    <input type="number" name="montant" class="form-control" value="{{ $pointage->montant }}">
                </div>
            </div>

            @if($pointage->type == 'absence')
            <div class="mb-4">
                <label class="text-white-50 small fw-bold text-uppercase">Motif / Sanction</label>
                <input type="text" name="motif" class="form-control" value="{{ $pointage->motif }}">
            </div>
            @else
            <div class="mb-4">
                <label class="text-white-50 small fw-bold text-uppercase">Agent Remplacé</label>
                <input type="text" name="agent_remplace" class="form-control" value="{{ $pointage->agent_remplace }}">
            </div>
            @endif

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">ENREGISTRER</button>
                <a href="{{ route('pointages.index', ['type' => $pointage->type]) }}" class="btn btn-outline-light rounded-pill px-4">ANNULER</a>
            </div>
        </form>
    </div>
</div>
@endsection
