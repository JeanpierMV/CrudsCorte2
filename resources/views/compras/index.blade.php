@extends('layouts.plantilla')

@section('contenido')
<div class="container">
    <h4 class="text-center mb-3">Registro de compras a proveedores</h4>

    @if (session('ok'))<div class="alert alert-success">{{ session('ok') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    <form method="GET" action="{{ route('compras.index') }}" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="proveedor_id" class="form-control">
                <option value="">Todos los proveedores</option>
                @foreach ($proveedores as $p)
                    <option value="{{ $p->id }}" @selected(request('proveedor_id') == $p->id)>{{ $p->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="insumo_id" class="form-control">
                <option value="">Todos los insumos</option>
                @foreach ($insumos as $i)
                    <option value="{{ $i->id }}" @selected(request('insumo_id') == $i->id)>{{ $i->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><input type="date" name="desde" value="{{ request('desde') }}" class="form-control" title="Desde"></div>
        <div class="col-md-2"><input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control" title="Hasta"></div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filtrar</button>
            <a href="{{ route('compras.index') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>

    <div class="mb-3">
        @can('compras.crear')
            <a href="{{ route('compras.create') }}" class="btn btn-info">Nueva compra</a>
        @endcan
        @can('compras.pdf')
            <a href="{{ route('compras.pdf', request()->query()) }}" class="btn btn-success">Generar pdf</a>
        @endcan
    </div>

    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Proveedor</th><th>Insumo</th><th>Cantidad</th><th>Fecha</th><th>Factura</th><th>Opciones</th></tr></thead>
        <tbody>
        @forelse ($compras as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->proveedor->nombre }}</td>
                <td>{{ $c->insumo->nombre }}</td>
                <td>{{ $c->cantidad }}</td>
                <td>{{ $c->fecha->format('Y-m-d') }}</td>
                <td>{{ $c->observacion ?? '—' }}</td>
                <td><a href="{{ route('compras.show', $c) }}" class="btn btn-sm btn-outline-secondary">Ver</a></td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted">No hay compras con esos filtros.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $compras->links('pagination::bootstrap-4') }}
</div>
@endsection
