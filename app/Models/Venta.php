<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'user_id',
        'fecha_venta',
        'total',
        'descuento',
        'tipo_pago',
        'moneda',
        'tipo_cambio',
        'monto_pagado',
        'monto_pagado_usd',
        'cambio',
        'estado',
        'observaciones',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con Detalles de venta
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
