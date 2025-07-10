<?php

namespace Database\Factories;

use App\Models\Movimiento;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetalleMovimiento>
 */
class DetalleMovimientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'movimiento_id' => Movimiento::query()->inRandomOrder()->value('id'),
            'producto_id' => Producto::query()->inRandomOrder()->value('id'),
            'cantidad' => $this->faker->numberBetween(1, 100),
            'precio_unitario' => $this->faker->randomFloat(2, 10, 500),
        ];
    }

}
