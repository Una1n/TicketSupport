<?php

namespace App\Livewire;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DashboardHome extends Component
{
    public int $closedTickets = 0;
    public int $openTickets = 0;
    public int $totalTickets = 0;

    public function mount(): void
    {
        $this->closedTickets = Ticket::closed()->count();
        $this->openTickets = Ticket::open()->count();
        $this->totalTickets = $this->closedTickets + $this->openTickets;
    }

    #[Layout('layouts.dashboard')]
    public function render(): View
    {
        return view('livewire.dashboard-home');
    }
}
