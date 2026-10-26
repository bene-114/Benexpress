@extends('layouts.app')

@section('content')
<!-- Migas de pan (Breadcrumbs) -->
<nav class="text-xs text-gray-500 mb-6 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-brand-green"><i class="fa-solid fa-house"></i> Inicio</a>
    <span>&gt;</span>
    <a href="{{ route('catalog.index') }}" class="hover:text-brand-green">Productos</a>
    <span>&gt;</span>
    <span class="font-bold text-gray-800 truncate max-w-xs">{{ $product->name }}</span>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">

    <!-- COLUMNA IZQUIERDA: GALERÍA DE IMÁGENES (Wireframe Detalle) -->
    <div class="lg:col-span-5">
        <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm relative mb-4">
            <!-- Botón Favorito -->
            <button class="absolute top-6 right-6 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md text-gray-400 hover:text-red-500 transition z-10">
                <i class="fa-regular fa-heart text-lg"></i>
            </button>

            <!-- Imagen Principal -->
            <div class="h-80 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden">
                @if($product->main_image)
                    <img id="main-product-img" src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <i class="fa-solid fa-image text-6xl text-gray-300"></i>
                @endif
            </div>
        </div>

        <!-- Miniaturas inferiores -->
        <div class="grid grid-cols-4 gap-3">
            <button onclick="changeImage('{{ asset('storage/' . $product->main_image) }}')" class="h-20 bg-gray-100 rounded-lg border-2 border-brand-green overflow-hidden flex items-center justify-center">
                @if($product->main_image)
                    <img src="{{ asset('storage/' . $product->main_image) }}" class="w-full h-full object-cover">
                @else
                    <i class="fa-solid fa-image text-xl text-gray-400"></i>
                @endif
            </button>

            @forelse($product->images as $img)
                <button onclick="changeImage('{{ asset('storage/' . $img->image_path) }}')" class="h-20 bg-gray-100 rounded-lg border border-gray-200 overflow-hidden flex items-center justify-center hover:border-brand-green">
                    <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                </button>
            @empty
                @for($i = 0; $i < 3; $i++)
                    <div class="h-20 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                        <i class="fa-solid fa-image text-gray-300"></i>
                    </div>
                @endfor
            @endforelse
        </div>
    </div>

    <!-- COLUMNA CENTRAL: INFORMACIÓN Y DESCRIPCIÓN -->
    <div class="lg:col-span-4">
        <h1 class="text-2xl font-black text-gray-900 mb-2">{{ $product->name }}</h1>

        <!-- Enlace a la Tienda -->
        <a href="#" class="inline-flex items-center gap-1.5 text-xs text-brand-green font-bold hover:underline mb-3">
            <i class="fa-solid fa-store"></i> Tienda: {{ $product->vendor->store_name ?? 'Comercio Local' }} &gt;
        </a>

        <!-- Calificación -->
        <div class="flex items-center gap-2 mb-4">
            <div class="flex items-center text-amber-400 text-xs">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star-half-stroke"></i>
            </div>
            <span class="text-xs text-gray-500 font-medium">(12 opiniones)</span>
        </div>

        <!-- Precio -->
        <div class="mb-6">
            <span class="text-3xl font-extrabold text-brand-dark">${{ number_format($product->price, 2) }}</span>
            <span class="text-xs text-gray-400 font-normal">pieza</span>
        </div>

        <!-- Descripción -->
        <div class="mb-6">
            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Descripción</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                {{ $product->description ?? 'Aquí va la descripción del producto. Puedes incluir sus características, materiales, medidas, colores disponibles y cualquier otra información relevante para el cliente.' }}
            </p>
        </div>

        <!-- Características -->
        <div>
            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Características</h3>
            <ul class="text-xs text-gray-600 space-y-1.5 list-disc list-inside">
                @forelse($product->characteristics as $spec)
                    <li>{{ $spec->spec_text }}</li>
                @empty
                    <li>Característica 1</li>
                    <li>Característica 2</li>
                    <li>Característica 3</li>
                    <li>Característica 4</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- COLUMNA DERECHA: ACCIONES DE COMPRA Y DISPONIBILIDAD -->
    <div class="lg:col-span-3">
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm space-y-5">
            
            <!-- Stock Disponible -->
            <div class="flex items-center gap-3 p-3 bg-emerald-50 text-emerald-800 rounded-xl border border-emerald-100">
                <i class="fa-solid fa-boxes-stacked text-xl text-brand-green"></i>
                <div>
                    <span class="block text-[10px] uppercase font-bold text-gray-500">Stock disponible</span>
                    <span class="text-xs font-bold text-brand-green">{{ $product->stock ?? 15 }} piezas</span>
                </div>
            </div>

            <!-- Selector de Cantidad -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Cantidad</label>
                <div class="flex items-center border border-gray-300 rounded-lg w-fit overflow-hidden">
                    <button type="button" onclick="adjustQty(-1)" class="px-3 py-1 bg-gray-100 text-gray-600 hover:bg-gray-200 font-bold">-</button>
                    <input type="number" id="qty" value="1" min="1" max="{{ $product->stock ?? 15 }}" readonly class="w-12 text-center text-xs font-bold focus:outline-none">
                    <button type="button" onclick="adjustQty(1)" class="px-3 py-1 bg-gray-100 text-gray-600 hover:bg-gray-200 font-bold">+</button>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="space-y-2 pt-2">
                
                <a href="#" id="buy-now-btn" onclick="goToCheckout(event)" class="w-full bg-brand-dark hover:bg-gray-800 text-white font-bold py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-2 shadow">
                    <i class="fa-solid fa-bag-shopping"></i> Comprar ahora
                </a>

                <script>
                    function goToCheckout(e) {
                        e.preventDefault();
                        const qty = document.getElementById('qty').value;
                        window.location.href = "{{ route('checkout', $product->id) }}?quantity=" + qty;
                    }
                </script>
                
               <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" id="form-qty" value="1">
                <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-cart-shopping text-brand-green"></i> Añadir al carrito
                </button>
                </form>

            <script>
                // Actualizar el input oculto del formulario cuando cambie el selector de cantidad
                document.getElementById('qty').addEventListener('change', function() {
                    document.getElementById('form-qty').value = this.value;
                });
                // También asegúrate de actualizarlo dentro de la función adjustQty si ya la tienes:
                // document.getElementById('form-qty').value = current;
            </script>
               
                <button type="button" class="w-full border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-2">
                    <i class="fa-regular fa-heart text-red-500"></i> Guardar en favoritos
                </button>
            </div>

            <hr class="border-gray-200">

            <!-- Información de Entrega -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Información de entrega</h4>
                
                <div class="flex items-start gap-2 text-xs">
                    <i class="fa-solid fa-store text-brand-green mt-0.5"></i>
                    <div>
                        <span class="font-bold text-gray-800 block">Disponible en local</span>
                        <span class="text-gray-500 text-[11px]">Sí, en esta tienda</span>
                    </div>
                </div>

                <div class="flex items-start gap-2 text-xs">
                    <i class="fa-solid fa-truck text-brand-orange mt-0.5"></i>
                    <div>
                        <span class="font-bold text-gray-800 block">Entrega a domicilio</span>
                        <span class="text-gray-500 text-[11px]">Puede ser (depende del proveedor)</span>
                    </div>
                </div>
            </div>

            <hr class="border-gray-200">

            <!-- Vendedor -->
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase block">Vendido por</span>
                    <span class="text-xs font-bold text-gray-800">{{ $product->vendor->store_name ?? 'Nombre de la tienda' }}</span>
                </div>
                <a href="#" class="px-3 py-1.5 border border-gray-300 text-xs font-bold text-gray-700 rounded-lg hover:bg-gray-100 transition">
                    Ver tienda
                </a>
            </div>

        </div>
    </div>

