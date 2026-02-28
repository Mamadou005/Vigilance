<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIGILANCE-COS | Bienvenue</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            top: -400px;
            right: -400px;
            animation: float 20s ease-in-out infinite;
        }

        .hero-bg::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            bottom: -300px;
            left: -300px;
            animation: float 25s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(50px, -70px) rotate(120deg); }
            66% { transform: translate(-40px, 40px) rotate(240deg); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="antialiased">
    <div class="hero-bg min-h-screen flex items-center justify-center px-4 py-12">
        <div class="glass-card rounded-3xl shadow-2xl p-8 md:p-12 max-w-2xl w-full text-center border-2 border-white/20 relative z-10">

            {{-- Logo Icon --}}
            <div class="mb-8 flex justify-center">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-3xl flex items-center justify-center shadow-2xl transform hover:scale-110 transition-transform duration-300">
                    <i class="ph ph-shield-check text-white text-6xl" style="font-weight: bold;"></i>
                </div>
            </div>

            {{-- Title --}}
            <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-3 tracking-tight">
                VIGILANCE<span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">-COS</span>
            </h1>

            {{-- Subtitle --}}
            <p class="text-xl md:text-2xl text-gray-600 font-bold mb-4">
                Unité de Contrôle Opérationnel
            </p>

            <div class="flex items-center justify-center gap-2 mb-8">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Sécurité 24/7</p>
            </div>

            {{-- Divider --}}
            <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-indigo-600 mx-auto mb-8 rounded-full"></div>

            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                <a href="{{ url('/dashboard') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-lg rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105">
                    <i class="ph ph-house-line mr-2 text-xl" style="font-weight: bold;"></i>
                    Accéder au Dashboard
                </a>
                @else
                <a href="{{ route('login') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-lg rounded-xl shadow-xl hover:shadow-2xl transition-all hover:scale-105">
                    <i class="ph ph-sign-in mr-2 text-xl" style="font-weight: bold;"></i>
                    Connexion
                </a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-white border-2 border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-700 font-bold text-lg rounded-xl transition-all hover:scale-105">
                    <i class="ph ph-user-plus mr-2 text-xl" style="font-weight: bold;"></i>
                    Créer un compte
                </a>
                @endif
                @endauth
            </div>

            {{-- Features --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12 pt-8 border-t-2 border-gray-200">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="ph ph-clock text-blue-600 text-2xl" style="font-weight: bold;"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Disponibilité 24/7</h3>
                    <p class="text-sm text-gray-600">Surveillance continue</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="ph ph-shield-check text-green-600 text-2xl" style="font-weight: bold;"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Sécurité Maximale</h3>
                    <p class="text-sm text-gray-600">Protection renforcée</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="ph ph-users-three text-purple-600 text-2xl" style="font-weight: bold;"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Équipe Professionnelle</h3>
                    <p class="text-sm text-gray-600">Agents qualifiés</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
