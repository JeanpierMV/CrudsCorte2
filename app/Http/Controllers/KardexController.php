<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\Kardex;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KardexController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:kardex.ver');
    }

    public function index(Request $request)
    {
        $filtros = $request->only(['insumo_id', 'desde', 'hasta']);

        if (! empty($filtros['desde']) && ! empty($filtros['hasta']) && $filtros['desde'] > $filtros['hasta']) {
            return back()->withInput()->with('error', 'La fecha inicial no puede ser mayor que la fecha final.');
        }

        $base = Kardex::filtrar($filtros);
        $resumen = [
            'movimientos' => (clone $base)->count(),
            'entradas'    => (float) (clone $base)->where('tipo', 'COMPRA')->sum('cantidad'),
        ];

        $movimientos = $base->with(['insumo', 'compra.proveedor'])
            ->orderByDesc('fecha_movimiento')->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('kardex.index', [
            'movimientos' => $movimientos,
            'insumos'     => Insumo::orderBy('nombre')->get(),
            'resumen'     => $resumen,
        ]);
    }
}
