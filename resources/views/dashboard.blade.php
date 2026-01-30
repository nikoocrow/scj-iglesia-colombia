@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="h-full flex flex-col space-y-4">
    <!-- Welcome Message - Más compacto -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            ¡Bienvenido, {{ Auth::user()->name }}! 👋
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Panel de administración del sistema de gestión de la iglesia
        </p>
    </div>

    <!-- Stats Cards - Más compactas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Estudiantes Card -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-green-600 dark:text-green-400">
                    @php
                    $promocionesActivas = \App\Models\Promocion::where('activa', true)->count();
                    @endphp
                    {{ $promocionesActivas }} {{ $promocionesActivas == 1 ? 'promoción' : 'promociones' }}
                </span>
            </div>
            <h3 class="text-gray-600 dark:text-gray-400 text-xs font-medium mb-1">Total Estudiantes</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                @php
                $totalEstudiantes = \App\Models\Estudiante::count();
                @endphp
                {{ $totalEstudiantes }}
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                @php
                $estudiantesEsteMes = \App\Models\Estudiante::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();
                @endphp
                <span class="text-green-600 dark:text-green-400 font-medium">{{ $estudiantesEsteMes }}</span> nuevos
                este mes
            </p>
        </div>

        <!-- Eventos Card -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-green-600 dark:text-green-400">+0%</span>
            </div>
            <h3 class="text-gray-600 dark:text-gray-400 text-xs font-medium mb-1">Eventos</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                <span class="text-green-600 dark:text-green-400 font-medium">0</span> próximos
            </p>
        </div>

        <!-- Ministerios Card -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-green-600 dark:text-green-400">+0%</span>
            </div>
            <h3 class="text-gray-600 dark:text-gray-400 text-xs font-medium mb-1">Ministerios Activos</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                <span class="text-purple-600 dark:text-purple-400 font-medium">0</span> miembros totales
            </p>
        </div>
    </div>

    <!-- Quick Actions & Activity - Lado a lado, más compactos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 flex-1">
        <!-- Quick Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-3">Acciones Rápidas</h3>
            <div class="space-y-2">
                <a href="#"
                    class="flex items-center p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg mr-3">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Agregar Nuevo Miembro</span>
                </a>

                <a href="#"
                    class="flex items-center p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                    <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg mr-3">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Crear Nuevo Evento</span>
                </a>

                <a href="#"
                    class="flex items-center p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg mr-3">
                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Registrar Asistencia</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-3">Actividad Reciente</h3>
            <div class="flex items-center justify-center h-32">
                <div class="text-center">
                    <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-lg inline-block mb-2">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        No hay actividad reciente
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection