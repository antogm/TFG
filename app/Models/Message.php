<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'body',
        'leido',
        'created_at'
    ];

    protected $casts = [
        'leido' => 'boolean',
    ];

    public function getBodyAttribute(string $mensaje_encriptado)
    {
        return Crypt::decryptString($mensaje_encriptado);
    }

    public function setBodyAttribute(string $mensaje)
    {
        $this->attributes['body'] = Crypt::encryptString($mensaje);
    }

    /////////// RELACIONES

    public function conversation(): BelongsTo{
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo{
        return $this->belongsTo(User::class, 'sender_id');
    }

    ////////////////////////////

    protected static function booted(){
        static::created(function ($message) {
            $message->conversation->update([
                'last_message_id' => $message->id
            ]);
        });
    }
}
