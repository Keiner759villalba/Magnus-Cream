@extends('layouts.app')

@section('content')
@php
    // soporta ambos nombres: $proveedor (español) o $proveedore (singular generado por Route::resource)
    $prov = $proveedor ?? $proveedore ?? null;
    // si aún no está, intentar obtener id desde la ruta
    if (!$prov && request()->route('proveedore')) {
        $prov = \App\Models\Proveedor::find(request()->route('proveedore'));
    }
@endphp

<div class="max-w-md mx-auto px-4">
	<h2 class="text-xl font-semibold mb-4">Editar proveedor</h2>

	@if(!$prov)
		<div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded">Proveedor no encontrado.</div>
	@else
	<form action="{{ route('proveedores.update', $prov->id) }}" method="POST">
		@csrf
		@method('PUT')
		<div class="grid grid-cols-1 gap-4">
			<input name="nombre" value="{{ $prov->nombre }}" placeholder="Nombre" class="w-full rounded border-gray-200 px-3 py-2" required>
			<input name="empresa" value="{{ $prov->empresa }}" placeholder="Empresa (opcional)" class="w-full rounded border-gray-200 px-3 py-2">
			<input name="telefono" value="{{ $prov->telefono }}" placeholder="Teléfono" class="w-full rounded border-gray-200 px-3 py-2">
			<div class="flex gap-2">
				<button class="bg-[#7B2CBF] text-white px-4 py-2 rounded">Actualizar</button>
				<a href="{{ route('proveedores.index') }}" class="px-4 py-2 rounded border">Cancelar</a>
			</div>
		</div>
	</form>
	@endif
</div>
@endsection
