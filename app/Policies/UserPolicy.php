<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Tous les utilisateurs authentifiés peuvent voir la liste
        return true;
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Tous les utilisateurs authentifiés peuvent voir les détails
        return true;
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        // Seulement les admins peuvent créer
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Seulement les admins peuvent modifier
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Seulement les admins peuvent supprimer (sauf eux-mêmes)
        return $user->role === 'admin' && $user->id !== $model->id;
    }
}
