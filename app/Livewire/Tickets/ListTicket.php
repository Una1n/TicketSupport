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
        $this->authorize('manage', $ticket);

        $title = $ticket->title;

        $ticket->delete();

        session()->flash('status', 'Ticket ' . $title . ' Deleted!');
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        $filteredTickets = Ticket::with(['user', 'categories', 'labels', 'agent'])
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
            ->when(Auth::user()->hasRole('Agent'), function ($query) {
                $query->assignedToAgent(Auth::user());
            })
            ->when(! Auth::user()->hasAnyRole('Admin', 'Agent'), function ($query) {
                $query->byUser(Auth::user());
            });

        return view('livewire.tickets.list-ticket', [
            'tickets' => $filteredTickets->paginate(8),
            'categories' => Category::all(),
        ]);
    }
}
