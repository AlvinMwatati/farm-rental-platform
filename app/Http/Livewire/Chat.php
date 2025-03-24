<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use App\Models\SharedPost;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent; // Ensure this event exists

class Chat extends Component
{
    public $users;
    public $messages;
    public $recipient_id;
    public $message = '';
    public $isSending = false;
     public $sharedPosts; // Add this property

    protected $listeners = ['echo-private:chat,MessageSent' => 'loadMessages'];

    public function mount($recipientId = null)
{
    $this->users = User::where('id', '!=', Auth::id())->get();
    $this->messages = collect();
    $this->sharedPosts = collect();

    if ($recipientId) {
        $this->recipient_id = $recipientId;
        $this->loadMessages();
        $this->loadSharedPosts();
    }
}


    public function selectUser($userId)
{
    if ($this->recipient_id !== $userId) { // Avoid reloading same chat
        $this->validateRecipient($userId);
        $this->recipient_id = $userId;
        $this->loadMessages();
        $this->loadSharedPosts();
    }
}


    public function loadMessages()
    {
        if ($this->recipient_id) {
            $this->messages = Message::with('sender')
                ->where(function ($query) {
                    $query->where('sender_id', Auth::id())
                          ->where('recipient_id', $this->recipient_id);
                })
                ->orWhere(function ($query) {
                    $query->where('sender_id', $this->recipient_id)
                          ->where('recipient_id', Auth::id());
                })
                
                ->orderBy('created_at', 'asc')
                ->get();
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $this->isSending = true;

        try {
            $message = Message::create([
                'sender_id' => Auth::id(),
                'recipient_id' => $this->recipient_id,
                'message' => $this->message, // Use the correct column name
            ]);

            $this->reset('message');
            broadcast(new MessageSent($message))->toOthers();
        } finally {
            $this->isSending = false;
        }
        $this->message = ''; // Clear input field
        $this->loadMessages();
    }

    protected function validateRecipient($userId)
    {
        abort_unless(
            User::where('id', $userId)
                ->where('id', '!=', Auth::id())
                ->exists(),
            404,
            'Recipient not found'
        );
    }

    // Custom validation messages
    public function messages()
    {
        return [
            'recipient_id.required' => 'Please select a user to chat with.',
            'recipient_id.exists' => 'The selected user does not exist.',
            'message.required' => 'A message is required.',
            'message.max' => 'The message cannot be longer than 1000 characters.',
        ];
    }

    public function loadSharedPosts()
{
    if ($this->recipient_id) {
        $this->sharedPosts = SharedPost::where('recipient_id', Auth::id())
            ->where('user_id', $this->recipient_id)
            ->with('post.user')
            ->latest()
            ->get();
    }
}

    public function render()
    {
        return view('livewire.chat', [
            'selectedUser' => $this->recipient_id 
                ? User::find($this->recipient_id)
                : null,
        ]);
    }
}