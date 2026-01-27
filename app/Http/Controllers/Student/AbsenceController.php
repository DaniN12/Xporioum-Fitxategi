<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = Absence::where('user_id', auth()->id())->get();
        return view('student.absences', compact('absences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'reason' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        $path = null;
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('absences', 'public');
        }

        Absence::create([
            'user_id' => auth()->id(),
            'date' => $request->date,
            'reason' => $request->reason,
            'document_path' => $path,
        ]);

        return back()->with('success', 'Ausencia enviada');
    }
}
