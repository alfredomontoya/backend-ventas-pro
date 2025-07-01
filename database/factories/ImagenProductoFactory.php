<?php


namespace Database\Factories;

use App\Models\ImagenProducto;
use App\Models\Producto; // ← Asegúrate de tener esta línea
use Illuminate\Database\Eloquent\Factories\Factory;

class ImagenProductoFactory extends Factory
{
    protected $model = ImagenProducto::class;

    public function definition(): array
    {
        return [
            'producto_id' => Producto::factory(),
            'ruta' => $this->faker->imageUrl(640, 480, 'products', true),
            'es_predeterminada' => false,
        ];
    }
}
