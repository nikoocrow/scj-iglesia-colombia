@extends('layouts.app')

@section('title', 'Promociones')
@section('page-title', 'Promociones')

@section('content')
<div class="space-y-4">
    <!-- Header con botón crear -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.manage_promotions') }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.manage_promotions_desc') }}</p>
        </div>
        <a href="{{ route('promociones.create') }}"
            class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold rounded-lg transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            {{ __('messages.new_promotion') }}
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
        <div class="relative group bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all hover:border-primary-500 dark:hover:border-primary-500">

            <!-- Botón engranaje -->
            <div class="absolute top-3 right-3 z-10">
                <button onclick="toggleMenu({{ $promocion->id }}, event)"
                    class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </button>
                <!-- Dropdown -->
                <div id="menu-{{ $promocion->id }}"
                    class="hidden absolute right-0 mt-1 w-44 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-20">
                    <button onclick="openDeleteModal({{ $promocion->id }}, '{{ addslashes($promocion->nombre) }}')"
                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        {{ __('messages.delete_promotion') }}
                    </button>
                </div>
            </div>

            <!-- Card clickeable -->
            <a href="{{ route('promociones.show', $promocion) }}" class="block p-6">
                <div class="flex items-start justify-between mb-4 pr-6">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                            Promoción {{ $promocion->nombre }}
                        </h3>
                        @if($promocion->año)
                        <p class="text-sm text-gray-500 dark:text-gray-400">Año {{ $promocion->año }}</p>
                        @endif
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $promocion->activa ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400' }}">
                        {{ $promocion->activa ? __('messages.active') : __('messages.inactive') }}
                    </span>
                </div>
                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="text-sm font-medium">{{ $promocion->estudiantes_count }} {{ __('messages.students') }}</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <div class="inline-block p-4 bg-gray-100 dark:bg-gray-800 rounded-full mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">{{ __('messages.no_promotions') }}</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-4">{{ __('messages.start_creating') }}</p>
            <a href="{{ route('promociones.create') }}"
                class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors">
                {{ __('messages.create_promotion') }}
            </a>
        </div>
        @endforelse
    </div>
</div>
<!-- Modal eliminar promoción -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-full">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('messages.delete_promotion') }}</h3>
        </div>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
            {{ __('messages.delete_warning') }} <strong id="deletePromoNombre" class="text-gray-900 dark:text-white"></strong> {{ __('messages.delete_warning2') }}
        </p>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            {{ __('messages.delete_confirm_text') }}
        </p>

        <input type="text" id="deleteConfirmInput" placeholder="Escribe aquí para confirmar..."
            oninput="checkDeleteInput()"
            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-red-500 mb-4">

        <div class="flex justify-end gap-3">
            <button onclick="closeDeleteModal()"
                class="px-4 py-2 text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                {{ __('messages.cancel') }}
            </button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" id="deleteBtn" disabled
                    class="px-4 py-2 text-sm bg-red-600 text-white font-semibold rounded-lg transition-colors opacity-40 cursor-not-allowed"
                    onclick="return document.getElementById('deleteConfirmInput').value === 'ELIMINAR'">
                    {{ __('messages.delete_permanently') }}
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Menú engranaje
    function toggleMenu(id, e) {
        e.preventDefault();
        e.stopPropagation();
        const menu = document.getElementById(`menu-${id}`);
        document.querySelectorAll('[id^="menu-"]').forEach(m => {
            if (m.id !== `menu-${id}`) m.classList.add('hidden');
        });
        menu.classList.toggle('hidden');
    }

    document.addEventListener('click', () => {
        document.querySelectorAll('[id^="menu-"]').forEach(m => m.classList.add('hidden'));
    });

    // Modal eliminar
    let deletePromoId = null;

    function openDeleteModal(id, nombre) {
        deletePromoId = id;
        document.getElementById('deletePromoNombre').textContent = `"Promoción ${nombre}"`;
        document.getElementById('deleteConfirmInput').value = '';
        document.getElementById('deleteForm').action = `/promociones/${id}`;
        checkDeleteInput();
        document.getElementById('deleteModal').classList.remove('hidden');
        document.querySelectorAll('[id^="menu-"]').forEach(m => m.classList.add('hidden'));
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        deletePromoId = null;
    }

    function checkDeleteInput() {
        const val = document.getElementById('deleteConfirmInput').value;
        const btn = document.getElementById('deleteBtn');
        const ok  = val === 'ELIMINAR';
        btn.disabled = !ok;
        btn.classList.toggle('opacity-40', !ok);
        btn.classList.toggle('cursor-not-allowed', !ok);
        btn.classList.toggle('hover:bg-red-700', ok);
    }

    document.getElementById('deleteModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('deleteModal')) closeDeleteModal();
    });
</script>
@endsection