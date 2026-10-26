@extends('layouts.app')

@section('content')
<!-- Migas de pan (Breadcrumbs) -->
<nav class="text-xs text-gray-500 mb-4 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-brand-green"><i class="fa-solid fa-house"></i> Inicio</a>
    <span>&gt;</span>
    <span class="font-bold text-gray-800">Productos</span>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

    <!-- COLUMNA IZQUIERDA: FILTROS (Wireframe Catálogo) -->
    <aside class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm h-fit">
        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-filter text-brand-orange"></i> Filtros
        </h2>

        <form action="{{ route('catalog.index') }}" method="GET">
            <!-- Filtro Rango de Precio -->
            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-700 mb-2">Precio</label>
                <div class="grid grid-cols-2 gap-2">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Mínimo"
                           class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-xs focus:outline-none focus:border-brand-green">
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Máximo"
                           class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-xs focus:outline-none focus:border-brand-green">
                </div>
            </div>

            <!-- Filtro Categorías (Checkboxes) -->
            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-700 mb-2">Categorías</label>
                <div class="space-y-2 max-h-48 overflow-y-auto pr-1 text-xs">
                    @forelse($categories as $cat)
                        <label class="flex items-center gap-2 text-gray-700 cursor-pointer">
                            <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                   {{ is_array(request('categories')) && in_array($cat->id, request('categories')) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-brand-green focus:ring-brand-green">
                            <span>{{ $cat->name }}</span>
                        </label>
                    @empty
                        <p class="text-gray-400 italic">No hay categorías disponibles</p>
                    @endforelse
                </div>
            </div>

            <!-- Ordenar por -->
            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-700 mb-2">Ordenar por</label>
                <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:outline-none focus:border-brand-green">
                    <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Más recientes</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-brand-dark hover:bg-gray-800 text-white font-bold py-2 rounded-lg text-xs transition shadow">
                Aplicar filtros
            </button>
            
            @if(request()->hasAny(['min_price', 'max_price', 'categories', 'sort', 'search']))
                <a href="{{ route('catalog.index') }}" class="block text-center text-xs text-red-600 font-semibold mt-2 hover:underline">
                    Limpiar filtros
                </a>
            @endif
        </form>
    </aside>

    <!-- COLUMNA DERECHA: GRILLA DE PRODUCTOS -->
    <section class="lg:col-span-3">
        <!-- Encabezado de catálogo -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 pb-4 border-b border-gray-200 gap-2">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Productos</h1>
                <p class="text-xs text-gray-500">Encuentra lo que necesitas en tu comunidad</p>
            </div>
            <p class="text-xs text-gray-600 font-medium">
                Mostrando {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} de {{ $products->total() }} productos
            </p>
        </div>

        <!-- Productos Grilla (4 columnas) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
            @forelse($products as $product)
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition relative flex flex-col justify-between">
                    <div>
                        <!-- Favorito -->
                        <button class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow text-gray-400 hover:text-red-500">
                            <i class="fa-regular fa-heart"></i>
                        </button>

                       <!-- Imagen del producto con enlace -->
<a href="{{ route('catalog.show', $product->id) }}" class="h-44 bg-gray-100 flex items-center justify-center block overflow-hidden">
    @if($product->main_image)
        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
    @else
        <i class="fa-solid fa-image text-4xl text-gray-300"></i>
    @endif
</a>

<!-- Detalles -->
<div class="p-4">
    <!-- Título del producto con enlace -->
    <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-1">
        <a href="{{ route('catalog.show', $product->id) }}" class="hover:text-brand-green transition">
            {{ $product->name }}
        </a>
    </h3>
    <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
        <i class="fa-solid fa-store text-brand-green text-[10px]"></i>
        <span class="truncate">{{ $product->vendor->store_name ?? 'Comercio Local' }}</span>
    </p>
    <div class="flex items-center gap-1 text-amber-400 text-xs mb-3">
        <i class="fa-solid fa-star"></i>
        <span class="text-gray-600 font-medium">0.0 (0)</span>
    </div>
    <p class="text-base font-extrabold text-brand-dark">
        ${{ number_format($product->price, 2) }}
    </p>
</div>
                    </div>

                    <div class="p-4 pt-0">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-brand-dark hover:bg-gray-800 text-white text-xs font-bold py-2 rounded-lg transition flex items-center justify-center gap-2 shadow-sm">
                                <i class="fa-solid fa-cart-shopping"></i> Agregar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-12 rounded-2xl border text-center">
                    <i class="fa-solid fa-box-open text-5xl text-gray-300 mb-3"></i>
                    <h3 class="text-base font-bold text-gray-700">No se encontraron productos</h3>
                    <p class="text-xs text-gray-500 mt-1">Intenta ajustando los filtros de búsqueda.</p>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </section>

</div>
@endsection