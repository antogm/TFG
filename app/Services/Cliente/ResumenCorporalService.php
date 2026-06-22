<?php

namespace App\Services\Cliente;

use App\Models\RegistroCorporal;
use App\Models\User;

class ResumenCorporalService
{
    public function getResumenCorporal(User $user): array
    {
        return [
            'peso' => $user->ultimoRegistroCorporal?->peso,
            'masa_muscular' => $user->ultimoRegistroMasaMuscular?->masa_muscular,
            'porcentaje_grasa' => $user->ultimoRegistroGrasaCorporal?->porcentaje_grasa,
        ];
    }

    public function getVariacionesCorporales(User $user): array
    {
        $registrosCorporales = $user->getRegistrosCorporalesGrafica();

        $ultimoRegistro = $registrosCorporales->last();
        $registroAnterior = $registrosCorporales->count() > 1
            ? $registrosCorporales->get($registrosCorporales->count() - 2)
            : null;

        return $this->formatearVariacionCorporal($registroAnterior, $ultimoRegistro, $user->objetivo);
    }

    private function formatearVariacionCorporal(?RegistroCorporal $registroAnterior, ?RegistroCorporal $ultimoRegistro, string $objetivo): array
    {
        $variaciones = [
            'peso' => ['valor' => '--', 'estado' => 'neutro'],
            'masa_muscular' => ['valor' => '--', 'estado' => 'neutro'],
            'porcentaje_grasa' => ['valor' => '--', 'estado' => 'neutro'],
        ];

        if (! $registroAnterior || ! $ultimoRegistro) {
            return $variaciones;
        }

        return [
            'peso' => $this->getVariacionPeso($registroAnterior, $ultimoRegistro, $objetivo),
            'masa_muscular' => $this->getVariacionMasaMuscular($registroAnterior, $ultimoRegistro),
            'porcentaje_grasa' => $this->getVariacionGrasaCorporal($registroAnterior, $ultimoRegistro),
        ];
    }

    private function getVariacionPeso(RegistroCorporal $registroAnterior, RegistroCorporal $ultimoRegistro, string $objetivo): array
    {
        // Calcula la diferencia de peso
        $variacion = (float) $ultimoRegistro->peso - (float) $registroAnterior->peso;

        // Prepara el texto que se mostrara en la tarjeta.
        $signo = '';
        if ($variacion > 0) {
            $signo = '+';
        }
        $valor = $signo . number_format($variacion, 2) . ' kg';

        // Decide si la variacion es positiva o negativa segun el objetivo.
        $estado = 'neutro';
        if ($objetivo === 'Pérdida de grasa') {
            if ($variacion < 0) {
                $estado = 'positivo';
            } elseif ($variacion > 0) {
                $estado = 'negativo';
            }
        } elseif ($objetivo === 'Aumento de masa muscular') {
            if ($variacion > 0) {
                $estado = 'positivo';
            } elseif ($variacion < 0) {
                $estado = 'negativo';
            }
        }

        // Devuelve el texto y el estado para que la vista pinte el color.
        return ['valor' => $valor, 'estado' => $estado];
    }

    private function getVariacionMasaMuscular(RegistroCorporal $registroAnterior, RegistroCorporal $ultimoRegistro): array
    {
        // Comprueba que ambos registros tengan masa muscular.
        if ($registroAnterior->masa_muscular === null || $ultimoRegistro->masa_muscular === null) {
            return ['valor' => '--', 'estado' => 'neutro'];
        }

        // Calcula la diferencia de masa muscular
        $variacion = (float) $ultimoRegistro->masa_muscular - (float) $registroAnterior->masa_muscular;

        // Prepara el texto que se mostrara en la tarjeta.
        $signo = '';
        if ($variacion > 0) {
            $signo = '+';
        }
        $valor = $signo . number_format($variacion, 2) . ' kg';

        // Decide si la variacion es buena, mala o neutra.
        $estado = 'neutro';
        if ($variacion > 0) {
            $estado = 'positivo';
        } elseif ($variacion < 0) {
            $estado = 'negativo';
        }

        // Devuelve el texto y el estado para que la vista pinte el color.
        return ['valor' => $valor, 'estado' => $estado];
    }

    private function getVariacionGrasaCorporal(RegistroCorporal $registroAnterior, RegistroCorporal $ultimoRegistro): array
    {
        // Comprueba que ambos registros tengan grasa corporal.
        if ($registroAnterior->porcentaje_grasa === null || $ultimoRegistro->porcentaje_grasa === null) {
            return ['valor' => '--', 'estado' => 'neutro'];
        }

        // Calcula la diferencia de grasa corporal
        $variacion = (float) $ultimoRegistro->porcentaje_grasa - (float) $registroAnterior->porcentaje_grasa;

        // Prepara el texto que se mostrara en la tarjeta.
        $signo = '';
        if ($variacion > 0) {
            $signo = '+';
        }
        $valor = $signo . number_format($variacion, 2) . ' %';

        // Decide si la variacion es buena, mala o neutra.
        $estado = 'neutro';
        if ($variacion < 0) {
            $estado = 'positivo';
        } elseif ($variacion > 0) {
            $estado = 'negativo';
        }

        // Devuelve el texto y el estado para que la vista pinte el color.
        return ['valor' => $valor, 'estado' => $estado];
    }
}
