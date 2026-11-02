<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h1 { font-size: 18px; text-align: center; margin-bottom: 4px; }
        .filtros { text-align: center; color: #666; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #9b6bcc; color: #fff; padding: 7px; text-align: left; }
        td { padding: 7px; border-bottom: 1px solid #ccc; }
        .bajo { color: #b00020; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Listado de insumos – Don Abe Urban Food</h1>
    <div class="filtros">
        @php $activos = array_filter($filtros); @endphp
        @if ($activos)
            Filtros:
            @foreach ($activos as $k => $v){{ $k }} = {{ $v }}@if (! $loop->last), @endif @endforeach
        @else
            Sin filtros
        @endif
        — {{ $insumos->count() }} registro(s)
    </div>
    <table>
        <thead><tr><th>ID</th><th>Nombre</th><th>Unidad</th><th>Stock actual</th><th>Stock mínimo</th><th>Vencimiento</th><th>Estado</th></tr></thead>
        <tbody>
        @foreach ($insumos as $i)
            <tr>
                <td>{{ $i->id }}</td>
                <td>{{ $i->nombre }}</td>
                <td>{{ $i->unidad_medida }}</td>
                <td>{{ $i->stock_actual }}</td>
                <td>{{ $i->stock_minimo }}</td>
                <td>{{ $i->fecha_vencimiento?->format('Y-m-d') ?? '—' }}</td>
                <td class="{{ $i->stock_bajo ? 'bajo' : '' }}">{{ $i->stock_bajo ? 'BAJO' : 'OK' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
