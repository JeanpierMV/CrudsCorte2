@extends('layouts.plantilla')

@section('contenido')
<div class="container">
    <h4 class="text-center mb-3">Consulta de kardex</h4>

    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    <form method="GET" action="{{ route('kardex.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <select name="insumo_id" class="form-control">
                <option value="">Todos los insumos</option>
                @foreach ($insumos as $i)
                    <option value="{{ $i->id }}" @selected(request('insumo_id') == $i->id)>{{ $i->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><input type="date" name="desde" value="{{ request('desde') }}" class="form-control" title="Desde"></div>
        <div class="col-md-2"><input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control" title="Hasta"></div>
        <div class="col-md-4">
            <button class="btn btn-primary">Consultar</button>
            <a href="{{ route('kardex.index') }}" class="btn btn-secondary">Limpiar</a>
            @can('kardex.pdf')
                <a href="{{ route('kardex.pdf', request()->query()) }}" class="btn btn-success">Generar pdf</a>
            @endcan
        </div>
    </form>

    <table class="table table-striped">
        <thead><tr><th>Fecha</th><th>Insumo</th><th>Tipo</th><th>Proveedor</th><th>Cantidad</th><th>Stock anterior</th><th>Stock nuevo</th></tr></thead>
        <tbody>
        @forelse ($movimientos as $m)
            <tr>
                <td>{{ $m->fecha_movimiento->format('Y-m-d') }}</td>
                <td>{{ $m->insumo->nombre }}</td>
                <td>{{ $m->tipo }}</td>
                <td>{{ $m->compra->proveedor->nombre ?? '—' }}</td>
                <td>{{ $m->cantidad }}</td>
                <td>{{ $m->stock_anterior }}</td>
                <td>{{ $m->stock_nuevo }}</td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted">No hay movimientos para ese filtro.</td></tr>
        @endforelse
        </tbody>
    </table>

    <p class="text-muted"><b>Movimientos:</b> {{ $resumen['movimientos'] }} | <b>Entradas:</b> {{ $resumen['entradas'] }}</p>

    {{ $movimientos->links('pagination::bootstrap-4') }}
</div>
@endsection
