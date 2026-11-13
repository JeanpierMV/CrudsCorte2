<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Base de datos no disponible</title>
</head>
<body>
    <main>
        <h1>Servicio temporalmente no disponible</h1>
        <p role="alert">{{ $message }}</p>
        <p>Si necesitas recuperar los datos del formulario, vuelve a la página anterior cuando el servicio esté disponible.</p>
        <button type="button" onclick="window.history.back()">Volver al formulario</button>
        <a href="{{ url('/') }}">Ir al inicio</a>
    </main>
</body>
</html>
