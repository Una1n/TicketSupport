<?php

namespace App\Livewire\Tickets;

use App\Models\Ticket;
use Livewire\Component;

class ShowTicket extends Component
{
    public Ticket $ticket;

    public function render()
    {
        $this->authorize('view', $this->ticket);

        return view('livewire.tickets.show-ticket');
    }
}
