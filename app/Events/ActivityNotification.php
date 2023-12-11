<?php

namespace App\Events;

use App\Models\subtasks;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActivityNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $actionType;
    public $actionDescription;
    public $task;
    public $subtask;

    public function __construct(User $user, $actionType, $actionDescription, Tasks $task = null, subtasks $subtask = null)
    {
        $this->user = $user;
        $this->actionType = $actionType;
        $this->actionDescription = $actionDescription;
        $this->task = $task;
        $this->subtask = $subtask;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
