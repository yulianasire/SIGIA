<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Carrera>
 */
class CarreraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->sentence(3)
        ];
    }
     // Crea un nuevo método 'configure' para definir la secuencia
    public function configure(): static
    {
        return $this->sequence(
            ['nombre' => 'Tecnicatura en Software'],
            ['nombre' => 'Profesorado de Primaria'],
            ['nombre' => 'Profesorado de Matemática'],
            ['nombre' => 'Tecnicatura de Enfermería'],
        );
    }

}
