<div>
    <x-mary-header title="Home" separator />
    <div class="flex gap-10 max-w-lg">
        <x-mary-stat title="Open Tickets" value="{{ $openTickets }}" icon="o-ticket" color="text-error" />
        <x-mary-stat title="Closed Tickets" value="{{ $closedTickets }}" icon="o-ticket" color="text-success" />
    </div>
</div>
