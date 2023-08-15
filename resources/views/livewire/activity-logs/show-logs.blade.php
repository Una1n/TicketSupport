<div>
    <div class="mt-4 text-xl font-bold">Logs</div>
    <div class="mb-4">
        @foreach ($logs as $log)
            <div class="mt-2 rounded-lg border border-orange-600 bg-orange-200 px-4 py-2 shadow-md">
                <div class="mb-1 text-xs">
                    @if ($log->event === 'created')
                        {{ $log->created_at->diffForHumans() }}
                        @if ($log->causer)
                            <span class="font-semibold"> by {{ $log->causer->name }}</span>
                        @endif
                    @else
                        {{ $log->updated_at->diffForHumans() }}
                        @if ($log->causer)
                            <span class="font-semibold"> by {{ $log->causer->name }}</span>
                        @endif
                    @endif
                </div>
                <div>
                    @if ($log->event === 'created')
                        Ticket Created
                    @else
                        Ticket Updated:</br>
                        @foreach ($log->changes->get('attributes') as $key => $attribute)
                            @if ($key === 'agent.name')
                                <p><span class="text-gray-500">Agent Assigned = </span> {{ $attribute }}</p>
                            @else
                                <p><span class="text-gray-500">{{ ucfirst($key) }} = </span> {{ $attribute }}</p>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
