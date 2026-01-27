<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function dashboard()
    {
        $todayAttendance = Attendance::where('user_id', auth()->id())
            ->where('date', today())
            ->first();

        return view('student.dashboard', compact('todayAttendance'));
    }

    public function punch(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        // 🔒 PRODUCCIÓN: requiere QR
        if (config('attendance.qr_required')) {
            if (!$request->qr_token) {
                return back()->withErrors([
                    'qr' => 'Es necesario escanear el código QR'
                ]);
            }

            // aquí luego validaremos el token QR
        }

        if (!$attendance) {
            Attendance::create([
                'user_id' => $user->id,
                'date' => $today,
                'entry_time' => now(),
            ]);

            return back()->with('success', 'Entrada registrada');
        }

        if (!$attendance->exit_time) {
            $attendance->update([
                'exit_time' => now(),
            ]);

            return back()->with('success', 'Salida registrada');
        }

        return back();
    }


    public function history()
    {
        $attendances = Attendance::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->get();

        return view('student.attendance-history', compact('attendances'));
    }
}
