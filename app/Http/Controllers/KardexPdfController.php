<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KardexPdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:kardex.pdf');
    }

    public function __invoke(Request $request)
    {
        $filtros = $request->only(['insumo_id', 'desde', 'hasta']);
        $movimientos = Kardex::with(['insumo', 'compra.proveedor'])->filtrar($filtros)
            ->orderByDesc('fecha_movimiento')->orderByDesc('id')->get();

        return Pdf::loadView('kardex.pdf', compact('movimientos', 'filtros'))->download('kardex.pdf');
    }
}
