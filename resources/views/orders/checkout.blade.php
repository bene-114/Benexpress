@extends('layouts.app')

@section('content')
<!-- Migas de pan -->
<nav class="text-xs text-gray-500 mb-6 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-brand-green"><i class="fa-solid fa-house"></i> Inicio</a>
    <span>&gt;</span>
    <a href="{{ route('catalog.index') }}" class="hover:text-brand-green">Productos</a>
    <span>&gt;</span>
    <a href="{{ route('catalog.show', $product->id) }}" class="hover:text-brand-green">{{ $product->name }}</a>
    <span>&gt;</span>
    <span class="font-bold text-gray-800">Comprar</span>
</nav>

<h1 class="text-2xl font-black text-gray-900 mb-1">Comprar producto</h1>
<p class="text-xs text-gray-500 mb-6">Completa la información para realizar tu compra.</p>

<form action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- COLUMNA IZQUIERDA: OP CIONES DE ENTREGA Y PAGO (Ventanas 7 y 8) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- 1. Producto Seleccionado -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-2 text-xs font-bold text-gray-700 uppercase tracking-wider mb-4">
                    <span class="w-6 h-6 bg-brand-dark text-white rounded-full flex items-center justify-center text-xs">1</span>
                    <span>Producto seleccionado</span>
                </div>

                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden border">
                            @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-image text-gray-300 text-2xl"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm">{{ $product->name }}</h3>
                            <p class="text-xs text-gray-500">Tienda: {{ $product->vendor->store_name ?? 'Comercio Local' }}</p>
                            <p class="text-sm font-extrabold text-brand-dark mt-1">${{ number_format($product->price, 2) }} <span class="text-[10px] text-gray-400 font-normal">pieza</span></p>
                        </div>
                    </div>

                    <div class="text-right">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Cantidad</label>
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                            <button type="button" onclick="updateCheckoutQty(-1)" class="px-2.5 py-1 bg-gray-100 text-gray-600 font-bold text-xs hover:bg-gray-200">-</button>
                            <input type="number" id="checkout-qty" name="quantity" value="{{ $quantity }}" min="1" max="{{ $product->stock ?? 15 }}" readonly class="w-10 text-center text-xs font-bold focus:outline-none">
                            <button type="button" onclick="updateCheckoutQty(1)" class="px-2.5 py-1 bg-gray-100 text-gray-600 font-bold text-xs hover:bg-gray-200">+</button>
                        </div>
                        <span class="text-[10px] text-gray-400 mt-1 block">Stock: {{ $product->stock ?? 15 }} piezas</span>
                    </div>
                </div>
            </div>

            <!-- 2. Método de Entrega -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-2 text-xs font-bold text-gray-700 uppercase tracking-wider mb-4">
                    <span class="w-6 h-6 bg-brand-dark text-white rounded-full flex items-center justify-center text-xs">2</span>
                    <span>Método de entrega</span>
                </div>

                <div class="space-y-3">
                    <!-- Opción: Recoger en Local -->
                    <label class="border-2 rounded-xl p-4 flex items-start gap-3 cursor-pointer transition border-gray-200 hover:border-brand-green" id="label-recoleccion">
                        <input type="radio" name="delivery_type" value="recoleccion" checked onclick="toggleDelivery('recoleccion')" class="mt-1 text-brand-green focus:ring-brand-green">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-store text-brand-green"></i>
                                <span class="font-bold text-xs text-gray-800">Recoger en el local</span>
                            </div>
                            <p class="text-[11px] text-gray-500 mt-0.5">Pasaré a recoger mi pedido en la tienda.</p>
                        </div>
                    </label>

                    <!-- Opción: Entrega a Domicilio -->
                    <label class="border-2 rounded-xl p-4 flex flex-col gap-3 cursor-pointer transition border-gray-200 hover:border-brand-green" id="label-domicilio">
                        <div class="flex items-start gap-3">
                            <input type="radio" name="delivery_type" value="domicilio" onclick="toggleDelivery('domicilio')" class="mt-1 text-brand-green focus:ring-brand-green">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-truck text-brand-orange"></i>
                                    <span class="font-bold text-xs text-gray-800">Entrega a domicilio</span>
                                </div>
                                <p class="text-[11px] text-gray-500 mt-0.5">Quiero recibir mi pedido en mi domicilio.</p>
                            </div>
                        </div>

                        <!-- Campos desplegables para Domicilio (Ventana 8) -->
                        <div id="fields-domicilio" class="hidden border-t border-gray-100 pt-3 space-y-3 mt-1">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 mb-1">Dirección de entrega</label>
                                <div class="relative">
                                    <i class="fa-solid fa-location-dot absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                                    <input type="text" name="delivery_address" placeholder="Av. Principal No. 123, Barrio Centro, Benemérito de las Américas, Chiapas" class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg text-xs focus:outline-none focus:border-brand-green">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1">Referencia (opcional)</label>
                                    <input type="text" name="delivery_reference" placeholder="Ej. Casa color azul, a un lado de la tienda..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:outline-none focus:border-brand-green">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1">Teléfono de contacto</label>
                                    <div class="relative">
                                        <i class="fa-solid fa-phone absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                                        <input type="tel" name="delivery_phone" placeholder="961 123 4567" class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg text-xs focus:outline-none focus:border-brand-green">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-blue-50 p-2.5 rounded-lg flex items-center justify-between text-xs text-blue-900 font-medium">
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-truck text-brand-orange"></i> Costo de entrega (según el proveedor)</span>
                                <span class="font-bold" id="display-shipping">$100.00</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- 3. Método de pago -->
