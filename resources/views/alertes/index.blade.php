@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- ENTÊTE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="text-white-shadow">
            <h1 class="fw-bold text-white mb-0" style="text-shadow: 2px 2px 8px rgb(0,0,0);">JOURNAL DES ALERTES</h1>
            <p class="small text-uppercase tracking-widest text-white fw-bold mb-0" style="opacity: 1 !important;">
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
                            'non_traite' => 'bg-danger',
                            'en_cours' => 'bg-warning',
                            'resolu' => 'bg-success'
                            ][$alerte->statut] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $statusClass }} rounded-pill px-3 text-uppercase" style="font-size: 0.7rem;">
                                {{ str_replace('_', ' ', $alerte->statut) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                {{-- BOUTON VOIR --}}
                                <a href="{{ route('alertes.show', $alerte->id) }}" class="btn btn-custom-action btn-show" title="Voir">
                                    <i class="ph ph-eye"></i>
                                </a>

                                {{-- BOUTON MODIFIER --}}
                                <a href="{{ route('alertes.edit', $alerte->id) }}" class="btn btn-custom-action btn-edit" title="Modifier">
                                    <i class="ph ph-pencil-simple"></i>
                                </a>

                                {{-- BOUTON SUPPRIMER HARMONISÉ --}}
                                <button type="button" class="btn btn-custom-action btn-delete"
                                        onclick="confirmDelete({{ $alerte->id }}, '{{ $alerte->site->nom ?? 'cette alerte' }}')"
                                        title="Supprimer">
                                    <i class="ph ph-trash"></i>
                                </button>

                                {{-- Formulaire caché pour la suppression --}}
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

{{-- SCRIPT POUR LA FENÊTRE DE CONFIRMATION --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, siteName) {
        Swal.fire({
            title: 'Confirmation de suppression',
            text: "Supprimer ce rapport pour " + siteName + " définitivement ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Supprimer',
            cancelButtonText: 'Annuler',
            background: '#1a1a1a',
            color: '#ffffff',
            customClass: {
                popup: 'rounded-4 shadow-lg border border-secondary'
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
    .table thead th { border: none; letter-spacing: 1px; font-weight: 800; padding: 15px; }

    /* BOUTONS D'ACTIONS MINI ET DISCRETS */
    .btn-custom-action {
        width: 24px !important;
        height: 24px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 50% !important;
        padding: 0 !important;
        background-color: transparent !important;
        border: 1px solid #dee2e6 !important;
        color: #adb5bd !important;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-custom-action i { font-size: 0.85rem !important; }

    /* EFFETS HOVER PAR BOUTON */
    .btn-show:hover { background-color: #0dcaf0 !important; border-color: #0dcaf0 !important; color: white !important; }
    .btn-edit:hover { background-color: #ffc107 !important; border-color: #ffc107 !important; color: black !important; }
    .btn-delete:hover { background-color: #dc3545 !important; border-color: #dc3545 !important; color: white !important; }

    .text-white-shadow { text-shadow: 2px 2px 8px rgba(0,0,0,0.5); }
</style>
@endsection
