<?php

namespace App\Policies\V1;

use App\Models\User;
use App\Permissions\V1\Abilities;

class CategoryPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): bool
    {
        if ($user->tokenCan(Abilities::CreateCategory)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can replace the model.
     */
    public function replace(User $user): bool
    {
        if ($user->tokenCan(Abilities::ReplaceCategory)) {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        if ($user->tokenCan(Abilities::UpdateCategory)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        if ($user->tokenCan(Abilities::DeleteCategory)) {
            return true;
        }
        return false;
    }
}
