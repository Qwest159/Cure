<?php

namespace App\Policies;


use App\Models\User;
use Illuminate\Auth\Access\Response;

class CurePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->admin === 1;
    }

    /**
     * Determine whether the user can view the model.
     */
    // public function view(User $user, Article $article): bool
    // {
    //     return false;
    // }

    /**
     * Determine whether the user can create models.
     */
    // public function create(User $user): bool
    // {
    //     return $user->role->name === \App\Models\Role::AUTHOR || $user->role->name === \App\Models\Role::ADMIN;
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update(User $user, Article $article): bool
    // {
    //     return $user->id === $article->user_id  || $user->role->name === \App\Models\Role::ADMIN;
    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    public function delete(User $user): bool
    {
        return $user->admin === 1;
    }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(User $user, Article $article): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Article $article): bool
    // {
    //     return false;
    // }
}
