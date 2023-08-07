<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function manage(User $loggedInUser, User $user = null): bool
    {
        return $loggedInUser->hasPermissionTo('manage users');
    }
}
