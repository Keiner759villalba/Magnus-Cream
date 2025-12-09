@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
	<div class="flex items-center justify-between mb-6">
		<h1 class="text-2xl font-semibold">Inventario</h1>
	</div>

	<div class="bg-white rounded shadow overflow-x-auto">
		<table class="min-w-full divide-y divide-gray-200">
			<thead class="bg-gray-50">
				<tr>
					<th class="px-6 py-3 text-left text-sm text-gray-500">Producto</th>
					<th class="px-6 py-3 text-left text-sm text-gray-500">Stock</th>
					<th class="px-6 py-3 text-right text-sm text-gray-500">Acciones</th>
				</tr>
			</thead>
			<tbody class="bg-white divide-y divide-gray-100">
				@foreach($inventarios as $inv)
				<tr>
					<td class="px-6 py-4 text-sm">{{ $inv->producto->nombre }}</td>
					<td class="px-6 py-4 text-sm">{{ $inv->stock }}</td>
					<td class="px-6 py-4 text-sm text-right">
						<a href="{{ route('inventarios.edit', $inv) }}" class="text-[#7B2CBF]">Actualizar stock</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="mt-4">
		{{ $inventarios->links() }}
	</div>
</div>
@endsection
