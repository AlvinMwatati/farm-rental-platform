<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel; // ✅ Import PrivateChannel
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->message->recipient_id); // ✅ Use PrivateChannel
    }

    public function broadcastWith()
    {
        return [
            'sender_id' => $this->message->sender_id,
            'recipient_id' => $this->message->recipient_id,
            'message' => $this->message->message, // Use 'content' if your column is named "content"
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }
}