<?php

namespace Database\Factories;

use App\Models\CategoriaProducto;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{

     protected $model = Producto::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->words(2, true),
            'descripcion' => $this->faker->sentence(),
            'categoria_producto_id' => CategoriaProducto::query()->inRandomOrder()->value('id'),
            'codigo_barras' => $this->faker->unique()->ean13(),
            'estado' => true,
            'creado_por' => User::query()->inRandomOrder()->value('id'),
        ];
    }
}
