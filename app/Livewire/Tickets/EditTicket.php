<?php

namespace App\Livewire\Tickets;

use App\Livewire\Forms\TicketForm;
use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Features\SupportRedirects\Redirector;

class EditTicket extends Component
{
    use WithFileUploads;
    public Ticket $ticket;
    public TicketForm $form;

    public function mount(Ticket $ticket): void
    {
        $this->ticket = $ticket;
        $this->form->title = $ticket->title;
        $this->form->description = $ticket->description;
        $this->form->status = $ticket->status;
        $this->form->priority = $ticket->priority;
        $this->form->agentAssigned = $ticket->agent_id;

        $this->form->selectedCategories = $ticket->categories()->pluck('id')->toArray();
        $this->form->selectedLabels = $ticket->labels()->pluck('id')->toArray();
    }

    public function save(): Redirector|RedirectResponse
    {
        $this->authorize('update', $this->ticket);

        // Still needed even though the docs say it runs automatically
        $this->form->validate();

        $properties = $this->form->only(['title', 'status', 'description', 'priority']);
        if (! empty($this->form->agentAssigned) && auth()->user()->hasRole('Admin')) {
            $properties += ['agent_id' => $this->form->agentAssigned];
        }

        $this->ticket->update($properties);
        $this->ticket->categories()->sync($this->form->selectedCategories);
        $this->ticket->labels()->sync($this->form->selectedLabels);

        foreach ($this->form->attachments as $attachment) {
            $path = $attachment->store('livewire', 'media');
            $this->ticket->addMediaFromDisk($path, 'media')->toMediaCollection('attachments');
        }

        return redirect()->route('tickets.show', $this->ticket)
            ->with('status', 'Ticket updated.');
    }

    public function render(): View
    {
        $this->authorize('update', $this->ticket);

        return view('livewire.tickets.edit-ticket', [
            'categories' => Category::all(),
            'labels' => Label::all(),
            'agents' => User::role('Agent')->get(),
        ]);
    }
}
