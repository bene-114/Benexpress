@extends('layouts.app')

@section('content')
<!-- Migas de pan -->
<nav class="text-xs text-gray-500 mb-6 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-brand-green"><i class="fa-solid fa-house"></i> Inicio</a>
    <span>&gt;</span>
    <span class="font-bold text-gray-800">Contacto</span>
</nav>

<div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-8 mb-12">

    <!-- INFORMACIÓN DE CONTACTO Y MAPA -->
    <div class="md:col-span-5 space-y-6">
        <div>
            <h1 class="text-2xl font-black text-gray-900 mb-2">Ponte en contacto</h1>
            <p class="text-xs text-gray-600 leading-relaxed">
                ¿Tienes dudas, sugerencias o deseas afiliar tu negocio a Benexpress? Estamos aquí para ayudarte.
            </p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 space-y-4 text-xs shadow-sm">
            <div class="flex items-start gap-3">
               
                
            </div>

            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center text-brand-orange flex-shrink-0">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-800">Correo Electrónico</p>
                    <p class="text-gray-500">soporte@benexpress.com</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 flex-shrink-0">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-800">Teléfono / WhatsApp</p>
                    <p class="text-gray-500">+52 (961) 123-4567</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 flex-shrink-0">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-800">Horario de Atención</p>
                    <p class="text-gray-500">Lunes a Sábado: 8:00 AM - 7:00 PM</p>
                </div>
            </div>
        </div>

        <!-- GOOGLE MAPS EMBED -->
        <div class="bg-white border border-gray-200 rounded-2xl p-3 shadow-sm">
            <p class="text-xs font-bold text-gray-800 mb-2 px-1 flex items-center gap-1.5">
                <i class="fa-solid fa-map-location-dot text-brand-green"></i> Encuéntranos en el municipio
            </p>
            <div class="rounded-xl overflow-hidden border border-gray-200 h-48 w-full">
                <iframe 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d516.2806556460074!2d-90.65951618849103!3d16.51515878217103!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x858b2b5c6aef3955%3A0xbc9990648bea169e!2sSoluciones%20Vazquez!5e0!3m2!1ses-419!2smx!4v1792994771774!5m2!1ses-419!2smx" ">
                </iframe>
            </div>
        </div>
    </div>

    <!-- FORMULARIO DE MENSAJE -->
    <div class="md:col-span-7">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Envíanos un mensaje</h2>

            <form action="#" method="POST" onsubmit="alert('¡Gracias por tu mensaje! Nos pondremos en contacto contigo a la brevedad.'); return false;" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nombre completo</label>
                    <input type="text" required placeholder="Tu nombre" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Correo electrónico</label>
                        <input type="email" required placeholder="correo@ejemplo.com" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Teléfono</label>
                        <input type="tel" placeholder="961 000 0000" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Asunto</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green">
                        <option>Dudas generales</option>
                        <option>Quiero registrar mi tienda / negocio</option>
                        <option>Soporte con un pedido</option>
                        <option>Sugerencias</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Mensaje</label>
                    <textarea rows="4" required placeholder="Escribe tu mensaje aquí..." class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green"></textarea>
                </div>

                <button type="submit" class="w-full bg-brand-green hover:bg-emerald-800 text-white font-bold py-3 rounded-xl text-xs transition shadow-sm">
                    Enviar mensaje
                </button>
            </form>
        </div>
    </div>

</div>
@endsection

