<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProveedorPdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:proveedores.pdf');
    }

    /** PDF con los mismos filtros y orden que el listado. */
    public function __invoke(Request $request)
    {
        $filtros = $request->only(['q', 'orden']);
        $proveedores = Proveedor::filtrar($filtros)->ordenarPor($request->input('orden'))->get();

        return Pdf::loadView('proveedores.pdf', compact('proveedores', 'filtros'))
            ->download('listado-proveedores.pdf');
    }
}