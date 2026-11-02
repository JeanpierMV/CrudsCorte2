<?php

namespace Database\Factories;

use App\Models\Insumo;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Insumo> */
class InsumoFactory extends Factory
{
    protected $model = Insumo::class;

    public function definition(): array
    {
        return [
            'nombre'            => fake()->unique()->words(2, true),
            'unidad_medida'     => fake()->randomElement(['kg', 'g', 'l', 'ml', 'unidad']),
            'stock_actual'      => fake()->randomFloat(2, 20, 200),
            'stock_minimo'      => fake()->randomFloat(2, 5, 15),
            'fecha_vencimiento' => null,
        ];
    }

    public function stockBajo(): static
    {
        return $this->state(fn () => ['stock_actual' => 5, 'stock_minimo' => 10]);
    }
}
