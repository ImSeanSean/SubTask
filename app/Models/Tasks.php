<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    //Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    //Relationship to Subtasks
    public function subtasks()
    {
        return $this->hasMany(Subtasks::class, 'task_id');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'task_id');
    }
}
