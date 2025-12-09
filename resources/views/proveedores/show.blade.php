@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold">{{ $proveedor->nombre }}</h1>
            <div class="text-sm text-gray-500">{{ $proveedor->empresa }}</div>
        </div>

        <div class="space-x-2">
            <a href="{{ route('proveedores.edit', $proveedor) }}" class="px-4 py-2 bg-[#7B2CBF] text-white rounded">Editar proveedor</a>
            <a href="{{ route('proveedores.index') }}" class="px-4 py-2 rounded border">Volver</a>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-medium mb-3">Productos recibidos de este proveedor</h3>

        @if(session('success'))
            <div class="mb-3 p-2 bg-green-50 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        @if($proveedor->productosComprados && $proveedor->productosComprados->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-gray-600">ID</th>
                            <th class="px-3 py-2 text-left text-gray-600">Nombre</th>
                            <th class="px-3 py-2 text-right text-gray-600">Cantidad</th>
                            <th class="px-3 py-2 text-right text-gray-600">Precio compra (S/.)</th>
                            <th class="px-3 py-2 text-right text-gray-600">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($proveedor->productosComprados as $item)
                        <tr>
                            <td class="px-3 py-2">{{ $item->id }}</td>
                            <td class="px-3 py-2">{{ $item->nombre }}</td>
                            <td class="px-3 py-2 text-right">{{ $item->cantidad }}</td>
                            <td class="px-3 py-2 text-right">S/{{ number_format($item->precio_compra,2) }}</td>
                            <td class="px-3 py-2 text-right">
                                <form action="{{ route('productos_comprados.destroy', $item) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-gray-500">No hay registros de compras para este proveedor.</p>
        @endif
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-medium mb-3">Agregar producto recibido</h3>

        <form action="{{ route('proveedores.productos_comprados.store', $proveedor->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @csrf
            <input name="nombre" placeholder="Nombre del producto" class="col-span-2 rounded border-gray-200 px-3 py-2" required>
            <input name="cantidad" type="number" min="0" placeholder="Cantidad" class="rounded border-gray-200 px-3 py-2" required>
            <input name="precio_compra" type="number" step="0.01" placeholder="Precio compra" class="rounded border-gray-200 px-3 py-2" required>
            <div class="col-span-3 flex justify-end">
                <button class="bg-[#7B2CBF] text-white px-4 py-2 rounded">Agregar</button>
            </div>
        </form>
    </div>
</div>
@endsection
