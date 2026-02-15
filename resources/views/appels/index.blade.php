@extends('layouts.admin')

@section('content')
<div class="glass-card p-4 shadow-lg" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-radius: 30px; border: 1px solid rgba(255,255,255,0.2); color: white;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-shadow"><i class="ph ph-phone-call me-2"></i>Journal des Appels</h1>
        <a href="{{ route('appels.create') }}" class="btn btn-primary rounded-pill px-4 shadow">
            <i class="ph ph-plus-circle me-1"></i> Nouveau Pointage
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-borderless text-white align-middle">
            <thead class="border-bottom border-white-25">
            <tr>
                <th class="py-3 ps-4">Agent</th>
                <th class="py-3">Date d'appel</th>
                <th class="py-3">Présent</th>
                <th class="py-3">Commentaire</th>
                <th class="py-3 text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($appels as $appel)
            <tr class="border-bottom border-white-10" style="--bs-border-opacity: .05;">
                <td class="py-3 ps-4 fw-bold">{{ $appel->agent->nom ?? '—' }}</td>
                <td class="opacity-75">{{ $appel->date_appel }}</td>
                <td>
                    <span class="badge rounded-pill px-3 py-2 {{ $appel->present ? 'bg-success' : 'bg-danger' }}">
                        {{ $appel->present ? 'OUI' : 'NON' }}
                    </span>
                </td>
                <td class="small italic opacity-75">{{ Str::limit($appel->commentaire, 30) }}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('appels.edit', $appel->id) }}" class="btn btn-sm btn-light rounded-circle p-2 opacity-75">
                            <i class="ph ph-pencil-simple text-dark"></i>
                        </a>

                        {{-- SUPPRESSION PREMIUM --}}
                        <form action="{{ route('appels.destroy', $appel->id) }}" method="POST" id="delete-form-{{ $appel->id }}" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                        <button type="button" class="btn btn-sm btn-danger rounded-circle p-2 opacity-75 delete-btn" data-id="{{ $appel->id }}">
                            <i class="ph ph-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Supprimer ce pointage ?',
            text: "Cette donnée sera retirée du journal.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Supprimer',
            cancelButtonText: 'Annuler',
            background: '#1a1a1a',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#delete-form-${id}`).submit();
            }
        });
    });
</script>
@endpush
@endsection
