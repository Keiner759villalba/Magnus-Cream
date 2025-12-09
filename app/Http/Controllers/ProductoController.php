<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('inventario')->latest()->paginate(15);
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ]);

        $producto = Producto::create([
            'nombre' => $data['nombre'],
            'categoria' => $data['categoria'] ?? null,
            'precio_compra' => $data['precio_compra'],
            'precio_venta' => $data['precio_venta'],
        ]);

        Inventario::updateOrCreate(
            ['producto_id' => $producto->id],
            ['stock' => $data['stock'] ?? 0]
        );

        return redirect()->route('productos.index');
    }

    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ]);

        $producto->update([
            'nombre' => $data['nombre'],
            'categoria' => $data['categoria'] ?? null,
            'precio_compra' => $data['precio_compra'],
            'precio_venta' => $data['precio_venta'],
        ]);

        Inventario::updateOrCreate(
            ['producto_id' => $producto->id],
            ['stock' => $data['stock'] ?? ($producto->inventario->stock ?? 0)]
        );

        return redirect()->route('productos.index');
    }

    public function destroy(Producto $producto)
    {
        // Si tiene imagen, eliminarla
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        // Eliminar inventario
        if ($producto->inventario) {
            $producto->inventario->delete();
        }

        // Eliminar producto
        $producto->delete();

        return back();
    }
}
