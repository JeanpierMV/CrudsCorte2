<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/** Idempotente: se puede ejecutar varias veces sin duplicar roles ni permisos. */
class InsumoPermisosSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permisos = ['insumos.ver', 'insumos.crear', 'insumos.editar', 'insumos.eliminar', 'insumos.pdf'];
        foreach ($permisos as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'])->givePermissionTo($permisos);
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web'])->givePermissionTo(['insumos.ver', 'insumos.pdf']);
    }
}
