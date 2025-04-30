<div class="max-w-2xl">
    <x-mary-header title="Labels" separator />
    <x-mary-table :headers="$headers" :rows="$labels" striped with-pagination>
        @scope('actions', $label)
            <div class="flex flex-row">
                <x-mary-button icon="o-pencil-square" class="btn-ghost text-warning"
                    wire:click="editLabel({{ $label }})" tooltip-left="Edit" />
                <x-mary-button icon="o-trash" class="btn-ghost text-error" wire:confirm="Are you sure?"
                    wire:click="deleteLabel({{ $label }})" tooltip-left="Delete" />
            </div>
        @endscope
    </x-mary-table>
</div>
