<?php
use App\Http\Controllers\IncidenciaController;

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
Route::get('/normas', function () {
    return view('normas.index');
})->name('normas.index');


?>
