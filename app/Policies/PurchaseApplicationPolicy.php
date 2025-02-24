<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PurchaseApplication;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_purchase::application');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PurchaseApplication $purchaseApplication): bool
    {
        return $user->can('view_purchase::application');
    }
}
