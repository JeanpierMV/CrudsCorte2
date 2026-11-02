<?php

namespace Tests\Feature;

use App\Models\Proveedor;
use App\Models\User;
use Database\Seeders\ProveedorPermisosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProveedorControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(ProveedorPermisosSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $this->actingAs($admin);
    }

    public function test_listado_pagina_de_a_10(): void
    {
        Proveedor::factory()->count(12)->create();

        $this->get(route('proveedores.index'))
            ->assertOk()
            ->assertViewHas('proveedores', fn ($p) => $p->count() === 10 && $p->total() === 12);
    }

    public function test_busca_por_nombre_correo_o_telefono_y_ordena(): void
    {
        Proveedor::factory()->create(['nombre' => 'Distribuidora Cali', 'correo' => 'cali@mail.com']);
        Proveedor::factory()->create(['nombre' => 'Julio', 'correo' => 'julio@mail.com', 'telefono' => '3236458977']);

        $this->get(route('proveedores.index', ['q' => 'cali']))
            ->assertViewHas('proveedores', fn ($p) => $p->total() === 1);

        $this->get(route('proveedores.index', ['q' => '3236458977']))
            ->assertViewHas('proveedores', fn ($p) => $p->total() === 1 && $p->first()->nombre === 'Julio');

        $this->get(route('proveedores.index', ['orden' => 'nombre_desc']))
            ->assertViewHas('proveedores', fn ($p) => $p->first()->nombre === 'Julio');
    }

    public function test_crea_proveedor(): void
    {
        $this->post(route('proveedores.store'), [
            'nombre' => 'Distribuidora Cali', 'telefono' => '300123456',
            'correo' => 'cali@mail.com', 'direccion' => 'Cra 56 #22-19',
        ])->assertRedirect(route('proveedores.index'));

        $this->assertDatabaseHas('proveedores', ['nombre' => 'Distribuidora Cali']);
    }

    public function test_valida_telefono_y_correo(): void
    {
        $this->post(route('proveedores.store'), [
            'nombre' => 'X', 'telefono' => 'abc', 'correo' => 'no-es-correo',
        ])->assertSessionHasErrors(['telefono', 'correo']);
    }

    public function test_actualiza_proveedor(): void
    {
        $p = Proveedor::factory()->create();

        $this->put(route('proveedores.update', $p), [
            'nombre' => 'Nuevo nombre', 'telefono' => '3001234567', 'correo' => 'nuevo@mail.com',
        ])->assertRedirect(route('proveedores.index'));

        $this->assertDatabaseHas('proveedores', ['id' => $p->id, 'nombre' => 'Nuevo nombre']);
    }

    public function test_elimina_proveedor(): void
    {
        $p = Proveedor::factory()->create();

        $this->delete(route('proveedores.destroy', $p))->assertRedirect(route('proveedores.index'));
        $this->assertDatabaseMissing('proveedores', ['id' => $p->id]);
    }

    public function test_rol_user_no_puede_eliminar(): void
    {
        $p = Proveedor::factory()->create();
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user)->get(route('proveedores.index'))->assertOk();
        $this->actingAs($user)->delete(route('proveedores.destroy', $p))->assertForbidden();
        $this->assertDatabaseHas('proveedores', ['id' => $p->id]);
    }

    public function test_genera_pdf_con_filtros(): void
    {
        Proveedor::factory()->create(['nombre' => 'Distribuidora Cali']);

        $this->get(route('proveedores.pdf', ['q' => 'Cali']))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }
}