<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DerivacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Asegúrate de permitir la solicitud
    }

    public function rules(): array
    {
        return [
            'tramite_id' => 'required|exists:tramites,id',
            'usuario_origen_id' => 'required|exists:users,id',
            'usuario_destino_id' => 'required|exists:users,id',
            'area' => 'required|string|max:100',
            'glosa' => 'nullable|string',
            'orden' => 'nullable|integer',
            'fecha_derivacion' => 'nullable|date',
            'fecha_recepcion' => 'nullable|date|after_or_equal:fecha_derivacion',
        ];
    }
}
