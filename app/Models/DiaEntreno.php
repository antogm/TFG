<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiaEntreno extends Model
{
    protected $table = 'dia_entrenos';

    protected $fillable = [
        'rutina_id',
        'nombre',
        'descripcion',
        'orden',
    ];

    /////////// RELACIONES

    public function rutina(): BelongsTo
    {
        return $this->belongsTo(Rutina::class, 'rutina_id');
    }

    public function ejercicios(): HasMany
    {
        return $this->hasMany(DiaEntrenoEjercicio::class, 'dia_entreno_id');
    }

    public function ejerciciosProgramados(): HasMany
    {
        return $this->hasMany(DiaEntrenoEjercicio::class, 'dia_entreno_id');
    }

    public function registrosEntrenamientos(): HasMany
    {
        return $this->hasMany(RegistroEntrenamiento::class, 'dia_entreno_id');
    }

    ////////////////////////////

    public function guardarEjerciciosProgramados(array $ejercicios): void
    {
        foreach (array_values($ejercicios) as $index => $ejercicio) {
            $this->ejerciciosProgramados()->create([
                'ejercicio_id' => $ejercicio['ejercicio_id'],
                'series' => $ejercicio['series'],
                'repeticiones' => $ejercicio['repeticiones'],
                'carga' => $ejercicio['carga'] ?? null,
                'duracion_segundos' => $ejercicio['duracion_segundos'] ?? null,
                'orden' => $index + 1,
            ]);
        }
    }
}
