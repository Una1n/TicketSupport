<?php

namespace App\Livewire;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DashboardHome extends Component
{
    public $closedTickets = 0;
    public $openTickets = 0;

    public function mount(): void
    {
        $this->closedTickets = Ticket::closed()->count();
        $this->openTickets = Ticket::open()->count();
    }

    #[Layout('layouts.dashboard')]
    public function render(): View
    {
        return view('livewire.dashboard-home');
    }
}
