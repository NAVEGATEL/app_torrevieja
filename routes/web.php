<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EmailTemplateController; // Nuevo controlador
use App\Http\Controllers\PublicController;
use App\Http\Controllers\FileUploadController;
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


Route::get('/consentA', function () {
    return view('consents.consentA');
})->name('consentA');

Route::get('/consentT', function () {
    return view('consents.consentT');
})->name('consentT');

Route::post('/upload-pdf', [FileUploadController::class, 'store']);

// Grupo de rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Ruta para el panel principal (dashboard)
    Route::get('/panel', [HomeController::class, 'index'])->name('panel');

    // Grupo de rutas protegidas con middleware adicional (opcional)
    Route::group(['middleware' => 'adminOrBasic'], function () {
        Route::get('/storage/uploads/{filename}', function ($filename) {
            $path = storage_path('app/uploads/' . $filename);
        
            if (!file_exists($path)) {
                abort(404);
            }
        
            $mimeType = mime_content_type($path);
            return response()->file($path, [
                'Content-Type' => $mimeType,
            ]);
        })->name('storage.files');

        // ##########################################################################################
        // Ruta para gestionar usuarios
        Route::get('/panel/users', [HomeController::class, 'users'])->name('users.index'); 
        // Ruta para realizar acciones en usuarios
        Route::post('/panel/user-actions', [HomeController::class, 'userActions'])->name('userActions');

        
        // ##########################################################################################
        // Ruta para ver y filtrar correos
        Route::get('/panel/emails', [HomeController::class, 'emails'])->name('emails.index');
        // Ruta para enviar correos 
        Route::post('/panel/send', [HomeController::class, 'send'])->name('send'); 
        
        
        // ##########################################################################################
        // Rutas para gestionar plantillas de correos
        Route::prefix('panel/email-templates')->name('emailTemplates.')->group(function () {
            Route::get('/', [EmailTemplateController::class, 'index'])->name('index'); // Listar plantillas
            Route::post('/', [EmailTemplateController::class, 'store'])->name('store'); // Crear plantilla
            Route::delete('/{id}/logic-delete', [EmailTemplateController::class, 'logicDelete'])->name('emailTemplates.logicDelete'); // Eliminar lógica
            
        });
    });
});

// Logout personalizado
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
