<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $proveedor->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <p class="text-sm font-medium text-gray-500">Teléfono</p>
                    <p class="text-lg text-gray-900 font-semibold">{{ $proveedor->telefono }}</p>
                </div>
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <p class="text-sm font-medium text-gray-500">Correo</p>
                    <p class="text-lg text-gray-900">{{ $proveedor->correo }}</p>
                </div>
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <p class="text-sm font-medium text-gray-500">Dirección</p>
                    <p class="text-lg text-gray-900">{{ $proveedor->direccion ?? '—' }}</p>
                </div>
                <div class="mt-6">
                    <a href="{{ route('proveedores.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>