<?php

namespace Tests\Feature;

use App\Models\Insumo;
use App\Models\Kardex;
use App\Models\Proveedor;
use App\Models\User;
use Database\Seeders\CompraPermisosSeeder;
use Database\Seeders\InsumoPermisosSeeder;
use Database\Seeders\ProveedorPermisosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CompraKardexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed([InsumoPermisosSeeder::class, ProveedorPermisosSeeder::class, CompraPermisosSeeder::class]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $this->actingAs($admin);
    }

    private function datosCompra(Insumo $insumo, Proveedor $proveedor, $cantidad = 10): array
    {
        return ['proveedor_id' => $proveedor->id, 'insumo_id' => $insumo->id, 'cantidad' => $cantidad, 'observacion' => '01'];
    }

    public function test_dashboard_muestra_accesos_a_los_modulos_autorizados(): void
    {
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Insumos')
            ->assertSee('Proveedores')
            ->assertSee('Compras')
            ->assertSee('Kardex')
            ->assertSee(route('insumos.index'), false)
            ->assertSee(route('compras.index'), false)
            ->assertSee(route('kardex.index'), false);
    }

    public function test_compra_actualiza_stock_y_crea_kardex(): void
    {
        $insumo = Insumo::factory()->create(['nombre' => 'Arroz', 'stock_actual' => 144]);
        $proveedor = Proveedor::factory()->create();

        $this->post(route('compras.store'), $this->datosCompra($insumo, $proveedor))
            ->assertRedirect(route('compras.index'));

        $this->assertDatabaseHas('insumos', ['id' => $insumo->id, 'stock_actual' => 154]);
        $this->assertDatabaseHas('kardex', [
            'insumo_id' => $insumo->id, 'stock_anterior' => 144, 'stock_nuevo' => 154, 'tipo' => 'COMPRA',
        ]);
    }

    public function test_fallo_de_base_de_datos_muestra_mensaje_y_revierte_la_compra(): void
    {
        $insumo = Insumo::factory()->create(['stock_actual' => 50]);
        $proveedor = Proveedor::factory()->create();
        DB::unprepared("CREATE TRIGGER fail_kardex_insert BEFORE INSERT ON kardex BEGIN SELECT RAISE(ABORT, 'fallo simulado'); END");

        $this->post(route('compras.store'), $this->datosCompra($insumo, $proveedor))
            ->assertStatus(503)
            ->assertSee('problema con la base de datos')
            ->assertSessionHas('_old_input', fn (array $input) => $input['cantidad'] == 10);

        $this->assertDatabaseCount('compras', 0);
        $this->assertDatabaseHas('insumos', ['id' => $insumo->id, 'stock_actual' => 50]);
        $this->assertDatabaseCount('kardex', 0);
    }

    public function test_rechaza_cantidad_vacia_cero_o_texto(): void
    {
        $insumo = Insumo::factory()->create(['stock_actual' => 50]);
        $proveedor = Proveedor::factory()->create();

        foreach (['', '0', 'diez'] as $valor) {
            $this->post(route('compras.store'), $this->datosCompra($insumo, $proveedor, $valor))
                ->assertSessionHasErrors('cantidad');
        }

        $this->assertDatabaseCount('compras', 0);
        $this->assertDatabaseHas('insumos', ['id' => $insumo->id, 'stock_actual' => 50]);
    }

    public function test_kardex_filtra_por_insumo_y_pagina(): void
    {
        $arroz = Insumo::factory()->create(['nombre' => 'Arroz']);
        $lechuga = Insumo::factory()->create(['nombre' => 'Lechuga']);
        $proveedor = Proveedor::factory()->create();

        $this->post(route('compras.store'), $this->datosCompra($arroz, $proveedor));
        $this->post(route('compras.store'), $this->datosCompra($lechuga, $proveedor));

        $this->get(route('kardex.index', ['insumo_id' => $arroz->id]))
            ->assertOk()
            ->assertSee('Consulta de kardex')
            ->assertViewHas('movimientos', fn ($p) => $p->total() === 1)
            ->assertViewHas('resumen', fn ($r) => $r['movimientos'] === 1 && $r['entradas'] === 10.0);
    }

    public function test_compras_page_renders_its_content(): void
    {
        $this->get(route('compras.index'))
            ->assertOk()
            ->assertSee('Registro de compras a proveedores');
    }

    public function test_kardex_rechaza_rango_de_fechas_invertido(): void
    {
        $this->from(route('kardex.index'))
            ->get(route('kardex.index', ['desde' => '2026-12-01', 'hasta' => '2026-01-01']))
            ->assertSessionHas('error');
    }

    public function test_no_se_elimina_insumo_ni_proveedor_con_movimientos(): void
    {
        $insumo = Insumo::factory()->create();
        $proveedor = Proveedor::factory()->create();
        $this->post(route('compras.store'), $this->datosCompra($insumo, $proveedor));

        $this->delete(route('insumos.destroy', $insumo))->assertSessionHas('error');
        $this->delete(route('proveedores.destroy', $proveedor))->assertSessionHas('error');

        $this->assertDatabaseHas('insumos', ['id' => $insumo->id]);
        $this->assertDatabaseHas('proveedores', ['id' => $proveedor->id]);
        $this->assertSame(1, Kardex::count());
    }

    public function test_rol_user_puede_ver_pero_no_registrar_compras(): void
    {
        $insumo = Insumo::factory()->create();
        $proveedor = Proveedor::factory()->create();
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user)->get(route('compras.index'))->assertOk();
        $this->actingAs($user)->post(route('compras.store'), $this->datosCompra($insumo, $proveedor))->assertForbidden();
    }

    public function test_genera_pdfs(): void
    {
        $this->get(route('compras.pdf'))->assertOk()->assertHeader('content-type', 'application/pdf');
        $this->get(route('kardex.pdf'))->assertOk()->assertHeader('content-type', 'application/pdf');
    }
}
