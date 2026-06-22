<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainerProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->rol == 'entrenador';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'precio_mensual' => 'required|integer|min:0|max:1000',
            'descripcion' => 'required|string|max:500',
			'ocultar_lista_publica' => 'required|boolean',
            'bloquear_solicitudes_entrantes' => 'required|boolean',
        ];
    }
}
