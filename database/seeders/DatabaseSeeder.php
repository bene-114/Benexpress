<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\VendorProfile;
use App\Models\Product;
use App\Models\ProductCharacteristic;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categorías
        $catStore = Category::create(['name' => 'Artesanías y manualidades', 'type' => 'tienda']);
        $catProduct = Category::create(['name' => 'Artesanías', 'type' => 'producto']);

        // 2. Usuario Proveedor
        $user = User::create([
            'name' => 'Creaciones Hernández',
            'email' => 'contacto@creaciones.com',
            'phone' => '9611234567',
            'password' => Hash::make('password123'),
            'role' => 'proveedor',
        ]);

        // 3. Perfil del Proveedor
        $vendor = VendorProfile::create([
            'user_id' => $user->id,
            'store_name' => 'Creaciones Hernández',
            'category_id' => $catStore->id,
            'description' => 'Tienda dedicada a la elaboración de manualidades y recuerdos artesanales.',
            'clabe' => '012345678901234567',
            'status' => 'aprobado',
        ]);

        // 4. Producto de Prueba
        $product = Product::create([
            'vendor_profile_id' => $vendor->id,
            'category_id' => $catProduct->id,
            'name' => 'Conejo de crochet (llavero)',
            'description' => 'Llavero de tejido suave hecho a mano por artesanos locales. Disponible en varios colores.',
            'price' => 120.00,
            'stock' => 10,
            'main_image' => '',
        ]);

        // 5. Características
        ProductCharacteristic::create(['product_id' => $product->id, 'spec_text' => 'Tejido artesanal hecho a mano']);
        ProductCharacteristic::create(['product_id' => $product->id, 'spec_text' => 'Incluye argolla metálica resistente']);
    }
}