@extends('layouts.alumno', ['title' => __('message.rules_title')])

@section('content')
@php
  $firmado = false;
@endphp

<div class="max-w-5xl mx-auto">
  <div class="bg-white rounded-2xl shadow p-6 md:p-8">

    <div class="flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900">
          {{ __('message.rules_heading') }}
        </h1>
        <p class="text-gray-500 mt-2">
          {{ __('message.rules_subtitle') }}
        </p>
      </div>

      <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold border
                   {{ $firmado ? 'bg-green-50 text-green-700 border-green-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
        <span class="w-2 h-2 rounded-full {{ $firmado ? 'bg-green-500' : 'bg-amber-500' }}"></span>
        {{ $firmado ? __('message.rules_signed') : __('message.rules_pending') }}
      </span>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

      <div class="lg:col-span-2">
        <div class="bg-gray-50 border rounded-2xl p-5 md:p-6">
          <h2 class="text-lg font-extrabold text-gray-900">{{ __('message.rules_content_title') }}</h2>
          <p class="text-gray-600 mt-2">
            {{ __('message.rules_intro') }}
          </p>

          <div class="mt-4 space-y-3 text-gray-700">
            <div class="bg-white border rounded-xl p-4">
              <div class="font-bold">{{ __('message.rules_rule1_title') }}</div>
              <div class="text-sm text-gray-600 mt-1">{{ __('message.rules_rule1_text') }}</div>
            </div>

            <div class="bg-white border rounded-xl p-4">
              <div class="font-bold">{{ __('message.rules_rule2_title') }}</div>
              <div class="text-sm text-gray-600 mt-1">{{ __('message.rules_rule2_text') }}</div>
            </div>

            <div class="bg-white border rounded-xl p-4">
              <div class="font-bold">{{ __('message.rules_rule3_title') }}</div>
              <div class="text-sm text-gray-600 mt-1">{{ __('message.rules_rule3_text') }}</div>
            </div>
          </div>

          <div class="mt-6 text-sm text-gray-500">
            {{ __('message.rules_tip') }}
          </div>
        </div>
      </div>

      <div>
        <div class="bg-white border rounded-2xl p-5 md:p-6 shadow-sm">
          <h2 class="text-lg font-extrabold text-gray-900">{{ __('message.rules_actions_title') }}</h2>
          <p class="text-gray-500 mt-2">{{ __('message.rules_actions_subtitle') }}</p>

          <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3">
            <button type="button"
              class="w-full py-3 rounded-xl font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 transition"
              onclick="alert('{{ __('message.rules_sign_alert') }}')">
              {{ __('message.rules_sign_button') }}
            </button>

            <button type="button"
              class="w-full py-3 rounded-xl font-extrabold bg-gray-100 hover:bg-gray-200 transition"
              onclick="window.print()">
              {{ __('message.rules_download_button') }}
            </button>
          </div>

          <div class="mt-4 bg-gray-50 border rounded-xl p-4 text-sm text-gray-600">
            <span class="font-bold">{{ __('message.rules_note_label') }}</span>
            {{ __('message.rules_note_text') }}
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
