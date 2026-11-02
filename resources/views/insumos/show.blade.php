@extends('layouts.plantilla')

@section('contenido')
<div class="container" style="max-width:540px">
    <h4 class="text-center mb-3">{{ $insumo->nombre }}</h4>
    <ul class="list-group mb-3">
        <li class="list-group-item"><b>Unidad:</b> {{ $insumo->unidad_medida }}</li>
        <li class="list-group-item"><b>Stock actual:</b> {{ $insumo->stock_actual }}</li>
        <li class="list-group-item"><b>Stock mínimo:</b> {{ $insumo->stock_minimo }}</li>
        <li class="list-group-item"><b>Vencimiento:</b> {{ $insumo->fecha_vencimiento?->format('Y-m-d') ?? '—' }}</li>
        <li class="list-group-item"><b>Estado:</b> {{ $insumo->stock_bajo ? 'BAJO' : 'OK' }}</li>
    </ul>
    <a href="{{ route('insumos.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
