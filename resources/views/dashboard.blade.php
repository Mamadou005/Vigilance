@extends('layouts.admin')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="text-white-shadow">
        <h1 class="fw-bold text-white mb-0" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.6);">VIGILANCE COS</h1>
        <p class="small text-uppercase tracking-widest opacity-75 mb-0">
            {{ Auth::user()->role == 'responsable' ? 'Direction & Administration' : 'Supervision COS 24h/24' }}
        </p>
    </div>
    <span class="badge bg-primary p-3 shadow-lg border border-light rounded-pill">
        <i class="ph ph-identification-badge me-2"></i>
STATUT : {{ Auth::user()->role == 'responsable' ? 'RESPONSABLE COS' : 'AGENT COS' }}
    </span>
</div>
@endsection

@section('content')

{{-- 1. SECTION NAVIGATION : LES BOUTONS-DOSSIERS --}}
<div class="row g-4 mb-5 justify-content-center">
    <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ route('agents.index') }}" class="glass-btn shadow">
            <i class="ph ph-users-four"></i><span>Agents</span>
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ route('sites.index') }}" class="glass-btn shadow border-info">
            <i class="ph ph-buildings text-info"></i><span>Sites</span>
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ route('alertes.index') }}" class="glass-btn shadow border-danger">
            <i class="ph ph-megaphone text-danger"></i><span>Alertes</span>
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ route('appels.index') }}" class="glass-btn shadow border-success">
            <i class="ph ph-phone-call text-success"></i><span>Appels</span>
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ route('plannings.index') }}" class="glass-btn shadow border-warning">
            <i class="ph ph-calendar-check text-warning"></i><span>Planning</span>
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ route('remplacements.index') }}" class="glass-btn shadow border-primary">
            <i class="ph ph-arrows-clockwise text-primary"></i><span>Relèves</span>
        </a>
    </div>
</div>

<hr class="border-white-50 mb-5">

{{-- SECTION POINTAGES & RH : ABSENCES & SUPPLÉMENTS --}}
<div class="row g-4 mb-5">
    {{-- Bloc Absences & Sanctions --}}
    <div class="col-md-6">
        <div class="glass-card p-4 border-0 shadow-lg"
             style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.85), rgba(20, 24, 28, 0.95)); border-radius: 25px;">
            <div class="d-flex justify-content-between align-items-center text-white">
                <div>
                    <h6 class="text-uppercase small fw-bold opacity-75 mb-1">Sanctions du Mois</h6>
                    <h2 class="fw-bold mb-3">{{ number_format($totalSanctions ?? 0, 0, ',', ' ') }} <small class="small">F CFA</small></h2>
                    <a href="{{ route('pointages.index', ['type' => 'absence']) }}" class="btn btn-light btn-sm rounded-pill px-4 fw-bold shadow-sm">
OUVRIR LE RAPPORT
</a>
                </div>
                <i class="ph ph-warning-octagon display-3 opacity-25 text-white"></i>
            </div>
        </div>
    </div>

    {{-- Bloc Heures Supplémentaires --}}
    <div class="col-md-6">
        <div class="glass-card p-4 border-0 shadow-lg"
             style="background: linear-gradient(135deg, rgba(0, 210, 255, 0.85), rgba(20, 24, 28, 0.95)); border-radius: 25px;">
            <div class="d-flex justify-content-between align-items-center text-white">
                <div>
                    <h6 class="text-uppercase small fw-bold opacity-75 mb-1 text-white">Heures Supplémentaires</h6>
                    <h2 class="fw-bold mb-3">{{ $nbRemplacements ?? 0 }} <small class="small">Missions</small></h2>
                    <a href="{{ route('pointages.index', ['type' => 'supplementaire']) }}" class="btn btn-light btn-sm rounded-pill px-4 fw-bold shadow-sm">
OUVRIR LE RAPPORT
</a>
                </div>
                <i class="ph ph-clock-user display-3 opacity-25 text-white"></i>
            </div>
        </div>
    </div>
</div>

