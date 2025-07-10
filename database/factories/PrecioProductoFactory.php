<?php

namespace Database\Factories;

use App\Models\PrecioProducto;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrecioProducto>
 */
class PrecioProductoFactory extends Factory
{

     protected $model = PrecioProducto::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $inicio = $this->faker->dateTimeBetween('-6 months', 'now');
        return [
            'producto_id' => Producto::query()->inRandomOrder()->value('id'),
            'precio' => $this->faker->randomFloat(2, 10, 500),
            'fecha_inicio' => $inicio,
            'fecha_fin' => null,
            'creado_por' => User::query()->inRandomOrder()->value('id'),
        ];
    }
}
