<?php

namespace App\Policies;

use App\Models\Enums\UserRoleEnum;
use App\Models\InternalMove;
use App\Models\User;
use App\Utils\Utils;

class InternalMovePolicy
{
    private array $roles = [UserRoleEnum::ADMIN, UserRoleEnum::POINT_OF_SALES, UserRoleEnum::USER];
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Utils::isTransaction() && in_array($user->role, $this->roles);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InternalMove $intervalMove): bool
    {
        return Utils::isTransaction() && in_array($user->role, $this->roles);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Utils::isTransaction() && in_array($user->role, $this->roles);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InternalMove $intervalMove): bool
    {
        return Utils::isTransaction() && in_array($user->role, [UserRoleEnum::ADMIN, UserRoleEnum::POINT_OF_SALES]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InternalMove $intervalMove): bool
    {
        return Utils::isTransaction() && in_array($user->role, [UserRoleEnum::ADMIN, UserRoleEnum::POINT_OF_SALES]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InternalMove $intervalMove): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InternalMove $intervalMove): bool
    {
        return false;
    }
}
