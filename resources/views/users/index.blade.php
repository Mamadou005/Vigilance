@extends('layouts.admin')

@section('content_header_title', 'Gestion des Utilisateurs')
@section('content_header_subtitle', 'Liste complète des utilisateurs du système')

@section('content')

{{-- Header avec Bouton Ajouter (visible seulement pour les admins) --}}
<div class="glass-card rounded-2xl p-6 mb-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="ph-bold ph-identification-card text-white text-2xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-gray-100">
                    Utilisateurs
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">{{ $users->count() }} utilisateur(s)</p>
            </div>
        </div>

        @can('create', App\Models\User::class)
        <a href="{{ route('users.create') }}"
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
            <i class="ph-bold ph-plus-circle mr-2 text-xl"></i>
            Nouvel Utilisateur
        </a>
        @endcan
    </div>
</div>

{{-- Tableau des Utilisateurs --}}
<div class="glass-card rounded-2xl overflow-hidden shadow-xl">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-900 p-4">
        <h4 class="text-lg font-black text-white flex items-center">
            <i class="ph-bold ph-table text-indigo-400 mr-2 text-2xl"></i>
            Liste des Utilisateurs
        </h4>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                <tr class="text-center font-black uppercase">
                    <th class="px-4 py-3 text-left border-r border-gray-200 dark:border-gray-600">Nom</th>
                    <th class="px-3 py-3 border-r border-gray-200 dark:border-gray-600">Email</th>
                    <th class="px-3 py-3 border-r border-gray-200 dark:border-gray-600">Rôle</th>
                    <th class="px-3 py-3 border-r border-gray-200 dark:border-gray-600">Créé le</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <td class="px-4 py-3 font-bold text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-600">
                        <div class="flex items-center gap-2">
                            <i class="ph-bold ph-user-circle text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                            {{ $user->name }}
                        </div>
                    </td>
                    <td class="px-3 py-3 text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600 text-center">
                        {{ $user->email }}
                    </td>
                    <td class="px-3 py-3 text-center border-r border-gray-200 dark:border-gray-600">
                        @if($user->role === 'admin')
                        <span class="inline-flex items-center px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-full text-xs font-bold">
                            <i class="ph-bold ph-crown mr-1"></i> ADMIN
                        </span>
                        @elseif($user->role === 'responsable')
                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-full text-xs font-bold">
                            <i class="ph-bold ph-user-check mr-1"></i> RESPONSABLE
                        </span>
                        @else
                        <span class="inline-flex items-center px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-400 rounded-full text-xs font-bold">
                            <i class="ph-bold ph-user mr-1"></i> AGENT
                        </span>
                        @endif
                    </td>
                    <td class="px-3 py-3 text-center text-gray-600 dark:text-gray-400 font-medium border-r border-gray-200 dark:border-gray-600">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            @can('update', $user)
                            <a href="{{ route('users.edit', $user) }}"
                               class="p-2 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-lg transition-colors">
                                <i class="ph-bold ph-pencil text-lg"></i>
                            </a>
                            @endcan

                            @can('delete', $user)
                            <button type="button"
                                    onclick="confirmDelete({{ $user->id }})"
                                    class="p-2 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 rounded-lg transition-colors">
                                <i class="ph-bold ph-trash text-lg"></i>
                            </button>
                            <form action="{{ route('users.destroy', $user) }}"
                                  method="POST"
                                  id="delete-form-{{ $user->id }}"
                                  class="hidden">
                                @csrf @method('DELETE')
                            </form>
                            @endcan

                            @cannot('update', $user)
                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-500 rounded-lg text-xs font-bold">
                                Lecture seule
                            </span>
                            @endcannot
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <i class="ph-bold ph-user-circle-slash text-gray-400 dark:text-gray-600 text-6xl mb-4"></i>
                        <p class="text-gray-600 dark:text-gray-400 font-medium">Aucun utilisateur trouvé.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Supprimer cet utilisateur ?',
            html: '<p class="text-gray-600 font-medium">Cette action est irréversible !</p>',
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
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
