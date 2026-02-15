@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- 1. BARRE DE RECHERCHE ET ACTIONS - VERSION TRANSPARENTE CORRIGÉE --}}
    <div class="glass-card p-3 mb-5 border-0 shadow-lg"
         style="background: rgba(255, 255, 255, 0.1) !important; backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.15) !important; border-radius: 25px;">
        <div class="row align-items-center">
            <div class="col-md-3">
                <h4 class="fw-bold mb-0 text-white"> {{-- Texte passé en blanc --}}
                    <i class="ph ph-buildings me-2 text-primary"></i> Sites & Banques
                </h4>
            </div>

            <div class="col-md-6">
                <form action="{{ route('sites.index') }}" method="GET" class="search-bar-z3-mini d-flex align-items-center">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Trouver un site...">
                    <button type="submit" class="btn btn-cyan-search-mini fw-bold text-uppercase">
                        RECHERCHER
                    </button>
                </form>
            </div>

            <div class="col-md-3 text-end">
                <a href="{{ route('sites.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                    <i class="ph ph-plus-circle me-2"></i> Nouveau Site
                </a>
            </div>
        </div>
    </div>

    {{-- 2. GRILLE DES CARTES DE SITES --}}
    <div class="row g-4">
        @forelse($sites as $site)
        <div class="col-md-6 col-lg-4">
            <div class="site-card-wrapper shadow-lg">
                {{-- Partie Haute Sombre --}}
                <div class="card-top p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box shadow-glow">
                            <i class="ph ph-bank text-info display-5"></i>
                        </div>
                        <span class="badge rounded-pill px-3 py-2" style="background: rgba(0, 210, 255, 0.15); color: #00d2ff; border: 1px solid rgba(0, 210, 255, 0.3); font-size: 0.65rem; letter-spacing: 1px;">
                            {{ strtoupper($site->secteur ?? 'Secteur Inconnu') }}
                        </span>
                    </div>

                    <h4 class="fw-bold text-white mb-1">{{ $site->nom }}</h4>
                    <p class="text-white-50 small mb-4">
                        <i class="ph ph-map-pin me-1"></i> {{ $site->adresse ?? 'Adresse non spécifiée' }}
                    </p>

                    <div class="site-stats d-flex gap-4">
                        <div class="stat-item">
                            <span class="d-block h4 fw-bold text-white mb-0">{{ $site->agents->count() }}</span>
                            <span class="text-white-50 text-uppercase fw-bold" style="font-size: 0.6rem; letter-spacing: 1px;">Agents Actifs</span>
                        </div>
                    </div>
                </div>

                {{-- Partie Basse Blanche avec Actions ALIGNÉES --}}
                <div class="card-bottom bg-white p-3 d-flex justify-content-start align-items-center" style="border-radius: 0 0 30px 30px; min-height: 70px;">
                    <div class="d-flex gap-4 align-items-center">
                        <a href="{{ route('sites.edit', $site->id) }}" class="text-dark text-decoration-none fw-bold small hover-primary">
                            <i class="ph ph-pencil-simple-line me-1"></i> Modifier
                        </a>

                        <a href="{{ route('plannings.site', ['secteur' => $site->secteur]) }}" class="text-primary text-decoration-none fw-bold small">
                            <i class="ph ph-calendar-check me-1"></i> Planning
                        </a>

                        <form action="{{ route('sites.destroy', $site->id) }}" method="POST" id="delete-form-{{ $site->id }}" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                        <a href="javascript:void(0)" class="text-danger text-decoration-none fw-bold small delete-btn" data-id="{{ $site->id }}">
                            <i class="ph ph-trash-simple me-1"></i> Supprimer
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="glass-card p-5 d-inline-block" style="background: rgba(255,255,255,0.05);">
                <i class="ph ph-buildings display-1 text-white-50"></i>
                <p class="text-white mt-3">Aucun site enregistré.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        Swal.fire({
            title: 'Confirmation de suppression',
            text: "Supprimer ce site définitivement ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Supprimer',
            cancelButtonText: 'Annuler',
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
    /* Style de la barre de recherche interne pour qu'elle ressorte sur le transparent */
    .search-bar-z3-mini {
        background: rgba(0, 0, 0, 0.5) !important;
        backdrop-filter: blur(5px);
        border-radius: 50px;
        padding: 4px 6px 4px 20px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        max-width: 420px;
        margin: 0 auto;
    }
    .search-bar-z3-mini input {
        background: transparent !important;
        border: none !important;
        color: white !important;
        box-shadow: none !important;
        font-size: 0.8rem !important;
    }
    .search-bar-z3-mini input::placeholder {
        color: rgba(255, 255, 255, 0.6) !important;
    }

    .btn-cyan-search-mini {
        background-color: #00d2ff !important;
        color: #000 !important;
        border-radius: 50px;
        padding: 6px 18px;
        font-size: 0.75rem;
        border: none;
    }

    .site-card-wrapper { border-radius: 30px; overflow: hidden; transition: 0.4s; }
    .site-card-wrapper:hover { transform: translateY(-10px); }
    .card-top { background: linear-gradient(135deg, rgba(30, 35, 45, 0.95), rgba(15, 18, 22, 0.98)); min-height: 230px; }
    .icon-box { background: rgba(0, 210, 255, 0.12); border-radius: 20px; width: 65px; height: 65px; display: flex; align-items: center; justify-content: center; }
    .hover-primary:hover { color: #00d2ff !important; }

    .delete-btn:hover {
        color: #ff4d4d !important;
        opacity: 0.8;
    }
</style>
@endsection
