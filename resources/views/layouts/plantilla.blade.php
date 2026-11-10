<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'CrudsCorte2'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell">
<nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 app-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <span class="app-brand-logo"><img src="{{ asset('images/don-abe-urban-food.png') }}" alt="Logo de Don Abe Urban Food"></span>
            <span>DON ABE <span class="app-brand-accent">URBAN FOOD</span></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-navigation"
                aria-controls="main-navigation" aria-expanded="false" aria-label="Mostrar navegación">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-navigation">
            <div class="navbar-nav me-auto">
                @can('insumos.ver')
                    <a class="nav-link" href="{{ route('insumos.index') }}">Insumos</a>
                @endcan
                @can('proveedores.ver')
                    <a class="nav-link" href="{{ route('proveedores.index') }}">Proveedores</a>
                @endcan
                @can('compras.ver')
                    <a class="nav-link" href="{{ route('compras.index') }}">Compras</a>
                @endcan
                @can('kardex.ver')
                    <a class="nav-link" href="{{ route('kardex.index') }}">Kardex</a>
                @endcan
            </div>
            <span class="navbar-text me-3">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light btn-sm" type="submit">Cerrar sesión</button>
            </form>
        </div>
    </div>
</nav>
<main class="container pb-4">
    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif
    @yield('contenido')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
