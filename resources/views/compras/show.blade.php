@extends('layouts.plantilla')

@section('contenido')
<div class="container" style="max-width:540px">
    <h4 class="text-center mb-3">Compra #{{ $compra->id }}</h4>
    <ul class="list-group mb-3">
        <li class="list-group-item"><b>Proveedor:</b> {{ $compra->proveedor->nombre }}</li>
        <li class="list-group-item"><b>Insumo:</b> {{ $compra->insumo->nombre }}</li>
        <li class="list-group-item"><b>Cantidad:</b> {{ $compra->cantidad }}</li>
        <li class="list-group-item"><b>Fecha:</b> {{ $compra->fecha->format('Y-m-d') }}</li>
        <li class="list-group-item"><b>Factura:</b> {{ $compra->observacion ?? '—' }}</li>
        @if ($compra->kardex)
            <li class="list-group-item"><b>Stock:</b> {{ $compra->kardex->stock_anterior }} → {{ $compra->kardex->stock_nuevo }}</li>
        @endif
    </ul>
    <a href="{{ route('compras.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
