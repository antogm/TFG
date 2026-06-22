<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistroEjercicio extends Model
{
    protected $fillable = [
        'registro_entrenamiento_id',
        'dia_entreno_ejercicio_id',
        'series_realizadas',
        'repeticiones_realizadas',
        'peso_utilizado',
        'duracion',
    ];

    protected $casts = [
        'series_realizadas' => 'integer',
        'repeticiones_realizadas' => 'integer',
        'peso_utilizado' => 'decimal:2',
        'duracion' => 'integer',
    ];

    /////////// RELACIONES

    public function registroEntrenamiento(): BelongsTo
    {
        return $this->belongsTo(RegistroEntrenamiento::class, 'registro_entrenamiento_id');
    }

    public function diaEntrenoEjercicio(): BelongsTo
    {
        return $this->belongsTo(DiaEntrenoEjercicio::class, 'dia_entreno_ejercicio_id');
    }

    ////////////////////////////
}
