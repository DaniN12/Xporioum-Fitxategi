<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Absence;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = Absence::with('user')
            ->latest()
            ->get();

        return view('teacher.absences.index', compact('absences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date'   => 'required|date',
            'reason' => 'required|string|max:255',
            'file'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filePath = null;

        // ⬇️ AQUÍ VA EXACTAMENTE
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('absences', 'public');
        }

        Absence::create([
            'user_id'   => auth()->id(),
            'date'      => $request->date,
            'reason'    => $request->reason,
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Ausencia enviada correctamente');
    }
}
