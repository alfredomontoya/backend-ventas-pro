<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'cliente_id' => 'nullable|exists:clientes,id',
            'usuario_id' => 'required|exists:users,id',
            'fecha_venta' => 'required|date',
            'tipo_pago' => 'required|in:efectivo,transferencia,qr',
            'moneda' => 'required|in:BOB,USD',
            'tipo_cambio' => 'nullable|numeric',
            'monto_pagado' => 'required|numeric|min:0',
            'monto_pagado_usd' => 'nullable|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'estado' => 'string|in:pagada,pendiente,anulada',
            'observaciones' => 'nullable|string',

            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
        ];

        return $rules;
    }
}
