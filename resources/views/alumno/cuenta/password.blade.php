@extends('layouts.alumno', ['title' => 'Cambiar contraseña'])

@section('content')
<div class="max-w-4xl mx-auto">
  @if(session('error'))
    <div class="mb-4 p-3 rounded-xl bg-red-100 text-red-700 font-semibold">{{ session('error') }}</div>
  @endif
  @if(session('success'))
    <div class="mb-4 p-3 rounded-xl bg-green-100 text-green-700 font-semibold">{{ session('success') }}</div>
  @endif

  <div class="bg-white rounded-2xl shadow p-6 max-w-xl">
    <h2 class="text-2xl font-extrabold mb-6">Cambiar la contraseña</h2>

    <form action="{{ route('cuenta.password.update') }}" method="POST" class="space-y-4">
      @csrf

      <input class="w-full border rounded-xl p-3" type="password" name="password_actual" placeholder="Contraseña actual">
      <input class="w-full border rounded-xl p-3" type="password" name="password" placeholder="Nueva contraseña">
      <input class="w-full border rounded-xl p-3" type="password" name="password_confirmation" placeholder="Confirmación de la nueva contraseña">

      <div class="text-sm text-gray-500 grid grid-cols-1 sm:grid-cols-2 gap-2 pt-2">
        <div>✓ Mínimo 8 caracteres</div>
        <div>✓ Al menos 1 mayúscula y 1 minúscula</div>
        <div>✓ Al menos 1 cifra</div>
        <div>✓ Al menos 1 carácter especial</div>
      </div>

      <button class="mt-2 w-full py-3 rounded-xl font-extrabold text-white bg-gray-900 hover:opacity-90">
        Guardar
      </button>
    </form>
  </div>
</div>
@endsection
