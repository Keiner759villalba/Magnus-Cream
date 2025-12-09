<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'nombre' => 'María González Ruiz',
                'telefono' => '3001234567',
                'correo' => 'maria.gonzalez@email.com',
                'direccion' => 'Calle 45 #23-12, Chapinero, Bogotá',
                'identificacion' => '1012345678',
            ],
            [
                'nombre' => 'Carlos Rodríguez Pérez',
                'telefono' => '3109876543',
                'correo' => 'carlos.rodriguez@email.com',
                'direccion' => 'Carrera 15 #67-34, Usaquén, Bogotá',
                'identificacion' => '1023456789',
            ],
            [
                'nombre' => 'Laura Martínez Silva',
                'telefono' => '3156789012',
                'correo' => 'laura.martinez@email.com',
                'direccion' => 'Avenida 68 #12-45, Engativá, Bogotá',
                'identificacion' => '1034567890',
            ],
            [
                'nombre' => 'Juan Pérez Gómez',
                'telefono' => '3187654321',
                'correo' => 'juan.perez@email.com',
                'direccion' => 'Calle 100 #89-23, Suba, Bogotá',
                'identificacion' => '1045678901',
            ],
            [
                'nombre' => 'Ana López Torres',
                'telefono' => '3201239876',
                'correo' => 'ana.lopez@email.com',
                'direccion' => 'Carrera 7 #45-67, Teusaquillo, Bogotá',
                'identificacion' => '1056789012',
            ],
            [
                'nombre' => 'Diego Ramírez Castro',
                'telefono' => '3125678901',
                'correo' => 'diego.ramirez@email.com',
                'direccion' => 'Calle 80 #23-45, Barrios Unidos, Bogotá',
                'identificacion' => '1067890123',
            ],
            [
                'nombre' => 'Sofía Hernández Rojas',
                'telefono' => '3134567890',
                'correo' => 'sofia.hernandez@email.com',
                'direccion' => 'Carrera 50 #12-34, Kennedy, Bogotá',
                'identificacion' => '1078901234',
            ],
            [
                'nombre' => 'Andrés Morales Vargas',
                'telefono' => '3143456789',
                'correo' => 'andres.morales@email.com',
                'direccion' => 'Avenida Boyacá #45-67, Fontibón, Bogotá',
                'identificacion' => '1089012345',
            ],
            [
                'nombre' => 'Valentina Sánchez Cruz',
                'telefono' => '3152345678',
                'correo' => 'valentina.sanchez@email.com',
                'direccion' => 'Calle 170 #56-78, Suba, Bogotá',
                'identificacion' => '1090123456',
            ],
            [
                'nombre' => 'Santiago Díaz Mendoza',
                'telefono' => '3161234567',
                'correo' => 'santiago.diaz@email.com',
                'direccion' => 'Carrera 30 #67-89, Santa Fe, Bogotá',
                'identificacion' => '1101234567',
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}