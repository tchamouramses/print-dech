<?php

namespace App\Policies;

use App\Models\Enums\UserRoleEnum;
use App\Models\Transaction;
use App\Models\User;
use App\Utils\Utils;

class TransactionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Utils::isPrint();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        return Utils::isPrint();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Utils::isPrint();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Transaction $transaction): bool
    {
        return Utils::isPrint();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Transaction $transaction): bool
    {
        return Utils::isPrint() && in_array($user->role, [UserRoleEnum::ADMIN]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Transaction $transaction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Transaction $transaction): bool
    {
        return false;
    }
}
