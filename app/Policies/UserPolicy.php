<?php

namespace App\Policies;

use App\Models\ClienteEntrenador;
use App\Models\RegistroEntrenamiento;
use App\Models\User;

class UserPolicy
{
    public function verProgreso(User $usuarioActual, User $user): bool
    {
        if ((int) $usuarioActual->id === (int) $user->id) {
            return true;
        }

        return $usuarioActual->rol === 'entrenador'
            && ClienteEntrenador::existeRelacionActiva($usuarioActual->id, $user->id);
    }

    public function verRegistroEntreno(User $usuarioActual, User $user, RegistroEntrenamiento $registroEntrenamiento): bool
    {
        if ((int) $registroEntrenamiento->usuario_id !== (int) $user->id) {
            return false;
        }

        if ((int) $usuarioActual->id === (int) $user->id) {
            return true;
        }

        return $usuarioActual->rol === 'entrenador'
            && ClienteEntrenador::existeRelacionActiva($usuarioActual->id, $user->id);
    }

    public function registrarEntreno(User $usuarioActual, User $user, int $rutinaId): bool
    {
        if ((int) $usuarioActual->id !== (int) $user->id || $usuarioActual->rol !== 'usuario') {
            return false;
        }

        $user->loadMissing('asignacionRutinaActiva');

        return (int) $user->asignacionRutinaActiva?->rutina_id === $rutinaId;
    }

    public function registrarDiaEntreno(User $usuarioActual, User $user, int $rutinaId, int $diaEntrenoId): bool
    {
        if (! $this->registrarEntreno($usuarioActual, $user, $rutinaId)) {
            return false;
        }

        $user->loadMissing('asignacionRutinaActiva.rutina.diasEntreno');

        foreach ($user->asignacionRutinaActiva?->rutina?->diasEntreno ?? [] as $diaEntreno) {
            if ((int) $diaEntreno->id === $diaEntrenoId) {
                return true;
            }
        }

        return false;
    }

    public function asignarRutina(User $usuarioActual, User $user): bool
    {
        return $usuarioActual->rol === 'entrenador'
            && ClienteEntrenador::existeRelacionActiva($usuarioActual->id, $user->id);
    }

    public function desasignarRutina(User $usuarioActual, User $user): bool
    {
        return $this->asignarRutina($usuarioActual, $user);
    }

    public function editarRegistroEntreno(User $usuarioActual, User $user, RegistroEntrenamiento $registroEntrenamiento): bool
    {
        return (int) $registroEntrenamiento->usuario_id === (int) $user->id
            && (int) $usuarioActual->id === (int) $user->id;
    }

    public function eliminarRegistroEntreno(User $usuarioActual, User $user, RegistroEntrenamiento $registroEntrenamiento): bool
    {
        return $this->editarRegistroEntreno($usuarioActual, $user, $registroEntrenamiento);
    }
}
