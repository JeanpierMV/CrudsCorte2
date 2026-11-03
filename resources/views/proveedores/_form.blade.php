@csrf
<div class="mb-4">
    <label for="nombre" class="block font-medium text-sm text-gray-700">Nombre del proveedor</label>
    <input id="nombre" name="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('nombre', $proveedor->nombre ?? '') }}">
    @error('nombre')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-4">
    <label for="telefono" class="block font-medium text-sm text-gray-700">Teléfono</label>
    <input id="telefono" name="telefono" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('telefono', $proveedor->telefono ?? '') }}">
    @error('telefono')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-4">
    <label for="correo" class="block font-medium text-sm text-gray-700">Correo</label>
    <input id="correo" name="correo" type="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('correo', $proveedor->correo ?? '') }}">
    @error('correo')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-4">
    <label for="direccion" class="block font-medium text-sm text-gray-700">Dirección (opcional)</label>
    <input id="direccion" name="direccion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('direccion', $proveedor->direccion ?? '') }}">
    @error('direccion')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
</div>

<div class="flex flex-col gap-2 mt-6">
    <button class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
        Guardar Proveedor
    </button>
    <a href="{{ route('proveedores.index') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 text-center">
        Cancelar
    </a>
</div>