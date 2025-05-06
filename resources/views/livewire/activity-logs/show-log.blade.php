<div class="max-w-5xl">
    <x-mary-header title="Activity Log" separator />
    <x-mary-card title="{{ ucfirst($log->subject->title) }}" subtitle="{{ ucfirst($log->description) }}" shadow separator>
        <x-slot:menu>
            <x-mary-badge value="{{ $log->created_at->diffForHumans() }}" class="badge-primary badge-soft" />
        </x-slot:menu>
        <div class="grid grid-cols-5 gap-6">
            <div class="font-bold">Caused by:</div>
            <x-mary-badge value="{{ $log->causer?->name }}" class="col-span-4 badge-primary" />
            <div class="font-bold">Attributes:</div>
            <pre class="col-span-4 overflow-auto">{{ json_encode(json_decode($log->changes, true), JSON_PRETTY_PRINT) }}</pre>
        </div>
    </x-mary-card>
</div>
