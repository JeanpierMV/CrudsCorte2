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
    <h1>Listado de proveedores – Don Abe Urban Food</h1>
    <div class="filtros">
        @php $activos = array_filter($filtros); @endphp
        @if ($activos)
            Filtros:
            @foreach ($activos as $k => $v){{ $k }} = {{ $v }}@if (! $loop->last), @endif @endforeach
        @else
            Sin filtros
        @endif
        — {{ $proveedores->count() }} registro(s)
    </div>
    <table>
        <thead><tr><th>ID</th><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Dirección</th></tr></thead>
        <tbody>
        @foreach ($proveedores as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->nombre }}</td>
                <td>{{ $p->telefono }}</td>
                <td>{{ $p->correo }}</td>
                <td>{{ $p->direccion ?? '—' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>