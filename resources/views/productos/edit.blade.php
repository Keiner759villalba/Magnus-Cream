@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4">
	<h2 class="text-xl font-semibold mb-4">Editar producto</h2>

	<form action="{{ route('productos.update', $producto) }}" method="POST">
		@csrf @method('PUT')
		<div class="grid grid-cols-1 gap-4">
			<input name="nombre" value="{{ $producto->nombre }}" placeholder="Nombre" class="w-full rounded border-gray-200 px-3 py-2" required>
			<input name="categoria" value="{{ $producto->categoria }}" placeholder="Categoría" class="w-full rounded border-gray-200 px-3 py-2">
			<label class="text-sm text-gray-700">Costo de producción (S/.)</label>
			<input name="precio_compra" value="{{ $producto->precio_compra }}" type="number" step="0.01" placeholder="Costo" class="w-full rounded border-gray-200 px-3 py-2" required>
			<label class="text-sm text-gray-700">Precio de venta (S/.)</label>
			<input name="precio_venta" value="{{ $producto->precio_venta }}" type="number" step="0.01" placeholder="Precio venta" class="w-full rounded border-gray-200 px-3 py-2" required>

			<label class="text-sm text-gray-700">Stock</label>
			<input name="stock" type="number" min="0" value="{{ $producto->inventario->stock ?? 0 }}" class="w-full rounded border-gray-200 px-3 py-2">

			<div class="flex items-center gap-2">
				<button class="bg-[#7B2CBF] text-white px-4 py-2 rounded">Actualizar</button>
				<a href="{{ route('productos.index') }}" class="px-4 py-2 rounded border">Cancelar</a>
			</div>
		</div>
	</form>
</div>
@endsection
@endsection
				<a href="{{ route('productos.index') }}" class="px-4 py-2 rounded border">Cancelar</a>
			</div>
		</div>
	</form>
</div>
@endsection
