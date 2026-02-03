@extends('layouts.alumno', ['title' => __('message.docs_title')])

@section('content')
<div class="max-w-4xl mx-auto">
  @if(session('success'))
    <div class="mb-4 p-3 rounded-xl bg-green-100 text-green-700 font-semibold">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-white rounded-2xl shadow p-6">
    <h2 class="text-2xl font-extrabold mb-6">{{ __('message.docs_heading') }}</h2>

    <form action="{{ route('cuenta.documentos.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf

      <select name="tipo" class="w-full border rounded-xl p-3 bg-white">
        <option value="personal">{{ __('message.docs_type_personal') }}</option>
        <option value="otros">{{ __('message.docs_type_other') }}</option>
      </select>

      <input type="file" name="documento" class="w-full border rounded-xl p-3 bg-white" required>

      <button class="w-full py-3 rounded-xl font-extrabold text-white bg-[#4338ca] hover:opacity-90">
        {{ __('message.docs_upload_button') }}
      </button>
    </form>

    <div class="mt-6 text-sm text-gray-500">
      {{ __('message.docs_note') }}
      <code>doc_personal_path</code> / <code>doc_otros_path</code>,
      {{ __('message.docs_note_2') }}
    </div>
  </div>
</div>
@endsection
