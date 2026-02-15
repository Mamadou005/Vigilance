<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vigilance COS | Bienvenue</title>
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.0.2/src/css/icons.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
            url("{{ asset('images/Vig.jpeg') }}") no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Source Sans Pro', sans-serif;
        }
        .welcome-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            padding: 4rem;
            border-radius: 2rem;
            text-align: center;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }
        .btn-welcome {
            background: #007bff;
            border-radius: 50px;
            padding: 12px 40px;
            transition: 0.3s;
            font-weight: bold;
            color: white !important;
        }
        .btn-welcome:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,123,255,0.4); }
    </style>
</head>
<body>
<div class="welcome-card">
    <i class="ph ph-shield-check mb-3" style="font-size: 70px; color: #007bff;"></i>
    <h1 class="display-3 fw-bold mb-0">VIGILANCE COS</h1>
    <p class="h4 mb-5 opacity-75">Unité de Contrôle Opérationnel</p>

    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
        @auth
        <a href="{{ url('/dashboard') }}" class="btn btn-welcome btn-lg">ACCÉDER AU DASHBOARD</a>
        @else
        <a href="{{ route('login') }}" class="btn btn-welcome btn-lg px-4">CONNEXION</a>
        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 rounded-pill fw-bold" style="border-width: 2px;">CRÉER UN COMPTE</a>
        @endif
        @endauth
    </div>
</div>
</body>
</html>
