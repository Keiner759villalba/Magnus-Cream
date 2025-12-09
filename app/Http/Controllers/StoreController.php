<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StoreController extends Controller
{
    public function index()
    {
        $productos = Producto::with('inventario')->paginate(12);
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            $prodIds = array_keys($cart);
            $prods = Producto::whereIn('id', $prodIds)->get()->keyBy('id');
            foreach ($cart as $pid => $qty) {
                if (!isset($prods[$pid])) continue;
                $p = $prods[$pid];
                $subtotal = $p->precio_venta * $qty;
                $cartItems[] = ['producto' => $p, 'cantidad' => $qty, 'subtotal' => $subtotal];
                $total += $subtotal;
            }
        }

        return view('store.index', compact('productos', 'cartItems', 'total'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'nullable|integer|min:1'
        ]);

        $qty = $data['cantidad'] ?? 1;
        $cart = Session::get('cart', []);
        $id = (int)$data['producto_id'];
        $cart[$id] = ($cart[$id] ?? 0) + $qty;
        Session::put('cart', $cart);

        return back()->with('success', 'Producto añadido al carrito.');
    }

    public function removeFromCart(Request $request)
    {
        $data = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'all' => 'nullable|boolean'
        ]);

        $id = (int)$data['producto_id'];
        $cart = Session::get('cart', []);
        if (!isset($cart[$id])) {
            return back();
        }

        if (!empty($data['all'])) {
            unset($cart[$id]);
        } else {
            $cart[$id] = max(0, $cart[$id] - 1);
            if ($cart[$id] <= 0) unset($cart[$id]);
        }

        Session::put('cart', $cart);
        return back()->with('success', 'Carrito actualizado.');
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'correo' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:255',
        ]);

        $cart = Session::get('cart', []);
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
            $productos = Producto::whereIn('id', array_keys($cart))->get()->keyBy('id');

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

        Session::forget('cart');

        return redirect()->route('cart.success', ['venta' => $ventaId]);
    }

    public function success(Venta $venta)
    {
        $venta->load('cliente', 'detalles.producto');
        return view('store.checkout_success', compact('venta'));
    }
}
