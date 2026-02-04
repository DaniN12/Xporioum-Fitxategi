<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FichajeController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\NormasController;

// TEACHER
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\QrController;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Teacher\AbsenceController as TeacherAbsenceController;

Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['es', 'en', 'eu'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return back();
})->name('setLocale');

Route::middleware(['locale'])->group(function () {

    Route::get('/', function () {
        return view('preloader');
    });

    Route::get('/qr/{token}', [FichajeController::class, 'consumeQrPublic'])->name('qr.consume');

    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/horas', [AlumnoController::class, 'horas'])->name('horas.index');
    Route::get('/horas/descargar', [AlumnoController::class, 'downloadHoras'])->name('horas.download');

    Route::get('/fichar', [FichajeController::class, 'vistaFichar'])->name('fichar.vista');
    Route::get('/fichar/qr', [FichajeController::class, 'vistaEscanearQR'])->name('fichar.qr');
    Route::post('/fichar/qr/validar', [FichajeController::class, 'validarQR'])->name('fichar.qr.validar');

    Route::post('/fichar/descanso', [FichajeController::class, 'iniciarDescanso'])->name('fichar.descanso');
    Route::post('/fichar/retomar', [FichajeController::class, 'retomarTurno'])->name('fichar.retomar');
    Route::post('/salida', [FichajeController::class, 'ficharSalida'])->name('fichar.salida');

    Route::get('/incidencias/crear', [IncidenciaController::class, 'create'])->name('incidencias.create');
    Route::post('/incidencias', [IncidenciaController::class, 'store'])->name('incidencias.store');

    /*
    |--------------------------------------------------------------------------
    | NORMAS + FIRMA DIGITAL
    |--------------------------------------------------------------------------
    | IMPORTANTE: SIN middleware auth porque tu login NO está usando Auth::login()
    | y el middleware auth te manda a /login aunque estés "dentro" por tu sistema.
    */
    Route::get('/normas', [NormasController::class, 'show'])->name('normas');
    Route::post('/normas/firmar', [NormasController::class, 'firmar'])->name('normas.firmar');
    Route::get('/cuenta/documentos', [NormasController::class, 'misDocumentos'])->name('cuenta.documentos');

    Route::prefix('cuenta')->name('cuenta.')->group(function () {

        Route::get('/', [CuentaController::class, 'index'])->name('index');

        Route::get('/datos', [CuentaController::class, 'datos'])->name('datos');
        Route::post('/datos', [CuentaController::class, 'datosUpdate'])->name('datos.update');

        // OJO: aquí ya lo estamos mostrando con NormasController->misDocumentos()
        Route::get('/documentos', [NormasController::class, 'misDocumentos'])->name('documentos');

        Route::get('/notificaciones', [CuentaController::class, 'notificaciones'])->name('notificaciones');

        Route::get('/password', [CuentaController::class, 'passwordForm'])->name('password');
        Route::post('/password', [CuentaController::class, 'passwordUpdate'])->name('password.update');
    });

    Route::middleware('is_teacher')
        ->prefix('teacher')
        ->name('teacher.')
        ->group(function () {

            Route::get('/dashboard', [StudentController::class, 'create'])->name('dashboard');
            Route::resource('students', StudentController::class);

            Route::patch('/students/{id}/toggle', [StudentController::class, 'toggleActive'])
                ->name('students.toggle');

            Route::get('/attendance', [TeacherAttendanceController::class, 'index'])->name('attendance.index');
            Route::get('/attendance/student', [TeacherAttendanceController::class, 'byStudent'])->name('attendance.student');

            Route::post('/attendance/update/{id}', [TeacherAttendanceController::class, 'update'])
                ->name('attendance.update');

            Route::get('/absences', [TeacherAbsenceController::class, 'index'])->name('absences.index');
            Route::post('/absences/{id}/accept', [TeacherAbsenceController::class, 'accept'])->name('absences.accept');
            Route::post('/absences/{id}/reject', [TeacherAbsenceController::class, 'reject'])->name('absences.reject');

            Route::get('/qr', [QrController::class, 'generate'])->name('qr');
            Route::post('/qr/generate', [QrController::class, 'apiGenerate'])->name('qr.api');
        });

});
