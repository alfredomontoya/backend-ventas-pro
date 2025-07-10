<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Venta;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VentaFactory extends Factory
{
    protected $model = Venta::class;

    public function definition(): array
    {
        $moneda = $this->faker->randomElement(['BOB', 'USD']);
        $tipoPago = $this->faker->randomElement(['efectivo', 'transferencia', 'qr']);
        $descuento = $this->faker->randomFloat(2, 0, 50);
        $total = $this->faker->randomFloat(2, 100, 500);
        $montoPagado = $total + $this->faker->randomFloat(2, 0, 20);
        $tipoCambio = $moneda === 'USD' ? 6.96 : null;
        $montoPagadoUSD = $moneda === 'USD' ? round($montoPagado / $tipoCambio, 2) : null;

        return [
            'cliente_id' => Cliente::query()->inRandomOrder()->value('id'),
            'user_id' => User::query()->inRandomOrder()->value('id'),
            'fecha_venta' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'total' => $total,
            'descuento' => $descuento,
            'tipo_pago' => $tipoPago,
            'moneda' => $moneda,
            'tipo_cambio' => $tipoCambio,
            'monto_pagado' => $montoPagado,
            'monto_pagado_usd' => $montoPagadoUSD,
            'cambio' => $montoPagado - ($total - $descuento),
            'estado' => $this->faker->randomElement(['pagada', 'pendiente', 'anulada']),
            'observaciones' => $this->faker->optional()->sentence(),
        ];
    }
}
