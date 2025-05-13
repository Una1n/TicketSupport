<x-mary-collapse separator>
    <x-slot:heading>
        Comments
    </x-slot:heading>
    <x-slot:content class="flex flex-col gap-4">
        @if ($ticket->status === 'open')
            <x-mary-card title="New Comment" class="">
                <x-mary-form wire:submit="save" no-separator>
                    <x-mary-textarea label="" wire:model="newComment" placeholder="Leave a comment on this ticket..."
                        rows="5" hint="Max 512 chars" />
                    <x-slot:actions>
                        <x-mary-button label="Add Comment" icon="o-plus" type="submit" class="btn-primary"
                            spinner="save" />
                    </x-slot:actions>
                </x-mary-form>
            </x-mary-card>
        @endif
        @foreach ($comments as $comment)
            <x-mary-card title="{{ $comment->user->name }}" subtitle="{{ $comment->user->email }}" class="">
                <x-slot:menu>
                    <x-mary-badge value="{{ $comment->created_at->diffForHumans() }}"
                        class="badge-primary badge-soft hidden lg:block" />
                </x-slot:menu>
                <div>
                    {{ $comment->message }}
                </div>
            </x-mary-card>
        @endforeach
    </x-slot:content>
</x-mary-collapse>
