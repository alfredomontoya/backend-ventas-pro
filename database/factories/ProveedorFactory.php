<?php

namespace Database\Factories;

use App\Models\Proveedor;
use App\Models\ReferenciaProveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    protected $model = Proveedor::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company,
            'razon_social' => $this->faker->companySuffix,
            'nit' => $this->faker->unique()->numerify('########'),
            'contacto' => $this->faker->name,
            'activo' => $this->faker->boolean(90), // 90% probabilidad de que esté activo
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Proveedor $proveedor) {
            // Teléfono
            ReferenciaProveedor::factory()->create([
                'proveedor_id' => $proveedor->id,
                'tipo' => 'telefono',
                'valor' => $this->faker->phoneNumber,
                'es_principal' => true,
            ]);

            // Correo
            ReferenciaProveedor::factory()->create([
                'proveedor_id' => $proveedor->id,
                'tipo' => 'correo',
                'valor' => $this->faker->unique()->safeEmail,
                'es_principal' => true,
            ]);

            // Dirección
            ReferenciaProveedor::factory()->create([
                'proveedor_id' => $proveedor->id,
                'tipo' => 'direccion',
                'valor' => $this->faker->address,
                'es_principal' => true,
            ]);
        });
    }
}
