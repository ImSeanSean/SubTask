<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    // public function scopeFilter($query, array $filters)
    // {
    //     if ($filters['search'] ?? false) {
    //         $query->where('name', 'like', '%' . request('search') . '%');
    //     }
    //     if ($filters['sort'] ?? false) {
    //         $column = $filters['sort'];
    //         // If the sort column is 'date', change it to 'updated_at' for sorting by the last update time
    //         $query->orderBy($column, 'desc');
    //     }
    // }

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
