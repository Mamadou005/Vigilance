<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'VIGILANCE-COS') }} - @yield('title', 'Authentification')</title>

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

        /* Glass Effect Enhanced */
        .glass-auth {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(148, 163, 184, 0.15);
        }

        /* Animated Background */
        .auth-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            position: relative;
            overflow: hidden;
        }

        .auth-bg::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%);
            top: -250px;
            right: -250px;
            animation: float 20s ease-in-out infinite;
        }

        .auth-bg::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.08) 0%, transparent 70%);
            bottom: -200px;
            left: -200px;
            animation: float 15s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -50px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        /* Grid Pattern Overlay */
        .grid-pattern {
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* Smooth Transitions */
        * { transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); }
    </style>

    @stack('styles')
</head>
<body class="antialiased font-sans">
    <div class="auth-bg grid-pattern min-h-screen flex items-center justify-center p-4 relative">
        <!-- Particles Effect (Optional) -->
        <div class="absolute inset-0 opacity-30 pointer-events-none">
            @for($i = 0; $i < 20; $i++)
                <div class="absolute w-1 h-1 bg-primary-400 rounded-full"
                     style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation: twinkle {{ rand(2, 5) }}s ease-in-out infinite {{ rand(0, 3) }}s;"></div>
            @endfor
        </div>

        <style>
            @keyframes twinkle {
                0%, 100% { opacity: 0; transform: scale(0); }
                50% { opacity: 1; transform: scale(1); }
            }
        </style>

        <!-- Main Content -->
        <div class="w-full max-w-6xl relative z-10">
            {{ $slot }}
        </div>
    </div>

    @stack('scripts')
</body>
</html>
