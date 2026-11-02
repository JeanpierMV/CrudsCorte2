<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:proveedores.ver')->only(['index', 'show']);
        $this->middleware('can:proveedores.crear')->only(['create', 'store']);
        $this->middleware('can:proveedores.editar')->only(['edit', 'update']);
        $this->middleware('can:proveedores.eliminar')->only('destroy');
    }

    public function index(Request $request)
    {
        $proveedores = Proveedor::filtrar($request->only('q'))
            ->ordenarPor($request->input('orden'))
            ->paginate(10)
            ->withQueryString();

        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(ProveedorRequest $request)
    {
        Proveedor::create($request->validated());

        return redirect()->route('proveedores.index')->with('ok', 'Proveedor registrado correctamente.');
    }

    public function show(Proveedor $proveedor)
    {
        return view('proveedores.show', compact('proveedor'));
    }

    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(ProveedorRequest $request, Proveedor $proveedor)
    {
        $proveedor->update($request->validated());

        return redirect()->route('proveedores.index')->with('ok', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        try {
            $proveedor->delete();
        } catch (QueryException $e) {
            // La FK de compras impide borrar proveedores con compras registradas.
            return back()->with('error', 'No se puede eliminar el proveedor porque tiene compras asociadas.');
        }

        return redirect()->route('proveedores.index')->with('ok', 'Proveedor eliminado.');
    }
}