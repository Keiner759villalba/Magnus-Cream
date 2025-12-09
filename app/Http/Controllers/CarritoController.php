<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function index()
    {
        $cart = Session::get('carrito', []); // [product_id => cantidad]
        $items = [];
        $total = 0;

        if (!empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
            foreach ($cart as $pid => $qty) {
                if (!isset($products[$pid])) continue;
                $p = $products[$pid];
                $subtotal = ($p->precio_venta ?? 0) * $qty;
                $items[] = [
                    'product' => $p,
                    'cantidad' => $qty,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        return view('carrito.index', compact('items', 'total'));
    }

    public function agregar(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = Session::get('carrito', []);
        $id = (int)$product->id;
        $cart[$id] = ($cart[$id] ?? 0) + 1;
        Session::put('carrito', $cart);
        return back()->with('success', 'Producto añadido al carrito.');
    }

    public function eliminar(Request $request, $id)
    {
        $cart = Session::get('carrito', []);
        $id = (int)$id;
        if (isset($cart[$id])) {
            unset($cart[$id]);
            if (empty($cart)) {
                Session::forget('carrito');
            } else {
                Session::put('carrito', $cart);
            }
        }
        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        Session::forget('carrito');
        return back()->with('success', 'Carrito vaciado.');
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'correo' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:255',
        ]);

        $cart = Session::get('carrito', []);
        if (empty($cart)) {
            return back()->withErrors(['cart' => 'El carrito está vacío.']);
        }

        $ventaId = null;

        DB::transaction(function () use ($data, &$ventaId, $cart) {
            $cliente = Cliente::create($data);

            $venta = Venta::create([
                'cliente_id' => $cliente->id,
                'total' => 0
            ]);

            $total = 0;
            $productos = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

            foreach ($cart as $pid => $qty) {
                if (!isset($productos[$pid])) continue;
                $p = $productos[$pid];
                $subtotal = $p->precio_venta * $qty;

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $p->id,
                    'cantidad' => $qty,
                    'subtotal' => $subtotal,
                ]);

                if ($p->inventario) {
                    $p->inventario->decrement('stock', $qty);
                }

                $total += $subtotal;
            }

            $venta->update(['total' => $total]);
            $ventaId = $venta->id;
        });

        Session::forget('carrito');

        return redirect()->route('carrito.success', ['venta' => $ventaId]);
    }

    public function success(Venta $venta)
    {
        $venta->load('cliente', 'detalles.producto');
        return view('store.checkout_success', compact('venta'));
    }
}
