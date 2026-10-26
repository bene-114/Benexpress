<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener categorías de productos para el Home
        $categories = Category::where('type', 'producto')->take(8)->get();

        // Obtener productos destacados con la información de su tienda
        $featuredProducts = Product::with('vendor')->take(4)->get();

        return view('home', compact('categories', 'featuredProducts'));
    }
}
