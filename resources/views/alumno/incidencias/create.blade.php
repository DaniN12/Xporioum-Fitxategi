@extends('layouts.alumno', ['title' => __('message.incidence_title')])

@section('content')
<div class="w-full max-w-3xl mx-auto px-4 sm:px-6 lg:px-10 py-10">

    @if(session('status'))
        <div class="bg-white rounded-2xl shadow border border-green-100 p-8 text-center">
            <div class="text-5xl mb-3">✅</div>
            <div class="font-extrabold text-2xl text-gray-900 mb-2">
                {{ session('status') }}
            </div>
            <p class="text-gray-500 mb-6">
                {{ __('message.incidence_success_text') }}
            </p>

            <a href="{{ route('incidencias.create') }}"
               class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition">
                {{ __('message.incidence_new_button') }}
            </a>
        </div>

    @else

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl p-4">
                <div class="font-extrabold mb-2">{{ __('message.incidence_error_title') }}</div>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="font-medium">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 text-2xl shadow-sm">
                📝
            </div>
            <h1 class="mt-4 text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                {{ __('message.incidence_heading') }}
            </h1>
            <p class="mt-2 text-gray-500 font-medium">
                {{ __('message.incidence_subtitle') }}
            </p>
        </div>

        <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white rounded-2xl shadow border border-gray-100 p-6 sm:p-8 space-y-6">

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        {{ __('message.incidence_date') }}
                    </label>
                    <input type="date" name="fecha" value="{{ old('fecha') }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        {{ __('message.incidence_reason') }}
                    </label>
                    <textarea name="motivo" required rows="5"
                        placeholder="{{ __('message.incidence_reason_placeholder') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                    >{{ old('motivo') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        {{ __('message.incidence_attachment') }}
                    </label>

                    <label class="group w-full cursor-pointer block">
                        <div class="w-full rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50
                                    p-6 flex items-center justify-between gap-4 group-hover:bg-gray-100 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl bg-white border flex items-center justify-center text-xl">
                                    📎
                                </div>

                                <div>
                                    <div class="font-bold text-gray-800">
                                        {{ __('message.incidence_upload_text') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ __('message.incidence_upload_types') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="file" name="adjunto" class="hidden" accept=".pdf,image/*" />
                    </label>

                    <p class="mt-2 text-xs text-gray-400">
                        {{ __('message.incidence_attachment_note') }}
                    </p>
                </div>
            </div>

            <button type="submit"
                class="w-full py-4 rounded-2xl font-extrabold text-white bg-[#4338ca] transition shadow-lg">
                {{ __('message.incidence_submit') }}
            </button>
        </form>

    @endif
</div>
@endsection
