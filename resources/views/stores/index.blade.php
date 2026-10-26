@extends('layouts.app')

@section('content')
<!-- Migas de pan -->
<nav class="text-xs text-gray-500 mb-6 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-brand-green"><i class="fa-solid fa-house"></i> Inicio</a>
    <span>&gt;</span>
    <span class="font-bold text-gray-800">Tiendas locales</span>
</nav>

<div class="mb-8">
    <h1 class="text-2xl font-black text-gray-900 mb-1">Comercio local en Benemérito de las Américas</h1>
    <p class="text-xs text-gray-500">Conoce los negocios locales, explora sus productos y apoya a nuestra comunidad.</p>
</div>

<!-- Barra de Búsqueda y Filtro por Categoría -->
<div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm mb-8">
    <form action="{{ route('stores.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-4">
        
        <div class="sm:col-span-6 relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar negocio por nombre..." 
                   class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green">
        </div>

        <div class="sm:col-span-4">
            <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green">
                <option value="">Todas las categorías de tiendas</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="sm:col-span-2">
            <button type="submit" class="w-full bg-brand-dark hover:bg-gray-800 text-white font-bold py-2 rounded-xl text-xs transition shadow-sm">
                Filtrar
            </button>
        </div>

    </form>
</div>

<!-- Grilla de Tiendas Locales -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    @forelse($stores as $store)
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between space-y-4">
            <div>
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center text-brand-green text-2xl font-bold flex-shrink-0">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-gray-900 text-sm truncate">{{ $store->store_name }}</h3>
                        <span class="inline-block bg-gray-100 text-gray-600 text-[10px] px-2.5 py-0.5 rounded-full font-semibold mt-1">
                            {{ $store->category->name ?? 'Comercio Local' }}
                        </span>
                    </div>
                </div>

                <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">
                    {{ $store->description ?? 'Comercio local comprometido con ofrecer productos y servicios de alta calidad en el municipio.' }}
                </p>
            </div>

            <div class="border-t border-gray-100 pt-3 flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg">
                    <i class="fa-solid fa-circle-check mr-1"></i> Verificado
                </span>

                <a href="{{ route('stores.show', $store->id) }}" class="text-xs font-bold text-brand-green hover:underline flex items-center gap-1">
                    Ver tienda <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white p-12 rounded-2xl border text-center">
            <i class="fa-solid fa-store-slash text-5xl text-gray-300 mb-3"></i>
            <h3 class="text-base font-bold text-gray-700">No se encontraron tiendas</h3>
            <p class="text-xs text-gray-500 mt-1">Prueba con otro término de búsqueda o categoría.</p>
        </div>
    @endforelse
</div>

<!-- Paginación -->
<div>
    {{ $stores->appends(request()->query())->links() }}
</div>
@endsection