<div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
    <div class="flex items-center gap-2 text-xs font-bold text-gray-700 uppercase tracking-wider mb-4">
        <span class="w-6 h-6 bg-brand-dark text-white rounded-full flex items-center justify-center text-xs">3</span>
        <span>Método de pago</span>
    </div>

    <div class="space-y-3">
        <!-- Opción: Efectivo -->
        <label class="border rounded-xl p-3.5 flex items-center gap-3 cursor-pointer hover:bg-gray-50 transition border-gray-200">
            <input type="radio" name="payment_method" value="efectivo" checked onclick="togglePayment('efectivo')" class="text-brand-green focus:ring-brand-green">
            <i class="fa-solid fa-money-bill-wave text-emerald-600 text-base"></i>
            <div>
                <span class="font-bold text-xs text-gray-800 block">Efectivo</span>
                <span class="text-[11px] text-gray-500">Pagaré en efectivo al recibir mi pedido.</span>
            </div>
        </label>

        <!-- Opción: Transferencia Bancaria (Con CLABE dinámica del proveedor) -->
        <label class="border rounded-xl p-3.5 flex flex-col gap-3 cursor-pointer hover:bg-gray-50 transition border-gray-200" id="label-transferencia">
            <div class="flex items-center gap-3">
                <input type="radio" name="payment_method" value="transferencia" onclick="togglePayment('transferencia')" class="text-brand-green focus:ring-brand-green">
                <i class="fa-solid fa-building-columns text-blue-600 text-base"></i>
                <div>
                    <span class="font-bold text-xs text-gray-800 block">Transferencia bancaria</span>
                    <span class="text-[11px] text-gray-500">Realizaré el pago por transferencia.</span>
                </div>
            </div>

            <!-- Caja de datos bancarios (Se muestra al seleccionar transferencia) -->
            <div id="fields-transferencia" class="hidden bg-blue-50 border border-blue-200 rounded-xl p-4 text-xs text-blue-900 space-y-2 mt-2">
                <p class="font-bold flex items-center gap-1 text-blue-900">
                    <i class="fa-solid fa-circle-info text-blue-600"></i> Datos para realizar tu pago:
                </p>
                <p class="text-gray-700">Tienda: <span class="font-bold text-gray-900">{{ $product->vendor->store_name ?? 'Comercio Local' }}</span></p>
                <p class="text-gray-700">CLABE Interbancaria (18 dígitos):</p>
                <div class="bg-white px-3 py-2 rounded-lg border border-blue-300 font-mono font-bold text-sm tracking-widest text-brand-dark select-all text-center">
                    {{ $product->vendor->clabe ?? '000000000000000000' }}
                </div>
                <p class="text-[11px] text-blue-800 font-medium italic mt-1">
                    <i class="fa-solid fa-clock mr-1"></i> Tu pedido se procesará y preparará en cuanto el proveedor confirme la recepción de tu pago.
                </p>
            </div>
        </label>
    </div>
