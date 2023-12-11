<?php

namespace App\Models;

use App\Events\ActivityNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class subtasks extends Model
{
    use HasFactory;

    public function task()
    {
        return $this->belongsTo(Tasks::class, 'task_id');
    }

    protected static function booted()
    {
        static::created(function ($subtask) {
            if ($subtask->status) {
                $subtask->task->increment('completed_subtasks_count');
                $task = $subtask->task;
                // Check if all subtasks have a status of 1
                $allSubtasksCompleted = $task->subtasks->every(fn ($subtask) => $subtask->status);
                // If all subtasks are completed, set the task's status to true
                if ($allSubtasksCompleted) {
                    $task->update(['status' => true]);
                } else {
                    $task->update(['status' => false]);
                }
            }
        });

        static::updated(function ($subtask) {
            if ($subtask->isDirty('status')) {
                $task = $subtask->task;

                if ($subtask->status) {
                    $task->increment('completed_subtasks_count');
                    event(new ActivityNotification(auth()->user(), 'Subtask Completed', $subtask->name . ' from ' . $task->name . ' has been completed.', $task, $subtask));
                } else {
                    $task->decrement('completed_subtasks_count');
                    event(new ActivityNotification(auth()->user(), 'Subtask Undone', $subtask->name . ' from ' . $task->name . ' has been undone.', $task, $subtask));
                }
                // Check if all subtasks have a status of 1
                $allSubtasksCompleted = $task->subtasks->every(fn ($subtask) => $subtask->status);
                // If all subtasks are completed, set the task's status to true
                if ($allSubtasksCompleted) {
                    $task->update(['status' => true]);
                    event(new ActivityNotification(auth()->user(), 'Task Completed', $task->name . ' has been completed.', $task));
                } else {
                    $task->update(['status' => false]);
                }
            }
        });

        static::deleted(function ($subtask) {
            if ($subtask->status) {
                $subtask->task->decrement('completed_subtasks_count');
                $task = $subtask->task;
                event(new ActivityNotification(auth()->user(), 'Subtask Deleted', $subtask->name . ' from ' . $task->name . ' has been deleted.', $task, $subtask));
                // Check if all subtasks have a status of 1
                $allSubtasksCompleted = $task->subtasks->every(fn ($subtask) => $subtask->status);
                // If all subtasks are completed, set the task's status to true
                if ($allSubtasksCompleted) {
                    $task->update(['status' => true]);
                } else {
                    $task->update(['status' => false]);
                }
            }
        });
    }
}
