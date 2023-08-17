<?php

namespace App\Livewire\ActivityLogs;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ListLog extends Component
{
    use WithPagination;

    public function render(): View
    {
        $logs = Activity::with(['subject', 'causer'])->latest()->paginate(10);

        return view('livewire.activity-logs.list-log', [
            'logs' => $logs,
        ]);
    }
}