</div>

        </div>

        <!-- COLUMNA DERECHA: RESUMEN DEL PEDIDO -->
        <div class="lg:col-span-5">
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm sticky top-24 space-y-4">
                <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3">Resumen de compra</h2>

                <!-- Ítem en resumen -->
                <div class="flex gap-3 items-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden border">
                        @if($product->main_image)
                            <img src="{{ asset('storage/' . $product->main_image) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-image text-gray-300"></i>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-xs text-gray-800 truncate">{{ $product->name }}</h4>
                        <p class="text-[11px] text-gray-500 truncate">Tienda: {{ $product->vendor->store_name ?? 'Comercio Local' }}</p>
                    </div>
                    <span class="font-bold text-xs text-gray-800">${{ number_format($product->price, 2) }}</span>
                </div>

                <hr class="border-gray-100">

                <div class="space-y-2 text-xs text-gray-600">
                    <div class="flex justify-between">
                        <span>Cantidad</span>
                        <span id="summary-qty" class="font-bold text-gray-800">{{ $quantity }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span id="summary-subtotal" class="font-bold text-gray-800">${{ number_format($product->price * $quantity, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Costo de entrega</span>
                        <span id="summary-shipping" class="font-bold text-gray-800">$0.00</span>
                    </div>
                </div>

                <div class="bg-emerald-50 p-3 rounded-xl flex items-center justify-between text-brand-dark">
                    <span class="text-xs font-bold">Total a pagar</span>
                    <span id="summary-total" class="text-xl font-black text-brand-green">${{ number_format($product->price * $quantity, 2) }}</span>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-700 mb-1">Notas (opcional)</label>
                    <textarea name="notes" rows="2" placeholder="Ej. Indicaciones para la entrega, referencias, etc." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:outline-none focus:border-brand-green"></textarea>
                </div>

                <button type="submit" class="w-full bg-brand-dark hover:bg-gray-800 text-white font-bold py-3 rounded-xl text-xs transition flex items-center justify-center gap-2 shadow">
                    <i class="fa-solid fa-cart-shopping"></i> Confirmar compra
                </button>

                <a href="{{ route('catalog.show', $product->id) }}" class="block text-center text-xs font-bold text-gray-500 hover:underline">
                    &larr; Volver
                </a>
            </div>
        </div>

    </div>
</form>

<script>
    const unitPrice = {{ $product->price }};

    function updateCheckoutQty(delta) {
        const qtyInput = document.getElementById('checkout-qty');
        let current = parseInt(qtyInput.value) || 1;
        let min = parseInt(qtyInput.min) || 1;
        let max = parseInt(qtyInput.max) || 15;

        current += delta;
        if (current < min) current = min;
        if (current > max) current = max;

        qtyInput.value = current;
        recalculateTotals();
    }

    function toggleDelivery(type) {
        const fields = document.getElementById('fields-domicilio');
        const labelReco = document.getElementById('label-recoleccion');
        const labelDomi = document.getElementById('label-domicilio');

        if (type === 'domicilio') {
            fields.classList.remove('hidden');
            labelDomi.classList.add('border-brand-green', 'bg-emerald-50/20');
            labelReco.classList.remove('border-brand-green', 'bg-emerald-50/20');
        } else {
            fields.classList.add('hidden');
            labelReco.classList.add('border-brand-green', 'bg-emerald-50/20');
            labelDomi.classList.remove('border-brand-green', 'bg-emerald-50/20');
        }
        recalculateTotals();
    }

    function recalculateTotals() {
        const qty = parseInt(document.getElementById('checkout-qty').value) || 1;
        const isDomicilio = document.querySelector('input[name="delivery_type"]:checked').value === 'domicilio';
        const shipping = isDomicilio ? 100.00 : 0.00;
        const subtotal = unitPrice * qty;
        const total = subtotal + shipping;

        document.getElementById('summary-qty').textContent = qty;
        document.getElementById('summary-subtotal').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('summary-shipping').textContent = '$' + shipping.toFixed(2);
        document.getElementById('summary-total').textContent = '$' + total.toFixed(2);
    }

    function togglePayment(method) {
        const transferFields = document.getElementById('fields-transferencia');
        const labelTransfer = document.getElementById('label-transferencia');

        if (method === 'transferencia') {
            transferFields.classList.remove('hidden');
            labelTransfer.classList.add('border-brand-green', 'bg-blue-50/20');
        } else {
            transferFields.classList.add('hidden');
            labelTransfer.classList.remove('border-brand-green', 'bg-blue-50/20');
        }
    }
</script>
@endsection