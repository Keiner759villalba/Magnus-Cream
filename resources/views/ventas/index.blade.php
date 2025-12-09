@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Ventas</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('ventas.create') }}" class="bg-[#7B2CBF] text-white px-4 py-2 rounded">Nueva venta</a>
            <a href="{{ route('ventas.stats') }}" class="bg-gray-100 border border-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-50">
                Informes
            </a>
        </div>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm text-gray-500">ID</th>
                    <th class="px-6 py-3 text-left text-sm text-gray-500">Cliente</th>
                    <th class="px-6 py-3 text-left text-sm text-gray-500">Total</th>
                    <th class="px-6 py-3 text-left text-sm text-gray-500">Fecha</th>
                    <th class="px-6 py-3 text-right text-sm text-gray-500">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($ventas as $venta)
                <tr>
                    <td class="px-6 py-4 text-sm">{{ $venta->id }}</td>
                    <td class="px-6 py-4 text-sm">{{ $venta->cliente->nombre ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm">S/{{ number_format($venta->total,2) }}</td>
                    <td class="px-6 py-4 text-sm">{{ $venta->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 text-sm text-right">
                        <a href="{{ route('ventas.show', $venta) }}" class="text-[#7B2CBF] mr-3">Detalles</a>
                        <form action="{{ route('ventas.destroy', $venta) }}" method="POST" class="inline">
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
        {{ $ventas->links() }}
    </div>
</div>
@endsection
