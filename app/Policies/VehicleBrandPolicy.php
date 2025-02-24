<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VehicleBrand;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehicleBrandPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_vehicle::brand');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, VehicleBrand $vehicleBrand): bool
    {
        return $user->can('view_vehicle::brand');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_vehicle::brand');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, VehicleBrand $vehicleBrand): bool
    {
        return $user->can('update_vehicle::brand');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, VehicleBrand $vehicleBrand): bool
    {
        return $user->can('delete_vehicle::brand');
    }
}
