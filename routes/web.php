<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\VendorProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\PasswordResetController;

// Ventana 1: Página Principal
Route::get('/', [HomeController::class, 'index'])->name('home');

use App\Http\Controllers\AuthController;

// Ventana 2: Inicio de Sesión
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');


// Ventana 3 y 4: Registro de Usuario / Proveedor
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');

// Ventana 5: Catálogo de Productos
Route::get('/productos', [CatalogController::class, 'index'])->name('catalog.index');
//ventana 6: detalle del producto
Route::get('/productos/{id}', [CatalogController::class, 'show'])->name('catalog.show');

// Rutas Protegidas (Exigen inicio de sesión obligatorio)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Proceso de Compra (Ventanas 7 y 8)
    Route::get('/comprar/{product}', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/comprar', [OrderController::class, 'store'])->name('checkout.store');
    
    // Seguimiento de Compras (Ventana 10)
    Route::get('/mis-compras', [OrderController::class, 'index'])->name('orders.index');
//rutas del carrito protegidos
    Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
    Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
    Route::post('/carrito/eliminar/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/carrito/vaciar', [CartController::class, 'clear'])->name('cart.clear');
//rutas del proveedor 
    Route::get('/mi-negocio', [VendorProductController::class, 'index'])->name('vendor.dashboard');
    Route::get('/mi-negocio/productos/crear', [VendorProductController::class, 'create'])->name('vendor.products.create');
    Route::post('/mi-negocio/productos', [VendorProductController::class, 'store'])->name('vendor.products.store');
    Route::post('/mi-negocio/productos/eliminar/{id}', [VendorProductController::class, 'destroy'])->name('vendor.products.destroy');
    Route::get('/mi-negocio/productos/editar/{id}', [VendorProductController::class, 'edit'])->name('vendor.products.edit');
    Route::post('/mi-negocio/productos/actualizar/{id}', [VendorProductController::class, 'update'])->name('vendor.products.update');
    //rutas del admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/categorias', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::delete('/admin/categorias/{id}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
    Route::post('/admin/proveedores/{id}/estado', [AdminController::class, 'updateVendorStatus'])->name('admin.vendors.status');
});


// Ventana: Directorio de Tiendas y Perfil de Tienda
Route::get('/tiendas', [StoreController::class, 'index'])->name('stores.index');
Route::get('/tiendas/{id}', [StoreController::class, 'show'])->name('stores.show');
// Rutas Informativas Estáticas
Route::view('/nosotros', 'pages.about')->name('about');
Route::view('/contacto', 'pages.contact')->name('contact');



// Rutas de Recuperación de Contraseña
Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'store'])->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');