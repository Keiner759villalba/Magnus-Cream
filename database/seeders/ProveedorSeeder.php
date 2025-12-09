<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        $proveedores = [
            [
                'nombre' => 'Frutas Frescas del Valle',
                'empresa' => 'Distribuidora FDV S.A.S',
                'telefono' => '3201234567',
            ],
            [
                'nombre' => 'Lácteos Premium',
                'empresa' => 'Lácteos Premium Colombia',
                'telefono' => '3109876543',
            ],
            [
                'nombre' => 'Dulces y Sabores',
                'empresa' => 'Dulces y Sabores Ltda',
                'telefono' => '3156789012',
            ],
            [
                'nombre' => 'Empaques Biodegradables',
                'empresa' => 'EcoPack Colombia',
                'telefono' => '3187654321',
            ],
        ];

        foreach ($proveedores as $proveedor) {
            Proveedor::create($proveedor);
        }
    }
}