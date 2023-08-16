<?php

namespace App\Livewire\ActivityLogs;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ListLog extends Component
{
    use WithPagination;

    public function render()
    {
        $logs = Activity::with(['subject', 'causer'])->latest()->paginate(10);

        return view('livewire.activity-logs.list-log', [
            'logs' => $logs,
        ]);
    }
}
