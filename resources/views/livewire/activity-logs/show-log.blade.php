<div class="max-w-5xl">
    <x-mary-header title="Ticket Activity Log" separator />
    <div class="flex flex-col gap-6">
        <x-mary-card title="Ticket" shadow separator>
            <x-slot:menu>
                @if ($log->description === 'updated')
                    <x-mary-icon name="o-pencil-square" class="text-warning" />
                @elseif ($log->description === 'created')
                    <x-mary-icon name="o-plus-circle" class="text-success" />
                @elseif ($log->description === 'deleted')
                    <x-mary-icon name="o-trash" class="text-error" />
                @endif
                <x-mary-badge value="{{ $log->created_at->diffForHumans() }}" class="badge-primary badge-soft" />
            </x-slot:menu>
            <div class="flex flex-col gap-6">
                <div class="font-bold wrap-break-word">
                    @if ($log->description === 'deleted')
                        {{ ucfirst(json_decode($log->properties, true)['old']['title']) }}
                    @else
                        {{ ucfirst($log->subject->title) }}
                    @endif
                </div>
                @if ($log->causer)
                    <div>
                        @if ($log->description === 'updated')
                            <div class="font-bold">Edited by:</div>
                        @elseif ($log->description === 'created')
                            <div class="font-bold">Created by:</div>
                        @elseif ($log->description === 'deleted')
                            <div class="font-bold">Deleted by:</div>
                        @endif
                        @if ($role->name === 'Regular')
                            <div>{{ $log->causer->name }} <x-mary-badge value="{{ $role->name }}"
                                    class="badge-accent badge-soft" /></div>
                        @elseif ($role->name === 'Agent')
                            <div>{{ $log->causer->name }} <x-mary-badge value="{{ $role->name }}"
                                    class="badge-primary badge-soft" /></div>
                        @elseif ($role->name === 'Admin')
                            <div>{{ $log->causer->name }} <x-mary-badge value="{{ $role->name }}"
                                    class="badge-warning badge-soft" /></div>
                        @endif
                    </div>
                @endif
            </div>
        </x-mary-card>
        <x-mary-card title="Properties" shadow separator>
            <pre class="overflow-auto">{{ json_encode(json_decode($log->changes, true), JSON_PRETTY_PRINT) }}</pre>
        </x-mary-card>
    </div>
</div>
