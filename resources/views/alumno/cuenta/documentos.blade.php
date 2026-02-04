@extends('layouts.alumno', ['title' => __('message.docs_title')])

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6">
  <div class="bg-white rounded-2xl shadow p-5 sm:p-6">
    <h2 class="text-2xl font-extrabold mb-6">Mis documentos</h2>

    @if(empty($docs) || $docs->isEmpty())
      <div class="text-center py-10 text-gray-500">
        No tienes documentos todavía.
      </div>
    @else
      <div class="space-y-3 sm:space-y-4">
        @foreach($docs as $doc)
          <div class="border rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="min-w-0">
              <div class="font-bold text-gray-900 break-words">
                {{ $doc->nombre_archivo }}
              </div>
              <div class="text-sm text-gray-500 mt-1">
                {{ $doc->tipo_archivo }}
              </div>
            </div>

            <a class="w-full sm:w-auto inline-flex items-center justify-center
                      px-4 py-3 sm:py-2 rounded-xl bg-indigo-600 text-white font-bold
                      hover:bg-indigo-700 active:bg-indigo-800 transition shadow whitespace-nowrap"
               href="{{ Storage::disk('public')->url($doc->ruta_archivo) }}"
               target="_blank">
              Descargar
            </a>
          </div>
        @endforeach
      </div>
    @endif

  </div>
</div>
@endsection
