<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioProducto extends Model
{
    /** @use HasFactory<\Database\Factories\PrecioProductoFactory> */
    use HasFactory;

     protected $fillable = [
        'producto_id',
        'precio',
        'fecha_inicio',
        'fecha_fin',
        'creado_por',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}
