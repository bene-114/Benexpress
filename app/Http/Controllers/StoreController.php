<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorProfile;
use App\Models\Category;

class StoreController extends Controller
{
    // Mostrar listado de tiendas (Directorio)
    public function index(Request $request)
    {
        $categories = Category::where('type', 'tienda')->get();

        $query = VendorProfile::with('category')->where('status', 'aprobado');

        // Buscar por nombre de tienda
        if ($request->filled('search')) {
            $query->where('store_name', 'LIKE', '%' . $request->search . '%');
        }

        // Filtrar por categoría de tienda
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $stores = $query->paginate(9);

        return view('stores.index', compact('stores', 'categories'));
    }

    // Mostrar detalle/perfil de una tienda y sus productos
    public function show($id)
    {
        $store = VendorProfile::with(['category', 'user', 'products'])->findOrFail($id);

        return view('stores.show', compact('store'));
    }
}