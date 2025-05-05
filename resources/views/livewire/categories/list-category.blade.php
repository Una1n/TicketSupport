<div class="max-w-2xl">
    <x-mary-header title="Categories" separator>
        <x-slot:actions>
            <x-mary-button icon="o-plus" label="Create" class="btn-primary" wire:click="createCategory" />
        </x-slot:actions>
    </x-mary-header>
    <div class="card bg-base-100 p-5 pt-2 shadow-xs">
        <x-mary-table :headers="$headers" :rows="$categories" :sort-by="$sortBy" with-pagination>
            @scope('actions', $category)
                <div class="flex flex-row">
                    <x-mary-button icon="o-pencil-square" class="btn-ghost text-warning"
                        wire:click="openEditModal({{ $category }})" tooltip="Edit" />
                    <x-mary-button icon="o-trash" class="btn-ghost text-error" wire:confirm="Are you sure?"
                        wire:click="deleteCategory({{ $category }})" tooltip="Delete" />
                </div>
            @endscope
        </x-mary-table>
    </div>
    @if ($this->editCategory)
        <x-mary-modal wire:model="editModal" title="Update Category" persistent>
            @livewire(Categories\EditCategory::class, ['category' => $this->editCategory])
        </x-mary-modal>
    @endif
</div>
