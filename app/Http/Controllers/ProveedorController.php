<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        // eager load compras y productos con inventario
        $proveedores = Proveedor::with(['productos.inventario', 'productosComprados'])->latest()->paginate(12);
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'empresa' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
        ]);

        Proveedor::create($data);
        return redirect()->route('proveedores.index');
    }

    public function show(Proveedor $proveedor)
    {
        // eager load compras y (opcional) productos de venta
        $proveedor->load(['productosComprados', 'productos.inventario']);
        return view('proveedores.show', compact('proveedor'));
    }

    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'empresa' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
        ]);

        $proveedor->update($data);
        return redirect()->route('proveedores.index');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();
        return back();
    }
}
