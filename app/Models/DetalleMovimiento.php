<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleMovimiento extends Model
{
    /** @use HasFactory<\Database\Factories\DetalleMovimientoFactory> */
    use HasFactory;

    protected $fillable = ['movimiento_id', 'producto_id', 'cantidad', 'precio_unitario'];

    public function movimiento() {
        return $this->belongsTo(Movimiento::class);
    }

    public function producto() {
        return $this->belongsTo(Producto::class);
    }
}
