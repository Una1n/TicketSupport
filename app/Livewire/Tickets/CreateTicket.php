<?php

namespace App\Livewire\Tickets;

use App\Livewire\Forms\TicketForm;
use App\Mail\TicketCreated;
use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Features\SupportRedirects\Redirector;
use Mail;

class CreateTicket extends Component
{
    use WithFileUploads;
    public TicketForm $form;

    public function save(): Redirector|RedirectResponse
    {
        $this->authorize('create', Ticket::class);

        // Default to open status
        $this->form->status = 'open';

        // Still needed even though the docs say it runs automatically
        $this->form->validate();

        $properties = $this->form->only(['title', 'status', 'description', 'priority']);
        $properties += ['user_id' => auth()->user()->id];

        $ticket = Ticket::create($properties);
        $ticket->categories()->sync($this->form->selectedCategories);
        $ticket->labels()->sync($this->form->selectedLabels);

        foreach ($this->form->attachments as $attachment) {
            $path = $attachment->store('livewire', 'media');
            $ticket->addMediaFromDisk($path, 'media')->toMediaCollection('attachments');
        }

        Mail::send(new TicketCreated($ticket));

        return redirect()->route('tickets.show', $ticket)
            ->with('status', 'Ticket created.');
    }

    public function render(): View
    {
        return view('livewire.tickets.create-ticket', [
            'categories' => Category::all(),
            'labels' => Label::all(),
        ]);
    }
}
