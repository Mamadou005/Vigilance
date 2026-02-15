@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center py-4">
    <div class="glass-card p-4 shadow-lg" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(25px); border-radius: 35px; border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 600px; color: white;">

        <div class="d-flex align-items-center mb-4">
            <a href="javascript:history.back()" class="btn btn-link text-white p-0 me-3"><i class="ph ph-arrow-left h4 mb-0"></i></a>
            <h4 class="fw-bold mb-0">Faction de : {{ $agent->nom }} {{ $agent->prenom }}</h4>
        </div>

        <form action="{{ route('plannings.store', $agent->id) }}" method="POST">
            @csrf
            @foreach($jours as $jour)
            <div class="row g-2 align-items-center py-2 border-bottom border-white-10">
                <div class="col-3 fw-bold text-uppercase small text-info">{{ $jour }}</div>

                <div class="col-4">
                    <select name="jours[{{ $jour }}]" class="form-select form-select-sm bg-transparent text-white border-white-25 rounded-pill">
                        <option value="F" {{ $planning && $planning->$jour == 'F' ? 'selected' : '' }} class="text-dark">Faction</option>
                        <option value="R" {{ $planning && $planning->$jour == 'R' ? 'selected' : '' }} class="text-dark">Repos</option>
                    </select>
                </div>

                <div class="col-5">
                    <select name="heures[{{ $jour }}]" class="form-select form-select-sm bg-dark text-white border-white-25 rounded-pill shadow-sm">
                        <option value="">-- Horaire --</option>
                        <option value="07h-19h" {{ $planning && $planning->{"h_$jour"} == '07h-19h' ? 'selected' : '' }}>07h-19h (J)</option>
                        <option value="19h-07h" {{ $planning && $planning->{"h_$jour"} == '19h-07h' ? 'selected' : '' }}>19h-07h (N)</option>
                        <option value="07h-15h" {{ $planning && $planning->{"h_$jour"} == '07h-15h' ? 'selected' : '' }}>07h-15h (J)</option>
                        <option value="15h-23h" {{ $planning && $planning->{"h_$jour"} == '15h-23h' ? 'selected' : '' }}>15h-23h (S)</option>
                        <option value="23h-07h" {{ $planning && $planning->{"h_$jour"} == '23h-07h' ? 'selected' : '' }}>23h-07h (N)</option>
                    </select>
                </div>
            </div>
            @endforeach

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('plannings.index') }}" class="btn btn-outline-light rounded-pill px-4">Annuler</a>
                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow">ENREGISTRER</button>
            </div>
        </form>
    </div>
</div>
@endsection
