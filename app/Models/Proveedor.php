<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'razon_social',
        'nit',
        'contacto',
        'activo',
    ];

    public function referencias()
    {
        return $this->hasMany(ReferenciaProveedor::class);
    }
}
