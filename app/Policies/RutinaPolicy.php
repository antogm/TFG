<?php

namespace App\Policies;

use App\Models\Rutina;
use App\Models\User;

class RutinaPolicy
{
    public function create(User $user): bool
    {
        return $user->rol === 'entrenador';
    }

    public function update(User $user, Rutina $rutina): bool
    {
        return $user->rol === 'entrenador'
            && (int) $rutina->autor_id === (int) $user->id;
    }

    public function delete(User $user, Rutina $rutina): bool
    {
        return $this->update($user, $rutina);
    }
}
