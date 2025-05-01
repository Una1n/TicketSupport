<div class="max-w-2xl">
    <x-mary-header title="Labels" separator>
        <x-slot:actions>
            <x-mary-button icon="o-plus" label="Create" class="btn-primary" wire:click="createLabel" />
        </x-slot:actions>
    </x-mary-header>
    <div class="card bg-base-100 p-5 pt-2 shadow-xs">
        <x-mary-table :headers="$headers" :rows="$labels" :sort-by="$sortBy" with-pagination>
            @scope('actions', $label)
                <div class="flex flex-row">
                    <x-mary-button icon="o-pencil-square" class="btn-ghost text-warning"
                        wire:click="editLabel({{ $label }})" tooltip="Edit" />
                    <x-mary-button icon="o-trash" class="btn-ghost text-error" wire:confirm="Are you sure?"
                        wire:click="deleteLabel({{ $label }})" tooltip="Delete" />
                </div>
            @endscope
        </x-mary-table>
    </div>
</div>
