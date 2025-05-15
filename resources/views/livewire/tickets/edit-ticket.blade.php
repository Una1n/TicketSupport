<div class="max-w-2xl">
    <x-mary-header title="Update Ticket" separator />
    <x-mary-form wire:submit="save" no-separator>
        @if (auth()->user()->hasRole('Admin'))
            <x-mary-select label="Agent Assigned" wire:model="agentAssigned" :options="$agents" />
        @endif
        <x-mary-input label="Title" wire:model.blur="form.title" placeholder="Fill in a Title..." />
        <x-mary-select label="Priority" wire:model.blur="form.priority" :options="$priorities" />
        <x-mary-textarea label="Description" wire:model.blur="form.description" placeholder="Explain the issue..."
            rows="6" />
        <x-mary-choices label="Categories" wire:model="form.selectedCategories" :options="$categories"
            placeholder="Select Category(s)" clearable />
        <x-mary-choices label="Labels" wire:model="form.selectedLabels" :options="$labels" placeholder="Select Label(s)"
            clearable />
        <x-mary-file wire:model="form.attachments" label="Attach Files" multiple />
        @if ($oldAttachments)
            @foreach ($oldAttachments as $attachment)
                <div class="flex flex-row gap-3 mt-2">
                    <x-mary-button link="{{ $attachment->original_url }}" class="btn-soft flex-1"
                        label="Attachment {{ $loop->iteration }}" external />
                    <x-mary-button label="Remove" icon="o-trash"
                        wire:confirm="Are you sure that you want to remove this attachment?"
                        wire:click="removeAttachment({{ $attachment->id }})" class="btn-error" responsive />
                </div>
            @endforeach
        @endif
        <x-slot:actions>
            <x-mary-button label="Cancel" class="btn-soft" wire:click="cancel" />
            <x-mary-button label="Update" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-mary-form>
</div>