{{-- 2. SECTION STATISTIQUES --}}
@if(Auth::user()->role == 'responsable')
<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="small-box p-4 mb-4 border-start border-5 border-info shadow-lg glass-card-solid">
            <div class="inner">
                <h3 class="fw-bold text-info">{{ array_sum($statsAgents) ?? '0' }}</h3>
                <p class="text-uppercase small fw-bold text-muted">Effectif Total</p>
            </div>
            <div class="icon text-info opacity-25"><i class="ph ph-users-three"></i></div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="small-box p-4 mb-4 border-start border-5 border-danger shadow-lg glass-card-solid">
            <div class="inner">
                <h3 class="fw-bold text-danger">{{ $alertesNonTraitees ?? '0' }}</h3>
                <p class="text-uppercase small fw-bold text-muted">Alertes Critiques</p>
            </div>
            <div class="icon text-danger opacity-25"><i class="ph ph-warning-octagon"></i></div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="small-box p-4 mb-4 border-start border-5 border-warning shadow-lg glass-card-solid">
            <div class="inner">
                <h3 class="fw-bold text-warning">{{ $remplacementsEnCours ?? '0' }}</h3>
                <p class="text-uppercase small fw-bold text-muted">Suivi Remplacements</p>
            </div>
            <div class="icon text-warning opacity-25"><i class="ph ph-arrows-clockwise"></i></div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-7">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden glass-card-solid">
            <div class="card-header bg-dark text-white py-3">
                <h3 class="card-title fw-bold m-0 small text-uppercase tracking-wider">
                    <i class="ph ph-map-trifold me-2 text-primary"></i>OCCUPATION PAR SECTEURS
</h3>
            </div>
            <div class="card-body p-0">
                {{-- REGROUPEMENT PAR SECTEUR RESTAURÉ --}}
                @foreach($sites->groupBy('secteur') as $secteurNom => $sitesDuSecteur)
                <div class="p-2 bg-light border-bottom d-flex justify-content-between align-items-center px-4">
                    <span class="badge bg-dark text-uppercase small px-3 rounded-pill fw-bold">
                        {{ $secteurNom ?: 'SANS SECTEUR' }}
                    </span>
                    <span class="small text-muted fw-bold">{{ $sitesDuSecteur->count() }} Sites</span>
                </div>
                <table class="table table-hover mb-0 text-dark border-bottom">
                    <tbody>
@foreach($sitesDuSecteur as $site)
                    <tr>
                        <td class="ps-4 fw-bold w-75">
                            <i class="ph ph-bank me-2 opacity-50 text-primary"></i>{{ $site->nom }}
                        </td>
                        <td class="text-center">
                                <span class="badge bg-primary rounded-pill px-3">
                                    {{ $site->agents->count() }} Agents
</span>
                        </td>
                    </tr>
@endforeach
                    </tbody>
                </table>
@endforeach
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card border-0 shadow-lg rounded-4 glass-card-solid p-4 text-dark">
            <h5 class="fw-bold text-primary mb-3"><i class="ph ph-gear-six me-2"></i>Actions Rapides</h5>
            <div class="d-grid gap-3">
                <a href="{{ route('agents.create') }}" class="btn btn-primary rounded-pill py-2 shadow-sm fw-bold">ENREGISTRER UN AGENT</a>
                <a href="{{ route('sites.create') }}" class="btn btn-outline-dark rounded-pill py-2 fw-bold">AJOUTER UN SITE</a>
            </div>
        </div>
    </div>
</div>
@else
{{-- VUE AGENT --}}
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card border-0 shadow-lg mb-4 glass-bubble-supervision">
            <div class="card-body p-5 text-white text-center">
                <i class="ph ph-shield-check mb-3 h1 text-primary"></i>
                <h2 class="fw-bold">CONSOLE DE SUPERVISION</h2>
                <div class="row g-4 mt-4">
                    <div class="col-md-6">
                        <div class="p-4 rounded-4 supervision-box">
                            <h5 class="fw-bold"><i class="ph ph-warning-octagon me-2 text-danger"></i>Alertes</h5>
                            <p class="small mb-0 opacity-75">Vérifiez les rapports de site.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 rounded-4 supervision-box">
                            <h5 class="fw-bold"><i class="ph ph-users-four me-2 text-success"></i>Effectif</h5>
                            <p class="small mb-0 opacity-75">Pointage agents 24h/24.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <a href="{{ route('alertes.create') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow fw-bold">SIGNALER UN INCIDENT</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    .glass-btn {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 25px 10px;
        color: white;
        text-decoration: none;
        transition: 0.3s;
        height: 100%;
    }
    .glass-btn:hover { background: rgba(255, 255, 255, 0.2); transform: translateY(-8px); color: white; border-color: white; }
    .glass-btn i { font-size: 2.2rem; margin-bottom: 12px; }
    .glass-btn span { font-weight: bold; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; }

    .glass-card-solid { background: rgba(255, 255, 255, 0.95) !important; border-radius: 20px !important; }
    .glass-bubble-supervision { background: rgba(255, 255, 255, 0.1) !important; backdrop-filter: blur(25px); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 45px !important; }
    .supervision-box { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); }
    .text-white-shadow { text-shadow: 2px 2px 8px rgba(0,0,0,0.5); }

    .glass-card { backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
</style>
@endsection
