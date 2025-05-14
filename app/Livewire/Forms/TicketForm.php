<?php

namespace App\Livewire\Forms;

use App\Models\Ticket;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TicketForm extends Form
{
    public Ticket $ticket;

    #[Validate(['required', 'min:3', 'max:255'])]
    public string $title = '';

    #[Validate(['required', 'in:open,closed'])]
    public string $status = '';

    #[Validate(['required', 'string', 'in:low,medium,high'])]
    public string $priority = '';

    #[Validate(['required', 'string', 'min:20'])]
    public string $description = '';

    /** @var array<string> */
    #[Validate(['sometimes', 'exists:categories,id'])]
    public array $selectedCategories = [];

    /** @var array<string> */
    #[Validate(['sometimes', 'exists:labels,id'])]
    public array $selectedLabels = [];

    #[Validate(['nullable', 'exists:users,id'])]
    public ?int $agentAssigned = null;

    // New Files attached
    public mixed $attachments = [];

    // Old Attachments when updating ticket
    public Collection $oldAttachments;

    public function setTicket(Ticket $ticket): void
    {
        $this->ticket = $ticket;
        $this->title = $ticket->title;
        $this->description = $ticket->description;
        $this->status = $ticket->status;
        $this->priority = $ticket->priority;
        $this->agentAssigned = $ticket->agent_id;

        $this->selectedCategories = $ticket->categories()->pluck('id')->toArray();
        $this->selectedLabels = $ticket->labels()->pluck('id')->toArray();
        $this->oldAttachments = $ticket->getMedia('attachments');
    }

    public function store(): void
    {
        // Default to open status
        $this->status = 'open';

        $this->validate();

        /** @phpstan-ignore assign.propertyType */
        $this->ticket = auth()->user()->tickets()->create(
            $this->only(['title', 'status', 'description', 'priority']),
        );
        $this->ticket->categories()->sync($this->selectedCategories);
        $this->ticket->labels()->sync($this->selectedLabels);

        foreach ($this->attachments as $attachment) {
            $path = $attachment->store('livewire', 'media');
            $this->ticket->addMediaFromDisk($path, 'media')->toMediaCollection('attachments');
        }
    }

    public function update(): void
    {
        $this->validate();

        $this->ticket->update(
            $this->only(['title', 'status', 'description', 'priority'])
        );

        if (! empty($this->agentAssigned) && auth()->user()->hasRole('Admin')) {
            $this->ticket->agent()->associate($this->agentAssigned)->save();
        }

        $this->ticket->categories()->sync($this->selectedCategories);
        $this->ticket->labels()->sync($this->selectedLabels);

        foreach ($this->attachments as $attachment) {
            $path = $attachment->store('livewire', 'media');
            $this->ticket->addMediaFromDisk($path, 'media')->toMediaCollection('attachments');
        }
    }
}
