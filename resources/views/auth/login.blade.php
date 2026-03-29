@extends('layouts.guest')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">

        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/logo.webp') }}" alt="Logo" class="w-20 h-20">
            </div>

            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ config('app.name', 'Iglesia') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('messages.management_system') }}
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8">

            <h3 class="text-2xl font-bold text-center mb-6 text-gray-900 dark:text-white">
                {{ __('messages.login') }}
            </h3>

            {{-- Errores --}}
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

            {{-- Status --}}
            @if (session('status'))
            <div
                class="mb-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-600 dark:text-green-400 px-4 py-3 rounded-lg text-sm">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                        <label>{{ __('messages.email') }}</label>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-800 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                        <label>{{ __('messages.password') }}</label>
                    </label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-800 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <input type="checkbox" name="remember" class="mr-2">
                        {{ __('messages.remember') }}
                    </label>

                    <a href="{{ route('password.request') }}" class="text-sm text-primary-600">
                        {{ __('messages.forgot_password') }}
                    </a>
                </div>

                <button type="submit"
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-lg">
                    {{ __('messages.login') }}
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                {{ __('messages.no_account') }}
                <a href="{{ route('register') }}" class="text-primary-600 font-semibold">
                    {{ __('messages.register_here') }}
                </a>
            </div>
        </div>

        <div class="mt-6 text-center text-sm text-gray-500">
            © {{ date('Y') }} {{ config('app.name') }}. {{ __('messages.all_rights') }}.
        </div>
    </div>
</div>
@endsection