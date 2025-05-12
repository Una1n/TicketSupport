<div>
    <x-mary-header title="Tickets" separator>
        <x-slot:middle class="!justify-end">
            <x-mary-input wire:model.live="search" icon="o-magnifying-glass" placeholder="Search..." clearable />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-funnel" class="btn-neutral" wire:click="filterTickets" responsive>
                Filters
                <x-mary-badge value="{{ $activeFilters }}" class="badge-soft badge-sm badge-primary" />
            </x-mary-button>
            <x-mary-button icon="o-plus" label="Create" class="btn-primary" wire:click="createTicket" responsive />
        </x-slot:actions>
    </x-mary-header>
    <div class="card bg-base-100 p-5 pt-2 shadow-xs">
        <x-mary-table :headers="$headers" :rows="$tickets" :sort-by="$sortBy" :link="route('tickets.show', ['ticket' => '[id]'])" with-pagination>
            @scope('cell_priority', $ticket)
                @if ($ticket->priority === 'low')
                    <x-mary-badge value="Low" class="badge-soft badge-accent" />
                @elseif ($ticket->priority === 'medium')
                    <x-mary-badge value="Medium" class="badge-soft badge-warning" />
                @else
                    <x-mary-badge value="High" class="badge-soft badge-error" />
                @endif
            @endscope
            @scope('cell_customCategories', $ticket)
                <div class="flex flex-row gap-2">
                    @foreach ($ticket->categories as $category)
                        <x-mary-badge value="{{ $category->name }}" class="badge-soft badge-primary" />
                    @endforeach
                </div>
            @endscope
            @scope('cell_status', $ticket)
                @if ($ticket->status === 'closed')
                    <x-mary-icon name="o-check-circle" class="text-success" />
                @endif
            @endscope
        </x-mary-table>
    </div>
    <x-mary-drawer wire:model="showFilters" title="Filters" right separator with-close-button close-on-escape
        class="w-11/12 lg:w-1/3">
        <div class="flex flex-col gap-4">
            <x-mary-select label="Status" wire:model.live="statusFilter" :options="$statusOptions" icon="o-question-mark-circle"
                placeholder="All" />
            <x-mary-select label="Priority" wire:model.live="priorityFilter" :options="$priorityOptions"
                icon="o-question-mark-circle" placeholder="All" />
            <x-mary-select label="Categories" wire:model.live="categoryFilter" :options="$categoryOptions"
                icon="o-question-mark-circle" placeholder="All" />
            <x-slot:actions>
                <x-mary-button label="Reset" wire:click="resetFilters" icon="o-x-mark" />
                <x-mary-button label="Done" class="btn-primary" @click="$wire.showFilters = false" icon="o-check" />
            </x-slot:actions>
        </div>
    </x-mary-drawer>
</div>
