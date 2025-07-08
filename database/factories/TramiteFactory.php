<?php

namespace Database\Factories;

use App\Models\Tramite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TramiteFactory extends Factory
{
    protected $model = Tramite::class;

    public function definition(): array
    {
        return [
            'nro' => 1, // puedes ajustar esto según tu lógica de gestión
            'fecha' => $this->faker->date(),
            'ci' => $this->faker->numerify('########'),
            'nombre' => $this->faker->name(),
            'referencia' => $this->faker->sentence(),
            'uv' => $this->faker->randomDigit(),
            'mz' => $this->faker->randomDigit(),
            'lt' => $this->faker->randomDigit(),
            'diamante' => $this->faker->word(),
            'user_id' => User::factory(), // Crea un usuario automáticamente
        ];
    }
}
