<?php

namespace Database\Seeders;

use App\Models\Venta;
use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VentaSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();
        
        // Crear 25 ventas distribuidas en los últimos 60 días
        for ($i = 0; $i < 25; $i++) {
            $diasAtras = rand(0, 60);
            $fecha = Carbon::now()->subDays($diasAtras);
            
            // Añadir variación en las horas
            $hora = rand(8, 20);
            $minuto = rand(0, 59);
            $fecha->setTime($hora, $minuto);

            Venta::create([
                'cliente_id' => $clientes->random()->id,
                'total' => 0, // Se calculará en DetalleVentaSeeder
                'created_at' => $fecha,
                'updated_at' => $fecha,
            ]);
        }
    }
}