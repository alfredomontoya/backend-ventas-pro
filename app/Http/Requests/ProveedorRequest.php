<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Asegúrate de manejar la autorización en middleware o policies si es necesario
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:128',
            'razon_social' => 'nullable|string|max:255',
            'nit' => 'nullable|string|max:32|unique:proveedores,nit,' . $this->route('proveedor'),
            'contacto' => 'nullable|string|max:255',
            'activo' => 'boolean',

            'referencias' => 'nullable|array',
            'referencias.*.tipo' => 'required|in:telefono,correo,direccion',
            'referencias.*.valor' => 'required|string|max:255',
            'referencias.*.es_principal' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'referencias.*.tipo.in' => 'El tipo de referencia debe ser: telefono, correo o direccion.',
            'referencias.*.valor.required' => 'El campo valor es obligatorio para cada referencia.',
            'referencias.*.tipo.required' => 'El campo tipo es obligatorio para cada referencia.',
        ];
    }
}
