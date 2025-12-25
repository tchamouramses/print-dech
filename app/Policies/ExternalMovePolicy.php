<?php

namespace App\Policies;

use App\Models\Enums\UserRoleEnum;
use App\Models\ExternalMove;
use App\Models\User;
use App\Utils\Utils;

class ExternalMovePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Utils::isTransaction() && in_array($user->role, [UserRoleEnum::ADMIN, UserRoleEnum::POINT_OF_SALES]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ExternalMove $externalMove): bool
    {
        return Utils::isTransaction() && in_array($user->role, [UserRoleEnum::ADMIN, UserRoleEnum::POINT_OF_SALES]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Utils::isTransaction() && in_array($user->role, [UserRoleEnum::ADMIN, UserRoleEnum::POINT_OF_SALES]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ExternalMove $externalMove): bool
    {
        return Utils::isTransaction() && $user->role == UserRoleEnum::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ExternalMove $externalMove): bool
    {
        return  Utils::isTransaction() && $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ExternalMove $externalMove): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ExternalMove $externalMove): bool
    {
        return false;
    }
}
