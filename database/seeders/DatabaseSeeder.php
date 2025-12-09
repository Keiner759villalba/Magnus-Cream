<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@magnuscream.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        // Crear usuario de prueba
        User::create([
            'name' => 'Usuario Prueba',
            'email' => 'usuario@magnuscream.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        // Ejecutar seeders en orden (importante por las relaciones)
        $this->call([
            ProveedorSeeder::class,
            ProductoSeeder::class,
            ClienteSeeder::class,
            InventarioSeeder::class,
            VentaSeeder::class,
            DetalleVentaSeeder::class,
        ]);
    }
}