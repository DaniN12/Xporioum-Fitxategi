@extends('layouts.alumno', ['title' => 'Mis documentos'])

@section('content')
<div class="max-w-4xl mx-auto">
  @if(session('success'))
    <div class="mb-4 p-3 rounded-xl bg-green-100 text-green-700 font-semibold">{{ session('success') }}</div>
  @endif

  <div class="bg-white rounded-2xl shadow p-6">
    <h2 class="text-2xl font-extrabold mb-6">Mis documentos</h2>

    <form action="{{ route('cuenta.documentos.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf

      <select name="tipo" class="w-full border rounded-xl p-3 bg-white">
        <option value="personal">Personal</option>
        <option value="otros">Otros</option>
      </select>

      <input type="file" name="documento" class="w-full border rounded-xl p-3 bg-white" required>

      <button class="w-full py-3 rounded-xl font-extrabold text-white bg-gray-900 hover:opacity-90">
        Subir documento
      </button>
    </form>

    <div class="mt-6 text-sm text-gray-500">
      Si lo tienes guardado en BD con columnas tipo <code>doc_personal_path</code> / <code>doc_otros_path</code>, aquí luego lo listamos.
    </div>
  </div>
</div>
@endsection
