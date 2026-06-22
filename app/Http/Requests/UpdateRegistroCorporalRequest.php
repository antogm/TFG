<?php

namespace App\Http\Requests;

use App\Models\RegistroCorporal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRegistroCorporalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $registroCorporal = $this->route('registroCorporal');
        $registroId = $registroCorporal instanceof RegistroCorporal ? (int) $registroCorporal->id : (int) $this->route('id');
        $imagenesExistentes = $registroCorporal instanceof RegistroCorporal ? $registroCorporal->imagenes()->count() : 0;
        $imagenesPermitidas = max(0, 3 - $imagenesExistentes);

        return [
            'peso' => ['required', 'numeric', 'min:1', 'max:500'],
            'masa_muscular' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'porcentaje_grasa' => ['nullable', 'numeric', 'min:1', 'max:100'],
            'fecha' => [
                'required',
                'date',
                'before_or_equal:today',
                Rule::unique((new RegistroCorporal())->getTable(), 'fecha_registro')
                    ->ignore($registroId)
                    ->where('usuario_id', Auth::id()),
            ],
            'imagenes' => ['nullable', 'array', 'max:' . $imagenesPermitidas],
            'imagenes.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha.unique' => __('registrocorporal.unique_date'),
        ];
    }

    public function attributes(): array
    {
        return [
            'peso' => __("requests.attributes.weight"),
            'masa_muscular' => __("requests.attributes.muscle_mass"),
            'porcentaje_grasa' => __("requests.attributes.body_fat_percentage"),
            'fecha' => __("requests.attributes.measurement_date"),
            'imagenes' => __("requests.attributes.body_photos"),
            'imagenes.*' => __("requests.attributes.body_photo"),
        ];
    }
}
