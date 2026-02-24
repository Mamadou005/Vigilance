@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Premium avec Barre de Recherche style "Z3" --}}
    <div class="glass-card p-3 mb-5 border-0 shadow-lg" style="background: rgba(20, 24, 28, 0.85); backdrop-filter: blur(15px); border-radius: 25px;">
        <div class="row align-items-center">
            <div class="col-md-3">
                <h4 class="fw-bold mb-0 text-white ms-2">Gestion des Agents</h4>
            </div>

            <div class="col-md-6">
                <form action="{{ route('agents.index') }}" method="GET" class="search-bar-z3-mini d-flex align-items-center">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control form-control-sm"
                           placeholder="Trouver un agent...">
                    <button type="submit" class="btn btn-cyan-search-mini fw-bold text-uppercase">
                        RECHERCHER
                    </button>
                </form>
            </div>

            <div class="col-md-3 text-end">
                <a href="{{ route('agents.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                    <i class="ph ph-plus-circle me-2"></i> Nouvel Agent
                </a>
            </div>
        </div>
    </div>

    {{-- Grille des Agents --}}
    <div class="row g-4">
        @forelse($agents as $agent)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="agent-card-wrapper shadow-lg">
                <div class="card-top p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="avatar-box">
                            <i class="ph ph-user-circle text-primary display-5"></i>
                        </div>
                        <div class="status-dot {{ $agent->statut == 'Présent' ? 'bg-success' : 'bg-danger' }}"></div>
                    </div>
                    <h5 class="fw-bold text-white mb-1">{{ $agent->nom }} {{ $agent->prenom }}</h5>
                    <p class="text-white-50 small mb-3"><i class="ph ph-fingerprint me-1"></i> Matricule: {{ $agent->matricule ?? 'N/A' }}</p>
                    <div class="agent-info text-white-50 small">
                        <div class="mb-1"><i class="ph ph-bank me-2"></i>{{ $agent->site->nom ?? 'Non affecté' }}</div>
                        <div><i class="ph ph-phone me-2"></i>{{ $agent->telephone ?? 'N/A' }}</div>
                    </div>
                </div>

                {{-- Partie Inférieure : 3 actions alignées proprement --}}
                <div class="card-bottom bg-white p-2">
                    <div class="row g-0 align-items-center text-center">
                        {{-- Action Modifier --}}
                        <div class="col-4 border-end">
                            <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-link text-dark p-0 text-decoration-none fw-bold action-link">
                                <i class="ph ph-pencil-simple d-block mb-1 mx-auto"></i> MODIFIER
                            </a>
                        </div>
                        {{-- Action Pointer --}}
                        <div class="col-4 px-1">
                            <button type="button" class="btn btn-cyan-pointer rounded-pill w-100 fw-bold text-white shadow-sm py-1"
                                    data-bs-toggle="modal" data-bs-target="#modalPointage{{ $agent->id }}">
                                POINTER
                            </button>
                        </div>
                        {{-- Action Supprimer MODIFIÉE --}}
                        <div class="col-4 border-start">
                            <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" id="delete-form-{{ $agent->id }}" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                            <button type="button" class="btn btn-link text-danger p-0 text-decoration-none fw-bold action-link delete-btn" data-id="{{ $agent->id }}">
                                <i class="ph ph-trash d-block mb-1 mx-auto"></i> SUPPRIMER
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODALE DE POINTAGE --}}
        <div class="modal fade" id="modalPointage{{ $agent->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; background: rgba(255,255,255,0.98);">
                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                        <h5 class="modal-title fw-bold text-dark">Pointage : {{ $agent->nom }} {{ $agent->prenom }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('pointages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                        <input type="hidden" name="site_id" value="{{ $agent->site_id }}">
                        <input type="hidden" name="date_pointage" value="{{ date('Y-m-d') }}">

                        <div class="modal-body py-4 px-4">
                            <div class="mb-3">
                                <label class="small text-uppercase fw-bold mb-2 text-muted">Nature du Pointage</label>
                                <select name="type" class="form-select border border-2 rounded-3 py-2 text-dark fw-bold"
                                        style="background-color: #f8f9fa;" id="typePointage{{ $agent->id }}"
                                        onchange="togglePointageFields({{ $agent->id }})">
                                    <option value="absence">Absence / Sanction</option>
                                    <option value="supplementaire">H. Supplémentaire</option>
                                </select>
                            </div>

                            <div id="fieldsAbsence{{ $agent->id }}">
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="small text-uppercase fw-bold mb-1 text-muted">Montant (F CFA)</label>
                                        <input type="number" name="montant" class="form-control bg-light border-0 py-2 text-dark fw-bold" placeholder="ex: 5000">
                                    </div>
                                    <div class="col-6">
                                        <label class="small text-uppercase fw-bold mb-1 text-muted">Nombre de Jours</label>
                                        <input type="number" name="nb_jours" value="1" class="form-control bg-light border-0 py-2 text-dark fw-bold">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="small text-uppercase fw-bold mb-1 text-muted">Motif de l'absence</label>
                                    <input type="text" name="motif" class="form-control bg-light border-0 py-2 text-dark fw-bold" placeholder="URGENCE, NON JUSTIFIER, etc.">
                                </div>
                            </div>

                            <div id="fieldsSupp{{ $agent->id }}" style="display:none;">
                                <div class="mb-3">
                                    <label class="small text-uppercase fw-bold mb-1 text-muted">Agent Remplacé</label>
                                    <input type="text" name="agent_remplace" class="form-control bg-light border-0 py-2 text-dark fw-bold" placeholder="Nom de l'agent absent remplacé">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pb-4 px-4">
                            <button type="submit" class="btn btn-primary rounded-pill w-100 py-2 fw-bold shadow-sm">VALIDER LE POINTAGE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-white opacity-50">
            <i class="ph ph-users-slash display-1"></i>
            <p class="mt-3">Aucun agent trouvé.</p>
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Supprimer cet Agent ?',
            text: "Toutes ses données seront perdues.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Supprimer',
            cancelButtonText: 'Annuler',
            background: '#14181c',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#delete-form-${id}`).submit();
            }
        });
    });

    function togglePointageFields(id) {
        const type = document.getElementById('typePointage' + id).value;
        const divAbsence = document.getElementById('fieldsAbsence' + id);
        const divSupp = document.getElementById('fieldsSupp' + id);

        if (type === 'absence') {
            divAbsence.style.display = 'block';
            divSupp.style.display = 'none';
        } else {
            divAbsence.style.display = 'none';
            divSupp.style.display = 'block';
        }
    }
