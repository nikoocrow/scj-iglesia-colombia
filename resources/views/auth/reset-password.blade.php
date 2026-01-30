@extends('layouts.guest')

@section('title', 'Restablecer Contraseña')

@section('content')
<div>
    <h3 class="text-2xl font-bold text-center mb-6 text-gray-900 dark:text-white">
        Restablecer Contraseña
    </h3>

    <!-- Mensajes de error -->
    @if ($errors->any())
    <div
        class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 px-4 py-3 rounded-lg">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                Correo Electrónico
            </label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition-colors duration-200 @error('email') border-red-500 @enderror"
                placeholder="correo@ejemplo.com">
            @error('email')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                Nueva Contraseña
            </label>
            <input id="password" type="password" name="password" required
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition-colors duration-200 @error('password') border-red-500 @enderror"
                placeholder="••••••••">
            @error('password')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Mínimo 8 caracteres</p>
        </div>

        <!-- Password Confirmation -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                Confirmar Contraseña
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition-colors duration-200"
                placeholder="••••••••">
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
            Restablecer Contraseña
        </button>
    </form>
</div>
@endsection