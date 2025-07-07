<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;
use App\Models\ReferenciaProveedor;

class ProveedorSeeder extends Seeder
{
    public function run()
    {
        Proveedor::factory()->count(10)->create();
        // ->each(function ($proveedor) {
        //     // Generar entre 1 y 3 teléfonos
        //     ReferenciaProveedor::factory()->count(1)->create([
        //         'proveedor_id' => $proveedor->id,
        //         'tipo' => 'telefono',
        //     ]);
        //     // Generar entre 1 y 2 correos
        //     ReferenciaProveedor::factory()->count(1)->create([
        //         'proveedor_id' => $proveedor->id,
        //         'tipo' => 'correo',
        //     ]);
        //     // Generar entre 1 y 2 direcciones
        //     ReferenciaProveedor::factory()->count(1)->create([
        //         'proveedor_id' => $proveedor->id,
        //         'tipo' => 'direccion',
        //     ]);
        // });
    }
}
