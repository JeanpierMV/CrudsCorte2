@csrf
@php $editando = isset($insumo); @endphp

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre del insumo</label>
    <input id="nombre" name="nombre" class="form-control" value="{{ old('nombre', $insumo->nombre ?? '') }}">
    @error('nombre')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="unidad_medida" class="form-label">Unidad de medida</label>
    <input id="unidad_medida" name="unidad_medida" class="form-control" placeholder="kg, l, unidad..."
           value="{{ old('unidad_medida', $insumo->unidad_medida ?? '') }}">
    @error('unidad_medida')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="stock_actual" class="form-label">Stock actual</label>
    @if ($editando)
        {{-- Solo lectura: el stock cambia únicamente con compras (kardex) --}}
        <input id="stock_actual" class="form-control" value="{{ $insumo->stock_actual }}" readonly>
    @else
        <input id="stock_actual" name="stock_actual" type="number" step="0.01" class="form-control" value="{{ old('stock_actual') }}">
        @error('stock_actual')<div class="text-danger small">{{ $message }}</div>@enderror
    @endif
</div>

<div class="mb-3">
    <label for="stock_minimo" class="form-label">Stock mínimo</label>
    <input id="stock_minimo" name="stock_minimo" type="number" step="0.01" class="form-control"
           value="{{ old('stock_minimo', $insumo->stock_minimo ?? '') }}">
    @error('stock_minimo')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento (opcional)</label>
    <input id="fecha_vencimiento" name="fecha_vencimiento" type="date" class="form-control"
           value="{{ old('fecha_vencimiento', $editando ? $insumo->fecha_vencimiento?->format('Y-m-d') : '') }}">
    @error('fecha_vencimiento')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<button class="btn btn-primary w-100">Guardar Insumo</button>
<a href="{{ route('insumos.index') }}" class="btn btn-secondary w-100 mt-2">Cancelar</a>
