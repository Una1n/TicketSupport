<div>
    <x-mary-header title="Ticket Activity Logs" separator />
    <x-mary-card>
        <x-mary-table :headers="$headers" :rows="$logs" :sort-by="$sortBy" :link="route('logs.show', ['log' => '[id]'])" with-pagination>
            @scope('cell_subject.title', $log)
                @if ($log->description === 'deleted')
                    <div class="flex flex-col">
                        <div class="max-w-45 truncate lg:max-w-full lg:text-nowrap">
                            {{ json_decode($log->properties, true)['old']['title'] }}</div>
                        <div class="text-base-content/30 lg:hidden">{{ $log->created_at->diffForHumans() }}</div>
                    </div>
                @else
                    <div class="flex flex-col">
                        @if ($log->subject)
                            <div class="max-w-45 lg:max-w-full truncate lg:text-nowrap">{{ $log->subject->title }}</div>
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
    </x-mary-card>
</div>
