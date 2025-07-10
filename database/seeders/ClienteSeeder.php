<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\CorreoCliente;
use App\Models\DireccionCliente;
use App\Models\TelefonoCliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cliente::factory(10)->create()->each(function ($cliente) {
            // Teléfonos
            $telefonos = TelefonoCliente::factory(['cliente_id' => $cliente->id])->count(2)->make();
            $telefonos[0]->es_principal = true;
            $cliente->telefonos()->saveMany($telefonos);

            // Correos
            $correos = CorreoCliente::factory(['cliente_id' => $cliente->id])->count(2)->make();
            $correos[0]->es_principal = true;
            $cliente->correos()->saveMany($correos);

            // Direcciones
            $direcciones = DireccionCliente::factory(['cliente_id' => $cliente->id])->count(2)->make();
            $direcciones[0]->es_principal = true;
            $cliente->direcciones()->saveMany($direcciones);
        });
    }
}
