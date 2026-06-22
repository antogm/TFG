<?php

namespace App\Policies;

use App\Models\RegistroCorporal;
use App\Models\User;

class RegistroCorporalPolicy
{
    public function view(User $user, RegistroCorporal $registroCorporal): bool
    {
        return $registroCorporal->puedeVer($user);
    }

    public function update(User $user, RegistroCorporal $registroCorporal): bool
    {
        return $registroCorporal->esPropietario($user->id);
    }

    public function delete(User $user, RegistroCorporal $registroCorporal): bool
    {
        return $this->update($user, $registroCorporal);
    }
}
