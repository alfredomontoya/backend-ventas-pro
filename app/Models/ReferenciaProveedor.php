<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenciaProveedor extends Model
{
    use HasFactory;

    protected $table = 'referencia_proveedores';

    protected $fillable = [
        'proveedor_id',
        'tipo', // telefono, email, direccion
        'valor',
        'es_principal',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
