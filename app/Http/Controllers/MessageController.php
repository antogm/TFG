<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function store(StoreMessageRequest $request, Conversation $conversation)
    {
        $this->authorize('sendMessage', $conversation);

        DB::transaction(function () use ($request, $conversation) {
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $request->user()->id,
                'body' => $request->string('body')->toString(),
            ]);

            $conversation->update([
                'last_message_id' => $message->id,
                'updated_at' => now(),
            ]);
        });

        // Redirige a la vista de la conversación (ya con el nuevo mensaje)
        return redirect()->route('conversations.show', $conversation->id);
    }
}