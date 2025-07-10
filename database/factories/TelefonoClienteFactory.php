<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TelefonoCliente>
 */
class TelefonoClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::query()->inRandomOrder()->value('id'),
            'numero' => $this->faker->unique()->phoneNumber,
            'es_principal' => false,
        ];
    }
}
