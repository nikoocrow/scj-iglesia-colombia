<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ruta principal
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación (solo para invitados)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    // Registro
    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    // Recuperar contraseña
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Restablecer contraseña
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Rutas protegidas (solo para usuarios autenticados)
Route::middleware('auth')->group(function () {

    // Perfil / Configuración
    Route::get('/configuracion', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/configuracion/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/configuracion/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');


    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Logout
    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');

    // Rutas de Promociones
    Route::resource('promociones', PromocionController::class);

    // Rutas de Estudiantes (anidadas en promociones)
    Route::post('promociones/{promocion}/estudiantes', [EstudianteController::class, 'store'])->name('estudiantes.store');
    Route::put('promociones/{promocion}/estudiantes/{estudiante}', [EstudianteController::class, 'update'])->name('estudiantes.update');
    Route::delete('promociones/{promocion}/estudiantes/{estudiante}', [EstudianteController::class, 'destroy'])->name('estudiantes.destroy');
    // Importar CSV
    Route::post('promociones/{promocion}/importar-csv', [EstudianteController::class, 'importarCsv'])->name('estudiantes.importar-csv');
    // Exportar Excel
    Route::get('promociones/{promocion}/exportar-excel', [EstudianteController::class, 'exportarExcel'])->name('estudiantes.exportar-excel');
});

// Cambio de idioma
Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['es', 'ko'])) {
        abort(400);
    }

    session()->put('locale', $locale);

    return redirect()->back();
})->name('lang.switch');