<?php

namespace Database\Factories;

use App\Models\Almacen;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movimiento>
 */
class MovimientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo' => $this->faker->randomElement(['entrada', 'salida', 'ajuste']),
            'motivo' => $this->faker->word,
            'almacen_id' => Almacen::query()->inRandomOrder()->value('id'),
            'usuario_id' => User::query()->inRandomOrder()->value('id'),
            'observaciones' => $this->faker->sentence,
        ];
    }

}
