<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    /** @use HasFactory<\Database\Factories\AlmacenFactory> */
    use HasFactory;

    protected $table = 'almacenes';

    protected $fillable = ['nombre', 'ubicacion', 'descripcion', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function movimientos() {
        return $this->hasMany(Movimiento::class);
    }
}
