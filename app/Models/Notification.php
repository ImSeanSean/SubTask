<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public function task()
    {
        return $this->belongsTo(Tasks::class, 'task_id');
    }
}
