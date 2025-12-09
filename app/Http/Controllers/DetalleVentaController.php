<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\ProveedorProducto; // O el modelo que uses para registrar compras/pagos
use Illuminate\Support\Facades\DB;

class VentasStatsController extends Controller
{
    public function stats()
    {
        // 1. Total vendido
        $totalVentas = Venta::sum('total') ?? 0;

        // 2. Costo de Bienes Vendidos (COGS - Costo de los productos que realmente se VENDIERON)
        $costTotal = DetalleVenta::select(DB::raw('SUM(detalle_ventas.cantidad * productos.precio_compra) AS cost_total'))
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->value('cost_total') ?? 0;

        // -------------------------------------------------------------
        // 3. CÁLCULO DE UTILIDAD BRUTA (Venta Total - COGS)
        // Esto es la utilidad directa de la venta del producto.
        $grossProfit = $totalVentas - $costTotal;
        // -------------------------------------------------------------

        // 4. Pagado a Proveedores (Gasto/Inversión en Inventario)
        // NOTA: Debes ajustar esta consulta para reflejar el total que has PAGADO por concepto de compras/inventario. 
        // A modo de ejemplo, aquí se está sumando el costo total de las compras registradas en ProveedorProducto.
        $paidToProviders = ProveedorProducto::sum(DB::raw('cantidad * precio_compra')) ?? 0; 
        
        // 5. Utilidad Neta Estimada (Utilidad Bruta - Gastos Operacionales/Inventario)
        // Esta es una estimación simple de la utilidad después de restar el gasto de inventario total.
        $netProfit = $grossProfit - $paidToProviders;

        // 6. Top Productos Vendidos (Para el reporte)
        $topProductos = DetalleVenta::select(
                'productos.nombre as producto_nombre',
                DB::raw('SUM(detalle_ventas.cantidad) as total_qty'),
                DB::raw('SUM(detalle_ventas.cantidad * detalle_ventas.precio) as total_sales')
            )
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->groupBy('productos.nombre')
            ->orderBy('total_qty', 'desc')
            ->limit(10)
            ->get();


        return view('ventas.stats', compact(
            'totalVentas', 
            'costTotal', 
            'paidToProviders', 
            'grossProfit', 
            'netProfit', 
            'topProductos'
        ));
    }
}