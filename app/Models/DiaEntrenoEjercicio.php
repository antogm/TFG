<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiaEntrenoEjercicio extends Model
{
    protected $table = 'dia_entreno_ejercicios';

    protected $fillable = [
        'dia_entreno_id',
        'ejercicio_id',
        'series',
        'repeticiones',
        'carga',
        'duracion_segundos',
        'orden',
    ];

    /////////// RELACIONES

    public function diaEntreno(): BelongsTo
    {
        return $this->belongsTo(DiaEntreno::class, 'dia_entreno_id');
    }

    public function ejercicio(): BelongsTo
    {
        return $this->belongsTo(Ejercicio::class, 'ejercicio_id');
    }

    public function registrosEjercicios(): HasMany
    {
        return $this->hasMany(RegistroEjercicio::class, 'dia_entreno_ejercicio_id');
    }

    ////////////////////////////
}
