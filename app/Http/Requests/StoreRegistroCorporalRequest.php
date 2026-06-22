<?php

namespace App\Http\Requests;

use App\Models\RegistroCorporal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StoreRegistroCorporalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'peso' => ['required', 'numeric', 'min:1', 'max:500'],
            'masa_muscular' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'porcentaje_grasa' => ['nullable', 'numeric', 'min:1', 'max:100'],
            'fecha' => [
                'required',
                'date',
                'before_or_equal:today',
                Rule::unique((new RegistroCorporal())->getTable(), 'fecha_registro')
                    ->where('usuario_id', Auth::id()),
            ],
            'imagenes' => ['nullable', 'array', 'max:3'],
            'imagenes.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'fecha.unique' => __('registrocorporal.unique_date'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
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
