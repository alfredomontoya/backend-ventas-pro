<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    use HasFactory;

    protected $fillable = [
        'nro',
        'fecha',
        'ci',
        'nombre',
        'referencia',
        'uv',
        'mz',
        'lt',
        'diamante',
        'user_id',
    ];

    // Relación con el usuario que registró el trámite
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con las derivaciones (si las agregas después)
    public function derivaciones()
    {
        return $this->hasMany(Derivacion::class);
    }
}
