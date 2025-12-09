<?php

namespace Database\Seeders;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class InventarioSeeder extends Seeder
{
    public function run(): void
    {
        $productos = Producto::all();

        foreach ($productos as $producto) {
            // Asignar stock según la categoría del producto
            $stock = match($producto->categoria) {
                'Fruta' => rand(30, 80),        // Las frutas son perecederas
                'Lácteo' => rand(25, 60),       // Los lácteos también
                'Topping' => rand(40, 90),      // Durables pero se usan mucho
                'Complemento' => rand(50, 100), // Buen stock
                'Endulzante' => rand(60, 120),  // Alta rotación
                'Empaque' => rand(200, 500),    // Se necesitan muchos
                default => rand(50, 100),
            };

            Inventario::create([
                'producto_id' => $producto->id,
                'stock' => $stock,
            ]);
        }
    }
}