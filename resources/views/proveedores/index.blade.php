<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Proveedores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if (session('ok'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('ok') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
                @endif

                <!-- Formulario de Filtros -->
                <form method="GET" action="{{ route('proveedores.index') }}" class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="flex-1">
                        <input type="text" name="q" value="{{ request('q') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Buscar por nombre, correo o teléfono">
                    </div>
                    <div class="w-full md:w-1/4">
                        <select name="orden" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Orden por ID</option>
                            <option value="nombre_asc" @selected(request('orden') === 'nombre_asc')>Nombre A-Z</option>
                            <option value="nombre_desc" @selected(request('orden') === 'nombre_desc')>Nombre Z-A</option>
                            <option value="recientes" @selected(request('orden') === 'recientes')>Más recientes</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 shadow">Filtrar</button>
                        <a href="{{ route('proveedores.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 shadow">Limpiar</a>
                    </div>
                </form>

                <div class="mb-6 flex gap-2">
                    @can('proveedores.crear')
                        <a href="{{ route('proveedores.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 shadow font-medium">Agregar Proveedor</a>
                    @endcan
                    @can('proveedores.pdf')
                        <a href="{{ route('proveedores.pdf', request()->query()) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 shadow font-medium">Generar PDF</a>
                    @endcan
                </div>

                <!-- Tabla Tailwind -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($proveedores as $p)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $p->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $p->nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $p->telefono }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $p->correo }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $p->direccion ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                    <a href="{{ route('proveedores.show', $p) }}" class="text-blue-600 hover:text-blue-900 font-medium">Ver</a>
                                    @can('proveedores.editar')
                                        <a href="{{ route('proveedores.edit', $p) }}" class="text-yellow-600 hover:text-yellow-900 font-medium">Editar</a>
                                    @endcan
                                    @can('proveedores.eliminar')
                                        <form action="{{ route('proveedores.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar el proveedor {{ $p->nombre }}?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:text-red-900 font-medium">Eliminar</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay proveedores con esos filtros.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $proveedores->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>