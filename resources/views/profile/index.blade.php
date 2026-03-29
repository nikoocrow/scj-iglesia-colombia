@extends('layouts.app')
@section('page-title', __('messages.configuration'))

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4 space-y-8">

    {{-- Foto de Perfil --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="px-8 py-5 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('messages.profile_photo') }}</h2>
        </div>
        <div class="px-8 py-6">
            <div class="flex flex-col items-center gap-5">
                {{-- Avatar --}}
                <div style="width:128px;height:128px;border-radius:50%;overflow:hidden;background:#2563eb;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:white;font-weight:700;font-size:2.5rem;">
                    @if($user->avatar)
                        <img src="{{ asset('avatars/' . $user->avatar) }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>

                {{-- Upload --}}
                <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf
                    @if(session('success_avatar'))
                        <p class="text-green-600 dark:text-green-400 text-sm mb-3 text-center">{{ session('success_avatar') }}</p>
                    @endif
                    @error('avatar')
                        <p class="text-red-500 text-sm mb-3 text-center">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 text-center">JPG, PNG o WEBP · Máximo 2MB</p>
                    <div class="flex items-center justify-center gap-3">
                        <input type="file" name="avatar" accept="image/*"
                            class="text-sm text-gray-500 dark:text-gray-400
                                   file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                   file:text-sm file:font-medium
                                   file:bg-gray-100 dark:file:bg-gray-700
                                   file:text-gray-700 dark:file:text-gray-300
                                   file:cursor-pointer hover:file:bg-gray-200 dark:hover:file:bg-gray-600">
                        <button type="submit"
                            class="shrink-0 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition-colors">
                            {{ __('messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Información de la cuenta --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="px-8 py-5 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('messages.account_info') }}</h2>
        </div>
        <div class="px-8 py-6 space-y-5 text-sm text-gray-700 dark:text-gray-300">
            <div class="flex justify-between items-center pb-4 border-b border-gray-100 dark:border-gray-700">
                <span class="font-medium text-gray-500 dark:text-gray-400">{{ __('messages.name') }}</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-medium text-gray-500 dark:text-gray-400">{{ __('messages.email') }}</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $user->email }}</span>
            </div>
        </div>
    </div>

    {{-- Cambiar Contraseña --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="px-8 py-5 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('messages.change_password') }}</h2>
        </div>
        <div class="px-8 py-6">

            @if(session('success_password'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-600 dark:text-green-400 px-4 py-3 rounded-lg text-sm">
                    {{ session('success_password') }}
                </div>
            @endif

            <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
                @csrf @method('PUT')

                <div style="display:flex;flex-direction:column;gap:8px;">
                    <label style="display:block;font-size:0.875rem;font-weight:500;color:#6b7280;">
                        {{ __('messages.current_password') }}
                    </label>
                    <input type="password" name="current_password"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 @error('current_password') border-red-500 @enderror">
                    @error('current_password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:flex;flex-direction:column;gap:8px;">
                    <label style="display:block;font-size:0.875rem;font-weight:500;color:#6b7280;">
                        {{ __('messages.new_password') }}
                    </label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:flex;flex-direction:column;gap:8px;">
                    <label style="display:block;font-size:0.875rem;font-weight:500;color:#6b7280;">
                        {{ __('messages.confirm_new_password') }}
                    </label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                <div style="padding-top:8px;">
                    <button type="submit"
                        class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors">
                        {{ __('messages.update_password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
