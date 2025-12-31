<?php

namespace App\Permissions\V1;

use App\Models\User;

final class Abilities
{
    public const CreateProduct = 'product:create';
    public const UpdateProduct = 'product:update';
    public const ReplaceProduct = 'product:replace';
    public const DeleteProduct = 'product:delete';


    public const UpdateOwnProduct = 'product:own:update';
    public const DeleteOwnProduct = 'product:own:delete';


    public const CreateCategory = 'category:create';
    public const UpdateCategory = 'category:update';
    public const ReplaceCategory = 'category:replace';
    public const DeleteCategory = 'category:delete';

    public const CreateUser = 'user:create';
    public const UpdateUser = 'user:update';
    public const ReplaceUser = 'user:replace';
    public const DeleteUser = 'user:delete';

    public static function getAbilities(User $user)
    {
        if ($user->is_manager) {
            return [
                self::CreateProduct,
                self::UpdateProduct,
                self::DeleteProduct,
                self::ReplaceProduct,
                self::CreateCategory,
                self::ReplaceCategory,
                self::UpdateCategory,
                self::DeleteCategory,
                self::CreateUser,
                self::ReplaceUser,
                self::UpdateUser,
                self::DeleteUser,
            ];
        } else {
            return [
                self::CreateProduct,
                self::UpdateOwnProduct,
                self::DeleteOwnProduct,
            ];
        }
    }
}
