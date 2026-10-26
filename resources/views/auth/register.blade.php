@extends('layouts.app')

@section('content')
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden max-w-5xl mx-auto my-8">
    <div class="grid grid-cols-1 md:grid-cols-12">
        
        <!-- Columna Izquierda: Mensaje Dinámico -->
        <div class="md:col-span-5 bg-gray-50 p-8 flex flex-col justify-center border-r border-gray-200">
            <div class="w-20 h-20 bg-emerald-100 rounded-2xl flex items-center justify-center text-brand-green mb-6 mx-auto md:mx-0">
                <i id="banner-icon" class="fa-solid fa-user-plus text-3xl"></i>
            </div>
            
            <h2 id="banner-title" class="text-2xl font-extrabold text-gray-900 mb-2 text-center md:text-left">Únete a BENEXPRESS</h2>
            <p id="banner-subtitle" class="text-gray-600 text-sm mb-6 text-center md:text-left">Crea tu cuenta y comienza a comprar en tu comunidad de forma fácil y segura.</p>
            
            <div class="space-y-4 text-sm text-gray-700">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-check text-brand-green w-5"></i>
                    <span id="feat-1">Crea tu cuenta en pocos minutos</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-bag-shopping text-brand-green w-5"></i>
                    <span id="feat-2">Compra o vende a más clientes</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-truck text-brand-green w-5"></i>
                    <span>Entrega local en tu domicilio</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-shield text-brand-green w-5"></i>
                    <span>Plataforma segura</span>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Formulario de Registro con Tabs -->
        <div class="md:col-span-7 p-8 md:p-10">
            <h1 class="text-2xl font-bold text-gray-900 mb-1">Crear cuenta</h1>
            <p class="text-xs text-gray-500 mb-6">Regístrate para comprar o vender en BENEXPRESS.</p>

            <!-- TAB SWITCHER: Cliente vs Proveedor (Ventanas 3 y 4) -->
            <div class="grid grid-cols-2 gap-2 bg-gray-100 p-1 rounded-xl mb-6">
                <button type="button" id="tab-cliente" onclick="setRole('cliente')" class="py-2 text-xs font-bold rounded-lg transition bg-white text-gray-800 shadow-sm">
                    <i class="fa-solid fa-user mr-1"></i> Cliente
                </button>
                <button type="button" id="tab-proveedor" onclick="setRole('proveedor')" class="py-2 text-xs font-bold rounded-lg transition text-gray-500 hover:text-gray-800">
                    <i class="fa-solid fa-store mr-1"></i> Proveedor
                </button>
            </div>

            <form action="{{ route('register.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="role" id="role_input" value="cliente">

                <!-- 1. Información Personal -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nombre completo</label>
                        <input type="text" name="name" placeholder="Ingresa tu nombre completo" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-brand-green">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Correo electrónico</label>
                        <input type="email" name="email" placeholder="ejemplo@correo.com" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-brand-green">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Teléfono</label>
                        <input type="tel" name="phone" placeholder="Ingresa tu teléfono" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-brand-green">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Contraseña</label>
                        <input type="password" name="password" placeholder="Crea una contraseña" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-brand-green">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" placeholder="Confirma contraseña" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-brand-green">
                    </div>
                </div>

                <!-- Carga de Identificación Oficial (INE) -->
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Identificación oficial (INE)</label>
                    <p class="text-[11px] text-gray-500 mb-2">Sube una foto o escanea tu INE para verificar tu identidad.</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="border-2 border-dashed border-gray-300 rounded-xl p-3 text-center cursor-pointer hover:border-brand-green transition flex flex-col items-center justify-center">
                            <i class="fa-solid fa-image text-brand-green text-xl mb-1"></i>
                            <span class="text-xs font-bold text-gray-700">Subir imagen</span>
                            <span class="text-[10px] text-gray-400">JPG o PNG (máx. 5 MB)</span>
                            <input type="file" name="ine_image" accept="image/*" class="hidden">
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-3 text-center opacity-60 flex flex-col items-center justify-center">
                            <i class="fa-solid fa-camera text-gray-500 text-xl mb-1"></i>
                            <span class="text-xs font-bold text-gray-700">Tomar foto del INE</span>
                            <span class="text-[10px] text-gray-400">Usa la cámara del dispositivo</span>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN PROVEEDOR (Desplegable dinámicamente - Ventana 4) -->
                <div id="vendor-section" class="hidden border-t border-gray-200 pt-4 mb-6">
                    <h3 class="text-sm font-bold text-brand-green mb-3">Información de tu negocio</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Nombre de la tienda o negocio</label>
                            <input type="text" name="store_name" placeholder="Ej. Creaciones Hernández"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-brand-green">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Categoría principal</label>
                            <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-brand-green">
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Descripción de tu negocio (opcional)</label>
                        <textarea name="description" rows="2" placeholder="Cuéntanos brevemente sobre tu negocio, tus productos y lo que me ofreces..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-brand-green"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Clave interbancaria (CLABE)</label>
                        <input type="text" name="clabe" placeholder="Ingresa la CLABE de 18 dígitos" maxlength="18"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-brand-green">
                    </div>
                </div>

                <!-- Botón de Envío Dinámico -->
                <button type="submit" id="submit-btn" class="w-full bg-brand-dark hover:bg-gray-800 text-white font-bold py-3 rounded-lg text-sm transition shadow mb-4">
                    Crear cuenta
                </button>

                <p class="text-center text-xs text-gray-600">
                    ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="font-bold text-brand-green hover:underline">Iniciar sesión</a>
                </p>
            </form>
        </div>

    </div>
</div>

<!-- Lógica JS para cambiar entre Cliente y Proveedor -->
<script>
    function setRole(role) {
        document.getElementById('role_input').value = role;
        
        const tabCliente = document.getElementById('tab-cliente');
        const tabProveedor = document.getElementById('tab-proveedor');
        const vendorSection = document.getElementById('vendor-section');
        const submitBtn = document.getElementById('submit-btn');

        const bannerTitle = document.getElementById('banner-title');
        const bannerSubtitle = document.getElementById('banner-subtitle');

        if (role === 'proveedor') {
            tabProveedor.className = "py-2 text-xs font-bold rounded-lg transition bg-brand-dark text-white shadow-sm";
            tabCliente.className = "py-2 text-xs font-bold rounded-lg transition text-gray-500 hover:text-gray-800";
            vendorSection.classList.remove('hidden');
            submitBtn.textContent = "Crear cuenta de proveedor";

            bannerTitle.textContent = "Sé proveedor en BENEXPRESS";
            bannerSubtitle.textContent = "Vende tus productos en tu comunidad y llega a más clientes.";
        } else {
            tabCliente.className = "py-2 text-xs font-bold rounded-lg transition bg-white text-gray-800 shadow-sm";
            tabProveedor.className = "py-2 text-xs font-bold rounded-lg transition text-gray-500 hover:text-gray-800";
            vendorSection.classList.add('hidden');
            submitBtn.textContent = "Crear cuenta";

            bannerTitle.textContent = "Únete a BENEXPRESS";
            bannerSubtitle.textContent = "Crea tu cuenta y comienza a comprar en tu comunidad de forma fácil y segura.";
        }
    }
</script>
@endsection