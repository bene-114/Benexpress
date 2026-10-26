@extends('layouts.app')

@section('content')
<!-- Migas de pan -->
<nav class="text-xs text-gray-500 mb-6 flex items-center gap-2">
    <a href="{{ route('home') }}" class="hover:text-brand-green"><i class="fa-solid fa-house"></i> Inicio</a>
    <span>&gt;</span>
    <span class="font-bold text-gray-800">Panel de Administración</span>
</nav>

<div class="mb-8">
    <h1 class="text-2xl font-black text-gray-900 mb-1">Panel de Control Administrador</h1>
    <p class="text-xs text-gray-500">Gestión global de categorías, aprobación de comercios y métricas de Benexpress.</p>
</div>

<!-- TARJETAS DE MÉTRICAS GENERALES -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
        <p class="text-xs font-semibold text-gray-500">Usuarios Totales</p>
        <p class="text-2xl font-black text-brand-dark mt-1">{{ $totalUsers }}</p>
    </div>
    <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
        <p class="text-xs font-semibold text-gray-500">Tiendas Aprobadas</p>
        <p class="text-2xl font-black text-brand-green mt-1">{{ $totalVendors }}</p>
    </div>
    <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
        <p class="text-xs font-semibold text-gray-500">Productos en Catálogo</p>
        <p class="text-2xl font-black text-brand-orange mt-1">{{ $totalProducts }}</p>
    </div>
    <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
        <p class="text-xs font-semibold text-gray-500">Pedidos Procesados</p>
        <p class="text-2xl font-black text-blue-600 mt-1">{{ $totalOrders }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    <!-- SECCIÓN 1: GESTIÓN DE CATEGORÍAS -->
    <div class="lg:col-span-6 space-y-6">
        
        <!-- Formulario para Nueva Categoría -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-folder-plus text-brand-orange"></i> Crear Nueva Categoría
            </h2>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nombre de la Categoría</label>
                    <input type="text" name="name" required placeholder="Ej. Abarrotes, Artesanías, Ropa..." 
                           class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tipo de Categoría</label>
                    <select name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-brand-green">
                        <option value="producto">Categoría de Producto</option>
                        <option value="tienda">Categoría de Tienda / Comercio</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-brand-dark hover:bg-gray-800 text-white font-bold py-2.5 rounded-xl text-xs transition shadow-sm">
                    Guardar Categoría
                </button>
            </form>
        </div>

        <!-- Listado de Categorías Existentes -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h2 class="text-base font-bold text-gray-900 mb-4">Categorías Registradas</h2>
            <div class="divide-y divide-gray-100 max-h-60 overflow-y-auto pr-1">
                @forelse($categories as $cat)
                    <div class="py-2.5 flex items-center justify-between text-xs">
                        <div>
                            <span class="font-bold text-gray-800">{{ $cat->name }}</span>
                            <span class="ml-2 text-[10px] px-2 py-0.5 rounded-full font-semibold {{ $cat->type === 'producto' ? 'bg-blue-50 text-blue-700' : 'bg-orange-50 text-brand-orange' }}">
                                {{ ucfirst($cat->type) }}
                            </span>
                        </div>
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Deseas borrar esta categoría?')" class="text-red-500 hover:text-red-700 p-1">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 py-4 text-center">No hay categorías configuradas.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- SECCIÓN 2: SOLICITUDES DE PROVEEDORES PENDIENTES -->
    <div class="lg:col-span-6 space-y-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-store text-brand-green"></i> Solicitudes de Proveedores Pendientes
            </h2>

            <div class="space-y-4">
                @forelse($pendingVendors as $vendor)
                    <div class="p-4 border border-gray-200 rounded-xl bg-gray-50 flex flex-col justify-between space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">{{ $vendor->store_name }}</h3>
                            <p class="text-xs text-gray-600 mt-1">{{ $vendor->description ?? 'Sin descripción proporcionada.' }}</p>
                            <p class="text-[10px] text-gray-400 mt-1">CLABE: {{ $vendor->clabe }}</p>
                        </div>

                        <div class="flex items-center gap-2 pt-2 border-t border-gray-200">
                            <!-- Aprobar -->
                            <form action="{{ route('admin.vendors.status', $vendor->id) }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="status" value="aprobado">
                                <button type="submit" class="w-full bg-brand-green hover:bg-emerald-800 text-white font-bold py-1.5 rounded-lg text-xs transition">
                                    <i class="fa-solid fa-check mr-1"></i> Aprobar
                                </button>
                            </form>

                            <!-- Rechazar -->
                            <form action="{{ route('admin.vendors.status', $vendor->id) }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="status" value="rechazado">
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-1.5 rounded-lg text-xs transition">
                                    <i class="fa-solid fa-xmark mr-1"></i> Rechazar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400 text-xs">
                        <i class="fa-solid fa-circle-check text-3xl mb-2 text-emerald-400"></i>
                        <p>No hay solicitudes pendientes de revisión.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection