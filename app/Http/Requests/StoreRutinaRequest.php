<?php

namespace App\Http\Requests;

use App\Models\Rutina;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreRutinaRequest extends FormRequest
{
    /**
     * Determina que el usuario tenga autorización para realizar la petición
     */
    public function authorize(): bool
    {
        $rutina = $this->route('rutina');

        if ($rutina instanceof Rutina) {
            return $this->user()->can('update', $rutina);
        }

        return $this->user()?->can('create', Rutina::class) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'dias_entreno' => ['required', 'integer', 'between:1,7'],
            'kcal_objetivo' => ['nullable', 'integer', 'min:0', 'max:10000'],
            'duracion_aproximada_min' => ['nullable', 'integer', 'min:1', 'max:600'],
            'pasos_objetivo' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'dias' => ['required', 'array', 'min:1'],
            'dias.*' => ['required', 'array'],
            'dias.*.nombre' => ['nullable', 'string', 'max:100'],
            'dias.*.ejercicios' => ['required', 'array', 'min:1'],
            'dias.*.ejercicios.*' => ['required', 'array'],
            'dias.*.ejercicios.*.ejercicio_id' => ['required', 'integer', 'exists:ejercicios,id'],
            'dias.*.ejercicios.*.nombre' => ['required', 'string', 'max:100'],
            'dias.*.ejercicios.*.series' => ['required', 'integer', 'min:1', 'max:20'],
            'dias.*.ejercicios.*.repeticiones' => ['required', 'integer', 'min:1', 'max:100'],
            'dias.*.ejercicios.*.carga' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'dias.*.ejercicios.*.duracion_segundos' => ['nullable', 'integer', 'min:1', 'max:86400'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $dayCount = min(max((int) $this->input('dias_entreno', 0), 0), 7);
            $days = $this->input('dias', []);

            if (!is_array($days)) {
                return;
            }

            for ($dayIndex = 0; $dayIndex < $dayCount; $dayIndex++) {
                $exercises = $days[$dayIndex]['ejercicios'] ?? null;

                if (!is_array($exercises) || count($exercises) === 0) {
                    $validator->errors()->add(
                        "dias.$dayIndex.ejercicios",
                        __("requests.messages.routine_day_requires_exercise")
                    );
                }
            }

            foreach ($days as $dayIndex => $day) {
                if (!is_array($day)) {
                    continue;
                }

                if (!ctype_digit((string) $dayIndex) || (int) $dayIndex < 0 || (int) $dayIndex >= $dayCount) {
                    $validator->errors()->add(
                        "dias.$dayIndex",
                        __("requests.messages.routine_day_not_selected")
                    );
                    continue;
                }

                $exerciseIds = collect($day['ejercicios'] ?? [])
                    ->pluck('ejercicio_id')
                    ->filter(fn ($exerciseId) => $exerciseId !== null && $exerciseId !== '')
                    ->map(fn ($exerciseId) => (string) $exerciseId);

                if ($exerciseIds->duplicates()->isNotEmpty()) {
                    $validator->errors()->add(
                        "dias.$dayIndex.ejercicios",
                        __("requests.messages.routine_duplicate_exercise")
                    );
                }
            }
        });
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nombre' => __("requests.attributes.name"),
            'descripcion' => __("requests.attributes.description"),
            'dias_entreno' => __("requests.attributes.training_days"),
            'kcal_objetivo' => __("requests.attributes.daily_calories"),
            'duracion_aproximada_min' => __("requests.attributes.approx_duration"),
            'pasos_objetivo' => __("requests.attributes.daily_steps"),
            'dias' => __("requests.attributes.training_days"),
            'dias.*.nombre' => __("requests.attributes.day_name"),
            'dias.*.ejercicios' => __("requests.attributes.day_exercises"),
            'dias.*.ejercicios.*.ejercicio_id' => __("requests.attributes.exercise"),
            'dias.*.ejercicios.*.nombre' => __("requests.attributes.exercise_name"),
            'dias.*.ejercicios.*.series' => __("requests.attributes.sets"),
            'dias.*.ejercicios.*.repeticiones' => __("requests.attributes.reps"),
            'dias.*.ejercicios.*.carga' => __("requests.attributes.load"),
            'dias.*.ejercicios.*.duracion_segundos' => __("requests.attributes.duration"),
        ];
    }
}
