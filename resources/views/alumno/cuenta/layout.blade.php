<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title ?? 'Cuenta' }}</title>
  @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gray-50">

  {{-- Header --}}
  <div class="bg-white border-b">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
      <div class="text-xl font-extrabold">{{ $title ?? 'Cuenta' }}</div>
      <div class="text-sm text-gray-600">{{ $u->nombre ?? '' }}</div>
    </div>
  </div>

  <div class="max-w-6xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

      {{-- Sidebar desktop --}}
      <aside class="hidden lg:block lg:col-span-4">
        <div class="bg-white rounded-2xl shadow p-3 space-y-1">
          <a href="{{ route('cuenta.datos') }}"
             class="block px-4 py-3 rounded-xl {{ request()->routeIs('cuenta.datos') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'hover:bg-gray-50' }}">
            Datos personales
          </a>

          <a href="{{ route('cuenta.documentos') }}"
             class="block px-4 py-3 rounded-xl {{ request()->routeIs('cuenta.documentos') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'hover:bg-gray-50' }}">
            Mis documentos
          </a>

          <a href="{{ route('cuenta.notificaciones') }}"
             class="block px-4 py-3 rounded-xl {{ request()->routeIs('cuenta.notificaciones') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'hover:bg-gray-50' }}">
            Notificaciones
          </a>

          <a href="{{ route('cuenta.password') }}"
             class="block px-4 py-3 rounded-xl {{ request()->routeIs('cuenta.password') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'hover:bg-gray-50' }}">
            Mi contraseña
          </a>

          {{-- Logout --}}
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
              class="w-full text-left block px-4 py-3 rounded-xl text-red-600 font-bold hover:bg-red-50">
              Desconexión
            </button>
          </form>
        </div>
      </aside>

      {{-- Contenido --}}
      <main class="lg:col-span-8">
        @yield('content')
      </main>

    </div>
  </div>

</body>
</html>
