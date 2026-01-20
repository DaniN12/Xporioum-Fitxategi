<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/profesor', function () {
    return view('profesor.dashboard');
});

Route::get('/alumno', function () {
    return view('alumno.dashboard');
});

Route::get('/alumnos/create', function () {
    return view('alumnos.create');
});
