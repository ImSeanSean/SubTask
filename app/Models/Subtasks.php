<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
                } else {
                    $task->decrement('completed_subtasks_count');
                }
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

        static::deleted(function ($subtask) {
            if ($subtask->status) {
                $subtask->task->decrement('completed_subtasks_count');
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
    }
}
