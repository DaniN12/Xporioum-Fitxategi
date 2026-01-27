<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->get();
        return view('teacher.students.index', compact('students'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('teacher.dashboard', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'dni' => 'required|string|unique:users',
            'company_id' => 'nullable|exists:companies,id',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dni' => $request->dni,
            'company_id' => $request->company_id,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        return redirect()
            ->route('teacher.dashboard')
            ->with('success', 'Alumno creado correctamente');
    }


    public function edit(User $student)
    {
        return view('teacher.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $student->id,
        ]);

        $student->update($request->only('name', 'email'));

        return redirect()->route('teacher.students.index')
            ->with('success', 'Alumno actualizado');
    }

    public function destroy(User $student)
    {
        $student->delete();

        return redirect()->route('teacher.students.index')
            ->with('success', 'Alumno eliminado');
    }
}
