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
    <h1>Listado de compras – Don Abe Urban Food</h1>
    <div class="filtros">
        @php $activos = array_filter($filtros); @endphp
        @if ($activos)
            Filtros:
            @foreach ($activos as $k => $v){{ $k }} = {{ $v }}@if (! $loop->last), @endif @endforeach
        @else
            Sin filtros
        @endif
        — {{ $compras->count() }} registro(s)
    </div>
    <table>
        <thead><tr><th>ID</th><th>Proveedor</th><th>Insumo</th><th>Cantidad</th><th>Fecha</th><th>Factura</th></tr></thead>
        <tbody>
        @foreach ($compras as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->proveedor->nombre }}</td>
                <td>{{ $c->insumo->nombre }}</td>
                <td>{{ $c->cantidad }}</td>
                <td>{{ $c->fecha->format('Y-m-d') }}</td>
                <td>{{ $c->observacion ?? '—' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
