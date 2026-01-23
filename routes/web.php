<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HorasUsuarioController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| RUTAS CON LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // HORAS
    Route::get('/horas', [HorasUsuarioController::class, 'index'])->name('horas');

    // PERFIL
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'password'])->name('password.update');

    // DASHBOARD
    Route::get('/dashboard', function () {
        return redirect()->route('horas');
    })->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| CAMBIO DE IDIOMA (NO NECESITA LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/idioma/{idioma}', function ($idioma) {

    if (!in_array($idioma, ['es', 'eu'])) {
        abort(400);
    }

    Session::put('locale', $idioma);
    App::setLocale($idioma);

    return redirect()->back();

})->name('idioma.cambiar');

require __DIR__.'/auth.php';
