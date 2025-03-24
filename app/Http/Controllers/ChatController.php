<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Chat Page
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $users = User::where('id', '!=', Auth::id())
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->get();

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
        })->orderBy('created_at', 'asc')->get(); // ✅ Fixed sorting direction

        return response()->json(['messages' => $messages]);
    }

    // Send a Message
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $validated['recipient_id'],
            'message' => $validated['message'],
        ]);

        return response()->json(['message' => 'Message sent!', 'data' => $message]);
    }

    public function startChat($userId)
    {
        $receiver = User::findOrFail($userId);

        return view('chat', compact('receiver'));
    }

    public function startChat2($user)
    {
        // $user contains the listing owner's ID.
        $receiver = User::findOrFail($user);
        return view('chat', compact('receiver'));
    }
}
