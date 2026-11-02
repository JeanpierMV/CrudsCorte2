<?php

namespace Database\Seeders;

use App\Models\Insumo;
use Illuminate\Database\Seeder;

class InsumoSeeder extends Seeder
{
    public function run(): void
    {
        $datos = [
            ['Arroz', 'kg', 144, 10],
            ['Lechuga', 'kg', 97, 10],
            ['Carne molida', 'kg', 33, 10],
            ['Mortadela', 'kg', 5, 10],
        ];

        foreach ($datos as [$nombre, $unidad, $stock, $minimo]) {
            Insumo::updateOrCreate(
                ['nombre' => $nombre],
                ['unidad_medida' => $unidad, 'stock_actual' => $stock, 'stock_minimo' => $minimo]
            );
        }
    }
}
