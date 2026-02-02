@extends('layouts.alumno', ['title' => 'Normas'])

@section('content')
@php
  // Demo: estado de firma (luego lo conectas con BD)
  $firmado = false;
@endphp

<div class="max-w-5xl mx-auto">
  <div class="bg-white rounded-2xl shadow p-6 md:p-8">

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900">
          Documento de normas
        </h1>
        <p class="text-gray-500 mt-2">
          Este documento recoge las condiciones de uso y el procedimiento de fichaje.
        </p>
      </div>

      <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold border
                   {{ $firmado ? 'bg-green-50 text-green-700 border-green-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
        <span class="w-2 h-2 rounded-full {{ $firmado ? 'bg-green-500' : 'bg-amber-500' }}"></span>
        {{ $firmado ? 'Firmado' : 'Pendiente de firma' }}
      </span>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- TEXTO --}}
      <div class="lg:col-span-2">
        <div class="bg-gray-50 border rounded-2xl p-5 md:p-6">
          <h2 class="text-lg font-extrabold text-gray-900">Contenido</h2>
          <p class="text-gray-600 mt-2">
            (Texto demo) El alumno se compromete a realizar el fichaje mediante QR, respetar el uso personal e
            intransferible de su acceso y cumplir las condiciones de uso del sistema. Cualquier incidencia deberá
            registrarse en el módulo de incidencias en el momento en que ocurra.
          </p>

          <div class="mt-4 space-y-3 text-gray-700">
            <div class="bg-white border rounded-xl p-4">
              <div class="font-bold">1. Fichaje obligatorio por QR</div>
              <div class="text-sm text-gray-600 mt-1">La entrada y salida se registran escaneando el código QR.</div>
            </div>

            <div class="bg-white border rounded-xl p-4">
              <div class="font-bold">2. Prohibido fichar por terceros</div>
              <div class="text-sm text-gray-600 mt-1">El acceso es personal e intransferible.</div>
            </div>

            <div class="bg-white border rounded-xl p-4">
              <div class="font-bold">3. Validación de ubicación</div>
              <div class="text-sm text-gray-600 mt-1">Solo se aceptan registros desde el centro.</div>
            </div>
          </div>

          <div class="mt-6 text-sm text-gray-500">
            Tip: En móvil es más cómodo firmar con el dedo.
          </div>
        </div>
      </div>

      {{-- ACCIONES --}}
      <div>
        <div class="bg-white border rounded-2xl p-5 md:p-6 shadow-sm">
          <h2 class="text-lg font-extrabold text-gray-900">Acciones</h2>
          <p class="text-gray-500 mt-2">Elige una opción:</p>

          {{-- Botones al lado (en desktop) y en columna (en móvil) --}}
          <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3">
            <button
              type="button"
              class="w-full py-3 rounded-xl font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 transition"
              onclick="alert('Aquí irá la firma digital (más adelante).')"
            >
              Firmar
            </button>

            <button
              type="button"
              class="w-full py-3 rounded-xl font-extrabold bg-gray-100 hover:bg-gray-200 transition"
              onclick="window.print()"
            >
              Descargar
            </button>
          </div>

          <div class="mt-4 bg-gray-50 border rounded-xl p-4 text-sm text-gray-600">
            <span class="font-bold">Nota:</span> al firmar guardaremos el PDF firmado en <b>Mis documentos</b>.
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
  @media print {
    aside, nav, header, .no-print { display: none !important; }
    body { background: white !important; }
    main { padding: 0 !important; }
  }
</style>
@endsection
