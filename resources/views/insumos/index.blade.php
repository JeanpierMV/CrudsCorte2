@extends('layouts.plantilla')

@section('contenido')
<div class="container">
    <h4 class="text-center mb-3">Listado de insumos</h4>

    @if (session('ok'))<div class="alert alert-success">{{ session('ok') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    {{-- Filtros y búsqueda (GET para poder pasarlos al PDF) --}}
    <form method="GET" action="{{ route('insumos.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar por nombre">
        </div>
        <div class="col-md-3">
            <select name="unidad" class="form-control">
                <option value="">Todas las unidades</option>
                @foreach ($unidades as $u)
                    <option value="{{ $u }}" @selected(request('unidad') === $u)>{{ $u }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="estado" class="form-control">
                <option value="">Todos los estados</option>
                <option value="bajo" @selected(request('estado') === 'bajo')>Stock bajo</option>
                <option value="ok" @selected(request('estado') === 'ok')>Stock OK</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filtrar</button>
            <a href="{{ route('insumos.index') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>

    <div class="mb-3">
        @can('insumos.crear')
            <a href="{{ route('insumos.create') }}" class="btn btn-info">Agregar Insumo</a>
        @endcan
        @can('insumos.pdf')
            <a href="{{ route('insumos.pdf', request()->query()) }}" class="btn btn-success">Generar pdf</a>
        @endcan
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Unidad</th><th>Stock actual</th>
                <th>Stock mínimo</th><th>Vencimiento</th><th>Estado</th><th>Opciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($insumos as $i)
            <tr>
                <td>{{ $i->id }}</td>
                <td>{{ $i->nombre }}</td>
                <td>{{ $i->unidad_medida }}</td>
                <td>{{ $i->stock_actual }}</td>
                <td>{{ $i->stock_minimo }}</td>
                <td>{{ $i->fecha_vencimiento?->format('Y-m-d') ?? '—' }}</td>
                <td>
                    <span class="badge {{ $i->stock_bajo ? 'badge-danger bg-danger' : 'badge-success bg-success' }}">
                        {{ $i->stock_bajo ? 'BAJO' : 'OK' }}
                    </span>
                </td>
                <td class="text-nowrap">
                    <a href="{{ route('insumos.show', $i) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                    @can('insumos.editar')
                        <a href="{{ route('insumos.edit', $i) }}" class="btn btn-sm btn-warning">Editar</a>
                    @endcan
                    @can('insumos.eliminar')
                        <form action="{{ route('insumos.destroy', $i) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar el insumo {{ $i->nombre }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center text-muted">No hay insumos con esos filtros.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $insumos->links('pagination::bootstrap-4') }}
</div>
@endsection
