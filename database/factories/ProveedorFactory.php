<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Proveedor> */
class ProveedorFactory extends Factory
{
    protected $model = Proveedor::class;

    public function definition(): array
    {
        return [
            'nombre'    => fake()->unique()->company(),
            'telefono'  => fake()->numerify('3#########'),
            'correo'    => fake()->unique()->safeEmail(),
            'direccion' => fake()->streetAddress(),
        ];
    }
}