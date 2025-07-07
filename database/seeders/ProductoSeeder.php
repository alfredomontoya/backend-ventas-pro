<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaProducto;
use App\Models\Producto;
use App\Models\ImagenProducto;
use App\Models\PrecioProducto;
use App\Models\StockProducto;
use App\Models\User;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {

        // Crear 5 categorías
        $categorias = CategoriaProducto::factory(5)->create();

        // Por cada categoría, crear 10 productos
            Producto::factory(50)->create()->each(function ($producto)  {
                // Imágenes del producto
                $imagenes = ImagenProducto::factory(rand(1, 3))->create([
                    'producto_id' => $producto->id,
                ]);

                // Marcar una imagen como predeterminada
                $imagenes->random()->update(['es_predeterminada' => true]);

                // Precio actual
                PrecioProducto::factory()->create([
                    'producto_id' => $producto->id,
                ]);

                // Movimientos de stock
                StockProducto::factory(5)->create([
                    'producto_id' => $producto->id,
                ]);
            });
    }
}

