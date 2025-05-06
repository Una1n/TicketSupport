<?php

namespace App\Livewire\ActivityLogs;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ListLog extends Component
{
    use WithPagination;

    public array $headers = [
        ['key' => 'subject.title', 'label' => 'Title', 'sortable' => false],
        ['key' => 'description', 'label' => 'Description'],
        ['key' => 'causer.name', 'label' => 'Caused By', 'sortable' => false],
        ['key' => 'created_at', 'label' => 'Created'],
    ];
    public array $sortBy = ['column' => 'created_at', 'direction' => 'asc'];

    public function render(): View
    {
        $logs = Activity::with(['subject', 'causer'])
            ->orderBy(...array_values($this->sortBy))
            ->latest()->paginate(10);

        return view('livewire.activity-logs.list-log', [
            'logs' => $logs,
        ]);
    }
}
