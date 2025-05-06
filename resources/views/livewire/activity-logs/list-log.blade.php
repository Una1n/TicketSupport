<div>
    <x-mary-header title="Ticket Activity Logs" separator />
    <div class="card bg-base-100 p-5 pt-2 shadow-xs">
        <x-mary-table :headers="$headers" :rows="$logs" :sort-by="$sortBy" :link="route('logs.show', ['log' => '[id]'])" with-pagination>
            @scope('cell_created_at', $log)
                {{ $log->created_at->diffForHumans() }}
            @endscope
        </x-mary-table>
    </div>
</div>
