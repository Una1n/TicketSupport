<?php

namespace App\Livewire\ActivityLogs;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ShowLog extends Component
{
    public Activity $log;

    public function render(): View
    {
        return view('livewire.activity-logs.show-log');
    }
}
