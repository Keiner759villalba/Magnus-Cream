@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4">
    <h2 class="text-xl font-semibold mb-4">Registrar venta</h2>

    <form action="{{ route('ventas.store') }}" method="POST" id="venta-form">
        @csrf

        <div class="grid grid-cols-1 gap-4">

            <h3 class="text-lg font-medium mt-4">Productos de la venta</h3>

            {{-- Contenedor donde JavaScript insertará las filas de producto --}}
            <div id="productos-container" class="space-y-4">
                {{-- Filas de producto dinámicas --}}
            </div>

            <button type="button" id="add-producto" class="bg-gray-200 text-gray-700 px-4 py-2 rounded border border-dashed hover:bg-gray-300 transition duration-150 ease-in-out">
                ➕ Añadir otro producto
            </button>

            <h3 class="text-lg font-medium mt-4">Datos del cliente</h3>
            <input name="nombre" placeholder="Nombre" class="w-full rounded border-gray-200 px-3 py-2" required>
            <input name="identificacion" placeholder="Número de identificación" class="w-full rounded border-gray-200 px-3 py-2" required>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('ventas.index') }}" class="px-4 py-2 rounded border">Volver</a>
                <button type="submit" class="bg-[#7B2CBF] text-white px-4 py-2 rounded">Registrar venta</button>
            </div>
        </div>
    </form>
</div>

{{-- 
    ¡CLAVE! 🔑
    Este script pasa la colección de productos de Laravel (PHP) a una variable global 
    de JavaScript (window.productosData) para que app.js pueda usarla y renderizar los <select>.
--}}
<script>
    window.productosData = JSON.parse('{!! json_encode($productos->map(function ($p) {
        return [
            'id' => $p->id,
            'nombre' => $p->nombre,
            'precio_venta' => number_format($p->precio_venta, 2),
            'stock' => $p->inventario->stock ?? 0
        ];
    })->values()) !!}');
</script>

@endsection