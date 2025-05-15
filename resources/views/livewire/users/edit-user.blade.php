<div class="max-w-2xl">
    <x-mary-header title="Update User" separator />
    <x-mary-form wire:submit="save" no-separator>
        <x-mary-select label="Role" wire:model="form.role" :options="$roles" placeholder="Select a Role" />
        <x-mary-input label="Name" wire:model="form.name" placeholder="John Doe" />
        <x-mary-input label="Email" wire:model="form.email" placeholder="a@b.com" />
        <x-slot:actions>
            <x-mary-button label="Cancel" class="btn-soft" wire:click="cancel" />
            <x-mary-button label="Update" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-mary-form>
</div>
