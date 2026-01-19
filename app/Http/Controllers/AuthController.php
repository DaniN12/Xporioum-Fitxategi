<?php

use App\Http\Controllers\AuthController;

// Ruta de Login (Pública)
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// RUTAS PROTEGIDAS (Solo usuarios logueados)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    Route::get('/incidencias/crear', function () { return view('incidencias.create'); })->name('incidencias.create');

    Route::get('/normas', function () { return view('normas.index'); })->name('normas.index');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
