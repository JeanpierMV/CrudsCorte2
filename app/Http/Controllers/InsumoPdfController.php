<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InsumoPdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:insumos.pdf');
    }

    /** Genera el PDF con los mismos filtros que tiene el listado (llegan por la URL). */
    public function __invoke(Request $request)
    {
        $filtros = $request->only(['q', 'unidad', 'estado']);
        $insumos = Insumo::filtrar($filtros)->orderBy('id')->get();

        return Pdf::loadView('insumos.pdf', compact('insumos', 'filtros'))
            ->download('listado-insumos.pdf');
    }
}
