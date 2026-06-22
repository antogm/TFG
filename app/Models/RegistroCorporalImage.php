<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class RegistroCorporalImage extends Model
{
    protected $fillable = [
        'path',
    ];

    public function registroCorporal(): BelongsTo
    {
        return $this->belongsTo(RegistroCorporal::class, 'registro_corporal_id');
    }

    public function getUrlAttribute(): string
    {
        return route('registrocorporal.imagenes.show', ['id_usuario' => $this->registroCorporal->usuario_id, 'imagen' => $this]);
    }

    protected static function booted(): void
    {
        static::deleting(function (self $imagen): void {
            Storage::disk('local')->delete($imagen->path);
        });
    }
}