</div>

<!-- SECCIÓN DE PRODUCTOS RELACIONADOS -->
<div class="border-t border-gray-200 pt-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-900">Productos relacionados</h2>
        <a href="{{ route('catalog.index') }}" class="text-xs font-semibold text-brand-green hover:underline">Ver todos &gt;</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($relatedProducts as $rel)
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition relative flex flex-col justify-between">
                <div>
                    <button class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow text-gray-400 hover:text-red-500">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                    <div class="h-44 bg-gray-100 flex items-center justify-center">
                        <i class="fa-solid fa-image text-4xl text-gray-300"></i>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-1">{{ $rel->name }}</h3>
                        <p class="text-xs text-gray-500 mb-2">${{ number_format($rel->price, 2) }}</p>
                        <p class="text-[11px] text-gray-400">Tienda: {{ $rel->vendor->store_name ?? 'Comercio Local' }}</p>
                    </div>
                </div>
                <div class="p-4 pt-0">
                    <a href="{{ route('catalog.show', $rel->id) }}" class="w-full bg-gray-100 hover:bg-brand-green hover:text-white text-gray-700 text-xs font-bold py-2 rounded-lg transition block text-center">
                        Ver detalle
                    </a>
                </div>
            </div>
        @empty
            <p class="text-xs text-gray-400 col-span-4 text-center py-4">No hay productos relacionados por el momento.</p>
        @endforelse
    </div>
</div>

<script>
    function changeImage(src) {
        document.getElementById('main-product-img').src = src;
    }

    function adjustQty(delta) {
        const qtyInput = document.getElementById('qty');
        let current = parseInt(qtyInput.value) || 1;
        let min = parseInt(qtyInput.min) || 1;
        let max = parseInt(qtyInput.max) || 15;

        current += delta;
        if (current < min) current = min;
        if (current > max) current = max;

        qtyInput.value = current;
    }
</script>
@endsection