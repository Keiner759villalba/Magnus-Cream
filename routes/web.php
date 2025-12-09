<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\ProveedorProductoController;
use Illuminate\Support\Facades\Route;

// Al iniciar el servidor ir a autenticación
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard protegido
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas: sólo módulo administrador
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Módulo administrativo
    Route::resource('productos', ProductoController::class);
    Route::resource('inventarios', InventarioController::class)->except(['create', 'store']);
    // Forzar el parámetro singular a "proveedor" (evita {proveedore})
    Route::resource('proveedores', ProveedorController::class)->parameters(['proveedores' => 'proveedor']);

    // Rutas para gestionar productos recibidos por proveedor
    Route::resource('proveedores.productos_comprados', ProveedorProductoController::class)
        ->shallow()
        ->only(['store', 'destroy']);

    Route::resource('clientes', ClienteController::class);
    Route::resource('ventas', VentaController::class);
    Route::get('/ventas/stats', [VentaController::class, 'stats'])->name('ventas.stats'); // nueva ruta
    Route::get('/informes/ventas', [VentaController::class, 'stats'])->name('informes.ventas');
    Route::resource('detalle_ventas', DetalleVentaController::class)->only(['index','show','destroy']);
});

require __DIR__.'/auth.php';
