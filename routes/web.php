<?php
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\NormaController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

// Esta es la ruta que te falta y causa el error rojo
Route::post('/incidencias', [IncidenciaController::class, 'store'])->name('incidencias.store');


// Asegúrate de tener también la de mostrar el formulario
Route::get('/incidencias', function () {
    return view('incidencias.create');
})->name('incidencias.create');

use Illuminate\Support\Facades\Artisan;

Route::get('/setup-storage', function () {
    Artisan::call('storage:link');
    return "Enlace de almacenamiento creado correctamente";
});
Route::get('/normas', [NormaController::class, 'index'])->name('normas.index');

Route::get('/fichaje', function () {
    return view('fichaje.index');
})->name('fichaje.index');

// Horas
Route::get('/horas', function () {
    return view('horas.index');
})->name('horas.index');

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Perfil
Route::get('/perfil', function () {
    return view('perfil.index');
})->name('perfil.index');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

?>
