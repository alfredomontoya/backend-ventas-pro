<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProducto extends Model
{
    /** @use HasFactory<\Database\Factories\StockProductoFactory> */
    use HasFactory;
    protected $table = 'stock_productos';

    protected $fillable = [
        'producto_id',
        'cantidad',
        'tipo_movimiento',
        'fecha_movimiento',
        'nota',
    ];

    protected $casts = [
        'fecha_movimiento' => 'datetime',
        'cantidad' => 'integer',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
