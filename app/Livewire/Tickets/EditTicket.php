<?php

namespace App\Livewire\Tickets;

use App\Livewire\Forms\TicketForm;
use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class EditTicket extends Component
{
    public Ticket $ticket;
    public TicketForm $form;

    public function mount(Ticket $ticket): void
    {
        $this->ticket = $ticket;
        $this->form->title = $ticket->title;
        $this->form->description = $ticket->description;
        $this->form->status = $ticket->status;
        $this->form->priority = $ticket->priority;

        $this->form->selectedCategories = $ticket->categories()->pluck('id')->toArray();
        $this->form->selectedLabels = $ticket->labels()->pluck('id')->toArray();
    }

    public function save()
    {
        if (! Auth::user()->can('update', Ticket::class)) {
            abort(403);
        }

        // Still needed even though the docs say it runs automatically
        $this->form->validate();

        $properties = $this->form->only(['title', 'status', 'description', 'priority']);
        $properties += ['user_id' => Auth::user()->id];

        $this->ticket->update($properties);
        $this->ticket->categories()->sync($this->form->selectedCategories);
        $this->ticket->labels()->sync($this->form->selectedLabels);

        return redirect()->route('tickets.show', $this->ticket)
            ->with('status', 'Ticket updated.');
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.tickets.edit-ticket', [
            'categories' => Category::all(),
            'labels' => Label::all(),
        ]);
    }
}
