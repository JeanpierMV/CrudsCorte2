<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/** Idempotente: se puede ejecutar varias veces sin duplicar roles ni permisos. */
class ProveedorPermisosSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permisos = ['proveedores.ver', 'proveedores.crear', 'proveedores.editar', 'proveedores.eliminar', 'proveedores.pdf'];
        foreach ($permisos as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'])->givePermissionTo($permisos);
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web'])->givePermissionTo(['proveedores.ver', 'proveedores.pdf']);
    }
}