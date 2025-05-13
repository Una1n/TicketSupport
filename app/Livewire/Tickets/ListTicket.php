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

    // Table Settings
    public array $headers = [
        [
            'key' => 'status', 'label' => 'Status',
            'class' => 'text-center max-w-10 hidden lg:table-cell',
        ],
        ['key' => 'title', 'label' => 'Title', 'class' => 'max-w-20 lg:max-w-40'],
        [
            'key' => 'priority', 'label' => 'Priority',
            'class' => 'max-w-14 text-center hidden lg:table-cell',
        ],
        [
            'key' => 'agent.name', 'label' => 'Assigned To',
            'class' => 'max-w-26 hidden lg:table-cell', 'sortable' => false,
        ],
        [
            'key' => 'customCategories', 'label' => 'Categories',
            'class' => 'max-w-40 hidden lg:table-cell', 'sortable' => false,
        ],
    ];
    public array $sortBy = ['column' => 'title', 'direction' => 'asc'];

    // Filters
    public bool $showFilters = false;
    public int $activeFilters = 0;
    public string $categoryFilter;
    public string $statusFilter;
    public string $priorityFilter;

    public function filterTickets(): void
    {
        $this->showFilters = true;
    }

    public function resetFilters(): void
    {
        $this->categoryFilter = '';
        $this->statusFilter = '';
        $this->priorityFilter = '';
        $this->showFilters = false;
    }

    public function updateFilterCounter(): void
    {
        $this->activeFilters = 0;
        if (! empty($this->statusFilter)) {
            $this->activeFilters++;
        }
        if (! empty($this->priorityFilter)) {
            $this->activeFilters++;
        }
        if (! empty($this->categoryFilter)) {
            $this->activeFilters++;
        }
    }

    // public function deleteTicket(Ticket $ticket): void
    // {
    //     $this->authorize('manage', $ticket);
    //
    //     $title = $ticket->title;
    //
    //     $ticket->delete();
    //
    //     session()->flash('status', 'Ticket ' . $title . ' Deleted!');
    // }

    // TODO: Only show tickets based on logged in user:
    // regular user = only show tickets created by themselves
    // agent = only show tickets assigned to them
    // admin = show all tickets
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

        $this->updateFilterCounter();

        return view('livewire.tickets.list-ticket', [
            'tickets' => $filteredTickets
                ->orderBy(...array_values($this->sortBy))
                ->latest()
                ->paginate(8),
            'categoryOptions' => Category::all(),
            'statusOptions' => [
                ['id' => 'open', 'name' => 'Open'],
                ['id' => 'closed', 'name' => 'Closed'],
            ],
            'priorityOptions' => [
                ['id' => 'low', 'name' => 'Low'],
                ['id' => 'medium', 'name' => 'Medium'],
                ['id' => 'high', 'name' => 'High'],
            ],
        ]);
    }
}
