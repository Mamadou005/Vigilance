<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'VIGILANCE-COS') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* Glass Effect */
        .glass-effect {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(148, 163, 184, 0.1);
        }

        /* Smooth Transitions */
        * { transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); }
    </style>

    @stack('styles')
</head>
<body class="antialiased bg-navy-950 text-gray-100 font-sans" x-data="{ sidebarOpen: true, mobileSidebarOpen: false }">

    <!-- Mobile Sidebar Overlay -->
    <div x-show="mobileSidebarOpen"
         x-transition.opacity
         @click="mobileSidebarOpen = false"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden">
    </div>

    <!-- Sidebar -->
    <aside
        :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed left-0 top-0 z-50 h-screen w-64 glass-effect border-r border-navy-800/50 transition-transform duration-300 ease-in-out"
        x-show="sidebarOpen || mobileSidebarOpen"
        @click.away="mobileSidebarOpen = false">

        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-navy-800/50">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center transform group-hover:scale-110 transition-transform duration-200">
                    <i class="ph-bold ph-shield-check text-white text-xl"></i>
                </div>
                <span class="text-lg font-bold tracking-tight">
                    VIGILANCE<span class="text-primary-500">-COS</span>
                </span>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-primary-500/10 text-primary-400 border-l-4 border-primary-500' : 'text-gray-400 hover:bg-navy-800/50 hover:text-white' }} transition-all duration-200 group">
                <i class="ph ph-house-line text-xl"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Section: Opérations -->
            <div class="pt-6">
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Opérations</h3>

                <a href="{{ route('agents.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('agents.*') ? 'bg-primary-500/10 text-primary-400 border-l-4 border-primary-500' : 'text-gray-400 hover:bg-navy-800/50 hover:text-white' }} transition-all duration-200 group">
                    <i class="ph ph-identification-card text-xl"></i>
                    <span class="font-medium">Agents</span>
                    @if(isset($totalAgents) && $totalAgents > 0)
                        <span class="ml-auto bg-navy-800 text-gray-300 text-xs px-2 py-1 rounded-lg">{{ $totalAgents }}</span>
                    @endif
                </a>

                <a href="{{ route('sites.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('sites.*') ? 'bg-primary-500/10 text-primary-400 border-l-4 border-primary-500' : 'text-gray-400 hover:bg-navy-800/50 hover:text-white' }} transition-all duration-200 group">
                    <i class="ph ph-bank text-xl"></i>
                    <span class="font-medium">Sites & Banques</span>
                </a>

                <a href="{{ route('alertes.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('alertes.*') ? 'bg-primary-500/10 text-primary-400 border-l-4 border-primary-500' : 'text-gray-400 hover:bg-navy-800/50 hover:text-white' }} transition-all duration-200 group">
                    <i class="ph ph-warning-octagon text-xl"></i>
                    <span class="font-medium">Alertes</span>
                    @if(isset($alertesNonTraitees) && $alertesNonTraitees > 0)
                        <span class="ml-auto bg-red-500/20 text-red-400 text-xs px-2 py-1 rounded-lg animate-pulse">{{ $alertesNonTraitees }}</span>
                    @endif
                </a>
            </div>

            <!-- Section: Planification -->
            <div class="pt-6">
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Planification</h3>

                <!-- Secteurs (Dropdown) -->
                <div x-data="{ open: {{ request()->routeIs('plannings.site') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-gray-400 hover:bg-navy-800/50 hover:text-white transition-all duration-200">
                        <div class="flex items-center space-x-3">
                            <i class="ph ph-map-trifold text-xl"></i>
                            <span class="font-medium">Secteurs</span>
                        </div>
                        <i class="ph ph-caret-right text-sm transform transition-transform duration-200" :class="open ? 'rotate-90' : ''"></i>
                    </button>

                    <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                        <a href="{{ route('plannings.site', ['secteur' => 'Secteur 1 (Ville)']) }}"
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm {{ request('secteur') == 'Secteur 1 (Ville)' ? 'text-primary-400 bg-primary-500/10' : 'text-gray-500 hover:text-gray-300' }} transition-colors">
                            <i class="ph ph-dot text-lg"></i>
                            <span>Secteur 1 (Ville)</span>
                        </a>
                        <a href="{{ route('plannings.site', ['secteur' => 'Secteur 2 (Banlieu)']) }}"
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm {{ request('secteur') == 'Secteur 2 (Banlieu)' ? 'text-primary-400 bg-primary-500/10' : 'text-gray-500 hover:text-gray-300' }} transition-colors">
                            <i class="ph ph-dot text-lg"></i>
                            <span>Secteur 2 (Banlieue)</span>
                        </a>
                        <a href="{{ route('plannings.site', ['secteur' => 'Secteur 3 (Region)']) }}"
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm {{ request('secteur') == 'Secteur 3 (Region)' ? 'text-primary-400 bg-primary-500/10' : 'text-gray-500 hover:text-gray-300' }} transition-colors">
                            <i class="ph ph-dot text-lg"></i>
                            <span>Secteur 3 (Région)</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('plannings.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('plannings.index') ? 'bg-primary-500/10 text-primary-400 border-l-4 border-primary-500' : 'text-gray-400 hover:bg-navy-800/50 hover:text-white' }} transition-all duration-200 group">
                    <i class="ph ph-calendar-check text-xl"></i>
                    <span class="font-medium">Planning</span>
                </a>

                <a href="{{ route('remplacements.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('remplacements.*') ? 'bg-primary-500/10 text-primary-400 border-l-4 border-primary-500' : 'text-gray-400 hover:bg-navy-800/50 hover:text-white' }} transition-all duration-200 group">
                    <i class="ph ph-arrows-clockwise text-xl"></i>
                    <span class="font-medium">Suivi & Relèves</span>
                </a>
            </div>
        </nav>

        <!-- User Profile (Bottom) -->
        <div class="p-4 border-t border-navy-800/50">
            <div class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-navy-800/50">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center">
                    <i class="ph-bold ph-user text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->role == 'responsable' ? 'Responsable' : 'Agent' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:ml-64 transition-all duration-300">
        <!-- Top Navigation Bar -->
        <header class="sticky top-0 z-30 glass-effect border-b border-navy-800/50">
            <div class="flex items-center justify-between h-16 px-6">
                <!-- Mobile Menu Button -->
                <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="lg:hidden text-gray-400 hover:text-white">
                    <i class="ph ph-list text-2xl"></i>
                </button>

                <!-- Page Title -->
                <div class="flex-1">
                    @yield('header')
                </div>

                <!-- Right Actions -->
                <div class="flex items-center space-x-4">
                    <!-- User Role Badge -->
                    <div class="hidden sm:flex items-center space-x-2 px-4 py-2 bg-primary-500/10 border border-primary-500/20 rounded-xl">
                        <i class="ph ph-identification-badge text-primary-400"></i>
                        <span class="text-sm font-medium text-primary-400">
                            {{ Auth::user()->role == 'responsable' ? 'RESPONSABLE COS' : 'AGENT COS' }}
                        </span>
                    </div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-xl text-sm font-medium transition-colors duration-200 border border-red-500/20">
                            <i class="ph ph-sign-out mr-2"></i>
                            <span class="hidden sm:inline">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 min-h-screen">
            @yield('content')
        </main>
    </div>

    <!-- Toast Notifications Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2"></div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    <script>
        // Toast Notification System
        function showToast(message, type = 'success') {
            const icons = {
                success: 'ph-check-circle',
                error: 'ph-x-circle',
                warning: 'ph-warning',
                info: 'ph-info'
            };

            const colors = {
                success: 'from-emerald-500 to-emerald-600',
                error: 'from-red-500 to-red-600',
                warning: 'from-yellow-500 to-yellow-600',
                info: 'from-blue-500 to-blue-600'
            };

            const toast = document.createElement('div');
            toast.className = `flex items-center space-x-3 px-4 py-3 rounded-xl bg-gradient-to-r ${colors[type]} text-white shadow-premium-lg transform transition-all duration-300 translate-x-0 animate-slide-in`;
            toast.innerHTML = `
                <i class="ph-bold ${icons[type]} text-xl"></i>
                <span class="font-medium">${message}</span>
            `;

            document.getElementById('toast-container').appendChild(toast);

            setTimeout(() => {
                toast.style.transform = 'translateX(400px)';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Laravel Session Flash Messages
        @if(session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif
        @if(session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif
        @if(session('warning'))
            showToast("{{ session('warning') }}", 'warning');
        @endif
        @if(session('info'))
            showToast("{{ session('info') }}", 'info');
        @endif
    </script>
</body>
</html>
