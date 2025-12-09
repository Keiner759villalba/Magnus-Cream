@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4">
	<h2 class="text-xl font-semibold mb-4">Actualizar stock: {{ $inventario->producto->nombre }}</h2>

	<form action="{{ route('inventarios.update', $inventario) }}" method="POST">
		@csrf @method('PUT')
		<div class="grid gap-4">
			<input name="stock" type="number" value="{{ $inventario->stock }}" min="0" class="w-full rounded border-gray-200 px-3 py-2" required>
			<div class="flex gap-2">
				<button class="bg-[#7B2CBF] text-white px-4 py-2 rounded">Guardar</button>
				<a href="{{ route('inventarios.index') }}" class="px-4 py-2 rounded border">Cancelar</a>
			</div>
		</div>
	</form>
</div>
@endsection
