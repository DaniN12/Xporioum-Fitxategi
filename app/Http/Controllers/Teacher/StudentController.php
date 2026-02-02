<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Company;
use App\Models\Profesor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Listado de alumnos del profesor logueado
     */
    public function index()
    {
        $profesor = $this->currentProfesor();

        $students = Alumno::where('profesor_id', $profesor->id_profesor)
            ->with(['usuario', 'empresa'])
            ->orderByDesc('id_alumno')
            ->get();

        return view('teacher.students.index', compact('students'));
    }

    /**
     * Formulario crear alumno (dashboard del profesor)
     */
    public function create()
    {
        $companies = Company::orderBy('nombre')->get();
        return view('teacher.dashboard', compact('companies'));
    }

    /**
     * Guardar alumno (crea usuario + alumno)
     */
    public function store(Request $request)
    {
        $profesor = $this->currentProfesor();

        $request->validate([
            'nombre'      => 'required|string|max:100',
            'email'       => 'required|email|max:100|unique:usuario,email',
            'dni'         => 'required|string|max:15|unique:usuario,dni',
            'empresa_id'  => 'required|exists:empresa,id_empresa',
            'contrasena'  => 'required|min:6',
        ]);

        // 1️⃣ Crear usuario
        $user = User::create([
            'email'      => $request->email,
            'contrasena' => Hash::make($request->contrasena),
            'nombre'     => $request->nombre,
            'dni'        => $request->dni,
            'idioma_id'  => 1,
            'activo'     => 1,
        ]);

        // 2️⃣ Crear alumno
        Alumno::create([
            'usuario_id'  => $user->id_usuario,
            'profesor_id' => $profesor->id_profesor,
            'empresa_id'  => $request->empresa_id,
            'fecha_alta'  => now()->toDateString(),
        ]);

        return redirect()
            ->route('teacher.dashboard')
            ->with('success', 'Alumno creado correctamente');
    }

    /**
     * Editar alumno
     */
    public function edit($id)
    {
        $profesor = $this->currentProfesor();

        $student = Alumno::where('id_alumno', $id)
            ->where('profesor_id', $profesor->id_profesor)
            ->with(['usuario', 'empresa'])
            ->firstOrFail();

        $companies = Company::orderBy('nombre')->get();

        return view('teacher.students.edit', compact('student', 'companies'));
    }

    /**
     * Actualizar alumno
     */
    public function update(Request $request, $id)
    {
        $profesor = $this->currentProfesor();

        $student = Alumno::where('id_alumno', $id)
            ->where('profesor_id', $profesor->id_profesor)
            ->with('usuario')
            ->firstOrFail();

        $request->validate([
            'nombre'     => 'required|string|max:100',
            'email'      => 'required|email|max:100|unique:usuario,email,' . $student->usuario->id_usuario . ',id_usuario',
            'dni'        => 'required|string|max:15|unique:usuario,dni,' . $student->usuario->id_usuario . ',id_usuario',
            'empresa_id' => 'required|exists:empresa,id_empresa',
        ]);

        $student->usuario->update([
            'nombre' => $request->nombre,
            'email'  => $request->email,
            'dni'    => $request->dni,
        ]);

        $student->update([
            'empresa_id' => $request->empresa_id,
        ]);

        return redirect()
            ->route('teacher.students.index')
            ->with('success', 'Alumno actualizado');
    }

    /**
     * Activar / Desactivar alumno
     */
    public function toggleActive($id)
    {
        $profesor = $this->currentProfesor();

        $student = Alumno::where('id_alumno', $id)
            ->where('profesor_id', $profesor->id_profesor)
            ->with('usuario')
            ->firstOrFail();

        $student->usuario->update([
            'activo' => $student->usuario->activo ? 0 : 1
        ]);

        return redirect()
            ->route('teacher.students.index')
            ->with('success', 'Estado del alumno actualizado');
    }

    /**
     * Eliminar alumno definitivo
     */
    public function destroy($id)
    {
        $profesor = $this->currentProfesor();

        $student = Alumno::where('id_alumno', $id)
            ->where('profesor_id', $profesor->id_profesor)
            ->with('usuario')
            ->firstOrFail();

        $usuario = $student->usuario;

        $student->delete();

        if ($usuario) {
            $usuario->delete();
        }

        return redirect()
            ->route('teacher.students.index')
            ->with('success', 'Alumno eliminado definitivamente');
    }

    /**
     * 🔐 Profesor logueado (por sesión, NO auth())
     */
    private function currentProfesor(): Profesor
    {
        $idUsuario = (int) session('id_usuario');

        if (!$idUsuario) {
            abort(403, 'NO HAY USUARIO EN SESIÓN');
        }

        return Profesor::where('usuario_id', $idUsuario)->firstOrFail();
    }
}
