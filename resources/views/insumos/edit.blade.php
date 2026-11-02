@extends('layouts.plantilla')

@section('contenido')
<div class="container" style="max-width:540px">
    <h4 class="text-center mb-3">Editar Insumo</h4>
    <form action="{{ route('insumos.update', $insumo) }}" method="POST" novalidate>
        @method('PUT')
        @include('insumos._form')
    </form>
</div>
@endsection
