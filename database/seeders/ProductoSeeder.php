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
        // Crear un usuario que será el creador de todos los productos y precios
        $usuario = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        // Crear 5 categorías
        $categorias = CategoriaProducto::factory(5)->create();

        // Por cada categoría, crear 10 productos
        foreach ($categorias as $categoria) {
            Producto::factory(10)->create([
                'categoria_producto_id' => $categoria->id,
                'creado_por' => $usuario->id,
            ])->each(function ($producto) use ($usuario) {

                // Imágenes del producto
                $imagenes = ImagenProducto::factory(rand(1, 3))->create([
                    'producto_id' => $producto->id,
                ]);

                // Marcar una imagen como predeterminada
                $imagenes->random()->update(['es_predeterminada' => true]);

                // Precio actual
                PrecioProducto::factory()->create([
                    'producto_id' => $producto->id,
                    'creado_por' => $usuario->id,
                ]);

                // Movimientos de stock
                StockProducto::factory(5)->create([
                    'producto_id' => $producto->id,
                ]);
            });
        }
    }
}

