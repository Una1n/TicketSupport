<?php

namespace App\Livewire\Tickets;

use App\Livewire\Forms\TicketForm;
use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateTicket extends Component
{
    public TicketForm $form;

    public function save()
    {
        $this->authorize('create', Ticket::class);

        // Default to open status
        $this->form->status = 'open';

        // Still needed even though the docs say it runs automatically
        $this->form->validate();

        $properties = $this->form->only(['title', 'status', 'description', 'priority']);
        $properties += ['user_id' => Auth::user()->id];

        $ticket = Ticket::create($properties);
        $ticket->categories()->sync($this->form->selectedCategories);
        $ticket->labels()->sync($this->form->selectedLabels);

        return redirect()->route('tickets.show', $ticket)
            ->with('status', 'Ticket created.');
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.tickets.create-ticket', [
            'categories' => Category::all(),
            'labels' => Label::all(),
        ]);
    }
}
