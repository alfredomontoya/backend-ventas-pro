<?php

namespace Database\Factories;

use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetalleVentaFactory extends Factory
{
    protected $model = DetalleVenta::class;

    public function definition(): array
    {
        // Obtener un producto existente aleatorio
        $producto = Producto::inRandomOrder()->first();

        // Si no hay productos en la base de datos, lanza una excepción
        if (!$producto) {
            throw new \Exception('No hay productos disponibles en la base de datos para generar DetalleVenta.');
        }

        // Obtener precio actual del producto (si tienes relación con PrecioProducto, puedes ajustarlo)
        $precioUnitario = $producto->precioActual()?->precio ?? $this->faker->randomFloat(2, 10, 100);

        $cantidad = $this->faker->numberBetween(1, 5);
        $subtotal = $cantidad * $precioUnitario;

        return [
            'venta_id' => Venta::factory(),
            'producto_id' => $producto->id,
            'cantidad' => $cantidad,
            'precio_unitario' => $precioUnitario,
            'subtotal' => $subtotal,
        ];
    }
}
