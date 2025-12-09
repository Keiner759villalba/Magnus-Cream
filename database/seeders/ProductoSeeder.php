<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener proveedores
        $proveedorFrutas = Proveedor::where('nombre', 'Frutas Frescas del Valle')->first();
        $proveedorLacteos = Proveedor::where('nombre', 'Lácteos Premium')->first();
        $proveedorDulces = Proveedor::where('nombre', 'Dulces y Sabores')->first();
        $proveedorEmpaques = Proveedor::where('nombre', 'Empaques Biodegradables')->first();

        $productos = [
            // Frutas
            [
                'nombre' => 'Fresas Frescas Premium (Kg)',
                'categoria' => 'Fruta',
                'precio_compra' => 8000.00,
                'precio_venta' => 12000.00,
                'proveedor_id' => $proveedorFrutas->id,
            ],
            [
                'nombre' => 'Fresas Económicas (Kg)',
                'categoria' => 'Fruta',
                'precio_compra' => 5000.00,
                'precio_venta' => 8000.00,
                'proveedor_id' => $proveedorFrutas->id,
            ],
            [
                'nombre' => 'Banano (Kg)',
                'categoria' => 'Fruta',
                'precio_compra' => 2500.00,
                'precio_venta' => 4000.00,
                'proveedor_id' => $proveedorFrutas->id,
            ],
            
            // Lácteos
            [
                'nombre' => 'Crema de Leche (500ml)',
                'categoria' => 'Lácteo',
                'precio_compra' => 3500.00,
                'precio_venta' => 5500.00,
                'proveedor_id' => $proveedorLacteos->id,
            ],
            [
                'nombre' => 'Leche Condensada (395g)',
                'categoria' => 'Lácteo',
                'precio_compra' => 4200.00,
                'precio_venta' => 6500.00,
                'proveedor_id' => $proveedorLacteos->id,
            ],
            [
                'nombre' => 'Queso Crema (250g)',
                'categoria' => 'Lácteo',
                'precio_compra' => 5500.00,
                'precio_venta' => 8000.00,
                'proveedor_id' => $proveedorLacteos->id,
            ],
            
            // Endulzantes y Toppings
            [
                'nombre' => 'Azúcar Refinada (Kg)',
                'categoria' => 'Endulzante',
                'precio_compra' => 2000.00,
                'precio_venta' => 3500.00,
                'proveedor_id' => $proveedorDulces->id,
            ],
            [
                'nombre' => 'Chocolate en Polvo (500g)',
                'categoria' => 'Topping',
                'precio_compra' => 5000.00,
                'precio_venta' => 7500.00,
                'proveedor_id' => $proveedorDulces->id,
            ],
            [
                'nombre' => 'Arequipe (250g)',
                'categoria' => 'Topping',
                'precio_compra' => 3800.00,
                'precio_venta' => 6000.00,
                'proveedor_id' => $proveedorDulces->id,
            ],
            [
                'nombre' => 'Chispas de Chocolate (200g)',
                'categoria' => 'Topping',
                'precio_compra' => 4500.00,
                'precio_venta' => 7000.00,
                'proveedor_id' => $proveedorDulces->id,
            ],
            
            // Complementos
            [
                'nombre' => 'Galletas Wafer (Paquete)',
                'categoria' => 'Complemento',
                'precio_compra' => 2500.00,
                'precio_venta' => 4000.00,
                'proveedor_id' => $proveedorDulces->id,
            ],
            [
                'nombre' => 'Cereal de Maíz (500g)',
                'categoria' => 'Complemento',
                'precio_compra' => 3200.00,
                'precio_venta' => 5000.00,
                'proveedor_id' => $proveedorDulces->id,
            ],
            [
                'nombre' => 'Granola (400g)',
                'categoria' => 'Complemento',
                'precio_compra' => 4000.00,
                'precio_venta' => 6500.00,
                'proveedor_id' => $proveedorDulces->id,
            ],
            
            // Empaques
            [
                'nombre' => 'Vasos Biodegradables 12oz (Unidad)',
                'categoria' => 'Empaque',
                'precio_compra' => 150.00,
                'precio_venta' => 300.00,
                'proveedor_id' => $proveedorEmpaques->id,
            ],
            [
                'nombre' => 'Vasos Biodegradables 16oz (Unidad)',
                'categoria' => 'Empaque',
                'precio_compra' => 200.00,
                'precio_venta' => 400.00,
                'proveedor_id' => $proveedorEmpaques->id,
            ],
            [
                'nombre' => 'Cucharas Biodegradables (Unidad)',
                'categoria' => 'Empaque',
                'precio_compra' => 50.00,
                'precio_venta' => 100.00,
                'proveedor_id' => $proveedorEmpaques->id,
            ],
            [
                'nombre' => 'Servilletas (Paquete x50)',
                'categoria' => 'Empaque',
                'precio_compra' => 1500.00,
                'precio_venta' => 2500.00,
                'proveedor_id' => $proveedorEmpaques->id,
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}