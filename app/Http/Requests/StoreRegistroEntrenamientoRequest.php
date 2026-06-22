<?php

namespace App\Http\Requests;

use App\Models\Rutina;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class StoreRegistroEntrenamientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        $usuario = Auth::user();

        if (! $usuario) {
            return false;
        }

        if ($usuario->rol !== 'usuario') {
            return false;
        }

        return $usuario->can('registrarEntreno', [$usuario, (int) $this->route('rutina')]);
    }

    public function rules(): array
    {
        return [
            'dia_activo_id' => ['required', 'integer'],
            'registro' => ['nullable', 'array'],
            'registro.*' => ['nullable', 'array'],
            'registro.*.*' => ['nullable', 'array'],
            'registro.*.*.series' => ['nullable', 'integer', 'min:0', 'max:99'],
            'registro.*.*.repeticiones' => ['nullable', 'integer', 'min:0', 'max:999'],
            'registro.*.*.carga' => ['nullable', 'numeric', 'min:0', 'max:9999.99'],
            'registro.*.*.duracion_segundos' => ['nullable', 'integer', 'min:0', 'max:86400'],
            'registro_resumen' => ['required', 'array'],
            'registro_resumen.*' => ['required', 'array'],
            'registro_resumen.*.pasos_realizados' => ['required', 'integer', 'min:0', 'max:100000'],
            'registro_resumen.*.adherencia_dieta' => ['required', 'boolean'],
            'registro_resumen.*.notas' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $rutina = Rutina::find($this->route('rutina'));

            if (! $rutina) {
                return;
            }

            $rutina->load('diasEntreno.ejerciciosProgramados');

            $diaActivoId = (int) $this->input('dia_activo_id');
            $diaEntreno = null;

            foreach ($rutina->diasEntreno as $dia) {
                if ((int) $dia->id === $diaActivoId) {
                    $diaEntreno = $dia;
                    break;
                }
            }

            if (! $diaEntreno) {
                $validator->errors()->add('dia_activo_id', __("requests.messages.store_day_not_in_routine"));
                return;
            }

            $pasosRealizados = $this->input("registro_resumen.$diaActivoId.pasos_realizados");

            if ($pasosRealizados === null || $pasosRealizados === '') {
                $validator->errors()->add(
                    "registro_resumen.$diaActivoId.pasos_realizados",
                    __("requests.messages.steps_required")
                );
            }

            $adherenciaDieta = $this->input("registro_resumen.$diaActivoId.adherencia_dieta");

            if ($adherenciaDieta === null || $adherenciaDieta === '') {
                $validator->errors()->add(
                    "registro_resumen.$diaActivoId.adherencia_dieta",
                    __("requests.messages.diet_adherence_required")
                );
            }

            $registroDia = $this->input("registro.$diaActivoId", []);
            $ejerciciosValidos = [];

            foreach ($diaEntreno->ejerciciosProgramados as $ejercicioProgramado) {
                $ejerciciosValidos[] = (int) $ejercicioProgramado->id;
            }

            foreach ($registroDia as $ejercicioId => $datos) {
                if (! in_array((int) $ejercicioId, $ejerciciosValidos, true)) {
                    $validator->errors()->add(
                        "registro.$diaActivoId",
                        __("requests.messages.exercises_not_in_day")
                    );

                    break;
                }
            }
        });
    }

    public function attributes(): array
    {
        return [
            'dia_activo_id' => __("requests.attributes.training_day"),
            'registro_resumen.*.pasos_realizados' => __("requests.attributes.steps_completed"),
            'registro_resumen.*.adherencia_dieta' => __("requests.attributes.diet_adherence"),
            'registro_resumen.*.notas' => __("requests.attributes.notes"),
            'registro.*.*.series' => __("requests.attributes.sets"),
            'registro.*.*.repeticiones' => __("requests.attributes.reps"),
            'registro.*.*.carga' => __("requests.attributes.load"),
            'registro.*.*.duracion_segundos' => __("requests.attributes.duration"),
        ];
    }
}
