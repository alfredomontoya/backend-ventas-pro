<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Derivacion extends Model
{
    use HasFactory;

    protected $table = 'derivacions';

    protected $fillable = [
        'tramite_id',
        'usuario_origen_id',
        'usuario_destino_id',
        'area',
        'glosa',
        'orden',
        'fecha_derivacion',
        'fecha_recepcion',
    ];


    public function tramite()
    {
        return $this->belongsTo(Tramite::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
