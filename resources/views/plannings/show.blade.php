@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center py-5">
    <div class="glass-card p-5 shadow-lg text-center" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border-radius: 40px; border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 600px; color: white;">
        <i class="ph ph-book-open h1 mb-3 text-info"></i>
        <h2 class="fw-bold text-shadow mb-4">Planning de {{ $agent->nom }}</h2>

        <div class="table-responsive mb-4">
            <table class="table table-bordered text-white text-center border-white-25">
                <thead class="bg-white-10 small">
                <tr>@foreach($jours as $jour) <th>{{ substr($jour, 0, 3) }}</th> @endforeach</tr>
                </thead>
                <tbody class="h4 fw-bold">
                <tr>
                    @foreach($jours as $jour)
                    @php $col = strtolower($jour); @endphp
                    <td>{{ $planning->$col ?? '—' }}</td>
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('agents.index') }}" class="btn btn-outline-light rounded-pill px-4">
                <i class="ph ph-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection
