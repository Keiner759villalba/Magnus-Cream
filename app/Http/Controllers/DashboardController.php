<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Venta; // Necesario para la corrección
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Muestra el dashboard principal
    public function index()
    {
        $clientes = Cliente::count();
        $productos = Producto::count();
        $ventasCount = Venta::count();

        $totalVentas = Venta::sum('total');

        // calcular costo total de ventas (sum cantidad * precio_compra)
        $costTotal = DetalleVenta::select(DB::raw('SUM(detalle_ventas.cantidad * productos.precio_compra) AS cost_total'))
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->value('cost_total') ?? 0;

        $ganancia = $totalVentas - $costTotal;

        // ----------------------------------------------------------------------
        // CÓDIGO AÑADIDO: Carga de las ventas recientes para el widget de navegación
        // ----------------------------------------------------------------------
        $ventas = Venta::with('cliente') // Eager loading de la relación 'cliente' para la tabla
                       ->latest()      // Ordenar por las más recientes
                       ->limit(5)      // Limitar a, por ejemplo, las 5 últimas
                       ->get();
        // ----------------------------------------------------------------------


        // Se añade 'ventas' a la función compact para pasarla a la vista
        return view('dashboard', compact('clientes', 'productos', 'ventasCount', 'totalVentas', 'ganancia', 'ventas'));
    }
}