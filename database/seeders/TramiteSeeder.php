<?php

namespace Database\Seeders;

use App\Models\Tramite;
use App\Models\User;
use App\Models\Derivacion;
use Illuminate\Database\Seeder;

class TramiteSeeder extends Seeder
{
    public function run(): void
    {
        // Asegura usuarios
        if (User::count() < 5) {
            \App\Models\User::factory()->count(5)->create();
        }

        $usuarios = User::all();

        // Crear 10 trámites
        Tramite::factory()->count(10)->create()->each(function ($tramite) use ($usuarios) {
            $cantidadDerivaciones = rand(1, 5);
            $usuarioOrigen = $usuarios->random();

            for ($i = 0; $i < $cantidadDerivaciones; $i++) {
                do {
                    $usuarioDestino = $usuarios->random();
                } while ($usuarioDestino->id === $usuarioOrigen->id);

                Derivacion::create([
                    'tramite_id' => $tramite->id,
                    'usuario_origen_id' => $usuarioOrigen->id,
                    'usuario_destino_id' => $usuarioDestino->id,
                    'area' => fake()->word(),
                    'glosa' => fake()->sentence(),
                    'fecha_derivacion' => now()->subDays(rand(1, 30)),
                    'fecha_recepcion' => now()->subDays(rand(0, 29)),
                ]);

                $usuarioOrigen = $usuarioDestino; // para simular la cadena lineal
            }
        });
    }
}
