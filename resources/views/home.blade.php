@extends('layouts.app')

@section('content')
<!-- BANNER PROMOCIONAL -->
<div class="bg-gradient-to-r from-emerald-800 to-brand-green text-white rounded-2xl p-8 mb-8 flex flex-col md:flex-row items-center justify-between shadow-lg">
    <div class="max-w-lg mb-6 md:mb-0">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-3 leading-tight">
            Compra en tu comunidad
        </h1>
        <p class="text-emerald-100 text-base mb-6">
            Productos locales, entrega rápida y apoyo a negocios de nuestro municipio.
        </p>
        <a href="{{ route('catalog.index') }}" class="inline-block bg-brand-orange hover:bg-orange-700 text-white font-bold px-6 py-3 rounded-lg shadow-md transition">
            Ver productos <i class="fa-solid fa-arrow-right ml-2"></i>
        </a>
    </div>
    <div class="w-full md:w-1/3 flex justify-center">
        <i class="fa-solid fa-store text-8xl text-emerald-200 opacity-80"></i>
    </div>
</div>

<!-- SECCIÓN DE CATEGORÍAS -->
<div class="mb-10">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Categorías</h2>
        <a href="{{ route('catalog.index') }}" class="text-sm font-semibold text-brand-green hover:underline">Ver todas &gt;</a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
        @forelse($categories as $cat)
            <a href="{{ route('catalog.index', ['categories[]' => $cat->id]) }}" class="bg-white p-4 rounded-xl border border-gray-200 text-center hover:shadow-md transition group">
                <div class="w-12 h-12 mx-auto mb-2 bg-emerald-50 rounded-full flex items-center justify-center text-brand-green group-hover:bg-brand-green group-hover:text-white transition">
                    <i class="fa-solid fa-box-open text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-gray-700 block">{{ $cat->name }}</span>
            </a>
        @empty
            <!-- Muestra estática visual para pruebas antes de llenar la BD -->
            <div class="bg-white p-4 rounded-xl border text-center"><p class="text-xs font-bold">Celulares</p></div>
            <div class="bg-white p-4 rounded-xl border text-center"><p class="text-xs font-bold">Computación</p></div>
            <div class="bg-white p-4 rounded-xl border text-center"><p class="text-xs font-bold">Moda y Accesorios</p></div>
            <div class="bg-white p-4 rounded-xl border text-center"><p class="text-xs font-bold">Deportes</p></div>
        @endforelse
    </div>
</div>

<!-- SECCIÓN DE PRODUCTOS DESTACADOS -->
<div>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Productos destacados</h2>
        <a href="{{ route('catalog.index') }}" class="text-sm font-semibold text-brand-green hover:underline">Ver todos &gt;</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($featuredProducts as $product)
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition relative flex flex-col justify-between">
                <div>
                   <!-- Botón Favorito -->
<button class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow text-gray-400 hover:text-red-500 z-10">
    <i class="fa-regular fa-heart"></i>
</button>

<!-- Imagen con enlace -->
<a href="{{ route('catalog.show', $product->id) }}" class="h-48 bg-gray-100 flex items-center justify-center block overflow-hidden">
    <i class="fa-solid fa-image text-4xl text-gray-300"></i>
</a>

<!-- Contenido -->
<div class="p-4">
    <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-1">
        <a href="{{ route('catalog.show', $product->id) }}" class="hover:text-brand-green transition">
            {{ $product->name }}
        </a>
    </h3>
    <p class="text-xs text-gray-500 mb-2">Tienda: <span class="font-medium text-gray-700">{{ $product->vendor->store_name ?? 'Comercio Local' }}</span></p>
    <div class="flex items-center gap-1 text-amber-400 text-xs mb-3">
        <i class="fa-solid fa-star"></i>
        <span class="text-gray-600 font-medium">4.8 (12)</span>
    </div>
    <p class="text-lg font-extrabold text-brand-dark">${{ number_format($product->price, 2) }} <span class="text-xs text-gray-400 font-normal">pieza</span></p>
</div>
                </div>
               <div class="p-4 pt-0">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full bg-gray-100 hover:bg-brand-green hover:text-white text-gray-700 text-xs font-bold py-2 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-shopping"></i> Agregar
                    </button>
                </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-sm col-span-4 text-center py-8">Aún no hay productos registrados en la base de datos.</p>
        @endforelse
    </div>
</div>
@endsection