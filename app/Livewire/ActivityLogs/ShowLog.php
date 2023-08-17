<?php

namespace App\Livewire\ActivityLogs;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ShowLog extends Component
{
    public Activity $log;

    public function render()
    {
        return view('livewire.activity-logs.show-log');
    }
}
