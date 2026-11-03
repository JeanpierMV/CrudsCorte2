<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de inventario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="mb-6 text-gray-600">Selecciona un módulo para continuar.</p>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @can('insumos.ver')
                    <a href="{{ route('insumos.index') }}" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:shadow-md">
                        <h3 class="text-lg font-semibold text-gray-900">Insumos</h3>
                        <p class="mt-2 text-sm text-gray-600">Consulta existencias y niveles mínimos.</p>
                    </a>
                @endcan

                @can('proveedores.ver')
                    <a href="{{ route('proveedores.index') }}" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:shadow-md">
                        <h3 class="text-lg font-semibold text-gray-900">Proveedores</h3>
                        <p class="mt-2 text-sm text-gray-600">Consulta la información de proveedores.</p>
                    </a>
                @endcan

                @can('compras.ver')
                    <a href="{{ route('compras.index') }}" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:shadow-md">
                        <h3 class="text-lg font-semibold text-gray-900">Compras</h3>
                        <p class="mt-2 text-sm text-gray-600">Consulta las compras registradas.</p>
                    </a>
                @endcan

                @can('kardex.ver')
                    <a href="{{ route('kardex.index') }}" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:shadow-md">
                        <h3 class="text-lg font-semibold text-gray-900">Kardex</h3>
                        <p class="mt-2 text-sm text-gray-600">Consulta los movimientos del inventario.</p>
                    </a>
                @endcan

                @if (! auth()->user()->canAny(['insumos.ver', 'proveedores.ver', 'compras.ver', 'kardex.ver']))
                    <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:col-span-2 lg:col-span-4">
                        <p class="text-gray-700">Tu cuenta todavía no tiene acceso a los módulos. Pide al administrador que ejecute <code>php artisan db:seed</code> y te asigne los permisos correspondientes.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
