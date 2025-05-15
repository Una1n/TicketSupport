<?php

namespace App\Livewire\Tickets;

use App\Livewire\Forms\TicketForm;
use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Mary\Traits\Toast;

class CreateTicket extends Component
{
    use Toast;
    use WithFileUploads;

    public TicketForm $form;

    public function save(): void
    {
        $this->authorize('create', Ticket::class);

        $this->form->store();

        $this->success(
            'Ticket ' . $this->form->ticket->title . ' created.',
            redirectTo: route('tickets.show', $this->form->ticket)
        );
    }

    public function render(): View
    {
        return view('livewire.tickets.create-ticket', [
            'categories' => Category::all(),
            'labels' => Label::all(),
            'priorities' => [
                ['id' => 'low', 'name' => 'Low'],
                ['id' => 'medium', 'name' => 'Medium'],
                ['id' => 'high', 'name' => 'High'],
            ],
        ]);
    }
}
