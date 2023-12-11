<?php

namespace App\Listeners;

use App\Events\ActivityNotification;
use App\Models\ActivityLogs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogActivityNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ActivityNotification $event)
    {
        $logData = [
            'user_id' => $event->user->id,
            'log_type' => $event->actionType,
            'description' => $event->actionDescription,
            'task_id' => $event->task ? $event->task->id : null,
            'subtask_id' => $event->subtask ? $event->subtask->id : null,
        ];

        ActivityLogs::create($logData);
    }
}
