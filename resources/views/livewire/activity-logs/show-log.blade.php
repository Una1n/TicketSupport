<div class="max-w-5xl">
    <x-mary-header title="Ticket Activity Log" separator />
    <div class="flex flex-col gap-6">
        <x-mary-card title="{{ ucfirst($log->description) }}" shadow separator>
            <x-slot:menu>
                <x-mary-badge value="{{ $log->created_at->diffForHumans() }}" class="badge-primary badge-soft" />
            </x-slot:menu>
            <div class="flex flex-col gap-6">
                <div>
                    <div class="font-bold">Title:</div>
                    {{ ucfirst($log->subject->title) }}
                </div>
                @if ($log->causer)
                    <div>
                        <div class="font-bold">Caused by:</div>
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
