@extends('layouts.plantilla')

@section('contenido')
<div class="container" style="max-width:540px">
    <h4 class="text-center mb-3">Crear Nuevo Insumo</h4>
    <form action="{{ route('insumos.store') }}" method="POST" novalidate>
        @include('insumos._form')
    </form>
</div>
@endsection
