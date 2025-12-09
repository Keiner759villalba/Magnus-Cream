<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\ProveedorProducto;

class ProveedorProductoController extends Controller
{
    public function store(Request $request, $proveedorId)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'precio_compra' => 'required|numeric|min:0',
        ]);

        $proveedor = Proveedor::findOrFail($proveedorId);

        $proveedor->productosComprados()->create($data);

        return redirect()->route('proveedores.show', $proveedorId)->with('success', 'Producto recibido agregado.');
    }

    public function destroy(ProveedorProducto $productos_comprado)
    {
        $proveedorId = $productos_comprado->proveedor_id;
        $productos_comprado->delete();

        return redirect()->route('proveedores.show', $proveedorId)->with('success', 'Registro eliminado.');
    }
}
