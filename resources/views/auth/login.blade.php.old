<x-guest-layout>
    <style>
        /* Configuration du fond immersif */
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
            url("{{ asset('images/Vig.jpeg') }}") no-repeat center center fixed !important;
            background-size: cover !important;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Source Sans Pro', sans-serif;
        }

        /* La bulle compacte et transparente */
        .glass-container {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 45px;
            padding: 40px 50px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            text-align: center;
            color: white;
        }

        /* Alertes de succès stylisées */
        .alert-custom {
            background: rgba(40, 167, 69, 0.25);
            border: 1px solid rgba(40, 167, 69, 0.4);
            color: #afffb3;
            padding: 12px;
            border-radius: 15px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }

        .brand-name {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.8);
            margin-bottom: 5px;
        }

        /* Champs de saisie */
        .custom-input {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            border-radius: 18px !important;
            color: white !important;
            padding: 14px 20px !important;
            margin-bottom: 18px;
            width: 100%;
            outline: none;
        }

        .custom-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Footer du formulaire */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            margin-bottom: 25px;
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-vigilus {
            background: #007bff !important;
            border: none !important;
            border-radius: 35px !important;
            padding: 12px 0 !important;
            width: 100%;
            font-weight: bold !important;
            color: white !important;
            text-transform: uppercase;
            box-shadow: 0 10px 20px rgba(0, 123, 255, 0.3);
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-vigilus:hover {
            transform: translateY(-2px);
            background: #0056b3 !important;
        }
    </style>

    <div class="glass-container">
        @if (session('status') || session('success'))
        <div class="alert-custom">
            <i class="ph ph-check-circle me-1"></i>
            {{ session('status') ?? session('success') }}
        </div>
        @endif

        <div class="mb-5">
            <h1 class="brand-name">VIGILANCE COS</h1>
            <p class="text-xs tracking-widest opacity-75 uppercase">Accès Superviseur</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input id="email" type="email" name="email" class="custom-input"
                   placeholder="Saisissez votre email" required autofocus>

            <input id="password" type="password" name="password" class="custom-input"
                   placeholder="Saisissez votre mot de passe" required>

            <div class="form-footer">
                <label class="flex items-center cursor-pointer mb-0">
                    <input type="checkbox" name="remember" class="rounded bg-white/10 border-white/20 text-blue-600 focus:ring-0 mr-2">
                    Se souvenir
                </label>

                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-white opacity-75 text-decoration-none">Oublié ?</a>
                @endif
            </div>

            <button type="submit" class="btn-vigilus">
                Connexion
            </button>
        </form>

        <div class="mt-4">
            <a href="{{ route('register') }}" class="text-xs text-gray-400 hover:text-white underline text-decoration-none">
                Créer un nouveau compte COS
            </a>
        </div>
    </div>
</x-guest-layout>
