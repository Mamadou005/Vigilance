@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="glass-card p-4 mb-4 border-0 shadow-lg" style="background: rgba(20, 24, 28, 0.85); backdrop-filter: blur(15px); border-radius: 25px;">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-xl-3">
                <h2 class="fw-bold text-white mb-0 text-nowrap">
                    <i class="ph ph-list-bullets me-2 text-info"></i>
                    {{ $search ? 'Historique' : ($type == 'absence' ? 'Sanctions' : 'Suppléments') }}
                </h2>
            </div>
    
            <div class="col-12 col-md-6 col-xl-4">
                <form action="{{ route('pointages.index') }}" method="GET" class="d-flex bg-white-10 rounded-pill p-1 shadow-sm">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           class="form-control border-0 bg-transparent text-white px-3"
                           placeholder="Rechercher un agent...">
                    <button type="submit" class="btn btn-info rounded-pill px-3 fw-bold">
                        <i class="ph ph-magnifying-glass"></i>
                    </button>
                    @if($search)
                    <a href="{{ route('pointages.index', ['type' => $type]) }}" class="btn btn-link text-white-50 small text-decoration-none d-flex align-items-center px-2">Effacer</a>
                    @endif
                </form>
            </div>

            <div class="col-12 col-md-6 col-xl-5">
                <div class="d-flex justify-content-md-end align-items-center gap-2 flex-wrap">
                    <button class="btn btn-primary rounded-pill px-3 fw-bold shadow-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalSaisieDirecte">
                        <i class="ph ph-plus-circle me-1"></i> SAISIR
                    </button>
                    <a href="{{ route('pointages.export', ['type' => $type, 'search' => $search]) }}" class="btn btn-success rounded-pill px-3 fw-bold shadow-sm d-flex align-items-center">
                        <i class="ph ph-file-xls me-1"></i> EXCEL
                    </a>

                    <div class="btn-group rounded-pill overflow-hidden border border-white-10 shadow-sm bg-dark">
                        <a href="{{ route('pointages.index', ['type' => 'absence']) }}" class="btn btn-{{ $type == 'absence' ? 'info' : 'dark' }} btn-sm px-3 fw-bold">Absences</a>
                        <a href="{{ route('pointages.index', ['type' => 'supplementaire']) }}" class="btn btn-{{ $type == 'supplementaire' ? 'info' : 'dark' }} btn-sm px-3 fw-bold">Suppléments</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card border-0 shadow-lg overflow-hidden" style="background: rgba(255, 255, 255, 0.95); border-radius: 25px;">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.75rem;">
                <thead class="bg-dark text-white text-uppercase small fw-bold">
                <tr>
                    <th class="ps-3 py-3" style="min-width: 120px;">Agent</th>
                    <th class="py-3">Site</th>
                    <th class="py-3 text-center">Base (AS)</th>
                    <th class="py-3 text-center">Type / Modif</th>
                    <th class="py-3 text-center text-info" style="background: rgba(0, 210, 255, 0.05);">Salaire Net</th>
                    <th class="py-3 text-center">Date</th>
                    <th class="py-3">Motif / Remplacé</th>
                    <th class="pe-3 text-center" style="min-width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody class="text-dark fw-medium">
                @forelse($pointages as $p)
                @php
                $salaireBase = $p->agent->salaire_base ?? 0;
                $montantLigne = $p->montant ?? 0;
                $netCumule = $salaireBase - ($p->agent->total_sanctions ?? 0) + ($p->agent->total_supplements ?? 0);
                @endphp
                <tr class="border-bottom">
                    <td class="ps-3 fw-bold text-truncate" style="max-width: 130px;">{{ $p->agent->nom }} {{ $p->agent->prenom }}</td>
                    <td><span class="badge bg-light text-dark border px-2 rounded-pill fw-bold" style="font-size: 0.65rem;">{{ Str::limit($p->site->nom, 10) }}</span></td>
                    <td class="text-center text-muted fw-bold">{{ number_format($salaireBase, 0, ',', ' ') }}</td>
                    <td class="text-center">
                        <span class="fw-bold text-{{ $p->type == 'absence' ? 'danger' : 'success' }}">
                            {{ $p->type == 'absence' ? '-' : '+' }}{{ number_format($montantLigne, 0, ',', ' ') }}
                        </span>
                    </td>
                    <td class="text-center fw-bold text-primary" style="background: rgba(0, 210, 255, 0.08);">
                        {{ number_format($netCumule, 0, ',', ' ') }} F
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($p->date_pointage)->format('d/m/y') }}</td>
                    <td class="small text-truncate" style="max-width: 150px;">
                        {{ $p->type == 'absence' ? ($p->motif ?? 'N/A') : ($p->agent_remplace ?? 'N/A') }}
                    </td>
                    <td class="pe-3 text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('pointages.edit', $p->id) }}" class="btn btn-xs btn-info rounded-pill px-2 shadow-sm"><i class="ph ph-pencil-simple"></i></a>

                            <form action="{{ route('pointages.destroy', $p->id) }}" method="POST" id="delete-form-{{ $p->id }}" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                            <button type="button" class="btn btn-xs btn-outline-danger rounded-pill px-2 shadow-sm delete-btn" data-id="{{ $p->id }}">
                                <i class="ph ph-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-5 text-muted">Aucun enregistrement.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODALE DE SAISIE --}}
