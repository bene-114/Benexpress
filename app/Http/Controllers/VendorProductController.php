<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\VendorProfile;
use App\Models\ProductImage;
use App\Models\ProductCharacteristic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VendorProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $vendor = VendorProfile::where('user_id', $user->id)->first();

        if (!$vendor) {
            return redirect()->route('home')->with('error', 'No cuentas con un perfil de proveedor.');
        }

        $products = Product::where('vendor_profile_id', $vendor->id)->latest()->paginate(10);
        $orders = Order::where('vendor_profile_id', $vendor->id)->latest()->take(5)->get();

        return view('vendor.dashboard', compact('vendor', 'products', 'orders'));
    }

    public function create()
    {
        $categories = Category::where('type', 'producto')->get();
        return view('vendor.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $vendor = VendorProfile::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|max:5120',
            'gallery_images.*' => 'nullable|image|max:5120',
            'characteristics' => 'nullable|array',
            'characteristics.*' => 'nullable|string|max:255',
        ]);

        // 1. Imagen principal
        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('products', 'public');
        }

        // 2. Crear Producto
        $product = Product::create([
            'vendor_profile_id' => $vendor->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'main_image' => $mainImagePath,
        ]);

        // 3. Guardar Imágenes Adicionales (Galería)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        // 4. Guardar Características
        if ($request->has('characteristics')) {
            foreach ($request->characteristics as $text) {
                if (!empty(trim($text))) {
                    ProductCharacteristic::create([
                        'product_id' => $product->id,
                        'spec_text' => trim($text),
                    ]);
                }
            }
        }
// Guardar las imágenes adicionales de la galería
if ($request->hasFile('gallery_images')) {
    foreach ($request->file('gallery_images') as $file) {
        $path = $file->store('products', 'public');
        
        \App\Models\ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $path,
        ]);
    }
}
        return redirect()->route('vendor.dashboard')->with('success', 'Producto publicado exitosamente.');
    }

    // FORMULARIO DE EDICIÓN
    public function edit($id)
    {
        $vendor = VendorProfile::where('user_id', Auth::id())->firstOrFail();
        $product = Product::with(['images', 'characteristics'])->where('vendor_profile_id', $vendor->id)->findOrFail($id);
        $categories = Category::where('type', 'producto')->get();

        return view('vendor.products.edit', compact('product', 'categories'));
    }

    // PROCESAR ACTUALIZACIÓN DEL PRODUCTO
    public function update(Request $request, $id)
    {
        $vendor = VendorProfile::where('user_id', Auth::id())->firstOrFail();
        $product = Product::where('vendor_profile_id', $vendor->id)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('main_image')) {
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            $product->main_image = $request->file('main_image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        // Actualizar o Guardar Nuevas Características
        if ($request->has('characteristics')) {
            $product->characteristics()->delete(); // Reemplazar anteriores
            foreach ($request->characteristics as $text) {
                if (!empty(trim($text))) {
                    ProductCharacteristic::create([
                        'product_id' => $product->id,
                        'spec_text' => trim($text),
                    ]);
                }
            }
        }
        // Guardar las imágenes adicionales de la galería
if ($request->hasFile('gallery_images')) {
    foreach ($request->file('gallery_images') as $file) {
        $path = $file->store('products', 'public');
        
        \App\Models\ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $path,
        ]);
    }
}

        return redirect()->route('vendor.dashboard')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $vendor = VendorProfile::where('user_id', Auth::id())->firstOrFail();
        $product = Product::where('vendor_profile_id', $vendor->id)->findOrFail($id);

        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }

        $product->delete();

        return back()->with('success', 'Producto eliminado correctamente.');
    }
}