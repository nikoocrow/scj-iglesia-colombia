@extends('layouts.app')

@section('title', 'Promoción ' . $promocion->nombre)
@section('page-title', 'Promoción ' . $promocion->nombre)

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('promociones.index') }}"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.promotion') }} {{ $promocion->nombre }}</h2>
                @if($promocion->activa)
                <span
                    class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">{{ __('messages.active') }}</span>
                @endif
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $estudiantes->count() }} {{ __('messages.students_registered') }}
            </p>
        </div>

        <!-- Botones en el header -->
        <div class="flex space-x-3">
            <!-- Botón Exportar CSV -->
            <a href="{{ route('estudiantes.exportar-excel', $promocion) }}"
                class="inline-flex items-center px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
                {{ __('messages.export_excel') }}
            </a>

            <!-- Botón Importar CSV -->
            <label for="csvFile"
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-white font-semibold rounded-lg transition-colors cursor-pointer">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                    </path>
                </svg>
                {{ __('messages.import_csv') }}
            </label>
            <form id="csvForm" action="/promociones/{{ $promocion->id }}/importar-csv" method="POST"
                enctype="multipart/form-data" class="hidden">
                @csrf
                <input type="file" name="csv_file" id="csvFile" accept=".csv"
                    onchange="document.getElementById('csvForm').submit()">
            </form>

            <!-- Botón para abrir modal -->
            <button id="openModalBtn"
                class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                {{ __('messages.add_student') }}
            </button>
        </div>
    </div>

    <!-- Mensajes -->
    @if(session('success'))
    <div
        class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-600 dark:text-green-400 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Tabla de estudiantes -->
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white shrink-0">{{ __('messages.student_list') }}</h3>
            <div class="flex items-center gap-3 ml-auto">
                <!-- Búsqueda -->
                <div class="relative w-56">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                    </div>
                    <input type="text" id="searchInput" placeholder="{{ __('messages.search_student') }}"
                        oninput="applyFilters()"
                        class="w-full pl-9 pr-4 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <!-- Por página -->
                <select id="perPageSelect" onchange="applyFilters()"
                    class="py-2 pl-3 pr-8 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="150">150</option>
                </select>
            </div>
        </div>

        @if($estudiantes->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        @php
                            $cols = [__('messages.name'), __('messages.who_invited'), __('messages.relation'), __('messages.evangelist'), __('messages.age'), __('messages.nationality')];
                        @endphp
                        @foreach($cols as $i => $col)
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <button onclick="sortTable({{ $i }})" id="sort-btn-{{ $i }}"
                                class="flex items-center gap-2 hover:text-gray-900 dark:hover:text-white transition-colors group">
                                {{ $col }}
                                <span id="sort-icon-{{ $i }}" class="flex flex-col items-center opacity-30 group-hover:opacity-70 transition-opacity">
                                    <!-- chevron-up-down (idle) -->
                                    <svg id="sort-svg-idle-{{ $i }}" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 9l4-4 4 4M16 15l-4 4-4-4"/>
                                    </svg>
                                    <!-- A→Z (asc, hidden by default) -->
                                    <span id="sort-label-asc-{{ $i }}" class="hidden text-[9px] font-bold leading-none text-blue-500">A→Z</span>
                                    <!-- Z→A (desc, hidden by default) -->
                                    <span id="sort-label-desc-{{ $i }}" class="hidden text-[9px] font-bold leading-none text-blue-500">Z→A</span>
                                </span>
                            </button>
                        </th>
                        @endforeach
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('messages.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($estudiantes as $estudiante)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{
                                $estudiante->translated('nombre_completo') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $estudiante->translated('quien_invito') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $estudiante->translated('relacion_con_quien_invito') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $estudiante->translated('evangelista_encargada') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $estudiante->edad ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $estudiante->translated('nacionalidad') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-3">
                                {{-- Botón Editar --}}
                                <button type="button"
                                    onclick="openEditModal({{ $estudiante->id }}, {{ json_encode($estudiante) }})"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                {{-- Botón Eliminar --}}
                                <form action="/promociones/{{ $promocion->id }}/estudiantes/{{ $estudiante->id }}"
                                    method="POST" onsubmit="return confirm('{{ __('messages.delete') }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg>
            <p class="text-gray-500 dark:text-gray-400">No hay estudiantes registrados</p>
            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Haz clic en "Agregar Estudiante" para comenzar</p>
        </div>
        @endif

        <!-- Paginación -->
        @if($estudiantes->count() > 0)
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <p id="paginationInfo" class="text-sm text-gray-500 dark:text-gray-400"></p>
            <div id="paginationControls" class="flex items-center gap-1"></div>
        </div>
        @endif
    </div>
</div>

<!-- Modal -->
<div id="estudianteModal"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div
            class="sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Agregar Nuevo Estudiante</h3>
            <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <form action="/promociones/{{ $promocion->id }}/estudiantes" method="POST" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Nombre Completo -->
                <div>
                    <label for="nombre_completo"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nombre Completo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre_completo" id="nombre_completo" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Quién Invitó -->
                <div>
                    <label for="quien_invito" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        ¿Quién lo invitó?
                    </label>
                    <input type="text" name="quien_invito" id="quien_invito"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Relación -->
                <div>
                    <label for="relacion_con_quien_invito"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        ¿Cuál es su relación?
                    </label>
                    <input type="text" name="relacion_con_quien_invito" id="relacion_con_quien_invito"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Evangelista Encargada -->
                <div>
                    <label for="evangelista_encargada"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Evangelista Encargada
                    </label>
                    <input type="text" name="evangelista_encargada" id="evangelista_encargada"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Edad -->
                <div>
                    <label for="edad" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Edad
                    </label>
                    <input type="number" name="edad" id="edad" min="0"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Fecha de Nacimiento -->
                <div>
                    <label for="fecha_nacimiento"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Fecha de Nacimiento
                    </label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Nacionalidad -->
                <div>
                    <label for="nacionalidad" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nacionalidad
                    </label>
                    <input type="text" name="nacionalidad" id="nacionalidad"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Conoce Estudiantes -->
                <div class="md:col-span-2">
                    <label for="conoce_estudiantes"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        ¿Conoce a alguno de los estudiantes?
                    </label>
                    <input type="text" name="conoce_estudiantes" id="conoce_estudiantes"
                        placeholder="Nombres de estudiantes que conoce"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="button" id="cancelBtn"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold rounded-lg transition-colors">
                    {{ __('messages.add_student') }}
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Estudiante -->
<div id="editModal"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Editar Estudiante</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="editForm" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nombre Completo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre_completo" id="edit_nombre_completo" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">¿Quién lo invitó?</label>
                    <input type="text" name="quien_invito" id="edit_quien_invito"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">¿Cuál es su relación?</label>
                    <input type="text" name="relacion_con_quien_invito" id="edit_relacion"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Evangelista Encargada</label>
                    <input type="text" name="evangelista_encargada" id="edit_evangelista"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Edad</label>
                    <input type="number" name="edad" id="edit_edad" min="0"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="edit_fecha_nacimiento"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nacionalidad</label>
                    <input type="text" name="nacionalidad" id="edit_nacionalidad"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">¿Conoce a alguno de los estudiantes?</label>
                    <input type="text" name="conoce_estudiantes" id="edit_conoce"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal agregar
    const modal = document.getElementById('estudianteModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

    // Sorting
    let currentCol = -1;
    let currentDir = 'asc';

    function sortTable(colIndex) {
        const table = document.querySelector('tbody');
        const rows = Array.from(table.querySelectorAll('tr'));

        if (currentCol === colIndex) {
            currentDir = currentDir === 'asc' ? 'desc' : 'asc';
        } else {
            currentDir = 'asc';
            currentCol = colIndex;
        }

        // Resetear todos los íconos
        for (let i = 0; i <= 5; i++) {
            document.getElementById(`sort-svg-idle-${i}`)?.classList.remove('hidden');
            document.getElementById(`sort-label-asc-${i}`)?.classList.add('hidden');
            document.getElementById(`sort-label-desc-${i}`)?.classList.add('hidden');
            document.getElementById(`sort-icon-${i}`)?.classList.remove('opacity-100');
            document.getElementById(`sort-icon-${i}`)?.classList.add('opacity-30');
        }

        // Activar ícono de la columna activa
        const idle  = document.getElementById(`sort-svg-idle-${colIndex}`);
        const asc   = document.getElementById(`sort-label-asc-${colIndex}`);
        const desc  = document.getElementById(`sort-label-desc-${colIndex}`);
        const wrap  = document.getElementById(`sort-icon-${colIndex}`);

        idle?.classList.add('hidden');
        wrap?.classList.remove('opacity-30');
        wrap?.classList.add('opacity-100');

        if (currentDir === 'asc') {
            asc?.classList.remove('hidden');
        } else {
            desc?.classList.remove('hidden');
        }

        rows.sort((a, b) => {
            const aText = a.querySelectorAll('td')[colIndex]?.innerText.trim() ?? '';
            const bText = b.querySelectorAll('td')[colIndex]?.innerText.trim() ?? '';

            if (colIndex === 4) {
                const aNum = parseFloat(aText) || 0;
                const bNum = parseFloat(bText) || 0;
                return currentDir === 'asc' ? aNum - bNum : bNum - aNum;
            }

            return currentDir === 'asc'
                ? aText.localeCompare(bText, 'es')
                : bText.localeCompare(aText, 'es');
        });

        rows.forEach(row => table.appendChild(row));
        currentPage = 1;
        renderTable();
    }

    // Modal editar
    const editModal = document.getElementById('editModal');

    function openEditModal(id, estudiante) {
        const promocionId = {{ $promocion->id }};
        document.getElementById('editForm').action = `/promociones/${promocionId}/estudiantes/${id}`;

        document.getElementById('edit_nombre_completo').value  = estudiante.nombre_completo  ?? '';
        document.getElementById('edit_quien_invito').value     = estudiante.quien_invito      ?? '';
        document.getElementById('edit_relacion').value         = estudiante.relacion_con_quien_invito ?? '';
        document.getElementById('edit_evangelista').value      = estudiante.evangelista_encargada     ?? '';
        document.getElementById('edit_edad').value             = estudiante.edad              ?? '';
        document.getElementById('edit_fecha_nacimiento').value = estudiante.fecha_nacimiento  ?? '';
        document.getElementById('edit_nacionalidad').value     = estudiante.nacionalidad      ?? '';
        document.getElementById('edit_conoce').value           = estudiante.conoce_estudiantes ?? '';

        editModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        editModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    editModal.addEventListener('click', (e) => { if (e.target === editModal) closeEditModal(); });

    // Paginación + Búsqueda
    let currentPage = 1;

    function applyFilters() {
        currentPage = 1;
        renderTable();
    }

    function renderTable() {
        const query  = document.getElementById('searchInput')?.value.toLowerCase().trim() ?? '';
        const perPage = parseInt(document.getElementById('perPageSelect')?.value ?? '20');
        const allRows = Array.from(document.querySelectorAll('tbody tr'));

        // Filtrar por búsqueda
        const filtered = allRows.filter(row => row.innerText.toLowerCase().includes(query));

        // Calcular páginas
        const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));
        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * perPage;
        const end   = start + perPage;

        // Mostrar/ocultar filas
        allRows.forEach(row => row.style.display = 'none');
        filtered.forEach((row, i) => {
            row.style.display = (i >= start && i < end) ? '' : 'none';
        });

        // Info
        const info = document.getElementById('paginationInfo');
        if (info) {
            const from = filtered.length === 0 ? 0 : start + 1;
            const to   = Math.min(end, filtered.length);
            info.textContent = `Mostrando ${from}–${to} de ${filtered.length} estudiantes`;
        }

        // Controles de paginación
        const controls = document.getElementById('paginationControls');
        if (controls) {
            controls.innerHTML = '';

            const btnClass = (active) =>
                `px-3 py-1.5 text-sm rounded-lg border transition-colors ${
                    active
                    ? 'bg-primary-600 border-primary-600 text-white font-semibold'
                    : 'border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                }`;

            // Anterior
            const prev = document.createElement('button');
            prev.innerHTML = '&laquo;';
            prev.className = btnClass(false) + (currentPage === 1 ? ' opacity-40 cursor-not-allowed' : '');
            prev.disabled = currentPage === 1;
            prev.onclick = () => { currentPage--; renderTable(); };
            controls.appendChild(prev);

            // Páginas
            for (let p = 1; p <= totalPages; p++) {
                if (totalPages > 7 && p > 2 && p < totalPages - 1 && Math.abs(p - currentPage) > 1) {
                    if (p === 3 || p === totalPages - 2) {
                        const dots = document.createElement('span');
                        dots.textContent = '…';
                        dots.className = 'px-2 text-gray-400';
                        controls.appendChild(dots);
                    }
                    continue;
                }
                const btn = document.createElement('button');
                btn.textContent = p;
                btn.className = btnClass(p === currentPage);
                btn.onclick = ((page) => () => { currentPage = page; renderTable(); })(p);
                controls.appendChild(btn);
            }

            // Siguiente
            const next = document.createElement('button');
            next.innerHTML = '&raquo;';
            next.className = btnClass(false) + (currentPage === totalPages ? ' opacity-40 cursor-not-allowed' : '');
            next.disabled = currentPage === totalPages;
            next.onclick = () => { currentPage++; renderTable(); };
            controls.appendChild(next);
        }
    }

    // Inicializar
    document.addEventListener('DOMContentLoaded', renderTable);
</script>
@endsection