<?php

namespace App\Policies;

use App\Models\Ejercicio;
use App\Models\User;

class EjercicioPolicy
{
    public function create(User $user): bool
    {
        return $user->rol === 'entrenador';
    }

    public function update(User $user, Ejercicio $ejercicio): bool
    {
        return $user->rol === 'entrenador';
    }
}
