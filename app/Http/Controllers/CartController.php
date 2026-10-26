<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Mostrar el Carrito de Compras (Ventana 9)
    public function index()
    {
        $cartItems = CartItem::with(['product.vendor'])
            ->where('user_id', Auth::id())
            ->get();

        $totalEstimated = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        $totalProductsCount = $cartItems->sum('quantity');

        return view('cart.index', compact('cartItems', 'totalEstimated', 'totalProductsCount'));
    }

    // Agregar producto al carrito
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->product_id;
        $quantity = (int) $request->quantity;

        // Verificar si ya existe en el carrito del usuario para sumar la cantidad
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Producto añadido al carrito correctamente.');
    }

    // Eliminar un ítem del carrito
    public function remove($id)
    {
        $cartItem = CartItem::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito.');
    }

    // Vaciar todo el carrito
    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')->with('success', 'El carrito ha sido vaciado.');
    }
}