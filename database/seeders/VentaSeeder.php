<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Venta::factory()
            ->count(10)
            ->has(\App\Models\DetalleVenta::factory()->count(3), 'detalles')
            ->create();
    }
}
