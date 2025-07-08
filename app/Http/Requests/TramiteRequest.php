<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TramiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitir la validación
    }

    public function rules(): array
    {
        return [
            'fecha' => ['required', 'date'],
            'ci' => ['required', 'string', 'max:20'],
            'nombre' => ['required', 'string', 'max:128'],
            'referencia' => ['nullable', 'string', 'max:255'],
            'uv' => ['nullable', 'string', 'max:10'],
            'mz' => ['nullable', 'string', 'max:10'],
            'lt' => ['nullable', 'string', 'max:10'],
            'diamante' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha.required' => 'La fecha es obligatoria.',
            'ci.required' => 'El CI es obligatorio.',
            'nombre.required' => 'El nombre es obligatorio.',
        ];
    }
}
