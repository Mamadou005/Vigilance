<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport #{{ $alerte->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .section { margin-bottom: 20px; }
        .section-title { font-weight: bold; text-transform: uppercase; background: #eee; padding: 5px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        .label { font-weight: bold; color: #555; }
        .observations { background: #f9f9f9; padding: 15px; border: 1px solid #ddd; white-space: pre-line; }
    </style>
</head>
<body>
<div class="header">
    <h1>VIGILANCE-COS</h1>
    <h3>RAPPORT D'INTERVENTION #{{ $alerte->id }}</h3>
    <p>Date d'émission: {{ $alerte->created_at->format('d/m/Y H:i') }}</p>
</div>

<div class="section">
    <div class="section-title">Localisation & Chronologie</div>
    <table>
        <tr><td class="label">Site:</td><td>{{ $alerte->site->nom }}</td></tr>
        <tr><td class="label">Heure Incident:</td><td>{{ $alerte->heure_incident }}</td></tr>
        <tr><td class="label">Heure Arrivée Brigade:</td><td>{{ $alerte->heure_arrivee_brigade }}</td></tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Nature & Intervention</div>
    <table>
        <tr><td class="label">Incident:</td><td>{{ $alerte->type_incident }}</td></tr>
        <tr><td class="label">Intervenant COS:</td><td>{{ $alerte->intervenant_nom }}</td></tr>
        <tr><td class="label">Statut:</td><td>{{ strtoupper($alerte->statut) }}</td></tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Observations</div>
    <div class="observations">
        {{ $alerte->observations ?: 'N/A' }}
    </div>
</div>
</body>
</html>
