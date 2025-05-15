<div class="max-w-2xl">
    <x-mary-header title="New Ticket" separator />
    <x-mary-form wire:submit="save" no-separator>
        <x-mary-input label="Title" wire:model.blur="form.title" placeholder="Fill in a Title..." />
        <x-mary-select label="Priority" wire:model.blur="form.priority" :options="$priorities" />
        <x-mary-textarea label="Description" wire:model.blur="form.description" placeholder="Explain the issue..."
            rows="6" />
        <x-mary-choices label="Categories" wire:model="form.selectedCategories" :options="$categories"
            placeholder="Select Category(s)" clearable />
        <x-mary-choices label="Labels" wire:model="form.selectedLabels" :options="$labels" placeholder="Select Label(s)"
            clearable />
        <x-mary-file wire:model="form.attachments" label="Files Attached" multiple />
        <x-slot:actions>
            <x-mary-button label="Cancel" class="btn-soft" wire:click="cancel" />
            <x-mary-button label="Create" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-mary-form>
</div>
