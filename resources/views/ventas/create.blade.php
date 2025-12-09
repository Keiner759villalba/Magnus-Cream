@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4">
    <h2 class="text-xl font-semibold mb-4">Registrar venta</h2>

    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-4">
            <label class="text-sm">Producto</label>
            <select name="producto_id" required class="w-full rounded border-gray-200 px-3 py-2">
                <option value="">-- Selecciona un producto --</option>
                @foreach($productos as $p)
                    <option value="{{ $p->id }}">{{ $p->nombre }} — S/{{ number_format($p->precio_venta,2) }} (Stock: {{ $p->inventario->stock ?? 0 }})</option>
                @endforeach
            </select>

            <label class="text-sm">Cantidad</label>
            <input name="cantidad" type="number" min="1" value="1" class="w-full rounded border-gray-200 px-3 py-2" required>

            <h3 class="text-lg font-medium mt-4">Datos del cliente</h3>
            <input name="nombre" placeholder="Nombre" class="w-full rounded border-gray-200 px-3 py-2" required>
            <input name="identificacion" placeholder="Número de identificación" class="w-full rounded border-gray-200 px-3 py-2" required>

            <div class="flex justify-between items-center">
                <a href="{{ route('ventas.index') }}" class="px-4 py-2 rounded border">Volver</a>
                <button type="submit" class="bg-[#7B2CBF] text-white px-4 py-2 rounded">Registrar venta</button>
            </div>
        </div>
    </form>
</div>
@endsection