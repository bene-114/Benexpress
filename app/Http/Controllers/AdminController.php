<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\VendorProfile;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    // Vista principal del Dashboard de Administrador
    public function index()
    {
        $totalUsers = User::count();
        $totalVendors = VendorProfile::where('status', 'aprobado')->count();
        $pendingVendors = VendorProfile::where('status', 'pendiente')->get();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $categories = Category::latest()->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalVendors', 'pendingVendors', 
            'totalProducts', 'totalOrders', 'categories'
        ));
    }

    // Crear nueva Categoría (Productos o Tiendas)
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'type' => 'required|in:producto,tienda',
        ]);

        Category::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return back()->with('success', 'Categoría registrada correctamente por el administrador.');
    }

    // Eliminar Categoría
    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Categoría eliminada del sistema.');
    }

    // Aprobar o Rechazar Proveedores
    public function updateVendorStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:aprobado,rechazado',
        ]);

        $vendor = VendorProfile::findOrFail($id);
        $vendor->update(['status' => $request->status]);

        return back()->with('success', "Estado del proveedor de '{$vendor->store_name}' actualizado a " . strtoupper($request->status) . ".");
    }
}