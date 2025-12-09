@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Clientes</h2>
        <a href="{{ route('clientes.create') }}" class="bg-[#7B2CBF] text-white px-4 py-2 rounded">Nuevo cliente</a>
    </div>

    <div class="bg-white border rounded-lg shadow-sm overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Identificación</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Compras</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($clientes as $cliente)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $cliente->nombre }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $cliente->identificacion }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $cliente->ventas_count ?? 0 }}</td>
                    <td class="px-6 py-4 text-sm text-right">
                        <a href="{{ route('clientes.edit', $cliente) }}" class="text-sm text-[#7B2CBF] hover:underline mr-3">Editar</a>
                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay clientes registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $clientes->links() ?? '' }}
        </div>
    </div>
</div>
@endsection