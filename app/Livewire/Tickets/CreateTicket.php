<?php

namespace App\Livewire\Tickets;

use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateTicket extends Component
{
    #[Rule(['required', 'unique:labels,name', 'min:3', 'max:255'])]
    public string $title = '';

    // TODO: Status should be automatically set to open on creation,
    // but editable to only allow open/closed
    #[Rule(['required', 'min:3', 'max:255'])]
    public string $status = '';

    #[Rule(['required', 'string', 'in:low,medium,high'])]
    public string $priority = '';

    #[Rule(['required', 'string', 'min:20'])]
    public string $description = '';

    public function save()
    {
        if (! Auth::user()->can('create', Ticket::class)) {
            abort(403);
        }

        // Default to open status
        $this->status = 'open';

        // Still needed even though the docs say it runs automatically
        $this->validate();

        $properties = $this->only(['title', 'status', 'description', 'priority']);
        $properties += ['user_id' => Auth::user()->id];

        dd($properties);

        $ticket = Ticket::create($properties);

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
