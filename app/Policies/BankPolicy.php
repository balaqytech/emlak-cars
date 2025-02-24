<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Bank;
use Illuminate\Auth\Access\HandlesAuthorization;

class BankPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_bank');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Bank $bank): bool
    {
        return $user->can('view_bank');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_bank');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Bank $bank): bool
    {
        return $user->can('update_bank');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bank $bank): bool
    {
        return $user->can('delete_bank');
    }
}
