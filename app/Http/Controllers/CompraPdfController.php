<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CompraPdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:compras.pdf');
    }

    public function __invoke(Request $request)
    {
        $filtros = $request->only(['proveedor_id', 'insumo_id', 'desde', 'hasta']);
        $compras = Compra::with(['proveedor', 'insumo'])->filtrar($filtros)->orderByDesc('id')->get();

        return Pdf::loadView('compras.pdf', compact('compras', 'filtros'))->download('listado-compras.pdf');
    }
}
