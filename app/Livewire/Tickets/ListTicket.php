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
    public array $headers = [
        ['key' => 'status', 'label' => 'Status', 'class' => 'text-center max-w-14'],
        ['key' => 'priority', 'label' => 'Priority', 'class' => 'max-w-14'],
        ['key' => 'title', 'label' => 'Title', 'class' => 'max-w-36 truncate'],
        [
            'key' => 'agent.name', 'label' => 'Assigned To',
            'class' => 'max-w-26', 'sortable' => false,
        ],
        [
            'key' => 'customCategories', 'label' => 'Categories',
            'class' => 'max-w-40', 'sortable' => false,
        ],
    ];
    public array $sortBy = ['column' => 'title', 'direction' => 'asc'];

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
            'tickets' => $filteredTickets
                ->orderBy(...array_values($this->sortBy))
                ->latest()
                ->paginate(8),
            'categories' => Category::all(),
        ]);
    }
}
