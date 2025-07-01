<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\StockProducto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockProducto>
 */
class StockProductoFactory extends Factory
{
     protected $model = StockProducto::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'producto_id' => Producto::factory(),
            'cantidad' => $this->faker->numberBetween(-20, 100),
            'tipo_movimiento' => $this->faker->randomElement(['entrada', 'venta', 'devolución']),
            'fecha_movimiento' => $this->faker->dateTimeThisYear(),
            'nota' => $this->faker->optional()->sentence(),
        ];
    }
}
