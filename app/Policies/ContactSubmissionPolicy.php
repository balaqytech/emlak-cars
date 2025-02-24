<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ContactSubmission;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactSubmissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_contact::submission');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContactSubmission $contactSubmission): bool
    {
        return $user->can('view_contact::submission');
    }
}
