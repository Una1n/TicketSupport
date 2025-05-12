<div>
    <x-mary-header title="Tickets" separator>
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <!-- TODO: Add badge to show number of active filters, (0) by default -->
            <x-mary-button icon="o-funnel" label="Filters" class="btn-neutral" wire:click="filterTicket" responsive />
            <x-mary-button icon="o-plus" label="Create" class="btn-primary" wire:click="createTicket" responsive />
        </x-slot:actions>
    </x-mary-header>
    <div class="card bg-base-100 p-5 pt-2 shadow-xs">
        <x-mary-table :headers="$headers" :rows="$tickets" :sort-by="$sortBy" with-pagination>
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
</div>
