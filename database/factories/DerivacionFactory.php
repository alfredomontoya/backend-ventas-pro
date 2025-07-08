<?php

namespace Database\Factories;

use App\Models\Derivacion;
use App\Models\Tramite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DerivacionFactory extends Factory
{
    protected $model = Derivacion::class;

    public function definition(): array
    {
        return [
            'tramite_id' => Tramite::factory(),
            'usuario_origen_id' => User::factory(),
            'usuario_destino_id' => User::factory(),
            'area' => $this->faker->randomElement(['Legal', 'Archivo', 'Recepción']),
            'glosa' => $this->faker->sentence(),
            'orden' => $this->faker->unique()->numberBetween(1, 10),
            'fecha_derivacion' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'fecha_recepcion' => $this->faker->dateTimeBetween('now', '+1 week'),
        ];

    }
}
