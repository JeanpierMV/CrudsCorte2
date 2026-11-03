<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        Proveedor::updateOrCreate(
            ['nombre' => 'Distribuidora Cali'],
            ['telefono' => '300123456', 'correo' => 'calidistribuidora@gmail.com', 'direccion' => 'Cra 56 #22-19']
        );
        Proveedor::updateOrCreate(
            ['nombre' => 'Julio'],
            ['telefono' => '3236458977', 'correo' => 'julioaragan@gmail.com', 'direccion' => 'Cra 66 #33-67']
        );
    }
}