<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class DashboardHome extends Component
{
    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.dashboard-home');
    }
}
