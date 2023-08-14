<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class TicketForm extends Form
{
    #[Rule(['required', 'min:3', 'max:255'])]
    public string $title = '';

    #[Rule(['required', 'in:open,closed'])]
    public string $status = '';

    #[Rule(['required', 'string', 'in:low,medium,high'])]
    public string $priority = '';

    #[Rule(['required', 'string', 'min:20'])]
    public string $description = '';

    #[Rule(['sometimes', 'exists:categories,id'])]
    public array $selectedCategories = [];

    #[Rule(['sometimes', 'exists:labels,id'])]
    public array $selectedLabels = [];

    #[Rule(['nullable', 'exists:users,id'])]
    public $agentAssigned = null;
}
