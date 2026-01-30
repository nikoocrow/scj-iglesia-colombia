@extends('layouts.app')

@section('title', 'Promociones')
@section('page-title', 'Promociones')

@section('content')
<div class="space-y-4">
    <!-- Header con botón crear -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Promociones</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Administra las promociones de estudiantes</p>
        </div>
        <a href="{{ route('promociones.create') }}"
            class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold rounded-lg transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Nueva Promoción
        </a>
    </div>

    <!-- Mensajes de éxito -->
    @if(session('success'))
    <div
        class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-600 dark:text-green-400 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Lista de promociones -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($promociones as $promocion)
        <a href="{{ route('promociones.show', $promocion) }}"
            class="block bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all hover:border-primary-500 dark:hover:border-primary-500">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                        Promoción {{ $promocion->nombre }}
                    </h3>
                    @if($promocion->año)
                    <p class="text-sm text-gray-500 dark:text-gray-400">Año {{ $promocion->año }}</p>
                    @endif
                </div>
                <span
                    class="px-2 py-1 text-xs font-semibold rounded-full {{ $promocion->activa ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400' }}">
                    {{ $promocion->activa ? 'Activa' : 'Inactiva' }}
                </span>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">{{ $promocion->estudiantes_count }} estudiantes</span>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>
        @empty
        <div class="col-span-3 text-center py-12">
            <div class="inline-block p-4 bg-gray-100 dark:bg-gray-800 rounded-full mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No hay promociones</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-4">Comienza creando tu primera promoción</p>
            <a href="{{ route('promociones.create') }}"
                class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors">
                Crear Promoción
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection