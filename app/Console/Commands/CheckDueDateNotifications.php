<?php

namespace App\Console\Commands;

use App\Models\Tasks;
use App\Models\Notification;
use Illuminate\Console\Command;

class CheckDueDateNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-due-date-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Tasks::whereDate('due-date', now()->addDays(3))
            ->orWhereDate('due-date', now()->addDays(2))
            ->orWhereDate('due-date', now()->addDay())
            ->orWhereDate('due-date', now())
            ->get();

        foreach ($tasks as $task) {
            // Create a notification message based on the due date
            $dueDate = $task['due-date'];
            $today = now()->startOfDay();
            $daysUntilDue = $today->diffInDays($dueDate);
            if ($daysUntilDue === 0) {
                $message = "{$task->name} is due today.";
            } elseif ($daysUntilDue === 1) {
                $message = "{$task->name} is due tomorrow.";
            } else {
                $message = "{$task->name} is due in {$daysUntilDue} days.";
            }

            // Check if there's an existing notification for the task
            $existingNotification = Notification::where('task_id', $task->id)->first();

            if ($existingNotification) {
                // Delete the existing notification if it exists
                $existingNotification->delete();
            }

            // Create a new notification
            Notification::create([
                'message' => $message,
                'task_id' => $task->id,
            ]);
        }
        $this->info('Notifications checked and created successfully.');
    }
}
