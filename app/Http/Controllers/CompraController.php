<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompraRequest;
use App\Models\Compra;
use App\Models\Insumo;
use App\Models\Kardex;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

/** Las compras son documentos inmutables: solo se listan, se ven y se registran. */
class CompraController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:compras.ver')->only(['index', 'show']);
        $this->middleware('can:compras.crear')->only(['create', 'store']);
    }

    public function index(Request $request)
    {
        $compras = Compra::with(['proveedor', 'insumo'])
            ->filtrar($request->only(['proveedor_id', 'insumo_id', 'desde', 'hasta']))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('compras.index', [
            'compras'     => $compras,
            'proveedores' => Proveedor::orderBy('nombre')->get(),
            'insumos'     => Insumo::orderBy('nombre')->get(),
        ]);
    }

    public function create()
    {
        return view('compras.create', [
            'proveedores' => Proveedor::orderBy('nombre')->get(),
            'insumos'     => Insumo::orderBy('nombre')->get(),
        ]);
    }

    public function store(CompraRequest $request)
    {
        // Compra + actualización de stock + movimiento de kardex: todo o nada.
        DB::transaction(function () use ($request) {
            $insumo = Insumo::lockForUpdate()->findOrFail($request->insumo_id);

            $anterior = (float) $insumo->stock_actual;
            $nuevo    = $anterior + (float) $request->cantidad;
            $fecha    = now()->toDateString();

            $compra = Compra::create([
                'proveedor_id' => $request->proveedor_id,
                'insumo_id'    => $insumo->id,
                'cantidad'     => $request->cantidad,
                'observacion'  => $request->observacion,
                'fecha'        => $fecha,
            ]);

            $insumo->update(['stock_actual' => $nuevo]);

            Kardex::create([
                'compra_id'        => $compra->id,
                'insumo_id'        => $insumo->id,
                'tipo'             => 'COMPRA',
                'cantidad'         => $request->cantidad,
                'stock_anterior'   => $anterior,
                'stock_nuevo'      => $nuevo,
                'fecha_movimiento' => $fecha,
            ]);
        });

        return redirect()->route('compras.index')->with('ok', 'Compra registrada y stock actualizado.');
    }

    public function show(Compra $compra)
    {
        $compra->load(['proveedor', 'insumo', 'kardex']);

        return view('compras.show', compact('compra'));
    }
}
