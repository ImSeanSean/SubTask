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
            }
        });

        static::updated(function ($subtask) {
            if ($subtask->isDirty('status')) {
                if ($subtask->status) {
                    $subtask->task->increment('completed_subtasks_count');
                } else {
                    $subtask->task->decrement('completed_subtasks_count');
                }
            }
        });

        static::deleted(function ($subtask) {
            if ($subtask->status) {
                $subtask->task->decrement('completed_subtasks_count');
            }
        });
    }
}
