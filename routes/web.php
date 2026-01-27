<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FichajeController;
use App\Http\Controllers\ProfesorController;

Route::get('/', function () {
    return view('preloader');
});

// LOGIN
Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// =====================
// ALUMNO
// =====================
Route::get('/fichar', [FichajeController::class, 'vistaFichar'])->name('fichar.vista');

// QR (ENTRADA)
Route::get('/fichar/qr', [FichajeController::class, 'vistaEscanearQR'])->name('fichar.qr');
Route::post('/fichar/qr/validar', [FichajeController::class, 'validarQR'])->name('fichar.qr.validar');

// DESCANSO / RETOMAR / SALIDA
Route::post('/fichar/descanso', [FichajeController::class, 'iniciarDescanso'])->name('fichar.descanso');
Route::post('/fichar/retomar', [FichajeController::class, 'retomarTurno'])->name('fichar.retomar');
Route::post('/salida', [FichajeController::class, 'ficharSalida'])->name('fichar.salida');


// =====================
// PROFESOR
// =====================
Route::get('/profesor', [ProfesorController::class, 'dashboard'])->name('profesor.dashboard');

// QR profesor (dinámico)
Route::get('/profesor/qr', [ProfesorController::class, 'vistaQR'])->name('profesor.qr');
Route::post('/profesor/qr/generar', [ProfesorController::class, 'generarQR'])->name('profesor.qr.generar');

// Alta alumnos
Route::get('/profesor/alumnos', [ProfesorController::class, 'alumnos'])->name('profesor.alumnos');
Route::post('/profesor/alumnos', [ProfesorController::class, 'crearAlumno'])->name('profesor.alumnos.crear');

// Fichajes de hoy
Route::get('/profesor/fichajes', [ProfesorController::class, 'fichajesHoy'])->name('profesor.fichajes.hoy');
