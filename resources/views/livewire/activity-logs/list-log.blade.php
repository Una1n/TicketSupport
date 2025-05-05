<div>
    <x-mary-header title="Ticket Activity Logs" separator />
    <div class="card bg-base-100 p-5 pt-2 shadow-xs">
        <x-mary-table :headers="$headers" :rows="$logs" :sort-by="$sortBy" with-pagination>
        </x-mary-table>
    </div>
</div>
