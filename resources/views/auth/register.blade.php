<x-guest-layout>
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
            url("{{ asset('images/Vig.jpeg') }}") no-repeat center center fixed !important;
            background-size: cover !important;
            height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0;
        }
        .bubble {
            background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 40px;
            padding: 40px; width: 100%; max-width: 400px; color: white; text-align: center;
        }
        .input-line {
            background: rgba(255, 255, 255, 0.1) !important; border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 15px !important; color: white !important; padding: 12px 20px !important;
            width: 100%; margin-bottom: 15px; outline: none;
        }
        .btn-vig {
            background: #007bff !important; border: none; border-radius: 30px;
            padding: 12px 40px; font-weight: bold; color: white; width: 100%; cursor: pointer;
        }
    </style>

    <div class="bubble">
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 5px;">VIGILANCE COS</h1>
        <p style="text-transform: uppercase; font-size: 0.7rem; letter-spacing: 2px; opacity: 0.8; margin-bottom: 30px;">Création de Profil</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" class="input-line" placeholder="Nom Complet" value="{{ old('name') }}" required>
            <input type="email" name="email" class="input-line" placeholder="Email" value="{{ old('email') }}" required>

            <select name="role" class="input-line" required>
                <option value="" disabled selected style="color: black;">Choisir le statut</option>
                <option value="responsable" style="color: black;">Responsable COS</option>
                <option value="agent" style="color: black;">Agent COS</option>
            </select>

            <input type="password" name="password" class="input-line" placeholder="Mot de passe" required>
            <input type="password" name="password_confirmation" class="input-line" placeholder="Confirmer mot de passe" required>

            <button type="submit" class="btn-vig">S'ENREGISTRER</button>

            <div style="margin-top: 20px;">
                <a href="{{ route('login') }}" style="color: rgba(255,255,255,0.7); font-size: 0.8rem; text-decoration: none;">Déjà inscrit ? Se connecter</a>
            </div>
        </form>
    </div>
</x-guest-layout>
