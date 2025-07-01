<?php

namespace Database\Factories;

use App\Models\CategoriaProducto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoriaProducto>
 */
class CategoriaProductoFactory extends Factory
{
     protected $model = CategoriaProducto::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->word(),
            'descripcion' => $this->faker->optional()->sentence(),
            'imagen' => $this->faker->imageUrl(200, 200, 'category'),
            'estado' => true,
        ];
    }
}