<div class="modal fade" id="modalSaisieDirecte" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg text-dark" style="border-radius: 25px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Saisie : {{ $type == 'absence' ? 'Sanction' : 'Supplément' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pointages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="small text-uppercase fw-bold text-muted mb-2 d-block">Sélectionner l'Agent</label>
                        <select name="agent_id" id="agent_id_select" class="form-select border-2 fw-bold" required>
                            <option value="">Choisir un agent...</option>
                            @foreach(\App\Models\Agent::orderBy('nom')->get() as $agent)
                            <option value="{{ $agent->id }}" data-salaire="{{ $agent->salaire_base }}">{{ $agent->nom }} {{ $agent->prenom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="small text-uppercase fw-bold text-muted mb-1 d-block">Salaire de Base (Contrat)</label>
                        <input type="number" name="salaire_base" id="salaire_base_input" class="form-control fw-bold text-primary" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="small text-uppercase fw-bold text-muted mb-1 d-block">Date</label>
                            <input type="date" name="date_pointage" class="form-control fw-bold" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="small text-uppercase fw-bold text-muted mb-1 d-block">Montant (F CFA)</label>
                            <input type="number" name="montant" class="form-control fw-bold" value="{{ $type == 'absence' ? '' : 5000 }}" required>
                        </div>
                    </div>
                    @if($type == 'absence')
                    <div class="mb-3">
                        <label class="small text-uppercase fw-bold text-muted mb-1 d-block">Motif</label>
                        <input type="text" name="motif" class="form-control" placeholder="Ex: Retard, Abandon...">
                    </div>
                    @else
                    <div class="mb-3">
                        <label class="small text-uppercase fw-bold text-muted mb-1 d-block">Agent Remplacé</label>
                        <input type="text" name="agent_remplace" class="form-control" placeholder="Nom du remplaçant">
                    </div>
                    @endif
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-primary rounded-pill w-100 py-2 fw-bold shadow">ENREGISTRER</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Confirmation',
            text: "Supprimer ce pointage ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Supprimer',
            background: '#1a1a1a',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#delete-form-${id}`).submit();
            }
        });
    });

    document.getElementById('agent_id_select').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        let salaire = selectedOption.getAttribute('data-salaire');
        document.getElementById('salaire_base_input').value = salaire ? salaire : 0;
    });
</script>
@endpush

<style>
    .bg-white-10 { background: rgba(255, 255, 255, 0.1); }
    .btn-xs { padding: 2px 8px; font-size: 0.75rem; }
    .table td, .table th { padding: 0.6rem 0.4rem !important; }
</style>
@endsection
