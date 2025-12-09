@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4">
	<h2 class="text-xl font-semibold mb-4">Nuevo proveedor</h2>

	<form action="{{ route('proveedores.store') }}" method="POST">
		@csrf
		<div class="grid grid-cols-1 gap-4">
			<input name="nombre" placeholder="Nombre" class="w-full rounded border-gray-200 px-3 py-2" required>
			<input name="empresa" placeholder="Empresa (opcional)" class="w-full rounded border-gray-200 px-3 py-2">
			<input name="telefono" placeholder="Teléfono" class="w-full rounded border-gray-200 px-3 py-2">
			<div class="flex gap-2">
				<button class="bg-[#7B2CBF] text-white px-4 py-2 rounded">Guardar</button>
				<a href="{{ route('proveedores.index') }}" class="px-4 py-2 rounded border">Cancelar</a>
			</div>
		</div>
	</form>
</div>
@endsection
