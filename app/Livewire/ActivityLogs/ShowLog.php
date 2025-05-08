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
        $user = $this->log->causer;
        $role = null;
        if ($user) {
            $role = $user->roles()->first();
        }

        return view('livewire.activity-logs.show-log', [
            'role' => $role
        ]);
    }
}
