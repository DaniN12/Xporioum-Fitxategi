@extends('layouts.alumno', ['title' => 'Datos personales'])

@section('content')
<div class="max-w-4xl mx-auto">
  @if(session('success'))
    <div class="mb-4 p-3 rounded-xl bg-green-100 text-green-700 font-semibold">{{ session('success') }}</div>
  @endif

  <div class="bg-white rounded-2xl shadow p-6">
    <h2 class="text-2xl font-extrabold mb-6">Mi perfil</h2>

    <form action="{{ route('cuenta.datos.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input class="w-full border rounded-xl p-3" name="nombre" value="{{ $u->nombre ?? '' }}" placeholder="Nombre">
        <input class="w-full border rounded-xl p-3" name="email" value="{{ $u->email ?? '' }}" placeholder="Email">
        <input class="w-full border rounded-xl p-3" name="dni" value="{{ $u->dni ?? '' }}" placeholder="DNI">
        <input class="w-full border rounded-xl p-3" name="telefono" value="{{ $u->telefono ?? '' }}" placeholder="Teléfono">
      </div>

      <div>
        <label class="block font-bold mb-2">Foto (opcional)</label>
        <input type="file" name="foto" class="w-full border rounded-xl p-3 bg-white">
      </div>

      <button class="w-full py-3 rounded-xl font-extrabold text-white bg-gray-900 hover:opacity-90">
        Guardar cambios
      </button>
    </form>
  </div>
</div>
@endsection

