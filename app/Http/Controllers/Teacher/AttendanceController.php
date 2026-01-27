<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function index(Request $request)
    {
        // Obtener todos los alumnos (para el select)
        $students = User::where('role', 'student')->orderBy('name')->get();

        // Alumno seleccionado (si existe)
        $studentId = $request->get('student_id');

        // Consulta base
        $attendances = Attendance::with('user')
            ->when($studentId, function ($query) use ($studentId) {
                $query->where('user_id', $studentId);
            })
            ->orderBy('date', 'desc')
            ->get();

        return view('teacher.attendance.index', compact(
            'attendances',
            'students',
            'studentId'
        ));
    }

    public function byStudent(Request $request)
    {
        $students = User::where('role', 'student')->get();

        $attendances = Attendance::where('user_id', $request->student_id)
            ->with('user')
            ->orderBy('date', 'desc')
            ->get();

        return view('teacher.attendance.index', compact('students', 'attendances'));
    }
}
