@extends('layouts.admin')

@section('content_header_title', 'Journal des Appels')
@section('content_header_subtitle', 'Pointages téléphoniques des agents')

@section('content')

{{-- Header avec Recherche --}}
<div class="glass-card rounded-2xl p-6 mb-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <h3 class="text-2xl font-black text-gray-900">
            <i class="ph-bold ph-phone-call text-green-600 mr-2"></i>
            Journal des Appels
        </h3>

        <div class="flex items-center gap-3">
            <a href="{{ route('appels.create') }}"
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
                <i class="ph-bold ph-plus-circle mr-2 text-xl"></i>
                Nouveau Pointage
            </a>
        </div>
    </div>
</div>

{{-- Table des Appels --}}
<div class="glass-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-900 text-white">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide">Agent</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide">Date d'appel</th>
                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wide">Présent</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide">Commentaire</th>
                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($appels as $appel)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <i class="ph-bold ph-user-circle text-blue-600 text-2xl mr-3"></i>
                            <span class="font-bold text-gray-900">{{ $appel->agent->nom ?? '—' }} {{ $appel->agent->prenom ?? '' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-700 font-medium">{{ \Carbon\Carbon::parse($appel->date_appel)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($appel->present)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border-2 border-green-300">
                            <i class="ph-bold ph-check-circle mr-1"></i>
                            OUI
                        </span>
                        @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border-2 border-red-300">
                            <i class="ph-bold ph-x-circle mr-1"></i>
                            NON
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-600 font-medium text-sm">{{ Str::limit($appel->commentaire ?? 'Aucun commentaire', 50) }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('appels.edit', $appel->id) }}"
                               class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors">
                                <i class="ph-bold ph-pencil-simple text-xl"></i>
                            </a>

                            <form action="{{ route('appels.destroy', $appel->id) }}" method="POST" id="delete-form-{{ $appel->id }}" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                            <button type="button" onclick="confirmDelete({{ $appel->id }})"
                                    class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                                <i class="ph-bold ph-trash text-xl"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <i class="ph-bold ph-phone-x text-gray-400 text-6xl mb-4"></i>
                        <p class="text-gray-600 font-medium">Aucun appel enregistré</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if(method_exists($appels, 'hasPages') && $appels->hasPages())
<div class="mt-8 flex justify-center">
    {{ $appels->links() }}
</div>
@endif

@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Supprimer ce Pointage ?',
            html: '<p class="text-gray-600 font-medium">Cette donnée sera retirée du journal des appels.</p>',
            icon: 'warning',
            iconColor: '#f59e0b',
            showCancelButton: true,
            confirmButtonText: '<i class="ph-bold ph-trash mr-2"></i>Oui, supprimer',
            cancelButtonText: '<i class="ph-bold ph-x mr-2"></i>Annuler',
            background: '#ffffff',
            color: '#111827',
            customClass: {
                popup: 'rounded-3xl shadow-2xl border-2 border-gray-200',
                title: 'text-2xl font-black text-gray-900 pt-6',
                htmlContainer: 'text-gray-600',
                confirmButton: 'px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 mx-2',
                cancelButton: 'px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all mx-2'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'animate__animated animate__fadeInDown animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
