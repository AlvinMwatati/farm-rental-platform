<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
{
    $users = \App\Models\User::where('id', '!=', auth()->id())->get();
    return view('chat', compact('users'));
}

// Get Messages for a Specific User
public function getMessages($recipientId)
{
    $messages = Message::where(function ($query) use ($recipientId) {
        $query->where('sender_id', auth()->id())
              ->where('recipient_id', $recipientId);
    })->orWhere(function ($query) use ($recipientId) {
        $query->where('sender_id', $recipientId)
              ->where('recipient_id', auth()->id());
    })->orderBy('created_at')->get();

    return response()->json(['messages' => $messages]);
}

// Send a Message
public function sendMessage(Request $request)
{
    $request->validate([
        'recipient_id' => 'required|exists:users,id',
        'content' => 'required|string',
    ]);

    $message = Message::create([
        'sender_id' => auth()->id(),
        'recipient_id' => $request->recipient_id,
        'content' => $request->content,
    ]);

    return response()->json(['message' => 'Message sent!', 'data' => $message]);
}

    
}
