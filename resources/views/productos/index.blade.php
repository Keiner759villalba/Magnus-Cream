@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
	<div class="flex items-center justify-between mb-6">
		<h1 class="text-2xl font-semibold">Productos</h1>
		<a href="{{ route('productos.create') }}" class="bg-[#7B2CBF] text-white px-4 py-2 rounded">Nuevo producto</a>
	</div>

	<div class="bg-white rounded shadow overflow-x-auto">
		<table class="min-w-full divide-y divide-gray-200">
			<thead class="bg-gray-50">
				<tr>
					<th class="px-6 py-3 text-left text-sm text-gray-500">SKU</th>
					<th class="px-6 py-3 text-left text-sm text-gray-500">Nombre</th>
					<th class="px-6 py-3 text-left text-sm text-gray-500">Categoría</th>
					<th class="px-6 py-3 text-left text-sm text-gray-500">Costo</th>
					<th class="px-6 py-3 text-left text-sm text-gray-500">Precio venta</th>
					<th class="px-6 py-3 text-left text-sm text-gray-500">Stock</th>
					<th class="px-6 py-3 text-right text-sm text-gray-500">Acciones</th>
				</tr>
			</thead>
			<tbody class="bg-white divide-y divide-gray-100">
				@foreach($productos as $producto)
				<tr>
					<td class="px-6 py-4 text-sm">{{ $producto->sku ?? $producto->id }}</td>
					<td class="px-6 py-4 text-sm">{{ $producto->nombre }}</td>
					<td class="px-6 py-4 text-sm">{{ $producto->categoria }}</td>
					<td class="px-6 py-4 text-sm">S/{{ number_format($producto->precio_compra,2) }}</td>
					<td class="px-6 py-4 text-sm">S/{{ number_format($producto->precio_venta,2) }}</td>
					<td class="px-6 py-4 text-sm">{{ $producto->inventario->stock ?? 0 }}</td>
					<td class="px-6 py-4 text-sm text-right">
						<a href="{{ route('productos.edit', $producto) }}" class="text-[#7B2CBF] mr-3">Editar</a>
						<form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline">
							@csrf @method('DELETE')
							<button type="submit" class="text-red-600">Eliminar</button>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="mt-4">
		{{ $productos->links() }}
	</div>
</div>
@endsection

