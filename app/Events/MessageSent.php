<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class MessageSent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $user;
    public $message;

    public function __construct(User $user, $message)
    {
        $this->user = $user->name; // Send the user's name
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // We'll broadcast on a public channel called 'chat.general'
        return new Channel('chat.general');
    }

    public function broadcastWith()
    {
        return [
            'user'    => $this->user,
            'message' => $this->message,
        ];
    }
}
