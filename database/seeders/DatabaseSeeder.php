<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->truncateTables([
            'users',
            'categoria_productos',
            'productos',
            'precio_productos',
            'stock_productos',
            'imagen_productos',
            'clientes',
            'direccion_clientes',
            'telefono_clientes',
            'correo_clientes',
            'almacenes',
            'movimientos',
            'detalle_movimientos',
            'ventas',
            'detalle_ventas',
            'proveedores',
            'referencia_proveedores'
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(10)->create();
        $this->call([
            ProductoSeeder::class,
            ClienteSeeder::class,
            VentaSeeder::class,
            ProveedorSeeder::class
        ]);
    }

    protected function truncateTables(array $tables)
{
    $connection = DB::getDriverName();

    if ($connection === 'mysql') {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
    } elseif ($connection === 'sqlite') {
        DB::statement('PRAGMA foreign_keys = OFF;');
    }

    foreach ($tables as $table) {
        // Usa delete() para mayor compatibilidad con SQLite
        DB::table($table)->delete();
        // También puedes resetear los IDs si quieres en SQLite
        if ($connection === 'sqlite') {
            DB::statement("DELETE FROM sqlite_sequence WHERE name = '$table'");
        }
    }

    if ($connection === 'mysql') {
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    } elseif ($connection === 'sqlite') {
        DB::statement('PRAGMA foreign_keys = ON;');
    }
}
}
