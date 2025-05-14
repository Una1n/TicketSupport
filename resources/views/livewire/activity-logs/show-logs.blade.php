<x-mary-collapse separator>
    <x-slot:heading>
        Logs
    </x-slot:heading>
    <x-slot:content class="flex flex-col gap-4">
        @foreach ($logs as $log)
            @if ($log->causer)
                @php
                    $causedBy = $log->causer->name;
                @endphp
            @else
                @php
                    $causedBy = 'System';
                @endphp
            @endif
            <x-mary-card title="Ticket {{ ucfirst($log->description) }}" subtitle="By {{ $causedBy }}"
                class="text-xs lg:text-sm" shadow>
                <x-slot:menu>
                    @if ($log->description === 'updated')
                        <x-mary-icon name="o-pencil-square" class="text-warning" />
                    @elseif ($log->description === 'created')
                        <x-mary-icon name="o-plus-circle" class="text-success" />
                    @elseif ($log->description === 'deleted')
                        <x-mary-icon name="o-trash" class="text-error" />
                    @endif
                    <x-mary-badge value="{{ $log->created_at->diffForHumans() }}"
                        class="badge-primary badge-soft hidden lg:block" />
                </x-slot:menu>
                @foreach ($log->changes->get('attributes') as $key => $attribute)
                    @continue(empty($attribute))

                    @if ($key === 'agent.name')
                        <p><span class="text-base-content/50">Agent Assigned = </span> {{ $attribute }}</p>
                    @else
                        <p><span class="text-base-content/50">{{ ucfirst($key) }} = </span>
                            {{ $attribute }}</p>
                    @endif
                @endforeach
                <div class="flex justify-end lg:hidden"><x-mary-badge value="{{ $log->created_at->diffForHumans() }}"
                        class="badge-primary badge-soft mt-4" /></div>
            </x-mary-card>
        @endforeach
    </x-slot:content>
</x-mary-collapse>
