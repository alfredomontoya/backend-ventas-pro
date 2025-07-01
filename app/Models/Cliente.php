<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'ci',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
        'fecha_nacimiento' => 'date',
    ];

    public function telefonos()
    {
        return $this->hasMany(TelefonoCliente::class);
    }

    public function telefonoPrincipal()
    {
        return $this->hasOne(TelefonoCliente::class)->where('es_principal', true);
    }

    public function correos()
    {
        return $this->hasMany(CorreoCliente::class);
    }

    public function correoPrincipal()
    {
        return $this->hasOne(CorreoCliente::class)->where('es_principal', true);
    }

    public function direcciones()
    {
        return $this->hasMany(DireccionCliente::class);
    }

    public function direccionPrincipal()
    {
        return $this->hasOne(DireccionCliente::class)->where('es_principal', true);
    }
}
