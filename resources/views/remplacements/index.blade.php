@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- 1. NAVIGATION PAR DOSSIERS (7 CATÉGORIES) --}}
    <div class="row g-2 mb-4 justify-content-center">
        @php
        $categories = [
        'Postes Vides' => ['icon' => 'ph-layout', 'color' => 'text-danger'],
        'Permissions' => ['icon' => 'ph-hand-palm', 'color' => 'text-info'],
        'Repos Medical' => ['icon' => 'ph-first-aid', 'color' => 'text-warning'],
        'Mise a Pied' => ['icon' => 'ph-warning-octagon', 'color' => 'text-secondary'],
        'Certificat de deces' => ['icon' => 'ph-users-three', 'color' => 'text-light'],
        'ADS a Depointer' => ['icon' => 'ph-user-minus', 'color' => 'text-primary'],
        'Permutation entre agents' => ['icon' => 'ph-arrows-left-right', 'color' => 'text-success']
        ];
        $currentCat = request('categorie', 'Postes Vides');
        @endphp

        @foreach($categories as $name => $style)
        <div class="col-4 col-md-3 col-lg-1-7">
            <a href="{{ route('remplacements.index', ['categorie' => $name]) }}"
               class="glass-btn shadow w-100 {{ $currentCat == $name ? 'active-folder' : '' }}">
                <i class="ph {{ $style['icon'] }} {{ $style['color'] }}"></i>
                <span>{{ $name }}</span>
            </a>
        </div>
        @endforeach
    </div>

    {{-- 2. BOUTON ACTION --}}
    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-primary btn-sm rounded-pill shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalSaisieExcel">
            <i class="ph ph-keyboard me-1"></i>
            <span>Saisir Relève</span>
        </button>
    </div>

    {{-- 3. TABLEAU TYPE EXCEL --}}
    <div class="glass-card border-0 shadow-lg p-0 overflow-hidden" style="background: rgba(255,255,255,0.98); border-radius: 20px;">
        <div class="bg-dark text-white p-3 fw-bold text-uppercase small d-flex justify-content-between align-items-center">
            <span>
                <i class="ph ph-table me-2 text-info"></i>
                SUIVI ET RELÈVE DES AGENTS ({{ $currentCat }})
            </span>
            <span class="badge bg-danger rounded-pill px-3">{{ $remplacements->count() }} Lignes</span>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-bordered align-middle mb-0" style="font-size: 0.72rem; border-color: #dee2e6;">
                <thead class="bg-light text-uppercase fw-bold text-secondary text-center">
                <tr>
                    <th style="width: 50px;">Act</th>
                    <th style="width: 160px;">Agent Remplacé</th>
                    <th style="width: 140px;">Postes (Site)</th>
                    <th style="min-width: 280px;">Motif (Raison)</th>
                    <th style="width: 180px;">Remplaçant</th>
                    <th style="width: 160px;">Site d'Affectation</th>
                    <th style="width: 100px;">Numero-Wave</th>
                    <th style="width: 110px;">Date Début</th>
                    <th style="width: 80px;">Action</th>
                </tr>
                </thead>
                <tbody class="text-dark">
                @forelse($remplacements as $r)
                <tr>
                    <td class="text-center fw-bold small">
                        @if($r->agent_remplacant_nom)
                        <span class="text-success">Fait</span>
                        @else
                        <span class="text-warning">En attente</span>
                        @endif
                    </td>
                    <td class="ps-2 fw-bold text-danger">{{ $r->agent_remplace_nom }}</td>
                    <td class="ps-2 fw-bold text-primary">{{ $r->poste_nom }}</td>
                    <td class="ps-2 italic text-muted">{{ $r->motif }}</td>
                    <td class="ps-2 fw-bold {{ !$r->agent_remplacant_nom ? 'text-muted italic' : '' }}">
                        {{ $r->agent_remplacant_nom ?? 'À trouver...' }}
                    </td>
                    <td class="ps-2 small">{{ $r->site_affectation ?? '---' }}</td>
                    <td class="text-center fw-bold">{{ $r->n_wave ?? '---' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($r->date_debut)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('remplacements.edit', $r->id) }}" class="btn btn-xs btn-outline-info rounded-circle"><i class="ph ph-pencil"></i></a>

                            <form action="{{ route('remplacements.destroy', $r->id) }}" method="POST" id="delete-form-{{ $r->id }}" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                            <button type="button" class="btn btn-xs btn-outline-danger rounded-circle delete-btn" data-id="{{ $r->id }}">
                                <i class="ph ph-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-5 text-muted italic">Aucun enregistrement dans {{ $currentCat }}.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 4. MODALE DE SAISIE DYNAMIQUE --}}
<div class="modal fade" id="modalSaisieExcel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark"><i class="ph ph-keyboard me-2"></i>Saisie d'une Relève Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('remplacements.store') }}" method="POST">
                @csrf
                <input type="hidden" name="categorie" value="{{ $currentCat }}">

                <div class="modal-body px-4 text-dark">
                    <div class="row g-3 text-start">
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Agent Remplacé (Obligatoire)</label>
                            <input type="text" name="agent_remplace_nom" class="form-control border-2" required>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Poste / Site (Obligatoire)</label>
                            <input type="text" name="poste_nom" class="form-control border-2" required>
                        </div>
                        <div class="col-12">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Motif (Obligatoire)</label>
                            <textarea name="motif" class="form-control border-2" rows="2" required></textarea>
                        </div>

                        <hr class="my-2 opacity-25">
                        <p class="small text-primary fw-bold mb-0">Informations de la Relève (Optionnel)</p>

                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Agent Remplaçant</label>
                            <input type="text" name="agent_remplacant_nom" class="form-control border-2">
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Site d'Affectation</label>
                            <input type="text" name="site_affectation" class="form-control border-2">
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Numéro Wave</label>
                            <input type="text" name="n_wave" class="form-control border-2">
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Date de Début</label>
                            <input type="date" name="date_debut" class="form-control border-2" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-primary rounded-pill w-100 py-2 fw-bold shadow">
                        ENREGISTRER DANS {{ strtoupper($currentCat) }}
                    </button>
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
            text: "Supprimer cette ligne du suivi ?",
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
</script>
@endpush

<style>
    @media (min-width: 992px) {
        .col-lg-1-7 { width: 14.28%; flex: 0 0 14.28%; }
    }

    .glass-btn {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px 5px;
        color: white;
        text-decoration: none !important;
        transition: 0.3s;
        height: 85px;
    }
    .glass-btn:hover { background: rgba(255, 255, 255, 0.15); transform: translateY(-3px); }
    .glass-btn i { font-size: 1.5rem; margin-bottom: 4px; }
    .glass-btn span {
        font-weight: bold;
        font-size: 0.58rem;
        text-transform: uppercase;
        color: rgba(255,255,255,0.7);
        text-align: center;
        line-height: 1.1;
    }

    .active-folder {
        background: rgba(0, 210, 255, 0.1) !important;
        border: 2px solid #00d2ff !important;
    }
    .active-folder span { color: #00d2ff; }

    .table th { background-color: #f8f9fa !important; color: #495057 !important; padding: 12px 5px !important; }
    .btn-xs { padding: 4px 8px; font-size: 0.75rem; border: 1px solid #dee2e6; }
</style>
@endsection
