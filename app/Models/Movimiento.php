<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    /** @use HasFactory<\Database\Factories\MovimientoFactory> */
    use HasFactory;

    protected $fillable = ['tipo', 'motivo', 'almacen_id', 'usuario_id', 'observaciones'];

    public function usuario() {
        return $this->belongsTo(User::class);
    }

    public function almacen() {
        return $this->belongsTo(Almacen::class);
    }

    public function detalles() {
        return $this->hasMany(DetalleMovimiento::class);
    }
}
