<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\Enums\UserRoleEnum;
use App\Models\User;
use App\Utils\Utils;

class ContactPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        return Utils::isPrint() && $user->isAdmin();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Utils::isPrint() && in_array($user->role, [UserRoleEnum::ADMIN, UserRoleEnum::USER]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Contact $contact): bool
    {
        return Utils::isPrint() && in_array($user->role, [UserRoleEnum::ADMIN, UserRoleEnum::USER]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Contact $contact): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Contact $contact): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Contact $contact): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Contact $contact): bool
    {
        return false;
    }
}
