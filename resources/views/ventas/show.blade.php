@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <h2 class="text-xl font-semibold">Venta #{{ $venta->id }}</h2>

    <div class="mt-4 bg-white rounded shadow p-4">
        <p>Cliente: {{ $venta->cliente->nombre }}</p>
        <p>Total: S/{{ number_format($venta->total,2) }}</p>
        <p>Costos: S/{{ number_format($costTotal,2) }}</p>
        <p>Ganancia: S/{{ number_format($profit,2) }}</p>

        <h3 class="mt-4 font-medium">Productos</h3>
        <ul class="mt-2">
            @foreach($venta->detalles as $d)
                <li>{{ $d->producto->nombre ?? 'N/A' }} — {{ $d->cantidad }} x S/{{ number_format($d->subtotal,2) }}</li>
            @endforeach
        </ul>
    </div>

    <div class="mt-4">
        <a href="{{ route('ventas.index') }}" class="bg-gray-200 px-4 py-2 rounded">Volver</a>
    </div>
</div>
@endsection

