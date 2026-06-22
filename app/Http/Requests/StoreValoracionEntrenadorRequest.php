<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreValoracionEntrenadorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->rol === 'usuario';
    }

    public function rules(): array
    {
        return [
            'valoracion' => [
                'required',
                'numeric',
                'min:0.5',
                'max:5',
                function ($attribute, $value, $fail) {
                    if (((float) $value * 2) != floor((float) $value * 2)) {
                        $fail(__("requests.messages.review_half_star_steps"));
                    }
                },
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'valoracion' => __("requests.attributes.review"),
        ];
    }
}
