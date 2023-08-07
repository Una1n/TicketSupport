<?php

namespace App\Policies;

use App\Models\Label;
use App\Models\User;

class LabelPolicy
{
    public function manage(User $user, Label $label = null): bool
    {
        return $user->hasPermissionTo('manage labels');
    }
}
