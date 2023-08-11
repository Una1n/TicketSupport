<?php

namespace App\Livewire\Tickets;

use App\Models\Ticket;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ShowTicket extends Component
{
    public Ticket $ticket;

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.tickets.show-ticket');
    }
}
