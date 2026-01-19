<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HorasUsuarioController;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/horas', [HorasUsuarioController::class, 'index'])->name('horas');

    Route::get('/dashboard', function () {
        return redirect()->route('horas'); // te manda a /horas
    })->name('dashboard');
});

require __DIR__.'/auth.php';
