<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria_producto_id',
        'codigo_barras',
        'estado',
        'creado_por',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    // Relaciones
    public function categoria()
    {
        return $this->belongsTo(CategoriaProducto::class, 'categoria_producto_id');
    }

    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class);
    }

    public function imagenPredeterminada()
    {
        return $this->hasOne(ImagenProducto::class)->where('es_predeterminada', true);
    }

    public function precios()
    {
        return $this->hasMany(PrecioProducto::class);
    }

    public function precioActual()
    {
        return $this->hasOne(PrecioProducto::class)->whereNull('fecha_fin')->latest('fecha_inicio');
    }

    public function movimientosStock()
    {
        return $this->hasMany(StockProducto::class);
    }

    public function getStockActualAttribute()
    {
        return $this->movimientosStock()->sum('cantidad');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}
