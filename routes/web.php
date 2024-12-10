<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PublicController;

// Ruta de fallback para redirigir a la página principal
Route::fallback(function () {
    return redirect('/');
});

// Autenticación
Auth::routes(["register" => false]); // Registro desactivado

// Ruta para redirigir al panel o al login según el estado de autenticación
Route::get('/', function () {
    return Auth::check() ? redirect()->route('panel') : redirect('/login');
})->name('home');

// Grupo de rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Ruta para el panel principal (dashboard)
    Route::get('/panel', [HomeController::class, 'index'])->name('panel');

    // Grupo de rutas protegidas con middleware adicional (opcional)
    Route::group(['middleware' => 'adminOrBasic'], function () {
        // Ruta para gestionar usuarios
        Route::get('/panel/users', [HomeController::class, 'users'])->name('users.index'); 

        // Ruta para enviar correos 
        Route::get('/panel/emails', [HomeController::class, 'emails'])->name('emails.index');
        Route::post('/panel/send', [HomeController::class, 'send'])->name('send');

        // Ruta para ajustes
        Route::get('/panel/settings', [HomeController::class, 'settings'])->name('settings.index');
        Route::post('/panel/settings', [BookingController::class, 'saveSettings'])->name('settings.save');
    });
});

// Logout personalizado
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
