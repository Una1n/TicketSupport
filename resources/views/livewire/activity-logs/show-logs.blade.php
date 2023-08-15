<div>
    @foreach ($logs as $log)
        <div class="mt-4 rounded-lg border border-orange-600 bg-orange-200 px-4 py-2 shadow-md">
            <div class="mb-1 text-xs">
                @if ($log->event === 'created')
                    {{ $log->created_at->diffForHumans() }} by
                    <span class="font-semibold">{{ $log->causer->name }}</span>
                @else
                    {{ $log->updated_at->diffForHumans() }} by
                    <span class="font-semibold">{{ $log->causer->name }}</span>
                @endif
            </div>
            <div class="col-span-5">
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
