<?php
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\NormaController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

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


// Perfil
Route::get('/perfil', function () {
    return "Bienvenido, " . Auth::user()->name . ". Tu registro ha funcionado correctamente.";
})->middleware('auth');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

?>

