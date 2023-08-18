<?php

namespace App\Livewire\Tickets;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListTicket extends Component
{
    use WithPagination;

    #[Url()]
    public string $search = '';

    // Filters
    public string $categoryFilter;
    public string $statusFilter;
    public string $priorityFilter;

    public function deleteTicket(Ticket $ticket): void
    {
        $this->authorize('manage', $ticket);

        $title = $ticket->title;

        $ticket->delete();

        session()->flash('status', 'Ticket ' . $title . ' Deleted!');
    }

    public function render(): View
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
            ->when(auth()->user()->hasRole('Agent'), function ($query) {
                $query->assignedToAgent(auth()->user());
            })
            ->when(! auth()->user()->hasAnyRole('Admin', 'Agent'), function ($query) {
                $query->byUser(auth()->user());
            });

        return view('livewire.tickets.list-ticket', [
            'tickets' => $filteredTickets->latest()->paginate(8),
            'categories' => Category::all(),
        ]);
    }
}
