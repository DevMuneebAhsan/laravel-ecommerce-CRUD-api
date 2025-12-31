<?php

namespace App\Policies\V1;

use App\Models\Product;
use App\Models\User;
use App\Permissions\V1\Abilities;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function store(User $user)
    {
        if ($user->tokenCan(Abilities::CreateProduct)) {
            return true;
        }
        return false;
    }
    public function replace(User $user)
    {
        if ($user->tokenCan(Abilities::ReplaceProduct)) {
            return true;
        }
        return false;
    }
    public function delete(User $user, Product $product)
    {
        if ($user->tokenCan(Abilities::DeleteProduct)) {
            return true;
        } else if ($user->tokenCan(Abilities::DeleteOwnProduct)) {
            return $user->id === $product->user_id;
        }
        return false;
    }
    public function update(User $user, Product $product)
    {
        if ($user->tokenCan(Abilities::UpdateProduct)) {
            return true;
        } else if ($user->tokenCan(Abilities::UpdateOwnProduct)) {
            return $user->id === $product->user_id;
        }
        return false;
    }
}
