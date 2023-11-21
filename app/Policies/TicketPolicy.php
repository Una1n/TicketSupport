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

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('Agent') && $ticket->agent->is($user)) {
            return true;
        }

        if ($ticket->user->is($user)) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Ticket $ticket): bool
    {
        if ($ticket->agent_id === $user->id) {
            return $user->hasPermissionTo('edit tickets');
        }

        return false;
    }
}
