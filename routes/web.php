<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\Student\AbsenceController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\QrController;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->group(function () {
        Route::get('/dashboard', [AttendanceController::class, 'dashboard'])->name('student.dashboard');
        Route::post('/punch', [AttendanceController::class, 'punch'])->name('student.punch');
        Route::get('/attendance', [AttendanceController::class, 'history'])->name('student.attendance');
        Route::get('/absences', [AbsenceController::class, 'index'])->name('student.absences');
        Route::post('/absences', [AbsenceController::class, 'store'])->name('student.absences.store');
});


Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');
});


Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [StudentController::class, 'create'])
            ->name('dashboard');

        // Alumnos
        Route::resource('students', StudentController::class);

        // Asistencia
        Route::get('/attendance', [TeacherAttendanceController::class, 'index'])
            ->name('attendance.index');

        Route::get('/attendance/student', [AttendanceController::class, 'byStudent'])
            ->name('attendance.student');

        // Ausencias
        Route::get('/absences', [AbsenceController::class, 'index'])
            ->name('absences.index');


        Route::get('/absences/{absence}/{status}', [AbsenceController::class, 'update'])
            ->name('absences.update');

        // QR
        Route::get('/qr', [QrController::class, 'generate'])
            ->name('qr');
});



Route::get('/student/qr/{token}', function ($token) {

    if (
        session('qr_token') !== $token ||
        now()->greaterThan(session('qr_expiration'))
    ) {
        abort(403, 'QR no válido');
    }

    return redirect()->route('student.dashboard')
        ->with('qr_valid', true);

})->name('student.qr.validate')->middleware(['auth', 'role:student']);

Route::get('/language/{lang}', function ($lang) {
    session(['locale' => $lang]);
    app()->setLocale($lang);
    return back();
});



require __DIR__.'/auth.php';
