@extends('layouts.app')

@section('content')
<!-- Migas de pan -->
<nav class="text-xs text-gray-500 mb-6 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-brand-green"><i class="fa-solid fa-house"></i> Inicio</a>
    <span>&gt;</span>
    <a href="{{ route('stores.index') }}" class="hover:text-brand-green">Tiendas</a>
    <span>&gt;</span>
    <span class="font-bold text-gray-800">{{ $store->store_name }}</span>
</nav>

<!-- Header de la Tienda -->
<div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm mb-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        
        <div class="flex items-center gap-5">
            <div class="w-20 h-20 bg-emerald-100 rounded-2xl flex items-center justify-center text-brand-green text-3xl font-bold flex-shrink-0">
                <i class="fa-solid fa-store"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-black text-gray-900">{{ $store->store_name }}</h1>
                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full">Verificado</span>
                </div>
                <p class="text-xs font-semibold text-brand-orange mt-1">{{ $store->category->name ?? 'Giro Comercial' }}</p>
                <p class="text-xs text-gray-600 mt-2 max-w-2xl">{{ $store->description }}</p>
            </div>
        </div>

        <div class="border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 text-xs text-gray-600 space-y-2 flex-shrink-0">
            <p><i class="fa-solid fa-user text-brand-green mr-2"></i> Encargado: <span class="font-bold text-gray-800">{{ $store->user->name ?? 'Propietario' }}</span></p>
            <p><i class="fa-solid fa-phone text-brand-green mr-2"></i> Teléfono: <span class="font-bold text-gray-800">{{ $store->user->phone ?? 'Sin especificar' }}</span></p>
            <p><i class="fa-solid fa-boxes-stacked text-brand-green mr-2"></i> Catálogo: <span class="font-bold text-gray-800">{{ $store->products->count() }} productos</span></p>
        </div>

    </div>
</div>

<!-- Catálogo de Productos de esta Tienda -->
<h2 class="text-xl font-bold text-gray-900 mb-4">Catálogo de productos de esta tienda</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @forelse($store->products as $product)
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition relative flex flex-col justify-between">
            <div>
                <a href="{{ route('catalog.show', $product->id) }}" class="h-44 bg-gray-100 flex items-center justify-center block overflow-hidden">
                    @if($product->main_image)
                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-image text-4xl text-gray-300"></i>
                    @endif
                </a>
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-1">
                        <a href="{{ route('catalog.show', $product->id) }}" class="hover:text-brand-green transition">
                            {{ $product->name }}
                        </a>
                    </h3>
                    <p class="text-base font-extrabold text-brand-dark mt-2">${{ number_format($product->price, 2) }}</p>
                </div>
            </div>

            <div class="p-4 pt-0">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full bg-brand-dark hover:bg-gray-800 text-white text-xs font-bold py-2 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-shopping"></i> Agregar
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white p-8 rounded-2xl border text-center text-gray-500 text-xs">
            Esta tienda aún no tiene productos publicados en su catálogo.
        </div>
    @endforelse
</div>
@endsection