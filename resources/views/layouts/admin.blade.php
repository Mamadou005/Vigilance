<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VIGILANCE-COS | Dashboard Premium</title>

    <!-- Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Background Animé */
        .dashboard-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #dbeafe 100%);
            position: relative;
            min-height: 100vh;
        }

        .dashboard-bg::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%);
            top: -300px;
            right: -300px;
            animation: float 25s ease-in-out infinite;
        }

        .dashboard-bg::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%);
            bottom: -250px;
            left: -250px;
            animation: float 20s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(40px, -60px) rotate(120deg); }
            66% { transform: translate(-30px, 30px) rotate(240deg); }
        }

        /* Grid Pattern */
        .grid-pattern {
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Sidebar */
        .sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        /* Glass Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        /* Smooth Transitions */
        * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Inter', sans-serif;
        }
    </style>

    @stack('styles')
</head>
<body class="antialiased" x-data="{ sidebarOpen: true }">
    <div class="dashboard-bg grid-pattern min-h-screen">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="sidebar fixed left-0 top-0 h-screen w-64 transition-transform duration-300 ease-in-out z-40 overflow-y-auto">

            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="ph-bold ph-shield-check text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-black text-gray-900 tracking-tight">
                            VIGILANCE<span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">-COS</span>
                        </h1>
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Sécurité 24/7</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all group">
                    <i class="ph-bold ph-house-line text-xl"></i>
                    <span class="font-bold text-sm">Dashboard</span>
                </a>

                <!-- Section Header -->
                <div class="pt-4 pb-2 px-4">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-wider">Opérations</p>
                </div>

                <!-- Agents -->
                <a href="{{ route('agents.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('agents.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all group">
                    <i class="ph-bold ph-identification-card text-xl"></i>
                    <span class="font-bold text-sm">Agents</span>
                </a>

                <!-- Sites -->
                <a href="{{ route('sites.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('sites.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all group">
                    <i class="ph-bold ph-bank text-xl"></i>
                    <span class="font-bold text-sm">Sites & Banques</span>
                </a>

                <!-- Alertes -->
                <a href="{{ route('alertes.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('alertes.*') ? 'bg-gradient-to-r from-red-50 to-orange-50 border-2 border-red-200 text-red-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all group">
                    <i class="ph-bold ph-warning-octagon text-xl"></i>
                    <span class="font-bold text-sm">Alertes</span>
                    @if(isset($alertesNonTraitees) && $alertesNonTraitees > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $alertesNonTraitees }}</span>
                    @endif
                </a>

                <!-- Section Header -->
                <div class="pt-4 pb-2 px-4">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-wider">Planification</p>
                </div>

                <!-- Secteurs (Dropdown) -->
                <div x-data="{ open: {{ request()->routeIs('plannings.site') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl {{ request()->routeIs('plannings.site') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all group">
                        <div class="flex items-center space-x-3">
                            <i class="ph-bold ph-map-trifold text-xl"></i>
                            <span class="font-bold text-sm">Secteurs</span>
                        </div>
                        <i :class="open ? 'rotate-90' : ''" class="ph-bold ph-caret-right text-sm transition-transform"></i>
                    </button>
                    <div x-show="open" x-collapse class="ml-4 mt-2 space-y-1">
                        <a href="{{ route('plannings.site', ['secteur' => 'Secteur 1 (Ville)']) }}"
                           class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-700 text-sm font-medium transition-all">
                            <i class="ph-fill ph-circle text-xs text-blue-400"></i>
                            <span>Secteur 1 (Ville)</span>
                        </a>
                        <a href="{{ route('plannings.site', ['secteur' => 'Secteur 2 (Banlieu)']) }}"
                           class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-700 text-sm font-medium transition-all">
                            <i class="ph-fill ph-circle text-xs text-blue-400"></i>
                            <span>Secteur 2 (Banlieue)</span>
                        </a>
                        <a href="{{ route('plannings.site', ['secteur' => 'Secteur 3 (Region)']) }}"
                           class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-700 text-sm font-medium transition-all">
                            <i class="ph-fill ph-circle text-xs text-blue-400"></i>
                            <span>Secteur 3 (Région)</span>
                        </a>
                    </div>
                </div>

                <!-- Planning -->
                <a href="{{ route('plannings.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('plannings.index') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all group">
                    <i class="ph-bold ph-calendar-check text-xl"></i>
                    <span class="font-bold text-sm">Planning</span>
                </a>

                <!-- Relèves -->
                <a href="{{ route('remplacements.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('remplacements.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all group">
                    <i class="ph-bold ph-arrows-clockwise text-xl"></i>
                    <span class="font-bold text-sm">Suivi & Relèves</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div :class="sidebarOpen ? 'ml-64' : 'ml-0'" class="transition-all duration-300">
            <!-- Top Navbar -->
            <nav class="navbar sticky top-0 z-30">
                <div class="px-6 py-4 flex items-center justify-between">
                    <!-- Left Side -->
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen"
                                class="p-2 rounded-xl hover:bg-gray-100 transition-colors">
                            <i class="ph-bold ph-list text-gray-700 text-2xl"></i>
                        </button>
                        <div>
                            <h2 class="text-xl font-black text-gray-900">@yield('content_header_title', 'Dashboard')</h2>
                            <p class="text-sm text-gray-500 font-medium">@yield('content_header_subtitle', 'Bienvenue sur VIGILANCE-COS')</p>
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center space-x-4">
                        <!-- User Info -->
                        <div class="flex items-center space-x-3 px-4 py-2 bg-blue-50 rounded-xl border-2 border-blue-200">
                            <i class="ph-bold ph-user-circle text-blue-600 text-2xl"></i>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name ?? 'Admin COS' }}</p>
                                <p class="text-xs text-blue-600 font-medium uppercase">{{ Auth::user()->role == 'responsable' ? 'Responsable' : 'Agent' }}</p>
                            </div>
                        </div>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold text-sm rounded-xl transition-all shadow-lg hover:shadow-xl">
                                <i class="ph-bold ph-sign-out mr-2"></i>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="p-6 relative z-10">
                @yield('content_header')
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    <script>
        $(document).ready(function() {
            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: 'success',
                    title: "{{ session('success') }}",
                    background: '#fff',
                    color: '#1f2937',
                    iconColor: '#10b981'
                });
            @endif
        });
    </script>
</body>
</html>
