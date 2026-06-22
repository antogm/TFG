<?php

namespace App\Services\Rutina;

use App\Models\RegistroEntrenamiento;
use App\Models\Rutina;
use App\Models\User;

class RutinaService
{
    public function getDatosRutina(int $rutinaId, User $usuario): array
    {
        $rutina = Rutina::getRutina($rutinaId, $usuario);

        $diasEntreno = $rutina->diasEntreno->sortBy('orden')->values();

        foreach ($diasEntreno as $dia) {
            $this->prepararDia($dia, collect(), false);
        }

        $mostrarBotonRegistro = false;

        if ($usuario->rol === 'usuario') {
            $mostrarBotonRegistro = $rutina->usuarioTieneAsignacion($usuario);
        }

        $puedeEditarRutina = $usuario->can('update', $rutina);
        $puedeEliminarRutina = $usuario->can('delete', $rutina);

        return [
            'rutina' => $rutina,
            'modoRegistro' => false,
            'mostrarBotonRegistro' => $mostrarBotonRegistro,
            'registroEntrenamiento' => null,
            'modoEdicionRegistro' => false,
            'diasEntreno' => $diasEntreno,
            'diaInicialId' => $diasEntreno->first()?->id,
            'adherenciaDietaGuardada' => null,
            'pasosRealizadosGuardados' => null,
            'notasGuardadas' => null,
            'puedeEditarRutina' => $puedeEditarRutina,
            'puedeEliminarRutina' => $puedeEliminarRutina,
        ];
    }

    public function getDatosCreateRegistro(Rutina $rutina): array
    {
        $diasEntreno = $rutina->diasEntreno->sortBy('orden')->values();

        foreach ($diasEntreno as $dia) {
            $this->prepararDia($dia, collect(), true);
        }

        return [
            'rutina' => $rutina,
            'modoRegistro' => true,
            'mostrarBotonRegistro' => false,
            'registroEntrenamiento' => null,
            'modoEdicionRegistro' => false,
            'diasEntreno' => $diasEntreno,
            'diaInicialId' => $diasEntreno->first()?->id,
            'adherenciaDietaGuardada' => null,
            'pasosRealizadosGuardados' => null,
            'notasGuardadas' => null,
            'puedeEditarRutina' => false,
            'puedeEliminarRutina' => false,
        ];
    }

    public function getDatosEditRegistro(Rutina $rutina, RegistroEntrenamiento $registroEntrenamiento): array
    {
        $diasEntreno = $rutina->diasEntreno
            ->sortBy('orden')
            ->where('id', (int) $registroEntrenamiento->dia_entreno_id)
            ->values();

        $registrosEjercicios = $registroEntrenamiento->registrosEjercicios->keyBy('dia_entreno_ejercicio_id');

        foreach ($diasEntreno as $dia) {
            $this->prepararDia($dia, $registrosEjercicios, true);
        }

        return [
            'rutina' => $rutina,
            'modoRegistro' => true,
            'mostrarBotonRegistro' => false,
            'registroEntrenamiento' => $registroEntrenamiento,
            'modoEdicionRegistro' => true,
            'diasEntreno' => $diasEntreno,
            'diaInicialId' => $diasEntreno->first()?->id,
            'adherenciaDietaGuardada' => $registroEntrenamiento->adherencia_dieta !== null
                ? (string) (int) $registroEntrenamiento->adherencia_dieta
                : null,
            'pasosRealizadosGuardados' => $registroEntrenamiento->pasos_realizados,
            'notasGuardadas' => $registroEntrenamiento->notas,
            'puedeEditarRutina' => false,
            'puedeEliminarRutina' => false,
        ];
    }

    private function prepararDia($dia, $registrosEjercicios, bool $modoRegistro): void
    {
        if ($dia->nombre) {
            $dia->nombre_detalle = __('views.day_number', ['number' => $dia->orden]) . ': ' . $dia->nombre;
        } else {
            $dia->nombre_detalle = __('views.day_number', ['number' => $dia->orden]);
        }

        $dia->numero_ejercicios_label = trans_choice(
            'views.exercise_count_singular',
            $dia->ejerciciosProgramados->count(),
            ['count' => $dia->ejerciciosProgramados->count()]
        );

        $ejerciciosDetalle = $dia->ejerciciosProgramados->sortBy('orden')->values();

        if ($modoRegistro) {
            foreach ($ejerciciosDetalle as $ejercicioProgramado) {
                $registroEjercicio = $registrosEjercicios->get($ejercicioProgramado->id);

                $ejercicioProgramado->series_registro = $registroEjercicio?->series_realizadas ?? $ejercicioProgramado->series;
                $ejercicioProgramado->repeticiones_registro = $registroEjercicio?->repeticiones_realizadas ?? $ejercicioProgramado->repeticiones;
                $ejercicioProgramado->carga_registro = $registroEjercicio?->peso_utilizado ?? $ejercicioProgramado->carga;
                $ejercicioProgramado->duracion_registro = $registroEjercicio?->duracion ?? $ejercicioProgramado->duracion_segundos;
            }
        }

        $dia->setRelation('ejerciciosDetalle', $ejerciciosDetalle);
    }
}
