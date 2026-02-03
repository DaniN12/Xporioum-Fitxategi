@extends('layouts.alumno', ['title' => __('message.profile_title')])

@section('content')
<div class="max-w-4xl mx-auto">

  @if(session('success'))
    <div class="mb-4 p-3 rounded-xl bg-green-100 text-green-700 font-semibold">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="mb-4 p-3 rounded-xl bg-red-100 text-red-700 font-semibold">
      {{ session('error') }}
    </div>
  @endif

  <div class="bg-white rounded-2xl shadow p-6">
    <div class="flex items-start justify-between gap-4 mb-6">
      <div>
        <h2 class="text-2xl font-extrabold">{{ __('message.profile_heading') }}</h2>
        <p class="text-sm text-gray-500 mt-1">
          {{ __('message.profile_locked_text') }}
        </p>
      </div>

      <div class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-slate-50 border text-slate-700 font-semibold text-sm">
        <i class="bi bi-lock-fill"></i>
        {{ __('message.profile_locked_badge') }}
      </div>
    </div>

    {{-- Datos solo lectura--}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
      <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('message.profile_name') }}</label>
        <input class="w-full border rounded-xl p-3 bg-gray-50 text-gray-700 cursor-not-allowed"
               value="{{ $u->nombre ?? '' }}" disabled>
      </div>

      <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('message.profile_email') }}</label>
        <input class="w-full border rounded-xl p-3 bg-gray-50 text-gray-700 cursor-not-allowed"
               value="{{ $u->email ?? '' }}" disabled>
      </div>

      <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('message.profile_dni') }}</label>
        <input class="w-full border rounded-xl p-3 bg-gray-50 text-gray-700 cursor-not-allowed"
               value="{{ $u->dni ?? '' }}" disabled>
      </div>

      <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('message.profile_phone') }}</label>
        <input class="w-full border rounded-xl p-3 bg-gray-50 text-gray-700 cursor-not-allowed"
               value="{{ $u->telefono ?? '' }}" disabled>
      </div>
    </div>

    {{-- Errores validación --}}
    @if ($errors->any())
      <div class="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-red-700">
        <div class="font-extrabold mb-2">{{ __('message.profile_error_title') }}</div>
        <ul class="list-disc pl-5 space-y-1">
          @foreach ($errors->all() as $error)
            <li class="font-medium">{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Solicitud de cambio --}}
    <form action="{{ route('cuenta.datos.update') }}" method="POST" class="space-y-3">
      @csrf

      <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">
          {{ __('message.profile_request_label') }}
        </label>

        <textarea
          name="solicitud"
          required
          rows="4"
          placeholder="{{ __('message.profile_request_placeholder') }}"
          class="w-full border rounded-xl p-3 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-300"
        >{{ old('solicitud') }}</textarea>

        <p class="text-xs text-gray-400 mt-2">
          {{ __('message.profile_request_note') }}
        </p>
      </div>

      <button class="w-full py-3 rounded-xl font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 transition">
        {{ __('message.profile_request_button') }}
      </button>
    </form>
  </div>
</div>
@endsection
