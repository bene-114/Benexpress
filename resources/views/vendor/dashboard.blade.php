@extends('layouts.app')

@section('content')
<!-- Migas de pan -->
<nav class="text-xs text-gray-500 mb-6 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-brand-green"><i class="fa-solid fa-house"></i> Inicio</a>
    <span>&gt;</span>
    <span class="font-bold text-gray-800">Panel de Proveedor</span>
</nav>

<!-- Encabezado del Negocio -->
<div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center text-brand-green text-2xl font-bold">
            <i class="fa-solid fa-store"></i>
        </div>
        <div>
            <h1 class="text-xl font-black text-gray-900">{{ $vendor->store_name }}</h1>
            <p class="text-xs text-gray-500">Estado de la cuenta: <span class="font-bold uppercase text-brand-orange">{{ $vendor->status }}</span></p>
        </div>
    </div>

    <a href="{{ route('vendor.products.create') }}" class="bg-brand-green hover:bg-emerald-800 text-white font-bold text-xs px-5 py-3 rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
        <i class="fa-solid fa-plus"></i> Publicar nuevo producto
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    <!-- TABLA DE PRODUCTOS DEL NEGOCIO -->
    <div class="lg:col-span-8 space-y-4">
        <h2 class="text-lg font-bold text-gray-900">Inventario de productos</h2>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 text-gray-500 uppercase border-b border-gray-200">
                        <tr>
                            <th class="p-4">Producto</th>
                            <th class="p-4">Precio</th>
                            <th class="p-4">Stock</th>
                            <th class="p-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border flex items-center justify-center">
                                        @if($product->main_image)
                                            <img src="{{ asset('storage/' . $product->main_image) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-image text-gray-300"></i>
                                        @endif
                                    </div>
                                    <span class="font-bold text-gray-800 line-clamp-1">{{ $product->name }}</span>
                                </td>
                                <td class="p-4 font-bold text-brand-dark">${{ number_format($product->price, 2) }}</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-full font-bold {{ $product->stock > 5 ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                        {{ $product->stock }} pzas
                                    </span>
                                </td>
                               <td class="p-4 text-right flex items-center justify-end gap-2">
                                    <!-- Botón Editar -->
                                    <a href="{{ route('vendor.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 p-1.5 transition" title="Editar producto">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('vendor.products.destroy', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este producto?')" class="text-red-500 hover:text-red-700 p-1.5 transition" title="Eliminar">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400">
                                    Aún no has registrado productos en tu tienda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- PEDIDOS RECIBIÓ LA TIENDA -->
    <div class="lg:col-span-4 space-y-4">
        <h2 class="text-lg font-bold text-gray-900">Últimos pedidos recibidos</h2>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 space-y-4">
            @forelse($orders as $order)
                <div class="border-b border-gray-100 pb-3 text-xs space-y-1">
                    <div class="flex justify-between font-bold text-gray-800">
                        <span>#{{ $order->order_code }}</span>
                        <span class="text-brand-green">${{ number_format($order->total, 2) }}</span>
                    </div>
                    <p class="text-gray-500">Entrega: <span class="capitalize font-semibold">{{ $order->delivery_type }}</span></p>
                    <p class="text-gray-400 text-[10px]">{{ $order->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-xs text-gray-400 text-center py-6">No hay pedidos registrados todavía.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection