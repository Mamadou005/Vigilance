<!DOCTYPE html>
<html lang="fr">
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
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Glass Effect Enhanced - Plus Clair */
        .glass-auth {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        /* Animated Background - Plus Lumineux */
        .auth-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #dbeafe 100%);
            position: relative;
            overflow: hidden;
        }

        .auth-bg::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.15) 0%, transparent 70%);
            top: -300px;
            right: -300px;
            animation: float 25s ease-in-out infinite;
        }

        .auth-bg::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, transparent 70%);
            bottom: -250px;
            left: -250px;
            animation: float 20s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(40px, -60px) rotate(120deg); }
            66% { transform: translate(-30px, 30px) rotate(240deg); }
        }

        /* Decorative Shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.08;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            top: 10%;
            left: 5%;
            animation: float 30s ease-in-out infinite;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #06b6d4, #0ea5e9);
            bottom: 15%;
            right: 10%;
            animation: float 25s ease-in-out infinite reverse;
        }

        /* Grid Pattern Overlay - Plus Subtil */
        .grid-pattern {
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.05) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Particles - Plus Visibles */
        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.5); }
        }

        /* Smooth Transitions */
        * { transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); }
    </style>

    @stack('styles')
</head>
<body class="antialiased font-sans">
    <div class="auth-bg grid-pattern min-h-screen flex items-center justify-center p-4 relative">
        <!-- Decorative Shapes -->
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>

        <!-- Particles Effect - Plus Colorés -->
        <div class="absolute inset-0 opacity-60 pointer-events-none">
            @for($i = 0; $i < 15; $i++)
                @php
                    $colors = ['#3b82f6', '#06b6d4', '#8b5cf6', '#0ea5e9', '#6366f1'];
                    $color = $colors[array_rand($colors)];
                @endphp
                <div class="absolute w-2 h-2 rounded-full"
                     style="background: {{ $color }}; left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation: twinkle {{ rand(3, 7) }}s ease-in-out infinite {{ rand(0, 4) }}s;"></div>
            @endfor
        </div>

        <!-- Main Content -->
        <div class="w-full max-w-6xl relative z-10">
            {{ $slot }}
        </div>
    </div>

    @stack('scripts')
</body>
</html>
