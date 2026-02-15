@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- 1. BARRE DE RECHERCHE ET ACTIONS --}}
    <div class="glass-card p-4 mb-5 border-0 shadow-lg" style="background: rgba(255,255,255,0.1) !important; backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.15) !important;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="fw-bold text-white mb-0">
                    <i class="ph ph-calendar-blank me-2 text-info"></i>
                    {{ $nomSecteur ?? 'Planning Global' }}
                </h2>
            </div>
            <div class="col-md-6">
                <form action="{{ route('plannings.index') }}" method="GET" class="d-flex bg-white-10 rounded-pill p-1">
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control border-0 bg-transparent text-white px-3" placeholder="Trouver un site ou un agent...">
                    <button type="submit" class="btn btn-info rounded-pill px-4 fw-bold shadow-sm">RECHERCHER</button>
                </form>
            </div>
        </div>
    </div>

    {{-- 2. LISTE DES SITES --}}
    <div class="row g-4">
        @forelse($sites as $site)
        <div class="col-12">
            {{-- ENTÊTE DU SITE (AJOUT DU DATA-BS-TOGGLE POUR LE PLIAGE) --}}
            <div class="glass-card p-3 d-flex justify-content-between align-items-center mb-2"
                 style="cursor: pointer; background: rgba(255,255,255,0.08);"
                 data-bs-toggle="collapse"
                 data-bs-target="#site-collapse-{{ $site->id }}" {{-- Correction : data-bs-target au lieu de href --}}
                 aria-expanded="false">

                <div class="d-flex align-items-center">
                    <div class="p-2 bg-primary rounded-3 me-3 shadow-sm"><i class="ph ph-bank h4 mb-0 text-white"></i></div>
                    <div>
                        <h5 class="fw-bold mb-0 text-white">{{ $site->nom }}</h5>
                        <div class="d-flex gap-3 align-items-center">
                            <small class="text-info fw-bold"><i class="ph ph-map-pin me-1"></i>{{ $site->secteur }}</small>
                            <div class="d-flex align-items-center bg-white-5 px-2 py-1 rounded-pill border border-white-10"
                                 data-bs-toggle="modal" data-bs-target="#modalRPE{{ $site->id }}"
                                 onclick="event.stopPropagation();">
                                <small class="text-warning fw-bold" style="cursor: pointer;">
                                    <i class="ph ph-phone-call me-1"></i> RPE: {{ $site->telephone ?? 'À renseigner' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-dark rounded-pill me-3 px-3 border border-white-10">{{ $site->agents->count() }} Agents</span>
                    <i class="ph ph-caret-down text-white opacity-50 transition-icon"></i>
                </div>
            </div>

            {{-- MODALE RPE (Conservée) --}}
            <div class="modal fade text-dark" id="modalRPE{{ $site->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 20px;">
                        <div class="modal-header border-0">
                            <h5 class="fw-bold">Contact RPE - {{ $site->nom }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            <i class="ph ph-phone-call display-1 text-primary mb-3"></i>
                            <h3 class="fw-bold">{{ $site->telephone ?? 'Non renseigné' }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ZONE COLLAPSE --}}
            <div class="collapse {{ (isset($nomSecteur) || isset($search)) ? 'show' : '' }}" id="site-collapse-{{ $site->id }}">
                <div class="row g-3 p-3 bg-white-5 rounded-4 mb-4">
                    @foreach($site->agents as $agent)
                    <div class="col-md-6 col-xl-4">
                        <div class="glass-card p-4 h-100 border-0 shadow-sm" style="background: rgba(0,0,0,0.4); border-radius: 25px;">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="ph ph-user-circle h2 mb-0 me-2 text-primary"></i>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-white">{{ $agent->nom }} {{ $agent->prenom }}</h6>
                                        <small class="text-white-50 fw-bold"><i class="ph ph-phone me-1"></i>{{ $agent->telephone ?? 'Aucun numéro' }}</small>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('plannings.create', $agent->id) }}" class="btn btn-outline-info btn-xs rounded-pill px-2 border-0" style="background: rgba(0, 210, 255, 0.1);">
                                        <i class="ph ph-calendar-plus h5 mb-0"></i>
                                    </a>
                                    @if($agent->planning)
                                    <form action="{{ route('plannings.destroy', $agent->planning->id) }}" method="POST" id="delete-form-{{ $agent->planning->id }}" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button type="button" class="btn btn-outline-danger btn-xs rounded-pill px-2 border-0 delete-btn" data-id="{{ $agent->planning->id }}" style="background: rgba(220, 53, 69, 0.1);">
                                        <i class="ph ph-trash h5 mb-0"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>

                            @if($agent->planning)
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered border-white-10 text-white text-center mb-0" style="font-size: 0.7rem;">
                                    <thead class="opacity-50"><tr><th>L</th><th>M</th><th>M</th><th>J</th><th>V</th><th>S</th><th>D</th></tr></thead>
                                    <tbody>
                                    <tr>
                                        @foreach(['lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche'] as $j)
                                        @php $h = "h_$j"; @endphp
                                        <td>
                                            @if($agent->planning->$j == 'F')
                                            <span class="fw-bold text-info">F</span><br>
                                            <span class="text-info fw-bold" style="font-size: 0.55rem;">{{ $agent->planning->$h }}</span>
                                            @else
                                            <span class="fw-bold text-danger">R</span><br>
                                            <span class="text-white-50" style="font-size: 0.55rem;">Repos</span>
                                            @endif
                                        </td>
                                        @endforeach
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-2">
                                <a href="{{ route('plannings.create', $agent->id) }}" class="btn btn-sm btn-link text-info text-decoration-none p-0 italic" style="font-size: 0.75rem;">
                                    <i class="ph ph-plus-circle me-1"></i> Générer un planning
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-white opacity-50"><i class="ph ph-magnifying-glass display-1"></i><p class="mt-3">Aucun site trouvé.</p></div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    // Script de suppression
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Supprimer le planning ?',
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

    // Animation de la flèche lors du pliage/dépliage
    $('.collapse').on('show.bs.collapse', function () {
        $(this).prev().find('.transition-icon').css('transform', 'rotate(180deg)');
    }).on('hide.bs.collapse', function () {
        $(this).prev().find('.transition-icon').css('transform', 'rotate(0deg)');
    });
</script>
@endpush

<style>
    .transition-icon { transition: transform 0.3s ease; }
    .bg-white-10 { background: rgba(255,255,255,0.1); }
    .bg-white-5 { background: rgba(255,255,255,0.05); }
    .btn-xs { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
    .italic { font-style: italic; }
</style>
@endsection
