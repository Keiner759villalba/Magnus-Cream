@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-4">Estadísticas de ventas</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Total vendido</div>
            <div class="mt-2 text-2xl font-bold text-[#7B2CBF]">S/{{ number_format($totalVentas,2) }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Costo de producción</div>
            <div class="mt-2 text-2xl font-bold">S/{{ number_format($costTotal,2) }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Pagado a proveedores</div>
            <div class="mt-2 text-2xl font-bold">S/{{ number_format($paidToProviders,2) }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Utilidad neta (estimada)</div>
            <div class="mt-2 text-2xl font-bold text-green-600">S/{{ number_format($netProfit,2) }}</div>
            <div class="text-xs text-gray-500 mt-1">Bruta: S/{{ number_format($grossProfit,2) }}</div>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow mb-6">
        <h3 class="font-medium mb-2">Top productos por cantidad vendida</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-600">Producto</th>
                        <th class="px-4 py-2 text-right text-gray-600">Cantidad</th>
                        <th class="px-4 py-2 text-right text-gray-600">Ventas (S/.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProductos as $tp)
                    <tr>
                        <td class="px-4 py-2">{{ $tp->producto_nombre ?? 'N/A' }}</td>
                        <td class="px-4 py-2 text-right">{{ $tp->total_qty }}</td>
                        <td class="px-4 py-2 text-right">S/{{ number_format($tp->total_sales,2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-600">Nota: Cálculos basados en los registros actuales. "Pagado a proveedores" considera los registros en proveedor_productos (cantidad * precio_compra).</p>
    </div>
</div>
@endsection
