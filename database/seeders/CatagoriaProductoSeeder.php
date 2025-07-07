<?php

namespace Database\Seeders;

use App\Models\CategoriaProducto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatagoriaProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CategoriaProducto::factory(10)->create();
    }
}
