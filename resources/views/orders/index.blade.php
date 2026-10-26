@extends('layouts.app')

@section('content')
<!-- Migas de pan -->
<nav class="text-xs text-gray-500 mb-6 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-brand-green"><i class="fa-solid fa-house"></i> Inicio</a>
    <span>&gt;</span>
    <span class="font-bold text-gray-800">Mis compras</span>
</nav>

<div class="grid grid-cols-1 md:grid-cols-12 gap-8">

    <!-- Menú Lateral de Perfil -->
    <div class="md:col-span-3">
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm text-center">
            <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center text-brand-green text-2xl font-bold mx-auto mb-3">
                <i class="fa-solid fa-user"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-sm">{{ Auth::user()->name }}</h3>
            <p class="text-xs text-gray-500 mb-4">{{ Auth::user()->email }}</p>

            <nav class="space-y-1 text-left text-xs font-medium">
                <a href="{{ route('orders.index') }}" class="flex items-center gap-2 px-3 py-2 bg-emerald-50 text-brand-green rounded-lg font-bold">
                    <i class="fa-solid fa-bag-shopping"></i> Mis compras
                </a>
                <a href="#" class="flex items-center gap-2 px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                    <i class="fa-solid fa-bell"></i> Notificaciones
                </a>
                <a href="#" class="flex items-center gap-2 px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                    <i class="fa-solid fa-user-gear"></i> Mis datos
                </a>
            </nav>
        </div>
    </div>

    <!-- Contenido Principal: Mis Compras (Wireframe Seguimiento) -->
    <div class="md:col-span-9 space-y-6">

        <h1 class="text-2xl font-black text-gray-900">Mis compras</h1>
        <p class="text-xs text-gray-500 -mt-4">Aquí puedes ver el estado de tus pedidos.</p>

        @forelse($orders as $order)
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden p-6 space-y-4">
                
                <!-- Encabezado del Pedido -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-3 text-xs">
                    <div>
                        <span class="font-extrabold text-gray-900 text-sm">Pedido #{{ $order->order_code }}</span>
                        <span class="text-gray-400 mx-2">|</span>
                        <span class="text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                        <span class="text-gray-400 mx-2">|</span>
                        <span class="text-gray-600 font-semibold">Tienda: {{ $order->vendor->store_name ?? 'Comercio Local' }}</span>
                    </div>
                    <div class="text-right">
                        <span class="font-black text-sm text-brand-dark">Total: ${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                <!-- Detalle de Ítems del Pedido -->
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 text-xs">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center border overflow-hidden">
                            @if($item->product && $item->product->main_image)
                                <img src="{{ asset('storage/' . $item->product->main_image) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-image text-gray-300"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800">{{ $item->product->name ?? 'Producto' }}</h4>
                            <p class="text-gray-500">{{ $item->quantity }} piezas | ${{ number_format($item->unit_price, 2) }} c/u</p>
                        </div>
                    </div>
                @endforeach

                <!-- Línea de Seguimiento del Pedido -->
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div class="grid grid-cols-4 text-center text-[10px] font-bold text-gray-500 relative">
                        
                        <div class="space-y-1">
                            <div class="w-6 h-6 bg-brand-green text-white rounded-full flex items-center justify-center mx-auto text-xs">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <span class="block text-brand-green font-bold">Pedido confirmado</span>
                        </div>

                        <div class="space-y-1">
                            <div class="w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center mx-auto text-xs">
                                <i class="fa-solid fa-box"></i>
                            </div>
                            <span>En preparación</span>
                        </div>

                        <div class="space-y-1">
                            <div class="w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center mx-auto text-xs">
                                <i class="fa-solid fa-truck"></i>
                            </div>
                            <span>En ruta</span>
                        </div>

                        <div class="space-y-1">
                            <div class="w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center mx-auto text-xs">
                                <i class="fa-solid fa-house"></i>
                            </div>
                            <span>Entregado</span>
                        </div>

                    </div>
                </div>

            </div>
        @empty
            <div class="bg-white p-12 rounded-2xl border text-center">
                <i class="fa-solid fa-bag-shopping text-5xl text-gray-300 mb-3"></i>
                <h3 class="text-base font-bold text-gray-700">Aún no tienes compras realizadas</h3>
                <p class="text-xs text-gray-500 mt-1">Explora nuestro catálogo y apoya a los negocios locales.</p>
            </div>
        @endforelse

    </div>

</div>
@endsection