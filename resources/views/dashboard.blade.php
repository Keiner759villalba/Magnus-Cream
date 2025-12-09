@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-sm text-gray-500">Clientes</div>
                <div class="mt-2 text-2xl font-bold text-[#7B2CBF]">{{ $clientes ?? 0 }}</div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-sm text-gray-500">Productos</div>
                <div class="mt-2 text-2xl font-bold text-[#7B2CBF]">{{ $productos ?? 0 }}</div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-sm text-gray-500">Ventas</div>
                <div class="mt-2 text-2xl font-bold text-[#7B2CBF]">{{ $ventasCount ?? 0 }}</div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-700">Resumen</h3>
            <p class="text-sm text-gray-500 mt-2">Accede a los módulos de la izquierda para gestionar productos, inventario, proveedores, clientes y ventas.</p>
        </div>
    </div>
</div>
@endsection
