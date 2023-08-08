<?php

namespace App\Livewire\Tickets;

use App\Models\Category;
use App\Models\Ticket;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListTicket extends Component
{
    use WithPagination;

    #[Url()]
    public string $search = '';

    // Filters
    public $categoryFilter;
    public $statusFilter;
    public $priorityFilter;

    public function deleteTicket(Ticket $ticket): void
    {
        if (! Auth::user()->can('manage', Ticket::class)) {
            abort(403);
        }

        $title = $ticket->title;

        $ticket->delete();

        session()->flash('status', 'Ticket ' . $title . ' Deleted!');
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.tickets.list-ticket', [
            'tickets' => Ticket::with(['user', 'categories', 'labels', 'agent'])
                ->search($this->search)
                ->when(! empty($this->categoryFilter), function ($query) {
                    $query->whereRelation('categories', 'id', $this->categoryFilter);
                })
                ->when(! empty($this->statusFilter), function ($query) {
                    $query->where('status', '=', $this->statusFilter);
                })
                ->when(! empty($this->priorityFilter), function ($query) {
                    $query->where('priority', '=', $this->priorityFilter);
                })
                ->paginate(8),
            'categories' => Category::all(),
        ]);
    }
}
