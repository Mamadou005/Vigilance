<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vigilance COS | Dashboard Premium</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">

    {{-- SCRIPT GLOBAL ICONES --}}
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    {{-- SweetAlert2 Theme Dark --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css">

    <style>
        :root { --glass: rgba(255, 255, 255, 0.1); --border: rgba(255, 255, 255, 0.15); }
        .app-wrapper {
            background: radial-gradient(circle at top right, rgba(0, 210, 255, 0.15), transparent),
            linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)),
            url("{{ asset('images/Vig.jpeg') }}") no-repeat center center fixed !important;
            background-size: cover !important; min-height: 100vh;
        }
        .app-sidebar { background: rgba(15, 15, 15, 0.85) !important; backdrop-filter: blur(25px); border-right: 1px solid var(--border) !important; }
        .nav-link { border-radius: 12px !important; margin: 2px 10px !important; transition: 0.3s; color: rgba(255,255,255,0.7) !important; }
        .nav-link.active { background: linear-gradient(90deg, rgba(0, 210, 255, 0.2), transparent) !important; border-left: 3px solid #00d2ff !important; color: #00d2ff !important; }
        .glass-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(15px); border: 1px solid var(--border); border-radius: 20px; }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg"> {{-- Remis la classe de ton 1er code --}}
<div class="app-wrapper">
    {{-- NAVBAR --}}
    <nav class="app-header navbar navbar-expand bg-transparent border-bottom border-white-10">
        <div class="container-fluid">
            <ul class="navbar-nav">
                {{-- Toggle sidebar remis comme ton 1er code --}}
                <li class="nav-item"> <a class="nav-link text-white" data-lte-toggle="sidebar" href="#"><i class="ph ph-list h4"></i></a> </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-3"> <span class="text-primary fw-bold small text-uppercase"><i class="ph ph-user-focus me-1"></i> {{ Auth::user()->name ?? 'Admin COS' }}</span> </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}"> @csrf <button type="submit" class="btn btn-outline-danger btn-xs rounded-pill px-3">DÉCONNEXION</button> </form>
                </li>
            </ul>
        </div>
    </nav>

    {{-- SIDEBAR --}}
    <aside class="app-sidebar bg-dark" data-bs-theme="dark">
        <div class="sidebar-brand py-4 text-center"> <a href="/" class="brand-link border-0"> <span class="brand-text fw-bold fs-4" style="letter-spacing: 2px;">VIGILANCE<span class="text-primary">-COS</span></span> </a> </div>
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                {{-- data-lte-toggle="treeview" remis ici --}}
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">
                    <li class="nav-item"> <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"> <i class="nav-icon ph ph-house-line"></i> <p>Dashboard</p> </a> </li>

                    <li class="nav-header opacity-50 small mt-3 text-white">OPÉRATIONS</li>
                    <li class="nav-item"> <a href="{{ route('agents.index') }}" class="nav-link {{ request()->routeIs('agents.*') ? 'active' : '' }}"> <i class="nav-icon ph ph-identification-card"></i> <p>Agents</p> </a> </li>
                    <li class="nav-item"> <a href="{{ route('sites.index') }}" class="nav-link {{ request()->routeIs('sites.*') ? 'active' : '' }}"> <i class="nav-icon ph ph-bank"></i> <p>Sites & Banques</p> </a> </li>
                    <li class="nav-item"> <a href="{{ route('alertes.index') }}" class="nav-link {{ request()->routeIs('alertes.*') ? 'active' : '' }}"> <i class="nav-icon ph ph-warning-octagon"></i> <p>Alertes</p> </a> </li>

                    <li class="nav-header opacity-50 small mt-3 text-white">PLANIFICATION</li>
                    {{-- MENU SECTEURS --}}
                    <li class="nav-item {{ request()->routeIs('plannings.site') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('plannings.site') ? 'active' : '' }}">
                            <i class="nav-icon ph ph-map-trifold"></i>
                            {{-- end ph ph-caret-right remis ici --}}
                            <p>Secteurs <i class="end ph ph-caret-right small"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"><a href="{{ route('plannings.site', ['secteur' => 'Secteur 1 (Ville)']) }}" class="nav-link py-1 {{ request('secteur') == 'Secteur 1 (Ville)' ? 'active' : '' }}"><i class="ph ph-dot me-2 text-info"></i> <p>Secteur 1 (Ville)</p></a></li>
                            <li class="nav-item"><a href="{{ route('plannings.site', ['secteur' => 'Secteur 2 (Banlieu)']) }}" class="nav-link py-1 {{ request('secteur') == 'Secteur 2 (Banlieu)' ? 'active' : '' }}"><i class="ph ph-dot me-2 text-info"></i> <p>Secteur 2 (Banlieue)</p></a></li>
                            <li class="nav-item"><a href="{{ route('plannings.site', ['secteur' => 'Secteur 3 (Region)']) }}" class="nav-link py-1 {{ request('secteur') == 'Secteur 3 (Region)' ? 'active' : '' }}"><i class="ph ph-dot me-2 text-info"></i> <p>Secteur 3 (Région)</p></a></li>
                        </ul>
                    </li>

                    <li class="nav-item"> <a href="{{ route('plannings.index') }}" class="nav-link {{ request()->routeIs('plannings.index') ? 'active' : '' }}"> <i class="nav-icon ph ph-calendar-check"></i> <p>Planning</p> </a> </li>
                    <li class="nav-item"> <a href="{{ route('remplacements.index') }}" class="nav-link {{ request()->routeIs('remplacements.*') ? 'active' : '' }}"> <i class="nav-icon ph ph-arrows-clockwise"></i> <p>Suivi & Relèves</p> </a> </li>
                </ul>
            </nav>
        </div>
    </aside>

    <main class="app-main p-4"> @yield('content') </main>
</div>

{{-- SCRIPTS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('scripts')

<script>
    $(document).ready(function() {
    @if(session('success'))
            Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#1a1a1a',
                color: '#fff'
            }).fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
    @endif
    });
</script>
</body>
</html>
