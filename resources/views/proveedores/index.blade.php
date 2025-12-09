@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Proveedores</h1>
        <a href="{{ route('proveedores.create') }}" class="bg-[#7B2CBF] text-white px-4 py-2 rounded">Nuevo proveedor</a>
    </div>

    @foreach($proveedores as $proveedor)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b flex items-center justify-between">
                <div>
                    <div class="text-lg font-medium text-gray-800">{{ $proveedor->nombre }}</div>
                    <div class="text-sm text-gray-500">{{ $proveedor->empresa }}</div>
                </div>

                <div class="text-sm text-gray-600">
                    @if($proveedor->telefono)
                        Teléfono: {{ $proveedor->telefono }}
                    @endif
                </div>
            </div>

            <div class="p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Productos recibidos (registros de compra)</h3>

                @if($proveedor->productosComprados && $proveedor->productosComprados->count())
                <div class="overflow-x-auto mb-4">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-500">ID</th>
                                <th class="px-4 py-2 text-left text-gray-500">Nombre</th>
                                <th class="px-4 py-2 text-right text-gray-500">Cantidad</th>
                                <th class="px-4 py-2 text-right text-gray-500">Precio compra (S/.)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($proveedor->productosComprados as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->id }}</td>
                                <td class="px-4 py-2">{{ $item->nombre }}</td>
                                <td class="px-4 py-2 text-right">{{ $item->cantidad }}</td>
                                <td class="px-4 py-2 text-right">S/{{ number_format($item->precio_compra,2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                <hr class="my-3">

                <h3 class="text-sm font-semibold text-gray-700 mb-2">Productos vinculados (catalogados)</h3>

                {{-- Solo se muestra la tabla si hay productos. Se eliminó el @else. --}}
                @if($proveedor->productos && $proveedor->productos->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-500">ID</th>
                                <th class="px-4 py-2 text-left text-gray-500">Nombre</th>
                                <th class="px-4 py-2 text-left text-gray-500">Categoría</th>
                                <th class="px-4 py-2 text-right text-gray-500">Stock</th>
                                <th class="px-4 py-2 text-right text-gray-500">Costo (S/.)</th>
                                <th class="px-4 py-2 text-right text-gray-500">Precio venta (S/.)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($proveedor->productos as $producto)
                            <tr>
                                <td class="px-4 py-2">{{ $producto->id }}</td>
                                <td class="px-4 py-2">{{ $producto->nombre }}</td>
                                <td class="px-4 py-2">{{ $producto->categoria }}</td>
                                <td class="px-4 py-2 text-right">{{ $producto->inventario->stock ?? 0 }}</td>
                                <td class="px-4 py-2 text-right">S/{{ number_format($producto->precio_compra ?? 0, 2) }}</td>
                                <td class="px-4 py-2 text-right">S/{{ number_format($producto->precio_venta ?? 0, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                
            </div>

            <div class="p-4 border-t flex items-center justify-end space-x-2">
                <a href="{{ route('proveedores.show', $proveedor) }}" class="text-sm text-gray-700 mr-3">Ver</a>
                <a href="{{ route('proveedores.edit', $proveedor) }}" class="text-sm text-[#7B2CBF] mr-3">Editar</a>
                <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-600">Eliminar</button>
                </form>
            </div>
        </div>
    @endforeach

    <div class="mt-4">
        {{ $proveedores->links() }}
    </div>
</div>
@endsection