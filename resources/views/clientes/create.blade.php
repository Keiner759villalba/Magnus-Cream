@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4">
	<h2 class="text-xl font-semibold mb-4">Nuevo cliente</h2>

	<form action="{{ route('clientes.store') }}" method="POST">
		@csrf
		<input name="nombre" placeholder="Nombre" class="w-full rounded border-gray-200 px-3 py-2 mb-3" required>
		<input name="telefono" placeholder="Teléfono" class="w-full rounded border-gray-200 px-3 py-2 mb-3">
		<input name="correo" type="email" placeholder="Correo" class="w-full rounded border-gray-200 px-3 py-2 mb-3">
		<input name="direccion" placeholder="Dirección" class="w-full rounded border-gray-200 px-3 py-2 mb-3">
		<div class="flex gap-2">
			<button class="bg-[#7B2CBF] text-white px-4 py-2 rounded">Guardar</button>
			<a href="{{ route('clientes.index') }}" class="px-4 py-2 rounded border">Cancelar</a>
		</div>
	</form>
</div>
@endsection
