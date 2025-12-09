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
        $productos = Producto::with('inventario')->orderBy('nombre')->get();
        return view('ventas.create', compact('productos'));
    }

    /**
     * Almacena una nueva venta en la base de datos (¡Actualizado para Múltiples Productos!)
     */
    public function store(Request $request)
    {
        // 1. VALIDACIÓN
        $request->validate([
            'nombre' => 'required|string|max:255',
            'identificacion' => 'required|string|max:100',
            
            // La clave: validar el array de productos
            'productos' => 'required|array|min:1', 
            'productos.*.producto_id' => 'required|exists:productos,id', 
            'productos.*.cantidad' => 'required|integer|min:1', 
        ]);

        $ventaId = null; 
        $totalVenta = 0; 

        DB::transaction(function () use ($request, &$ventaId, &$totalVenta) {
            
            // 2. Pre-procesar, verificar stock y calcular el total
            $detallesParaGuardar = [];

            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['producto_id']);
                $cantidad = (int)$item['cantidad'];
                $subtotal = $producto->precio_venta * $cantidad;

                // Verificar Stock antes de continuar con la transacción
                $stockActual = $producto->inventario->stock ?? 0;
                if ($cantidad > $stockActual) {
                    // Lanza una excepción para abortar la transacción (rollback)
                    throw new \Exception("Stock insuficiente para el producto: " . $producto->nombre . ". Stock disponible: " . $stockActual);
                }

                $totalVenta += $subtotal;

                $detallesParaGuardar[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal,
                ];
            }
            
            // 3. Obtener o crear el cliente
            $cliente = Cliente::firstOrCreate(
                ['identificacion' => $request->identificacion],
                ['nombre' => $request->nombre]
            );

            // 4. Crear la Venta (Cabecera) con el total final
            $venta = Venta::create([
                'cliente_id' => $cliente->id,
                'total' => $totalVenta, 
            ]);

            // 5. Crear los Detalles de Venta y actualizar el Stock
            foreach ($detallesParaGuardar as $detalleData) {
                // 5.1. Crear el DetalleVenta
                $venta->detalles()->create($detalleData); 

                // 5.2. Actualizar Inventario (decremento de stock)
                $producto = Producto::findOrFail($detalleData['producto_id']);
                $inv = $producto->inventario;
                
                // Usar el mismo 'firstOrCreate' y 'decrement' de tu código original
                $inv = Inventario::firstOrCreate(['producto_id' => $producto->id], ['stock' => 0]);
                $inv->decrement('stock', $detalleData['cantidad']);
            }
            
            // 6. Asignar la ID para el redireccionamiento
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