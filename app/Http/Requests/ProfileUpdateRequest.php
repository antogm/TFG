<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'genero' => ['required', 'in:Masculino,Femenino,Prefiero no especificarlo'],
            'altura' => ['required', 'integer', 'min:0', 'max:500'],
            'objetivo' => ['required', 'in:Pérdida de grasa,Aumento de masa muscular,Recomposición corporal,Sin objetivo marcado'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
			'bloquear_mensajes_desconocidos' => ['required', 'boolean'],
        ];
    }
}
