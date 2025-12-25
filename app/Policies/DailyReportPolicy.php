<?php

namespace App\Policies;

use App\Models\DailyReport;
use App\Models\Enums\UserRoleEnum;
use App\Models\User;
use App\Utils\Utils;

class DailyReportPolicy
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
    public function view(User $user, DailyReport $dailyReport): bool
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
    public function update(User $user, DailyReport $dailyReport): bool
    {
        return Utils::isTransaction() && in_array($user->role, [UserRoleEnum::ADMIN, UserRoleEnum::POINT_OF_SALES]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DailyReport $dailyReport): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DailyReport $dailyReport): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DailyReport $dailyReport): bool
    {
        return false;
    }
}
