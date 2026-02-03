@extends('layouts.alumno', ['title' => __('message.password_title')])

@section('content')
<div class="max-w-4xl mx-auto">
  @if(session('error'))
    <div class="mb-4 p-3 rounded-xl bg-red-100 text-red-700 font-semibold">{{ session('error') }}</div>
  @endif
  @if(session('success'))
    <div class="mb-4 p-3 rounded-xl bg-green-100 text-green-700 font-semibold">{{ session('success') }}</div>
  @endif

  <div class="bg-white rounded-2xl shadow p-6 max-w-xl">
    <h2 class="text-2xl font-extrabold mb-6">{{ __('message.password_heading') }}</h2>

    <form action="{{ route('cuenta.password.update') }}" method="POST" class="space-y-4">
      @csrf

      <input class="w-full border rounded-xl p-3" type="password" name="password_actual"
             placeholder="{{ __('message.password_current') }}">

      <input class="w-full border rounded-xl p-3" type="password" name="password"
             placeholder="{{ __('message.password_new') }}">

      <input class="w-full border rounded-xl p-3" type="password" name="password_confirmation"
             placeholder="{{ __('message.password_confirm') }}">

      <div class="text-sm text-gray-500 grid grid-cols-1 sm:grid-cols-2 gap-2 pt-2">
        <div>✓ {{ __('message.password_rule_1') }}</div>
        <div>✓ {{ __('message.password_rule_2') }}</div>
        <div>✓ {{ __('message.password_rule_3') }}</div>
        <div>✓ {{ __('message.password_rule_4') }}</div>
      </div>

      <button class="mt-2 w-full py-3 rounded-xl font-extrabold text-white bg-[#4338ca] hover:opacity-90">
        {{ __('message.password_save') }}
      </button>
    </form>
  </div>
</div>
@endsection