</script>
@endpush

<style>
    /* STYLE BARRE DE RECHERCHE Z3 */
    .search-bar-z3-mini {
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50px;
        padding: 4px 6px 4px 20px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        max-width: 450px;
        margin: 0 auto;
    }
    .search-bar-z3-mini input {
        background: transparent !important;
        border: none !important;
        color: white !important;
        box-shadow: none !important;
        font-size: 0.8rem !important;
    }
    .search-bar-z3-mini input::placeholder { color: rgba(255, 255, 255, 0.4) !important; font-size: 0.8rem; }
    .btn-cyan-search-mini {
        background-color: #00d2ff !important;
        color: #000 !important;
        border-radius: 50px;
        padding: 6px 18px;
        font-size: 0.75rem;
        border: none;
    }

    /* CARTES AGENTS */
    .agent-card-wrapper { border-radius: 25px; overflow: hidden; transition: 0.3s; }
    .agent-card-wrapper:hover { transform: translateY(-8px); }
    .card-top { background: rgba(20, 24, 28, 0.95); backdrop-filter: blur(15px); }
    .card-bottom { border-top: 1px solid rgba(0,0,0,0.05); }
    .status-dot { width: 10px; height: 10px; border-radius: 50%; box-shadow: 0 0 8px currentColor; }
    .bg-success { background-color: #28a745 !important; color: #28a745; }
    .bg-danger { background-color: #dc3545 !important; color: #dc3545; }
    .avatar-box { background: rgba(0, 210, 255, 0.1); border-radius: 12px; padding: 4px; }

    .action-link { font-size: 0.6rem !important; letter-spacing: 0.5px; }
    .action-link i { font-size: 1.1rem; }

    .btn-cyan-pointer {
        background-color: #00d2ff !important;
        border: none;
        font-size: 0.6rem;
        letter-spacing: 0.5px;
        padding: 8px 2px;
    }
    .btn-cyan-pointer:hover {
        background-color: #00b8e6 !important;
        transform: scale(1.05);
        transition: 0.3s;
    }

    .border-end { border-right: 1px solid rgba(0,0,0,0.08) !important; }
    .border-start { border-left: 1px solid rgba(0,0,0,0.08) !important; }

    .modal-content input, .modal-content select { color: #000 !important; }
</style>
@endsection
