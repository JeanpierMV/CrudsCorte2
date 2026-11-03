@extends('layouts.plantilla')

@section('contenido')
<div class="container" style="max-width:540px">
    <h4 class="text-center mb-3">Nueva compra</h4>
    <form action="{{ route('compras.store') }}" method="POST" novalidate>
        @csrf

        <div class="mb-3">
            <label for="proveedor_id" class="form-label">Proveedor</label>
            <select id="proveedor_id" name="proveedor_id" class="form-control">
                <option value="">Seleccionar proveedor</option>
                @foreach ($proveedores as $p)
                    <option value="{{ $p->id }}" @selected(old('proveedor_id') == $p->id)>{{ $p->nombre }}</option>
                @endforeach
            </select>
            @error('proveedor_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="insumo_id" class="form-label">Insumo</label>
            <select id="insumo_id" name="insumo_id" class="form-control">
                <option value="">Seleccionar insumo</option>
                @foreach ($insumos as $i)
                    <option value="{{ $i->id }}" @selected(old('insumo_id') == $i->id)>{{ $i->nombre }} (stock: {{ $i->stock_actual }} {{ $i->unidad_medida }})</option>
                @endforeach
            </select>
            @error('insumo_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input id="cantidad" name="cantidad" type="number" step="0.01" class="form-control" value="{{ old('cantidad') }}">
            @error('cantidad')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="observacion" class="form-label">Observación (N° de factura)</label>
            <input id="observacion" name="observacion" class="form-control" value="{{ old('observacion') }}">
            @error('observacion')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-primary w-100">Registrar compra</button>
        <a href="{{ route('compras.index') }}" class="btn btn-secondary w-100 mt-2">Cancelar</a>
    </form>
</div>
@endsection
