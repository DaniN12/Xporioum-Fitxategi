@php
  $isEdit = isset($student);
  $action = $isEdit
      ? route('teacher.students.update', $student->id_alumno)
      : route('teacher.students.store');

  $nombre = old('nombre', $isEdit ? ($student->usuario?->nombre ?? '') : '');
  $email  = old('email',  $isEdit ? ($student->usuario?->email ?? '')  : '');
  $dni    = old('dni',    $isEdit ? ($student->usuario?->dni ?? '')    : '');
  $empresaOld = old('empresa_id', $isEdit ? ($student->empresa_id ?? '') : '');
@endphp

@if ($errors->any())
  <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700">
    <div class="font-extrabold mb-2">{{ __('message.form_errors_title') }}</div>
    <ul class="list-disc pl-5 space-y-1 text-sm font-semibold">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ $action }}" class="space-y-6">
  @csrf
  @if($isEdit)
    @method('PUT')
  @endif

  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
      <label class="block text-sm font-extrabold text-slate-700 mb-2">{{ __('message.t_student_name') }}</label>
      <input name="nombre" value="{{ $nombre }}" required
             class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 outline-none
                    focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300">
    </div>

    <div>
      <label class="block text-sm font-extrabold text-slate-700 mb-2">{{ __('message.email') }}</label>
      <input name="email" type="email" value="{{ $email }}" required
             class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 outline-none
                    focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300">
    </div>

    <div>
      <label class="block text-sm font-extrabold text-slate-700 mb-2">{{ __('message.t_student_dni') }}</label>
      <input name="dni" value="{{ $dni }}" required
             class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 outline-none
                    focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300">
    </div>

    <div>
      <label class="block text-sm font-extrabold text-slate-700 mb-2">{{ __('message.t_student_company') }}</label>
      <select name="empresa_id" required
              class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 outline-none
                     focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300">
        <option value="">{{ __('message.t_student_company_pick') }}</option>
        @foreach($companies as $company)
          <option value="{{ $company->id_empresa }}" @selected($empresaOld == $company->id_empresa)>
            {{ $company->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Solo en CREATE --}}
    @unless($isEdit)
      <div class="md:col-span-2">
        <label class="block text-sm font-extrabold text-slate-700 mb-2">{{ __('message.t_student_password_initial') }}</label>
        <input name="contrasena" type="password" required
               class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 outline-none
                      focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300">
        <div class="text-xs text-slate-500 mt-2">
          {{ __('message.t_student_password_hint') }}
        </div>
      </div>
    @endunless
  </div>

  <button type="submit"
          class="w-full rounded-2xl py-4 font-extrabold text-white
                 bg-indigo-600 hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20">
    {{ $isEdit ? __('message.t_student_update_button') : __('message.t_student_create_button') }}
  </button>
</form>
