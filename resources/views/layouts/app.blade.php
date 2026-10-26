<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BENEXPRESS - Comercio y Entrega Local</title>
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#006837">

    <!-- Tailwind CSS CDN (Ideal para prototipado rápido en Laravel) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            green: '#006837',
                            orange: '#FF6600',
                            dark: '#1E293B',
                            light: '#F8FAFC'
                        }
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-brand-light text-brand-dark flex flex-col min-h-screen">

    <!-- ENCABEZADO / NAVBAR PRINCIPAL (Wireframe General) -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <!-- Barra Superior con Buscador -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-4">
            
            <!-- Logo BENEXPRESS -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-black text-brand-green tracking-tight">
                <i class="fa-solid fa-cart-shopping text-brand-orange"></i>
                BEN<span class="text-brand-orange">EXPRESS</span>
            </a>

            <!-- Buscador Global -->
            <form action="{{ route('catalog.index') }}" method="GET" class="flex-1 max-w-xl flex">
                <input type="text" name="search" placeholder="Buscar productos, tiendas o categorías..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:border-brand-green text-sm">
                <button type="submit" class="bg-brand-green text-white px-5 rounded-r-lg hover:bg-emerald-800 transition">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <!-- Menú de Usuario y Carrito -->
            <div class="flex items-center gap-4">
                <!-- Dropdown Categorías -->
                <a href="{{ route('catalog.index') }}" class="hidden md:flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg text-sm font-medium">
                    <i class="fa-solid fa-tag text-brand-orange"></i>
                    Categorías
                </a>

                <!-- Carrito con Badge -->
               <a href="{{ route('cart.index') }}" class="relative flex items-center gap-1 text-gray-700 hover:text-brand-green">
                <i class="fa-solid fa-cart-shopping text-xl"></i>
                <span class="text-xs font-bold hidden md:inline">Carrito</span>
                @auth
                    @php
                        $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-brand-orange text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                @endauth
                </a>

                @auth
                    @if(Auth::user()->role === 'proveedor')
                        <a href="{{ route('vendor.dashboard') }}" class="text-xs font-bold text-brand-green hover:underline bg-emerald-50 px-3 py-1.5 rounded-lg transition">
                            <i class="fa-solid fa-store mr-1"></i> Mi Negocio
                        </a>
                    @endif
                   
                @endauth

            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-white bg-brand-dark px-3 py-1.5 rounded-lg hover:bg-gray-800 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-user-shield"></i> Panel Admin
                    </a>
                @endif
            @endauth
         <!-- Autenticación / Acceso Dinámico -->
@auth
    <div class="flex items-center gap-3">
        <!-- Botón directo a Mis compras -->
        <a href="{{ route('orders.index') }}" class="text-xs font-bold text-gray-700 hover:text-brand-green bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition flex items-center gap-1.5">
            <i class="fa-solid fa-bag-shopping text-brand-green"></i> Mis compras
        </a>

        <span class="text-sm font-semibold text-gray-700 hidden sm:inline">
            <i class="fa-solid fa-user-circle text-brand-green mr-1"></i> {{ Auth::user()->name }}
        </span>

        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-xs text-red-600 font-bold hover:underline bg-red-50 px-2.5 py-1.5 rounded-lg">
                Salir
            </button>
        </form>
    </div>
@else
    <a href="{{ route('login') }}" class="text-sm font-medium hover:text-brand-green hidden sm:inline">Iniciar sesión</a>
    <a href="{{ route('register') }}" class="bg-brand-green text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-emerald-800 transition">Registrarse</a>
@endauth
            </div>
        </div>

        <!-- Menú de Navegación Inferior -->
        <nav class="border-t border-gray-200 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex gap-6 text-sm font-medium overflow-x-auto py-2">
                <a href="{{ route('home') }}" class="text-brand-green border-b-2 border-brand-green pb-1">Inicio</a>
                <a href="{{ route('catalog.index') }}" class="text-gray-600 hover:text-brand-green pb-1">Productos</a>
                <a href="{{route('stores.index')}}" class="hover:text-brand-green transition">Tiendas</a>
                <a href="#" class="text-gray-600 hover:text-brand-green pb-1">Ofertas</a>
                <a href="{{ route('about') }}" class="hover:text-brand-green transition">Nosotros</a>
                <a href="{{ route('contact') }}" class="hover:text-brand-green transition">Contacto</a>
            </div>
        </nav>
    </header>

 <!-- CONTENIDO DINÁMICO DE LAS VISTAS -->
<main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Alertas Flash / Mensajes de Bienvenida o Éxito -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-brand-green text-emerald-800 rounded-r-lg shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-brand-green text-lg"></i>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold text-sm">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    @yield('content')
</main>
    <!-- PIE DE PÁGINA -->
    <footer class="bg-brand-dark text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} BENEXPRESS - Plataforma Digital de Comercio y Entrega Local.</p>
            <p class="mt-1">Benemérito de las Américas, Chiapas.</p>
        </div>
    </footer>

    <!-- Service Worker PWA -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('PWA Service Worker Activo'))
                    .catch(err => console.log('Error PWA:', err));
            });
        }
    </script>
</body>
</html>