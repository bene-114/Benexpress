<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // 1. Obtener todas las categorías de tipo 'producto' para mostrarlas en los checkboxes del filtro
        $categories = Category::where('type', 'producto')->get();

        // 2. Iniciar la consulta de productos cargando la relación con la tienda (vendor)
        $query = Product::with('vendor');

        // 3. Filtrar por término de búsqueda (si el usuario escribió algo en el buscador principal del Navbar)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('vendor', function($subQ) use ($search) {
                      $subQ->where('store_name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // 4. Filtrar por categorías seleccionadas mediante checkboxes en la vista lateral
        if ($request->has('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        // 5. Filtrar por precio mínimo
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        // 6. Filtrar por precio máximo
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 7. Ordenamiento de resultados (Más recientes, menor precio, mayor precio)
        if ($request->input('sort') == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->input('sort') == 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('created_at', 'desc'); // Por defecto: más recientes
        }

        // 8. Paginación de 12 en 12 productos (tal como se muestra en los wireframes)
        $products = $query->paginate(12);

        // 9. Retornar la vista del catálogo con los datos
        return view('catalog.index', compact('products', 'categories'));
    }

    // Mostrar la Ventana 6: Detalle del Producto
    public function show($id)
    {
        // Buscar producto con sus relaciones (imágenes secundarias, características y tienda)
        $product = Product::with(['vendor', 'category', 'images', 'characteristics'])->findOrFail($id);

        // Obtener productos relacionados de la misma categoría (excluyendo el producto actual)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}