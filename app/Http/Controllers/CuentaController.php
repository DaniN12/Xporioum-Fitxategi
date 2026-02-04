<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CuentaController extends Controller
{
    private function userId(): int
    {
        return (int) session('id_usuario');
    }

    private function usuario()
    {
        return DB::table('usuario')->where('id_usuario', $this->userId())->first();
    }

    public function index()
    {
        return view('alumno.cuenta.index', ['u' => $this->usuario()]);
    }

    public function datos()
    {
        return view('alumno.cuenta.datos', ['u' => $this->usuario()]);
    }

    public function datosUpdate(Request $request)
    {
        $u = $this->usuario();
        if (!$u) abort(403);

        $data = $request->validate([
            'solicitud' => 'required|string|max:2000',
        ]);

        $alumnoId = (int) session('alumno_id');

        if (!$alumnoId) {
            $alumnoId = (int) DB::table('alumno')
                ->where('usuario_id', $this->userId())
                ->value('id_alumno');
        }

        DB::table('solicitud_datos')->insert([
            'usuario_id' => $this->userId(),
            'alumno_id'  => $alumnoId ?: null,
            'mensaje'    => $data['solicitud'],
            'estado'     => 'pendiente',
            'created_at' => now(),
        ]);

        return back()->with('success', 'Solicitud enviada ');
    }

    public function documentos()
    {
        return view('alumno.cuenta.documentos', ['u' => $this->usuario()]);
    }

    public function documentosUpload(Request $request)
    {
        $u = $this->usuario();
        if (!$u) abort(403);

        $request->validate([
            'documento' => 'required|file|mimes:pdf,jpg,jpeg,png|max:8192',
            'tipo' => 'required|in:personal,otros',
        ]);

        $path = $request->file('documento')->store('documentos', 'public');

        $col = $request->tipo === 'personal' ? 'doc_personal_path' : 'doc_otros_path';

        DB::table('usuario')->where('id_usuario', $this->userId())->update([$col => $path]);

        return back()->with('success', 'Documento subido ');
    }

    public function documentoDownload(string $tipo)
    {
        $u = $this->usuario();
        if (!$u) abort(403);

        $col = $tipo === 'personal' ? 'doc_personal_path' : ($tipo === 'otros' ? 'doc_otros_path' : null);
        if (!$col || empty($u->$col)) abort(404);

        return Storage::disk('public')->download($u->$col);
    }

    public function notificaciones()
    {
        return view('alumno.cuenta.notificaciones', ['u' => $this->usuario(), 'items' => []]);
    }

    public function passwordForm()
    {
        return view('alumno.cuenta.password', ['u' => $this->usuario()]);
    }

    public function passwordUpdate(Request $request)
    {
        $u = $this->usuario();
        if (!$u) abort(403);

        $data = $request->validate([
            'password_actual' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($data['password_actual'], $u->contrasena)) {
            return back()->with('error', 'Contraseña actual incorrecta.');
        }

        DB::table('usuario')->where('id_usuario', $this->userId())->update([
            'contrasena' => Hash::make($data['password']),
        ]);

        return back()->with('success', 'Contraseña cambiada ');
    }
}
