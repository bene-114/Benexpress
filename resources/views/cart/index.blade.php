@extends('layouts.app')

@section('content')
<!-- Migas de pan -->
<nav class="text-xs text-gray-500 mb-6 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-brand-green"><i class="fa-solid fa-house"></i> Inicio</a>
    <span>&gt;</span>
    <span class="font-bold text-gray-800">Carrito</span>
</nav>

<div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-black text-gray-900">Carrito de compras</h1>
        <p class="text-xs text-gray-500">Revisa tus productos antes de continuar.</p>
    </div>

    @if($cartItems->count() > 0)
        <form action="{{ route('cart.clear') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="border border-red-300 text-red-600 hover:bg-red-50 text-xs font-bold px-4 py-2 rounded-xl transition flex items-center gap-2">
                <i class="fa-solid fa-trash-can"></i> Vaciar carrito
            </button>
        </form>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

    <!-- COLUMNA IZQUIERDA: LISTADO DE PRODUCTOS EN EL CARRITO -->
    <div class="lg:col-span-8 space-y-4">
        @forelse($cartItems as $item)
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                
                <!-- Datos del producto -->
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center border overflow-hidden flex-shrink-0">
                        @if($item->product->main_image)
                            <img src="{{ asset('storage/' . $item->product->main_image) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-image text-gray-300 text-2xl"></i>
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('catalog.show', $item->product->id) }}" class="font-bold text-gray-800 text-sm hover:text-brand-green transition block">
                            {{ $item->product->name }}
                        </a>
                        <p class="text-xs text-gray-500 mb-1">Tienda: {{ $item->product->vendor->store_name ?? 'Comercio Local' }}</p>
                        <p class="text-sm font-extrabold text-brand-dark">${{ number_format($item->product->price, 2) }} <span class="text-[10px] text-gray-400 font-normal">pieza</span></p>
                    </div>
                </div>

                <!-- Cantidad y Subtotal -->
                <div class="flex items-center justify-between sm:justify-end gap-6 border-t sm:border-t-0 pt-3 sm:pt-0 border-gray-100">
                    <div>
                        <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Cantidad</span>
                        <span class="text-xs font-bold text-gray-800 bg-gray-100 px-3 py-1.5 rounded-lg border">
                            {{ $item->quantity }} pieza(s)
                        </span>
                        <span class="text-[10px] text-gray-400 block mt-1">Stock: {{ $item->product->stock }}</span>
                    </div>

                    <div class="text-right">
                        <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Subtotal</span>
                        <span class="text-sm font-black text-brand-dark">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                    </div>

                    <!-- Botón Comprar Producto Independiente & Eliminar -->
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('checkout', $item->product->id) }}?quantity={{ $item->quantity }}" class="bg-brand-dark hover:bg-gray-800 text-white font-bold px-3.5 py-2 rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow">
                            <i class="fa-solid fa-bag-shopping"></i> Comprar
                        </a>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline text-center">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-500 text-xs p-1 transition" title="Eliminar artículo">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="bg-white p-12 rounded-2xl border text-center">
                <i class="fa-solid fa-cart-shopping text-5xl text-gray-300 mb-3"></i>
                <h3 class="text-base font-bold text-gray-700">Tu carrito está vacío</h3>
                <p class="text-xs text-gray-500 mt-1 mb-6">Explora nuestro catálogo para agregar productos.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block bg-brand-green text-white font-bold text-xs px-6 py-3 rounded-xl hover:bg-emerald-800 transition">
                    Ver catálogo de productos
                </a>
            </div>
        @endforelse

        <div class="pt-4">
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-600 hover:text-brand-green">
                <i class="fa-solid fa-arrow-left"></i> Seguir comprando
            </a>
        </div>
    </div>

    <!-- COLUMNA DERECHA: RESUMEN DEL CARRITO -->
    <div class="lg:col-span-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm space-y-4 sticky top-24">
            <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3">Resumen del carrito</h2>

            <div class="space-y-2 text-xs text-gray-600">
                <div class="flex justify-between">
                    <span>Productos ({{ $totalProductsCount }})</span>
                    <span class="font-bold text-gray-800">${{ number_format($totalEstimated, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Costo de entrega</span>
                    <span class="font-bold text-gray-800">Se calcula después</span>
                </div>
            </div>

            <div class="bg-emerald-50 p-3.5 rounded-xl flex items-center justify-between text-brand-dark">
                <span class="text-xs font-bold">Total estimado</span>
                <span class="text-xl font-black text-brand-green">${{ number_format($totalEstimated, 2) }}</span>
            </div>

            <div class="bg-blue-50 border border-blue-200 p-3 rounded-xl flex items-start gap-2.5 text-xs text-blue-900">
                <i class="fa-solid fa-circle-info text-blue-600 mt-0.5"></i>
                <p class="text-[11px] leading-relaxed">
                    El costo de entrega se calculará según la tienda y la dirección de entrega en el siguiente paso al hacer clic en "Comprar".
                </p>
            </div>
        </div>
    </div>

</div>
@endsection