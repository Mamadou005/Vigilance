@extends('layouts.admin')

@section('content')
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<div class="container-fluid">
    {{-- ENTÊTE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="text-white-shadow">
            <h1 class="fw-bold text-white mb-0" style="text-shadow: 2px 2px 8px rgb(0,0,0);">JOURNAL DES ALERTES</h1>
            <p class="small text-uppercase tracking-widest text-white fw-bold mb-0">
                Rapports d'incidents et interventions Brigade
            </p>
        </div>
        <a href="{{ route('alertes.create') }}" class="btn btn-danger btn-lg rounded-pill px-4 fw-bold shadow-lg border-2 border-white">
            <i class="ph ph-warning-octagon me-2"></i> NOUVEL INCIDENT
        </a>
    </div>

    {{-- TABLEAU STYLE "PRO" --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden glass-card-solid">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-dark">
                    <thead class="bg-dark text-white text-uppercase small">
                    <tr>
                        <th class="ps-4">Date</th>
                        <th>Site</th>
                        <th>Heure Incident</th>
                        <th>Nature</th>
                        <th>Arr. Brigade</th>
                        <th>Intervenant</th>
                        <th>Statut</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="fw-bold">
                    @forelse($alertes as $alerte)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $alerte->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">
                                {{ $alerte->site->nom ?? 'N/A' }}
                            </span>
                        </td>
                        <td>{{ $alerte->heure_incident ?? '--:--' }}</td>
                        <td><i class="ph ph-warning text-danger me-1"></i> {{ $alerte->type_incident }}</td>
                        <td>{{ $alerte->heure_arrivee_brigade ?? 'N/A' }}</td>
                        <td>{{ $alerte->intervenant_nom }}</td>
                        <td>
                            @php
                            $statusClass = [
                            'non_traite' => 'bg-danger-subtle text-danger',
                            'en_cours' => 'bg-warning-subtle text-warning',
                            'resolu' => 'bg-success-subtle text-success'
                            ][$alerte->statut] ?? 'bg-secondary-subtle text-secondary';
                            @endphp
                            <span class="badge {{ $statusClass }} rounded-pill px-3 text-uppercase" style="font-size: 0.7rem;">
                                {{ str_replace('_', ' ', $alerte->statut) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <a href="{{ route('alertes.show', $alerte->id) }}" class="btn-light-action btn-view" title="Voir">
                                    <i class="ph-bold ph-eye"></i>
                                </a>

                                <a href="{{ route('alertes.pdf', $alerte->id) }}" class="btn-light-action btn-pdf" title="Télécharger PDF">
                                    <i class="ph-bold ph-file-pdf text-danger"></i>
                                </a>

                                <a href="{{ route('alertes.edit', $alerte->id) }}" class="btn-light-action btn-edit" title="Modifier">
                                    <i class="ph-bold ph-pencil-simple"></i>
                                </a>

                                <button type="button" class="btn-light-action btn-delete"
                                        onclick="confirmDelete({{ $alerte->id }}, '{{ $alerte->site->nom ?? 'cette alerte' }}')"
                                        title="Supprimer">
                                    <i class="ph-bold ph-trash"></i>
                                </button>

                                <form id="delete-form-{{ $alerte->id }}" action="{{ route('alertes.destroy', $alerte->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-5 text-muted">Aucun incident enregistré.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, siteName) {
        Swal.fire({
            title: 'Supprimer ?',
            text: "Voulez-vous vraiment supprimer ce rapport pour " + siteName + " ?",
            icon: 'warning',
            iconColor: '#ff5e5e',
            showCancelButton: true,
            confirmButtonColor: '#ff5e5e',
            cancelButtonColor: '#444',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            background: '#1a1a1a',
            color: '#ffffff',
            customClass: {
                popup: 'rounded-4 border border-secondary shadow-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>

<style>
    .glass-card-solid { background: rgba(255, 255, 255, 0.95) !important; border-radius: 20px !important; }
    .table thead th { border: none; letter-spacing: 1px; font-weight: 800; padding: 15px; font-size: 0.75rem; }

    .btn-light-action {
        width: 36px !important;
        height: 36px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 10px !important;
        border: none !important;
        transition: all 0.2s ease;
        text-decoration: none !important;
        cursor: pointer;
    }

    .btn-view { background-color: #e0f7fa !important; color: #00acc1 !important; }
    .btn-pdf { background-color: #ffebee !important; color: #d32f2f !important; }
    .btn-edit { background-color: #fffde7 !important; color: #fbc02d !important; }
    .btn-delete { background-color: #ffebee !important; color: #e53935 !important; }

    .btn-light-action i { font-size: 1.25rem !important; }

    .btn-light-action:hover { transform: translateY(-3px); filter: brightness(0.95); }
    .btn-view:hover { background-color: #00acc1 !important; color: white !important; }
    .btn-pdf:hover { background-color: #d32f2f !important; color: white !important; }
    .btn-edit:hover { background-color: #fbc02d !important; color: white !important; }
    .btn-delete:hover { background-color: #e53935 !important; color: white !important; }

    .text-white-shadow { text-shadow: 2px 2px 8px rgba(0,0,0,0.5); }
</style>
@endsection
