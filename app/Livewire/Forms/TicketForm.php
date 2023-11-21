<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class TicketForm extends Form
{
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

    // Files attached
    public mixed $attachments = [];
}
