<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
    /** @use HasFactory<\Database\Factories\ImagenProductoFactory> */
    use HasFactory;
    protected $table = 'imagen_productos';

    protected $fillable = [
        'producto_id',
        'ruta',
        'es_predeterminada',
    ];

    protected $casts = [
        'es_predeterminada' => 'boolean',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
