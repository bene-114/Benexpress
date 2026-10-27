@extends('layouts.app')

@section('content')
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden max-w-5xl mx-auto my-8">
    <div class="grid grid-cols-1 md:grid-cols-2">
        
        <!-- Columna Izquierda: Identidad y Beneficios (Estilo Wireframe) -->
        <div class="bg-gray-50 p-8 flex flex-col justify-center border-r border-gray-200">
            <div class="w-20 h-20 bg-emerald-100 rounded-2xl flex items-center justify-center text-brand-green mb-6 mx-auto md:mx-0">
                <i class="fa-solid fa-cart-shopping text-3xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900 mb-2 text-center md:text-left">Bienvenido a BENEXPRESS</h2>
            <p class="text-gray-600 text-sm mb-6 text-center md:text-left">Compra y vende en tu comunidad de forma fácil y segura.</p>
            
            <div class="space-y-4 text-sm text-gray-700">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-location-dot text-brand-green w-5"></i>
                    <span>Productos locales</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-store text-brand-green w-5"></i>
                    <span>Apoya a negocios de nuestro municipio</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-truck-fast text-brand-green w-5"></i>
                    <span>Entrega a domicilio</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-shield-halved text-brand-green w-5"></i>
                    <span>Compras seguras</span>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Formulario de Inicio de Sesión -->
        <div class="p-8 md:p-12 flex flex-col justify-center">
            <h1 class="text-2xl font-bold text-gray-900 mb-1">Iniciar sesión</h1>
            <p class="text-xs text-gray-500 mb-6">Ingresa a tu cuenta para continuar en BENEXPRESS.</p>

          <!-- Cambiar la etiqueta form por esta: -->
<form action="{{ route('login.process') }}" method="POST">
    @csrf

    <!-- Mostrar errores de validación si las credenciales fallan -->
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 text-xs rounded-lg">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="mb-4">
        <label class="block text-xs font-bold text-gray-700 mb-1">Correo electrónico</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fa-regular fa-envelope"></i>
            </span>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="ejemplo@correo.com" required
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-brand-green">
        </div>
    </div>

    <div class="mb-2">
        <label class="block text-xs font-bold text-gray-700 mb-1">Contraseña</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fa-solid fa-lock"></i>
            </span>
            <input type="password" name="password" placeholder="Ingresa tu contraseña" required
                   class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-brand-green">
        </div>
    </div>

    <div class="flex items-center justify-between mb-6 mt-3">
        <label class="flex items-center text-xs text-gray-600">
            <input type="checkbox" name="remember" class="rounded border-gray-300 text-brand-green focus:ring-brand-green mr-2">
            Recordarme
        </label>
        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">¿Olvidaste tu contraseña?</a>
    </div>

    <button type="submit" class="w-full bg-brand-dark hover:bg-gray-800 text-white font-bold py-2.5 rounded-lg text-sm transition mb-6 shadow">
        Iniciar sesión
    </button>

    <p class="text-center text-xs text-gray-600">
        ¿No tienes una cuenta? <a href="{{ route('register') }}" class="font-bold text-brand-green hover:underline">Regístrate aquí</a>
    </p>
</form>
        </div>

    </div>
</div>
@endsection