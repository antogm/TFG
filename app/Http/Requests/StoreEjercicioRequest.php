<?php

namespace App\Http\Requests;

use App\Models\Ejercicio;
use Illuminate\Foundation\Http\FormRequest;

class StoreEjercicioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $ejercicio = $this->route('ejercicio');

        if ($ejercicio instanceof Ejercicio) {
            return $this->user()->can('update', $ejercicio);
        }

        return $this->user()?->can('create', Ejercicio::class) ?? false;
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
            'grupos_musculares' => ['nullable', 'array'],
            'grupos_musculares.*' => ['integer', 'distinct', 'exists:grupos_musculares,id'],
            'link_youtube' => ['nullable', 'url', 'max:2048'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre' => __("requests.attributes.name"),
            'descripcion' => __("requests.attributes.description"),
            'grupos_musculares' => __("requests.attributes.muscle_groups"),
            'grupos_musculares.*' => __("requests.attributes.muscle_group"),
            'link_youtube' => __("requests.attributes.youtube_link"),
            'imagen' => __("requests.attributes.image"),
        ];
    }
}
