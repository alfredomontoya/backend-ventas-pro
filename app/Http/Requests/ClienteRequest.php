<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ci' => 'required|string|max:32|unique:clientes,ci,' . $this->route('cliente'),
            'nombres' => 'required|string|max:64',
            'apellido_paterno' => 'required|string|max:64',
            'apellido_materno' => 'nullable|string|max:64',
            'fecha_nacimiento' => 'nullable|date',
            'estado' => 'boolean',

            'telefonos' => 'nullable|array',
            'telefonos.*.numero' => 'required|string|max:32',
            'telefonos.*.es_principal' => 'boolean',

            'correos' => 'nullable|array',
            'correos.*.email' => 'required|email|max:128',
            'correos.*.es_principal' => 'boolean',

            'direcciones' => 'nullable|array',
            'direcciones.*.direccion' => 'required|string|max:255',
            'direcciones.*.es_principal' => 'boolean',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            // Validar duplicados en teléfonos
            if ($this->filled('telefonos')) {
                $numeros = array_column($this->telefonos, 'numero');
                if (count($numeros) !== count(array_unique($numeros))) {
                    $validator->errors()->add('telefonos', 'No se permiten teléfonos duplicados.');
                }
            }

            // Validar duplicados en correos
            if ($this->filled('correos')) {
                $emails = array_column($this->correos, 'email');
                if (count($emails) !== count(array_unique($emails))) {
                    $validator->errors()->add('correos', 'No se permiten correos electrónicos duplicados.');
                }
            }

            // Validar duplicados en direcciones
            if ($this->filled('direcciones')) {
                $direcciones = array_column($this->direcciones, 'direccion');
                if (count($direcciones) !== count(array_unique($direcciones))) {
                    $validator->errors()->add('direcciones', 'No se permiten direcciones duplicadas.');
                }
            }
        });
    }
}
