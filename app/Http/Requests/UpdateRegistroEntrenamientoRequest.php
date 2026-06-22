<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class UpdateRegistroEntrenamientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        $registroEntrenamiento = $this->route('registroEntrenamiento');

        return Auth::check()
            && Auth::user()->rol === 'usuario'
            && $registroEntrenamiento
            && (int) Auth::id() === (int) $registroEntrenamiento->usuario_id;
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
            $registroEntrenamiento = $this->route('registroEntrenamiento');

            if (! $registroEntrenamiento) {
                return;
            }

            $registroEntrenamiento->loadMissing('diaEntreno.ejerciciosProgramados');
            $diaEntreno = $registroEntrenamiento->diaEntreno;
            $diaActivoId = (int) $this->input('dia_activo_id');

            if (! $diaEntreno || (int) $diaEntreno->id !== $diaActivoId) {
                $validator->errors()->add('dia_activo_id', __("requests.messages.update_day_not_in_workout"));
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
            $ejerciciosValidos = $diaEntreno->ejerciciosProgramados->pluck('id')->all();

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
