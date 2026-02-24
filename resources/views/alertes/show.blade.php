@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('alertes.index') }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="ph ph-arrow-left me-2"></i>RETOUR AU JOURNAL
        </a>
    </div>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white text-dark">
        {{-- Header du Rapport --}}
        <div class="card-header bg-dark text-white p-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-0 text-uppercase">Rapport d'Intervention #{{ $alerte->id }}</h4>
                <p class="small mb-0 opacity-75">Émis le {{ $alerte->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <div class="text-end">
                @php
                $statusColor = $alerte->statut == 'resolu' ? 'bg-success' : ($alerte->statut == 'en_cours' ? 'bg-warning' : 'bg-danger');
                @endphp
                <span class="badge {{ $statusColor }} px-4 py-2 rounded-pill shadow-sm">
                    {{ strtoupper(str_replace('_', ' ', $alerte->statut)) }}
                </span>
            </div>
        </div>

        <div class="card-body p-5">
            <div class="row g-5">
                {{-- Colonne Gauche : Localisation & Temps --}}
                <div class="col-md-6 border-end">
                    <h5 class="fw-bold text-primary mb-4 text-uppercase border-bottom pb-2">Localisation & Chronologie</h5>
                    <div class="mb-4">
                        <label class="small text-muted text-uppercase d-block fw-bold">Site Concerné</label>
                        <span class="fs-5 fw-bold text-dark">{{ $alerte->site->nom ?? 'N/A' }}</span>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="small text-muted text-uppercase d-block fw-bold">Heure de l'Incident</label>
                            <span class="fw-bold fs-5">{{ $alerte->heure_incident ?? '--:--' }}</span>
                        </div>
                        <div class="col-6 text-danger">
                            <label class="small text-muted text-uppercase d-block fw-bold">Arrivée Brigade</label>
                            <span class="fw-bold fs-5">{{ $alerte->heure_arrivee_brigade ?? 'Non sollicitée' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Colonne Droite : Nature & Personnel --}}
                <div class="col-md-6">
                    <h5 class="fw-bold text-primary mb-4 text-uppercase border-bottom pb-2">Nature & Intervention</h5>
                    <div class="mb-4">
                        <label class="small text-muted text-uppercase d-block fw-bold">Type d'Incident</label>
                        <span class="fs-5 fw-bold text-danger"><i class="ph ph-warning me-2"></i>{{ $alerte->type_incident }}</span>
                    </div>
                    <div class="mb-4">
                        <label class="small text-muted text-uppercase d-block fw-bold">Agent Intervenant (COS)</label>
                        <span class="fw-bold fs-5">{{ $alerte->intervenant_nom }}</span>
                    </div>
                </div>

                {{-- Observations --}}
                <div class="col-12 mt-2">
                    <div class="p-4 bg-light rounded-4 border-start border-5 border-dark shadow-sm">
                        <label class="text-primary small text-uppercase fw-bold d-block mb-2">Observations Détaillées & Causes</label>
                        <p class="mb-0 fs-6 italic text-muted" style="white-space: pre-line; line-height: 1.6;">
                            {{ $alerte->observations ?: 'Aucune observation détaillée n\'a été saisie pour ce rapport.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer avec Actions --}}
        <div class="card-footer bg-light p-4 text-center">
            <div class="d-flex justify-content-center gap-2">
                <button onclick="window.print()" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm">
                    <i class="ph ph-printer me-2"></i>IMPRIMER
                </button>

                <a href="{{ route('alertes.pdf', $alerte->id) }}" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">
                    <i class="ph ph-file-pdf me-2"></i>TÉLÉCHARGER PDF
                </a>

                <a href="{{ route('alertes.edit', $alerte->id) }}" class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm">
                    <i class="ph ph-note-pencil me-2"></i>MODIFIER LE STATUT
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
