@extends('layouts.app')

@section('content')
<!-- Migas de pan -->
<nav class="text-xs text-gray-500 mb-6 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-brand-green"><i class="fa-solid fa-house"></i> Inicio</a>
    <span>&gt;</span>
    <span class="font-bold text-gray-800">Nosotros</span>
</nav>

<!-- Encabezado Principal -->
<div class="bg-white border border-gray-200 rounded-3xl p-8 mb-8 shadow-sm text-center max-w-4xl mx-auto">
    <span class="bg-emerald-100 text-brand-green text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Acerca de Benexpress</span>
    <h1 class="text-3xl font-black text-gray-900 mt-3 mb-4">Impulsando el Comercio Local en Benemérito de las Américas</h1>
    <p class="text-gray-600 text-xs sm:text-sm leading-relaxed max-w-2xl mx-auto">
        Somos una plataforma digital concebida para conectar a los productores, artesanos y negocios de nuestra comunidad con los consumidores locales, fortaleciendo la economía regional a través de herramientas tecnológicas accesibles.
    </p>
</div>

<!-- Misión y Visión -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto mb-12">
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
        <div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-brand-green text-xl mb-4">
                <i class="fa-solid fa-bullseye"></i>
            </div>
            <h2 class="text-lg font-extrabold text-gray-900 mb-2">Nuestra Misión</h2>
            <p class="text-xs text-gray-600 leading-relaxed">
                Facilitar el acceso a productos y servicios locales mediante una plataforma digital intuitiva, promoviendo el consumo responsable y apoyando el crecimiento de las pequeñas y medianas empresas de la región.
            </p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
        <div>
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-brand-orange text-xl mb-4">
                <i class="fa-solid fa-eye"></i>
            </div>
            <h2 class="text-lg font-extrabold text-gray-900 mb-2">Nuestra Visión</h2>
            <p class="text-xs text-gray-600 leading-relaxed">
                Convertirnos en el ecosistema digital de comercio y entregas de referencia en la región fronteriza de Chiapas, digitalizando a todos los negocios locales y mejorando la calidad de vida de nuestra comunidad.
            </p>
        </div>
    </div>
</div>

<!-- Valores Corporativos -->
<div class="max-w-4xl mx-auto mb-8">
    <h2 class="text-xl font-bold text-gray-900 text-center mb-6">Nuestros Valores</h2>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-200 text-center">
            <i class="fa-solid fa-handshake text-2xl text-brand-green mb-2"></i>
            <h3 class="font-bold text-xs text-gray-800">Comunidad</h3>
            <p class="text-[11px] text-gray-500 mt-1">Apoyo mutuo e impulso al talento y productos de nuestro municipio.</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200 text-center">
            <i class="fa-solid fa-shield-halved text-2xl text-brand-orange mb-2"></i>
            <h3 class="font-bold text-xs text-gray-800">Confianza</h3>
            <p class="text-[11px] text-gray-500 mt-1">Transacciones transparentes y soporte personalizado en cada compra.</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200 text-center">
            <i class="fa-solid fa-bolt text-2xl text-blue-600 mb-2"></i>
            <h3 class="font-bold text-xs text-gray-800">Innovación</h3>
            <p class="text-[11px] text-gray-500 mt-1">Tecnología PWA moderna al servicio de las necesidades locales.</p>
        </div>
    </div>
</div>
@endsection