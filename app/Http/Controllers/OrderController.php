<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Mostrar la vista de compras del usuario autenticado (Ventana 10)
    public function index()
    {
        $orders = Order::with(['items.product', 'vendor'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    // Pantalla de Compra Directa (Ventanas 7 y 8)
    public function checkout(Request $request, $productId)
    {
        $product = Product::with('vendor')->findOrFail($productId);
        $quantity = max(1, (int) $request->query('quantity', 1));

        return view('orders.checkout', compact('product', 'quantity'));
    }

    // Procesar la compra, descontar stock y guardar pedido
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'delivery_type' => 'required|in:recoleccion,domicilio',
            'payment_method' => 'required|in:efectivo,transferencia',
            'delivery_address' => 'required_if:delivery_type,domicilio|nullable|string|max:255',
            'delivery_reference' => 'nullable|string|max:255',
            'delivery_phone' => 'required_if:delivery_type,domicilio|nullable|string|max:20',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;

        // Validar que haya stock suficiente disponible
        if ($product->stock < $quantity) {
            return back()->withErrors(['quantity' => 'No hay suficiente inventario disponible. Stock actual: ' . $product->stock]);
        }

        $subtotal = $product->price * $quantity;
        $deliveryCost = ($request->delivery_type === 'domicilio') ? 100.00 : 0.00;
        $total = $subtotal + $deliveryCost;

        $orderCode = 'BP-' . date('Ymd') . '-' . rand(1000, 9999);

        // 1. Guardar el Pedido con el ID del Usuario Autenticado
        $order = Order::create([
            'order_code' => $orderCode,
            'user_id' => Auth::id(), // ID real del usuario que inició sesión
            'vendor_profile_id' => $product->vendor_profile_id,
            'delivery_type' => $request->delivery_type,
            'delivery_address' => $request->delivery_address,
            'delivery_reference' => $request->delivery_reference,
            'delivery_phone' => $request->delivery_phone,
            'delivery_cost' => $deliveryCost,
            'subtotal' => $subtotal,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'pendiente',
            'notes' => $request->notes,
        ]);

        // 2. Guardar los ítems del Pedido
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $product->price,
            'subtotal' => $subtotal,
        ]);

        // 3. DESCONTAR EL STOCK DEL PRODUCTO
        $product->decrement('stock', $quantity);

        return redirect()->route('orders.index')->with('success', '¡Compra realizada con éxito! Tu pedido es ' . $orderCode);
    }
}