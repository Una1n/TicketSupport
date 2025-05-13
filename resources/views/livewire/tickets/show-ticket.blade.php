<div x-data="{ isShowingLogs: false, isShowingComments: true }">
    <x-mary-header title="Ticket" separator>
        <x-slot:actions>
            <x-mary-button label="Edit" icon="o-pencil-square" wire:click="editTicket({{ $ticket }})"
                class="text-warning btn-ghost" responsive />
            <x-mary-button label="Delete" icon="o-trash" wire:click="deleteTicket({{ $ticket }})"
                class="text-error btn-ghost" responsive />
        </x-slot:actions>
    </x-mary-header>
    <div class="flex flex-col gap-6">
        <x-mary-card title="{{ ucfirst($ticket->title) }}" shadow separator>
            <x-slot:menu>
                @if ($ticket->status === 'closed')
                    <x-mary-icon name="o-check" class="text-success" />
                    <span class="text-success hidden lg:block">Closed</span>
                @else
                    <x-mary-icon name="o-exclamation-circle" class="text-error" />
                    <span class="text-error hidden lg:block">Open</span>
                @endif
            </x-slot:menu>
            <div class="flex flex-col gap-6">
                <div class="wrap-break-word">
                    <div>{{ ucfirst($ticket->description) }}</div>
                </div>
                <div>
                    <div class="font-bold">Priority</div>
                    @if ($ticket->priority === 'low')
                        <x-mary-badge value="Low" class="badge-soft badge-accent" />
                    @elseif ($ticket->priority === 'medium')
                        <x-mary-badge value="Medium" class="badge-soft badge-warning" />
                    @else
                        <x-mary-badge value="High" class="badge-soft badge-error" />
                    @endif
                </div>
                <div>
                    <div class="font-bold">Attachment(s)</div>
                    <div>
                        @forelse ($ticket->getMedia('attachments') as $attachment)
                            <a href="{{ $attachment->getUrl() }}"
                                class="text-blue-600 hover:underline">{{ $attachment->file_name }}</a>
                            @if ($loop->iteration !== $loop->count)
                                ,
                            @endif
                        @empty
                            <span class="text-base-content/30">No Attachments Found</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </x-mary-card>
        <div class="flex flex-col lg:flex-row justify-stretch gap-6">
            <x-mary-card title="Users" class="grow" shadow separator>
                <div class="flex flex-col gap-6">
                    <div>
                        <div class="font-bold">Created By</div>
                        <div class="text-base-content/50">{{ $ticket->user->name }}</div>
                    </div>
                    <div>
                        <div class="font-bold">Assigned Agent</div>
                        @if ($ticket->agent)
                            <div class="text-base-content/50">{{ $ticket->agent->name }}</div>
                        @else
                            <div class="text-base-content/30">No Agent Assigned yet</div>
                        @endif
                    </div>
                </div>
            </x-mary-card>
            <x-mary-card title="Classification" class="grow" shadow separator>
                <div class="flex flex-col gap-6">
                    <div>
                        <div class="font-bold">Categories</div>
                        @forelse ($ticket->categories as $category)
                            <x-mary-badge value="{{ $category->name }}" class="badge-soft badge-primary" />
                        @empty
                            <span class="text-base-content/30">No categories attached</span>
                        @endforelse
                    </div>
                    <div>
                        <div class="font-bold">Labels</div>
                        @forelse ($ticket->labels as $label)
                            <x-mary-badge value="{{ $label->name }}" class="badge-soft badge-secondary" />
                        @empty
                            <span class="text-base-content/30">No labels attached</span>
                        @endforelse
                    </div>
                </div>
            </x-mary-card>
        </div>
        <div class="flex gap-5">
            <x-mary-button label="Hide Logs" x-text="isShowingLogs ? 'Hide Logs' : 'Show Logs'"
                @click="isShowingLogs = !isShowingLogs" class="btn-primary btn-dash" />
            <x-mary-button label="Hide Comments" x-text="isShowingComments ? 'Hide Comments' : 'Show Comments'"
                @click="isShowingComments = !isShowingComments" class="btn-primary btn-dash" />
        </div>
    </div>
    <div x-show="isShowingComments" wire:transition>
        <livewire:comments.show-comments :ticket="$ticket" />
    </div>
    <div x-show="isShowingLogs" wire:transition>
        <livewire:activity-logs.show-logs :ticket="$ticket" />
    </div>
</div>
