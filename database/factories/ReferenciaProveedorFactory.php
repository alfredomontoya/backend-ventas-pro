<?php

namespace Database\Factories;

use App\Models\Proveedor;
use App\Models\ReferenciaProveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferenciaProveedorFactory extends Factory
{
    protected $model = ReferenciaProveedor::class;

    public function definition()
    {
        $tipo = $this->faker->randomElement(['telefono', 'email', 'direccion']);

        return [
            'proveedor_id' => Proveedor::factory(),
            'tipo' => $tipo,
            'valor' => match ($tipo) {
                'telefono' => $this->faker->phoneNumber(),
                'email' => $this->faker->unique()->safeEmail(),
                'direccion' => $this->faker->address(),
                default => $this->faker->text(50),
            },
        ];
    }
}
