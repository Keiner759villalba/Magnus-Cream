<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::with('producto')->paginate(20);
        return view('inventarios.index', compact('inventarios'));
    }

    public function edit(Inventario $inventario)
    {
        return view('inventarios.edit', compact('inventario'));
    }

    public function update(Request $request, Inventario $inventario)
    {
        $data = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $inventario->update($data);
        return redirect()->route('inventarios.index');
    }

    // helper to create inventory record when product created (optional)
    public function createForProduct(Producto $producto)
    {
        $inventario = Inventario::firstOrCreate(
            ['producto_id' => $producto->id],
            ['stock' => 0]
        );

        return redirect()->route('inventarios.edit', $inventario);
    }
}
