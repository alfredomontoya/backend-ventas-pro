<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriaProductoFactory> */
    use HasFactory;
    protected $table = 'categoria_productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_producto_id');
    }
}
