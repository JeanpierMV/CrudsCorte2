<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            Panel de inventario
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <section class="mb-10 flex flex-col items-center gap-6 overflow-hidden rounded-3xl border border-amber-200 bg-gradient-to-r from-amber-50 via-white to-amber-100 p-6 shadow-sm sm:flex-row sm:p-9">
                <div class="shrink-0 rounded-2xl bg-black p-2 shadow-md ring-1 ring-amber-300">
                    <x-application-logo class="h-28 w-28 rounded-xl object-contain sm:h-32 sm:w-32" />
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-700">Don Abe Urban Food</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Panel de inventario</h1>
                    <p class="mt-3 max-w-2xl text-gray-600">Administra tus insumos, proveedores y compras desde un solo lugar.</p>
                </div>
            </section>

            <div class="mb-5">
                <h2 class="text-lg font-semibold text-gray-900">Módulos de gestión</h2>
                <p class="mt-1 text-sm text-gray-600">Selecciona un módulo para continuar.</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @can('insumos.ver')
                    <a href="{{ route('insumos.index') }}" class="group rounded-2xl border-t-4 border-amber-400 bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-1 hover:shadow-lg">
                        <span class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-700" aria-hidden="true">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5.5A1.5 1.5 0 015.5 4h13A1.5 1.5 0 0120 5.5v13a1.5 1.5 0 01-1.5 1.5h-13A1.5 1.5 0 014 18.5v-13zM4 10h16M9 10v10" /></svg>
                        </span>
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-amber-700">Insumos</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Consulta existencias y niveles mínimos.</p>
                    </a>
                @endcan

                @can('proveedores.ver')
                    <a href="{{ route('proveedores.index') }}" class="group rounded-2xl border-t-4 border-amber-400 bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-1 hover:shadow-lg">
                        <span class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-700" aria-hidden="true">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 19H5a3 3 0 010-6h.5a5.5 5.5 0 0110.75-1.5H17a3.75 3.75 0 010 7.5zM19 5v4m-2-2h4" /></svg>
                        </span>
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-amber-700">Proveedores</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Consulta la información de proveedores.</p>
                    </a>
                @endcan

                @can('compras.ver')
                    <a href="{{ route('compras.index') }}" class="group rounded-2xl border-t-4 border-amber-400 bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-1 hover:shadow-lg">
                        <span class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-700" aria-hidden="true">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 4h2l2.4 11.2a2 2 0 002 1.6h8.8a2 2 0 002-1.6L22 8H6M10 21h.01M18 21h.01" /></svg>
                        </span>
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-amber-700">Compras</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Consulta las compras registradas.</p>
                    </a>
                @endcan

                @can('kardex.ver')
                    <a href="{{ route('kardex.index') }}" class="group rounded-2xl border-t-4 border-amber-400 bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-1 hover:shadow-lg">
                        <span class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-700" aria-hidden="true">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 19V5m0 14h16M7 15l4-4 3 2 5-6m0 0h-4m4 0v4" /></svg>
                        </span>
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-amber-700">Kardex</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Consulta los movimientos del inventario.</p>
                    </a>
                @endcan

                @if (! auth()->user()->canAny(['insumos.ver', 'proveedores.ver', 'compras.ver', 'kardex.ver']))
                    <div class="rounded-2xl border border-amber-200 bg-white p-6 shadow-sm sm:col-span-2 lg:col-span-4">
                        <p class="text-gray-700">Tu cuenta todavía no tiene acceso a los módulos. Pide al administrador que ejecute <code>php artisan db:seed</code> y te asigne los permisos correspondientes.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
