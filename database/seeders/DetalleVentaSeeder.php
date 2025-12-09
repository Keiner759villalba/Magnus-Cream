<?php

namespace Database\Seeders;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Illuminate\Database\Seeder;

class DetalleVentaSeeder extends Seeder
{
    public function run(): void
    {
        $ventas = Venta::all();
        $productos = Producto::all();

        foreach ($ventas as $venta) {
            // Cada venta tendrá entre 2 y 6 productos
            $numProductos = rand(2, 6);
            $totalVenta = 0;
            $productosUsados = [];

            for ($i = 0; $i < $numProductos; $i++) {
                // Seleccionar un producto que no se haya usado en esta venta
                do {
                    $producto = $productos->random();
                } while (in_array($producto->id, $productosUsados));

                $productosUsados[] = $producto->id;

                // Cantidad según el tipo de producto
                $cantidad = match($producto->categoria) {
                    'Fruta' => rand(1, 3),      // 1-3 kg de fresas
                    'Lácteo' => rand(1, 2),     // 1-2 unidades de crema
                    'Topping' => rand(1, 3),    // 1-3 toppings
                    'Complemento' => rand(1, 2), // 1-2 complementos
                    'Endulzante' => 1,           // Generalmente 1
                    'Empaque' => rand(2, 4),    // Varios vasos/cucharas
                    default => rand(1, 3),
                };

                $subtotal = $producto->precio_venta * $cantidad;
                $totalVenta += $subtotal;

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal,
                    'created_at' => $venta->created_at,
                    'updated_at' => $venta->updated_at,
                ]);
            }

            // Actualizar el total de la venta
            $venta->update(['total' => $totalVenta]);
        }
    }
}