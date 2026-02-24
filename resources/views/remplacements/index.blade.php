@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container-fluid py-4">

    {{-- 1. NAVIGATION PAR DOSSIERS --}}
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
                <span class="category-text">{{ $name }}</span>
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
                            <a href="{{ route('remplacements.edit', $r->id) }}" class="btn btn-xs btn-outline-info rounded-circle">
                                <i class="ph ph-pencil"></i>
                            </a>
                            <form action="{{ route('remplacements.destroy', $r->id) }}" method="POST" id="delete-form-{{ $r->id }}" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                            <button type="button" class="btn btn-xs btn-outline-danger rounded-circle" onclick="forcerSuppression({{ $r->id }})">
                                <i class="ph ph-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-5 text-muted italic">Aucun enregistrement trouvé.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 4. MODALE DE SAISIE --}}
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

                <div class="modal-body px-4 text-dark text-start">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Agent Remplacé (Obligatoire)</label>
                            <select name="agent_remplace_nom" id="agent_remplace_select" class="form-select select2-modal" required>
                                <option value=""></option>
                                @foreach($agents as $agent)
                                <option value="{{ $agent->nom }} {{ $agent->prenom }}" data-site="{{ $agent->site->nom ?? '' }}">
                                    {{ $agent->nom }} {{ $agent->prenom }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Poste / Site (Obligatoire)</label>
                            <select name="poste_nom" id="poste_nom_select" class="form-select select2-modal" required>
                                <option value=""></option>
                                @foreach($sites as $site)
                                <option value="{{ $site->nom }}">{{ $site->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Motif (Obligatoire)</label>
                            <textarea name="motif" class="form-control border-2" rows="2" required placeholder="Ex: Permission exceptionnelle..."></textarea>
                        </div>

                        <hr class="my-2 opacity-25">
                        <p class="small text-primary fw-bold mb-0">Informations de la Relève (Optionnel)</p>

                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Agent Remplaçant</label>
                            <select name="agent_remplacant_nom" class="form-select select2-modal">
                                <option value="">À trouver plus tard...</option>
                                @foreach($agents as $agent)
                                <option value="{{ $agent->nom }} {{ $agent->prenom }}">{{ $agent->nom }} {{ $agent->prenom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Site d'Affectation</label>
                            <select name="site_affectation" class="form-select select2-modal">
                                <option value="">Même site</option>
                                @foreach($sites as $site)
                                <option value="{{ $site->nom }}">{{ $site->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Numéro Wave</label>
                            <input type="text" name="n_wave" class="form-control border-2" placeholder="00 00 00 00">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var $j = jQuery.noConflict();

    $j(document).ready(function() {
        // Initialisation Select2
        $j('.select2-modal').select2({
            dropdownParent: $j('#modalSaisieExcel'),
            placeholder: "Rechercher...",
            width: '100%'
        });

        // Script Auto-sélection
        $j('#agent_remplace_select').on('select2:select', function (e) {
            var element = $j(e.params.data.element);
            var siteAssocie = element.data('site');
            if (siteAssocie) {
                $j('#poste_nom_select').val(siteAssocie.toString().trim()).trigger('change');
            }
        });
    });

    // Fonction de suppression avec le texte restauré
    function forcerSuppression(id) {
        Swal.fire({
            title: 'Voulez-vous vraiment supprimer cette ligne ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            background: '#1a1a1a',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

<style>
    @media (min-width: 992px) { .col-lg-1-7 { width: 14.28%; flex: 0 0 14.28%; } }
    .glass-btn {
        background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 8px 4px; color: white; text-decoration: none !important; transition: 0.3s; height: 80px;
    }
    .category-text {
        font-weight: bold; font-size: 0.52rem; text-transform: uppercase;
        color: rgba(255,255,255,0.8); text-align: center;
    }
    .active-folder { background: rgba(0, 210, 255, 0.1) !important; border: 2px solid #00d2ff !important; }
    .select2-container--default .select2-selection--single {
        border: 2px solid #dee2e6 !important; height: 45px !important; border-radius: 10px !important; padding-top: 8px !important;
    }
</style>
@endsection
