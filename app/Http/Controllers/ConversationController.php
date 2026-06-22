<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $conversations = Conversation::getConversaciones($request->user()->id);

        return view('conversations.lista-conversaciones', compact('conversations'));
    }

    public function show(Conversation $conversation){
        $userId = Auth::id();
        $this->authorize('view', $conversation);

        if ($conversation->hayMensajesEntrantesSinLeer($userId)) {
            $conversation->marcarMensajesEntrantesComoLeidos($userId);
        }

        $conversation->cargarChat();

        return view('conversations.show', compact('conversation'));
    }

    public function start($userId){
        $authId = Auth::id();

        // Evitar conversación consigo mismo
        if ($authId == $userId) {
            abort(403);
        }

        $conversation = Conversation::buscarEntreUsuarios($authId, $userId);

        if ($conversation) {
            return redirect()->to("/conversations/{$conversation->id}");
        }

        $user = User::findOrFail($userId);

        if ($user->bloquear_mensajes_desconocidos) {
            return redirect()
                ->back()
                ->with('error', __("views.unknown_messages_blocked"));
        }

        $conversation = Conversation::obtenerOCrearEntreUsuarios($authId, $userId);

        return redirect()->to("/conversations/{$conversation->id}");
    }
}
