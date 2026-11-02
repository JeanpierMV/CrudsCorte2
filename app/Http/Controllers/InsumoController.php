<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsumoRequest;
use App\Models\Insumo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InsumoController extends Controller
{
    public function __construct()
    {
        // Autorización con Spatie: cada acción exige su permiso.
        $this->middleware('can:insumos.ver')->only(['index', 'show']);
        $this->middleware('can:insumos.crear')->only(['create', 'store']);
        $this->middleware('can:insumos.editar')->only(['edit', 'update']);
        $this->middleware('can:insumos.eliminar')->only('destroy');
    }

    public function index(Request $request)
    {
        $filtros = $request->only(['q', 'unidad', 'estado']);

        $insumos = Insumo::filtrar($filtros)
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString(); // conserva los filtros al cambiar de página

        $unidades = Insumo::select('unidad_medida')->distinct()->orderBy('unidad_medida')->pluck('unidad_medida');

        return view('insumos.index', compact('insumos', 'unidades'));
    }

    public function create()
    {
        return view('insumos.create');
    }

    public function store(InsumoRequest $request)
    {
        Insumo::create($request->validated());

        return redirect()->route('insumos.index')->with('ok', 'Insumo registrado correctamente.');
    }

    public function show(Insumo $insumo)
    {
        return view('insumos.show', compact('insumo'));
    }

    public function edit(Insumo $insumo)
    {
        return view('insumos.edit', compact('insumo'));
    }

    public function update(InsumoRequest $request, Insumo $insumo)
    {
        $insumo->update($request->validated()); // stock_actual no se modifica aquí

        return redirect()->route('insumos.index')->with('ok', 'Insumo actualizado correctamente.');
    }

    public function destroy(Insumo $insumo)
    {
        try {
            $insumo->delete();
        } catch (QueryException $e) {
            // La FK del kardex impide borrar insumos con movimientos (regla de trazabilidad).
            return back()->with('error', 'No se puede eliminar el insumo porque tiene movimientos de kardex asociados.');
        }

        return redirect()->route('insumos.index')->with('ok', 'Insumo eliminado.');
    }
}
