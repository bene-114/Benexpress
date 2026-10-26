@extends('layouts.app')

@section('content')
<nav class="text-xs text-gray-500 mb-6 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-brand-green"><i class="fa-solid fa-house"></i> Inicio</a>
    <span>&gt;</span>
    <a href="{{ route('vendor.dashboard') }}" class="hover:text-brand-green">Panel de Proveedor</a>
    <span>&gt;</span>
    <span class="font-bold text-gray-800">Nuevo producto</span>
</nav>

<div class="max-w-3xl mx-auto bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
    <h1 class="text-2xl font-black text-gray-900 mb-1">Publicar producto</h1>
    <p class="text-xs text-gray-500 mb-6">Completa los detalles, imágenes y características de tu producto.</p>

    <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-xs font-bold text-gray-700 mb-1">Nombre del producto</label>
            <input type="text" name="name" required placeholder="Ej. Gomitas mágicas"
                   class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Categoría</label>
                <select name="category_id" required class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green">
                    <option value="">Selecciona una categoría</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Precio ($ MXN)</label>
                <input type="number" step="0.01" name="price" required placeholder="150.00"
                       class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-xs font-bold text-gray-700 mb-1">Stock (piezas disponibles)</label>
            <input type="number" name="stock" required placeholder="12" min="0"
                   class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green">
        </div>

        <div class="mb-4">
            <label class="block text-xs font-bold text-gray-700 mb-1">Descripción del producto</label>
            <textarea name="description" rows="3" placeholder="Describe los detalles de tu producto..."
                      class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green"></textarea>
        </div>

        <!-- SECCIÓN DE CARACTERÍSTICAS DINÁMICAS -->
        <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-gray-200">
            <label class="block text-xs font-bold text-gray-800 mb-2">Características del producto</label>
            <div id="characteristics-container" class="space-y-2">
                <input type="text" name="characteristics[]" placeholder="Ej. Presentación: Bolsa de 200g" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-xs">
                <input type="text" name="characteristics[]" placeholder="Ej. Sabor: Variado de frutas" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-xs">
            </div>
            <button type="button" onclick="addCharacteristicField()" class="mt-3 text-xs font-bold text-brand-green hover:underline flex items-center gap-1">
                <i class="fa-solid fa-plus-circle"></i> Agregar otra característica
            </button>
        </div>

        <!-- SECCIÓN DE IMÁGENES -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <!-- Imagen Principal -->
    <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Imagen Principal del Producto</label>
            <input type="file" name="main_image" accept="image/*" 
                class="w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-brand-green">
        </div>

        <!-- Imágenes Secundarias / Galería (Permite seleccionar varias fotos a la vez) -->
        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Imágenes Secundarias (Galería)</label>
            <input type="file" name="gallery_images[]" multiple accept="image/*" 
                class="w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700">
            <span class="text-[10px] text-gray-400 block mt-1">Puedes seleccionar varias imágenes dejando presionada la tecla Ctrl/Cmd.</span>
        </div>
    </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="flex-1 bg-brand-dark hover:bg-gray-800 text-white font-bold py-3 rounded-xl text-xs transition shadow">
                Guardar y publicar
            </button>
            <a href="{{ route('vendor.dashboard') }}" class="px-5 py-3 border border-gray-300 text-gray-700 font-bold text-xs rounded-xl hover:bg-gray-50 transition text-center">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    function addCharacteristicField() {
        const container = document.getElementById('characteristics-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'characteristics[]';
        input.placeholder = 'Nueva característica...';
        input.className = 'w-full px-3 py-1.5 border border-gray-300 rounded-lg text-xs mt-2';
        container.appendChild(input);
    }
</script>
@endsection