<?php

namespace App\Services\Cliente;

use App\Models\RegistroCorporal;
use App\Models\RegistroEntrenamiento;
use App\Models\User;
use Illuminate\Support\Collection;

class ClienteProgresoService
{
    public function __construct(private ResumenCorporalService $resumenCorporalService)
    {
    }

    // Reune todos los datos que necesita la vista del panel de progreso.
    public function getDatosProgreso(User $user, User $usuarioActual): array
    {
        $user->cargarDatosProgreso();

        $asignacionRutinaActiva = $user->asignacionRutinaActiva;
        $registrosCorporales = $user->getRegistrosCorporalesGrafica();
        $registrosEntrenos = $user->getRegistrosEntrenamientosGrafica();

        return [
            'user' => $user,
            'resumenCorporal' => $this->resumenCorporalService->getResumenCorporal($user),
            'variacionesCorporales' => $this->resumenCorporalService->getVariacionesCorporales($user),
            'asignacionRutinaActiva' => $asignacionRutinaActiva,
            'rutinaAsignada' => $asignacionRutinaActiva?->rutina,
            'entrenadorAsignado' => $user->entrenadorAsignado,
            'esSuEntrenador' => (int) $usuarioActual->id !== (int) $user->id,
            'rutinasDisponibles' => $usuarioActual->getRutinas(),
            'ultimosEntrenos' => $this->getUltimosEntrenos($registrosEntrenos),
            'datosGrafica' => $this->getDatosGrafica($registrosCorporales, $registrosEntrenos),
        ];
    }

    // Devuelve los ultimos entrenamientos que se muestran en el panel.
    private function getUltimosEntrenos(Collection $registrosEntrenos): Collection
    {
        return $registrosEntrenos
            ->sortByDesc('fecha_entrenamiento')
            ->take(5)
            ->map(function (RegistroEntrenamiento $registroEntreno) {
                return [
                    'fecha' => $registroEntreno->fecha_entrenamiento ? date('d/m/Y', strtotime($registroEntreno->fecha_entrenamiento)) : '-',
                    'nombre' => $registroEntreno->nombre,
                ];
            });
    }

    // Prepara todos los datos que necesita la grafica.
    private function getDatosGrafica(Collection $registrosCorporales, Collection $registrosEntrenos): array
    {
        $datos = [];
        $intervalos = [
            '7d' => date('Y-m-d', strtotime('-7 days')),
            '30d' => date('Y-m-d', strtotime('-30 days')),
            '6m' => date('Y-m-d', strtotime('-6 months')),
            'all' => null,
        ];

        foreach ($intervalos as $periodo => $fechaInicio) {
            $datos['peso'][$periodo] = $this->getDatosCorporales($registrosCorporales, $fechaInicio, 'peso');
            $datos['masa'][$periodo] = $this->getDatosCorporales($registrosCorporales, $fechaInicio, 'masa_muscular');
            $datos['grasa'][$periodo] = $this->getDatosCorporales($registrosCorporales, $fechaInicio, 'porcentaje_grasa');
            $datos['pasos'][$periodo] = $this->getDatosPasos($registrosEntrenos, $fechaInicio);
        }

        return $datos;
    }

    // Prepara los datos de peso, masa muscular o grasa corporal para la grafica.
    private function getDatosCorporales(Collection $registros, ?string $fechaInicio, string $campo): array
    {
        $labels = [];
        $values = [];
        $unit = __('progress-chart.units.kg');

        switch ($campo) {
            case 'peso':
                $label = __('progress-chart.metrics.peso');
                break;
            case 'masa_muscular':
                $label = __('progress-chart.metrics.masa');
                break;
            case 'porcentaje_grasa':
                $label = __('progress-chart.metrics.grasa');
                $unit = __('progress-chart.units.percent');
                break;
            default:
                $label = __('progress-chart.metrics.grasa');
                break;
        }

        foreach ($registros as $registro) {
            $fechaRegistro = (string) $registro->fecha_registro;

            if ($fechaInicio && substr($fechaRegistro, 0, 10) < $fechaInicio) {
                continue;
            }

            if ($registro->{$campo} === null) {
                continue;
            }

            $labels[] = date('d/m/Y', strtotime($fechaRegistro));
            $values[] = (float) $registro->{$campo};
        }

        return [
            'label' => $label,
            'unit' => $unit,
            'labels' => $labels,
            'values' => $values,
            'beginAtZero' => false,
        ];
    }

    // Prepara los datos de nº pasos agrupados por fecha para la gráfica
    private function getDatosPasos(Collection $registrosEntrenos, ?string $fechaInicio): array
    {
        $pasosPorFecha = [];

        foreach ($registrosEntrenos as $registro) {
            $fechaEntrenamiento = (string) $registro->fecha_entrenamiento;

            if ($fechaInicio && substr($fechaEntrenamiento, 0, 10) < $fechaInicio) {
                continue;
            }

            $fecha = date('Y-m-d', strtotime($fechaEntrenamiento));

            if (! isset($pasosPorFecha[$fecha])) {
                $pasosPorFecha[$fecha] = 0;
            }

            $pasosPorFecha[$fecha] += (int) $registro->pasos_realizados;
        }

        $labels = [];
        $values = [];

        foreach ($pasosPorFecha as $fecha => $pasos) {
            $labels[] = date('d/m/Y', strtotime($fecha));
            $values[] = $pasos;
        }

        return [
            'label' => __('progress-chart.metrics.pasos'),
            'unit' => __('progress-chart.units.steps'),
            'labels' => $labels,
            'values' => $values,
            'beginAtZero' => true,
        ];
    }
}
