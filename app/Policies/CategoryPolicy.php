<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function manage(User $user, Category $category = null): bool
    {
        return $user->hasPermissionTo('manage categories');
    }
}
