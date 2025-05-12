<div>
    <x-mary-header title="Ticket Activity Logs" separator />
    <div class="card bg-base-100 p-5 pt-2 shadow-xs">
        <x-mary-table :headers="$headers" :rows="$logs" :sort-by="$sortBy" :link="route('logs.show', ['log' => '[id]'])" with-pagination>
            @scope('cell_subject.title', $log)
                @if ($log->description === 'deleted')
                    <div class="flex flex-col">
                        <div>{{ json_decode($log->properties, true)['old']['title'] }}</div>
                        <div class="text-base-content/30 lg:hidden">{{ $log->created_at->diffForHumans() }}</div>
                    </div>
                @else
                    <div class="flex flex-col">
                        @if ($log->subject)
                            <div>{{ $log->subject->title }}</div>
                        @else
                            @if ($log->description === 'updated')
                                <span class="text-error">[Title Unavailable]</span>
                            @else
                                {{ ucfirst(json_decode($log->properties, true)['attributes']['title']) }}
                            @endif
                        @endif
                        <div class="text-base-content/30 lg:hidden">{{ $log->created_at->diffForHumans() }}</div>
                    </div>
                @endif
            @endscope
            @scope('cell_icon', $log)
                @if ($log->description === 'updated')
                    <x-mary-icon name="o-pencil-square" class="text-warning" />
                @elseif ($log->description === 'created')
                    <x-mary-icon name="o-plus-circle" class="text-success" />
                @elseif ($log->description === 'deleted')
                    <x-mary-icon name="o-trash" class="text-error" />
                @endif
            @endscope
            @scope('cell_description', $log)
                @if ($log->description === 'updated')
                    <x-mary-icon name="o-pencil-square" class="text-warning" />
                @elseif ($log->description === 'created')
                    <x-mary-icon name="o-plus-circle" class="text-success" />
                @elseif ($log->description === 'deleted')
                    <x-mary-icon name="o-trash" class="text-error" />
                @endif
            @endscope
            @scope('cell_created_at', $log)
                {{ $log->created_at->diffForHumans() }}
            @endscope
        </x-mary-table>
    </div>
</div>
