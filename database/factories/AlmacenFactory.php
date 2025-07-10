<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Almacen>
 */
class AlmacenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'nombre' => $this->faker->company,
            'ubicacion' => $this->faker->address,
            'descripcion' => $this->faker->sentence,
            'user_id' => User::query()->inRandomOrder()->value('id')
        ];
    }
}
