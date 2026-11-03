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
    </style>
</head>
<body>
    <h1>Kardex de inventario – Don Abe Urban Food</h1>
    <div class="filtros">
        @php $activos = array_filter($filtros); @endphp
        @if ($activos)
            Filtros:
            @foreach ($activos as $k => $v){{ $k }} = {{ $v }}@if (! $loop->last), @endif @endforeach
        @else
            Sin filtros
        @endif
        — {{ $movimientos->count() }} movimiento(s)
    </div>
    <table>
        <thead><tr><th>Fecha</th><th>Insumo</th><th>Tipo</th><th>Proveedor</th><th>Cantidad</th><th>Stock anterior</th><th>Stock nuevo</th></tr></thead>
        <tbody>
        @foreach ($movimientos as $m)
            <tr>
                <td>{{ $m->fecha_movimiento->format('Y-m-d') }}</td>
                <td>{{ $m->insumo->nombre }}</td>
                <td>{{ $m->tipo }}</td>
                <td>{{ $m->compra->proveedor->nombre ?? '—' }}</td>
                <td>{{ $m->cantidad }}</td>
                <td>{{ $m->stock_anterior }}</td>
                <td>{{ $m->stock_nuevo }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
