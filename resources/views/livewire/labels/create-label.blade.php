<div class="max-w-2xl">
    <x-mary-header title="New Label" separator />
    <x-mary-form wire:submit="save" no-separator>
        <x-mary-input label="Name" wire:model="name" />
        <x-slot:actions>
            <x-mary-button label="Cancel" class="btn-soft" wire:click="cancel" />
            <x-mary-button label="Create" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-mary-form>
</div>
