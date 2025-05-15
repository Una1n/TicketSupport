<div>
    <x-mary-header title="Home" separator />
    <div class="flex gap-10 max-w-lg">
        <x-mary-stat title="Open Tickets" value="{{ $openTickets }}" icon="o-ticket" color="text-error"
            class="dark:bg-base-100 bg-base-300" />
        <x-mary-stat title="Closed Tickets" value="{{ $closedTickets }}" icon="o-ticket" color="text-success"
            class="dark:bg-base-100 bg-base-300" />
    </div>
</div>
