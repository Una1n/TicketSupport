<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasPermissionTo('manage tickets')) {
            return true;
        }

        return null;
    }

    public function viewList(User $user): bool
    {
        return true;
    }

    public function view(User $user, Ticket $ticket): bool
    {
        // TODO: Only allowed to show your own assigned ticket if agent user
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->hasPermissionTo('edit tickets');
    }
}
