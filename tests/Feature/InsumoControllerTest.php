<?php

namespace Tests\Feature;

use App\Models\Insumo;
use App\Models\User;
use Database\Seeders\InsumoPermisosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InsumoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(InsumoPermisosSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        $this->actingAs($this->admin);
    }

    public function test_listado_pagina_de_a_10(): void
    {
        Insumo::factory()->count(12)->create();

        $this->get(route('insumos.index'))
            ->assertOk()
            ->assertViewHas('insumos', fn ($p) => $p->count() === 10 && $p->total() === 12);
    }

    public function test_filtra_por_texto_y_por_stock_bajo(): void
    {
        Insumo::factory()->create(['nombre' => 'Arroz', 'stock_actual' => 50, 'stock_minimo' => 10]);
        Insumo::factory()->stockBajo()->create(['nombre' => 'Mortadela']);

        $this->get(route('insumos.index', ['q' => 'Arroz']))
            ->assertViewHas('insumos', fn ($p) => $p->total() === 1);

        $this->get(route('insumos.index', ['estado' => 'bajo']))
            ->assertViewHas('insumos', fn ($p) => $p->total() === 1 && $p->first()->nombre === 'Mortadela');
    }

    public function test_crea_insumo(): void
    {
        $this->post(route('insumos.store'), [
            'nombre' => 'Carne molida', 'unidad_medida' => 'kg',
            'stock_actual' => 33, 'stock_minimo' => 10,
        ])->assertRedirect(route('insumos.index'));

        $this->assertDatabaseHas('insumos', ['nombre' => 'Carne molida']);
    }

    public function test_rechaza_nombre_duplicado_y_valores_negativos(): void
    {
        Insumo::factory()->create(['nombre' => 'Arroz']);

        $this->post(route('insumos.store'), [
            'nombre' => 'Arroz', 'unidad_medida' => 'kg', 'stock_actual' => -1, 'stock_minimo' => -5,
        ])->assertSessionHasErrors(['nombre', 'stock_actual', 'stock_minimo']);
    }

    public function test_actualiza_minimo_pero_no_el_stock(): void
    {
        $insumo = Insumo::factory()->create(['stock_actual' => 100, 'stock_minimo' => 10]);

        $this->put(route('insumos.update', $insumo), [
            'nombre' => $insumo->nombre, 'unidad_medida' => $insumo->unidad_medida,
            'stock_minimo' => 15, 'stock_actual' => 999,
        ])->assertRedirect(route('insumos.index'));

        $this->assertDatabaseHas('insumos', ['id' => $insumo->id, 'stock_minimo' => 15, 'stock_actual' => 100]);
    }

    public function test_elimina_insumo(): void
    {
        $insumo = Insumo::factory()->create();

        $this->delete(route('insumos.destroy', $insumo))->assertRedirect(route('insumos.index'));
        $this->assertDatabaseMissing('insumos', ['id' => $insumo->id]);
    }

    public function test_rol_user_solo_puede_ver_no_crear(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user)->get(route('insumos.index'))->assertOk();
        $this->actingAs($user)->post(route('insumos.store'), [
            'nombre' => 'X', 'unidad_medida' => 'kg', 'stock_actual' => 1, 'stock_minimo' => 1,
        ])->assertForbidden();
    }

    public function test_invitado_es_redirigido_al_login(): void
    {
        auth()->logout();
        $this->get(route('insumos.index'))->assertRedirect(route('login'));
    }

    public function test_genera_pdf_con_filtros(): void
    {
        Insumo::factory()->create(['nombre' => 'Arroz']);

        $this->get(route('insumos.pdf', ['q' => 'Arroz']))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }
}
