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
        ['key' => 'icon', 'label' => '', 'sortable' => false, 'class' => 'lg:hidden'],
        [
            'key' => 'subject.title', 'label' => 'Title', 'sortable' => false,
            'class' => 'whitespace-nowrap'],
        [
            'key' => 'description', 'label' => 'Status',
            'class' => 'hidden text-center lg:table-cell'
        ],
        [
            'key' => 'causer.name', 'label' => 'Caused By', 'sortable' => false,
            'class' => 'hidden lg:table-cell'
        ],
        ['key' => 'created_at', 'label' => 'Created', 'class' => 'hidden lg:table-cell'],
    ];
    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

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
