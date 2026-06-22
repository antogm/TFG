<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class RegistroEntrenamiento extends Model
{
    protected $fillable = [
        'usuario_id',
        'asignacion_rutina_id',
        'dia_entreno_id',
        'nombre',
        'fecha_entrenamiento',
        'pasos_realizados',
        'adherencia_dieta',
        'notas',
    ];

    protected $casts = [
        'fecha_entrenamiento' => 'date',
        'adherencia_dieta' => 'boolean',
    ];

    /////////// RELACIONES

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function asignacionRutina(): BelongsTo
    {
        return $this->belongsTo(AsignacionRutina::class, 'asignacion_rutina_id');
    }

    public function diaEntreno(): BelongsTo
    {
        return $this->belongsTo(DiaEntreno::class, 'dia_entreno_id');
    }

    public function registrosEjercicios(): HasMany
    {
        return $this->hasMany(RegistroEjercicio::class, 'registro_entrenamiento_id');
    }

    ////////////////////////////

    public function getNombreAttribute(?string $value): ?string
    {
        return $value;
    }

    public static function createRegistroEntrenamiento(AsignacionRutina $asignacionRutina, DiaEntreno $diaEntreno, array $registroEjercicios, array $resumenDia, int $usuarioId): self
    {
        return DB::transaction(function () use ($asignacionRutina, $diaEntreno, $registroEjercicios, $resumenDia, $usuarioId) {
            $fechaEntrenamiento = now()->toDateString();
            $nombreDia = $diaEntreno->nombre ?: __('views.day_number', ['number' => $diaEntreno->orden]);
            $nombreEntreno = $nombreDia . ' - ' . date('d/m/Y', strtotime($fechaEntrenamiento));

            $registroEntrenamiento = new self();
            $registroEntrenamiento->usuario_id = $usuarioId;
            $registroEntrenamiento->dia_entreno_id = $diaEntreno->id;
            $registroEntrenamiento->nombre = $nombreEntreno;
            $registroEntrenamiento->fecha_entrenamiento = $fechaEntrenamiento;
            $registroEntrenamiento->pasos_realizados = (int) $resumenDia['pasos_realizados'];
            $registroEntrenamiento->adherencia_dieta = (bool) $resumenDia['adherencia_dieta'];
            $registroEntrenamiento->notas = $resumenDia['notas'] ?? null;

            $asignacionRutina->registrosEntrenamientos()->saveOrFail($registroEntrenamiento);

            $ejercicios = self::getDatosEjercicios($diaEntreno, $registroEjercicios);
            $registroEntrenamiento->registrosEjercicios()->createMany($ejercicios);

            return $registroEntrenamiento;
        });
    }

    public function updateRegistroEntrenamiento(DiaEntreno $diaEntreno, array $registroEjercicios, array $resumenDia): void
    {
        $this->update([
            'pasos_realizados' => (int) $resumenDia['pasos_realizados'],
            'adherencia_dieta' => (bool) $resumenDia['adherencia_dieta'],
            'notas' => $resumenDia['notas'] ?? null,
        ]);

        foreach (self::getDatosEjercicios($diaEntreno, $registroEjercicios) as $datosEjercicio) {
            $this->registrosEjercicios()->updateOrCreate(
                ['dia_entreno_ejercicio_id' => $datosEjercicio['dia_entreno_ejercicio_id']],
                $datosEjercicio
            );
        }
    }

    private static function getDatosEjercicios(DiaEntreno $diaEntreno, array $registroEjercicios): array
    {
        $ejercicios = [];

        foreach ($diaEntreno->ejerciciosProgramados->sortBy('orden') as $ejercicioProgramado) {
            $datosEjercicio = $registroEjercicios[$ejercicioProgramado->id] ?? [];
            $seriesRealizadas = $ejercicioProgramado->series;
            $repeticionesRealizadas = $ejercicioProgramado->repeticiones;
            $pesoUtilizado = null;
            $duracion = null;

            if (isset($datosEjercicio['series']) && $datosEjercicio['series'] !== '') {
                $seriesRealizadas = (int) $datosEjercicio['series'];
            }

            if (isset($datosEjercicio['repeticiones']) && $datosEjercicio['repeticiones'] !== '') {
                $repeticionesRealizadas = (int) $datosEjercicio['repeticiones'];
            }

            if (isset($datosEjercicio['carga']) && $datosEjercicio['carga'] !== '') {
                $pesoUtilizado = (float) $datosEjercicio['carga'];
            }

            if (isset($datosEjercicio['duracion_segundos']) && $datosEjercicio['duracion_segundos'] !== '') {
                $duracion = (int) $datosEjercicio['duracion_segundos'];
            }

            $ejercicios[] = [
                'dia_entreno_ejercicio_id' => $ejercicioProgramado->id,
                'series_realizadas' => $seriesRealizadas,
                'repeticiones_realizadas' => $repeticionesRealizadas,
                'peso_utilizado' => $pesoUtilizado,
                'duracion' => $duracion,
            ];
        }

        return $ejercicios;
    }
}
