<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'last_message_id',
        'updated_at'
    ];

    /////////// RELACIONES

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function lastMessage(){
        return $this->belongsTo(Message::class, 'last_message_id');
    }

    public function userOne(){
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo(){
        return $this->belongsTo(User::class, 'user_two_id');
    }

    ////////////////////////////

	// Devuelve al otro participante de la conversación
    public function otherUser(int $userId): ?User{
        return $this->user_one_id === $userId ? $this->userTwo : $this->userOne;
    }

    public function getOtherAttribute(): ?User{
        $userId = Auth::id();
        return $this->user_one_id === $userId ? $this->userTwo : $this->userOne;
    }

    public function hasParticipant(int $userId): bool{
        return $this->user_one_id === $userId || $this->user_two_id === $userId;
    }

    public function scopeWhereParticipant(Builder $query, int $userId): Builder{
        return $query->where(function (Builder $q) use ($userId) {
            $q->where('user_one_id', $userId)
                ->orWhere('user_two_id', $userId);
        });
    }

    public function scopeWithChatSummary(Builder $query): Builder{
        return $query
            ->with(['userOne', 'userTwo', 'lastMessage.sender'])
            ->orderByDesc('updated_at');
    }

    public static function getConversaciones(int $userId)
    {
        return self::query()
            ->whereParticipant($userId)
            ->withChatSummary()
            ->simplePaginate(15);
    }

    public function cargarChat(): self{
        return $this->load([
            'userOne',
            'userTwo',
            'messages' => function ($q) {
                $q->with('sender')->orderBy('created_at');
            },
        ]);
    }

    public function hayMensajesEntrantesSinLeer(int $userId): bool{
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('leido', false)
            ->exists();
    }

    public function marcarMensajesEntrantesComoLeidos(int $userId): int{
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('leido', false)
            ->update(['leido' => true]);
    }

    public static function buscarEntreUsuarios($authId, $userId): ?self{
        return self::where(function ($q) use ($authId, $userId) {
            $q->where('user_one_id', $authId)
                ->where('user_two_id', $userId);
        })->orWhere(function ($q) use ($authId, $userId) {
            $q->where('user_one_id', $userId)
                ->where('user_two_id', $authId);
        })->first();
    }

    public static function obtenerOCrearEntreUsuarios($authId, $userId): self{
        $conversation = self::buscarEntreUsuarios($authId, $userId);

        if ($conversation) {
            return $conversation;
        }

        return self::create([
            'user_one_id' => $authId,
            'user_two_id' => $userId
        ]);
    }

	public static function conocidos(int $userId): array{
        $conversaciones = self::whereParticipant($userId)->get();
        $conocidos = [];

        foreach ($conversaciones as $conversation) {
            $otroUsuario = $conversation->otherUser($userId);

            if ($otroUsuario) {
                $conocidos[] = $otroUsuario->id;
            }
        }

        return $conocidos;
    }
}
