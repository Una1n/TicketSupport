<div class="max-w-2xl">
    <x-mary-form wire:submit="save" no-separator>
        <x-mary-input label="Name" wire:model="form.name" />
        <x-slot:actions>
            <x-mary-button label="Cancel" class="btn-soft" wire:click="cancel" />
            <x-mary-button label="Update" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-mary-form>
</div>
