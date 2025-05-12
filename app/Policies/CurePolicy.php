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
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->admin === 1;
    }

    public function store(User $user): bool
    {
        return  $user->admin === 1;
    }
    public function edit(User $user): bool
    {
        return  $user->admin === 1;
    }
    // /**
    //  * Determine whether the user can update the model.
    //  */
    public function update(User $user): bool
    {
        return  $user->admin === 1;
    }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    public function destroy(User $user): bool
    {
        return $user->admin === 1;
    }
}
