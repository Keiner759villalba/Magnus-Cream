<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Muestra una lista de las ventas.
     */
    public function index()
    {
        $ventas = Venta::with('cliente')->latest()->paginate(20);
        return view('ventas.index', compact('ventas'));
    }

    /**
     * Muestra el formulario para crear una nueva venta.
     */
    public function create()
    {
        $productos = Producto::orderBy('nombre')->get();
        return view('ventas.create', compact('productos'));
    }

    /**
     * Almacena una nueva venta en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'nombre' => 'required|string|max:255',
            'identificacion' => 'required|string|max:100',
        ]);

        $ventaId = null; // Inicializar la variable para usar fuera de la transacción

        DB::transaction(function () use ($data, &$ventaId) {
            // 1. Obtener o crear el cliente
            $cliente = Cliente::firstOrCreate(
                ['identificacion' => $data['identificacion']],
                ['nombre' => $data['nombre']]
            );

            // 2. Crear la Venta
            $venta = Venta::create([
                'cliente_id' => $cliente->id,
                'total' => 0, // Se actualizará más tarde
            ]);

            // 3. Crear el Detalle de Venta y actualizar stock
            $producto = Producto::findOrFail($data['producto_id']);
            $cantidad = (int)$data['cantidad'];
            $subtotal = $producto->precio_venta * $cantidad;

            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'subtotal' => $subtotal,
            ]);

            // 4. Actualizar Inventario (decremento de stock)
            $inv = Inventario::firstOrCreate(['producto_id' => $producto->id], ['stock' => 0]);
            $inv->decrement('stock', $cantidad);

            // 5. Actualizar el Total de la Venta
            $venta->update(['total' => $subtotal]);

            $ventaId = $venta->id;
        });

        return redirect()->route('ventas.show', $ventaId);
    }

    /**
     * Muestra los detalles de una venta específica.
     */
    public function show(Venta $venta)
    {
        $venta->load('cliente', 'detalles.producto');

        $costTotal = 0;
        foreach ($venta->detalles as $d) {
            // Usar precio_compra del producto para calcular el costo
            $costTotal += ($d->producto->precio_compra ?? 0) * $d->cantidad;
        }
        $profit = $venta->total - $costTotal; // Ganancia = Venta Total - Costo Total

        return view('ventas.show', compact('venta', 'costTotal', 'profit'));
    }

    /**
     * Elimina una venta y revierte el stock.
     */
    public function destroy(Venta $venta)
    {
        // Revertir el stock antes de eliminar la venta
        foreach ($venta->detalles as $d) {
            if ($d->producto && $d->producto->inventario) {
                $d->producto->inventario->increment('stock', $d->cantidad);
            }
        }
        
        $venta->delete();
        return back();
    }

    /**
     * Muestra estadísticas de ventas (Totales, Ganancias, Top Productos).
     */
    public function stats()
    {
        $totalVentas = Venta::sum('total');

        $costTotal = DetalleVenta::select(DB::raw('SUM(detalle_ventas.cantidad * productos.precio_compra) AS cost_total'))
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->value('cost_total') ?? 0;

        // Total pagado a proveedores según registros de compras (proveedor_productos)
        $paidToProviders = DB::table('proveedor_productos')
            ->select(DB::raw('SUM(cantidad * precio_compra) as paid_total'))
            ->value('paid_total') ?? 0;

        $grossProfit = $totalVentas - $costTotal;
        $netProfit = $grossProfit - $paidToProviders;

        $topProductos = DetalleVenta::select(
                'productos.id as producto_id',
                'productos.nombre as producto_nombre',
                DB::raw('SUM(detalle_ventas.cantidad) as total_qty'),
                DB::raw('SUM(detalle_ventas.subtotal) as total_sales')
            )
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->groupBy('productos.id', 'productos.nombre')
            ->orderByDesc('total_qty')
            ->take(10)
            ->get();

        return view('ventas.stats', compact('totalVentas', 'costTotal', 'paidToProviders', 'grossProfit', 'netProfit', 'topProductos'));
    }
}