@extends('layouts.alumno', ['title' => __('message.incidence_title')])

@section('content')
<div class="w-full max-w-3xl mx-auto px-4 sm:px-6 lg:px-10 py-10">

    @if(session('status'))
        <div class="bg-white rounded-3xl shadow-xl border border-emerald-100 p-8 sm:p-10 text-center relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-56 h-56 bg-emerald-100/60 rounded-full blur-2xl"></div>

            <div class="mx-auto mb-4 w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shadow-sm">
                <svg class="w-9 h-9 text-emerald-600" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <div class="font-extrabold text-2xl sm:text-3xl text-gray-900 mb-2">
                {{ session('status') }}
            </div>

            <p class="text-gray-500 mb-7">
                {{ __('message.incidence_success_text') }}
            </p>

            <a href="{{ route('incidencias.create') }}"
               class="inline-flex items-center justify-center px-7 py-3.5 rounded-2xl font-extrabold text-white
                      bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 transition shadow-lg shadow-indigo-600/20">
                {{ __('message.incidence_new_button') }}
            </a>
        </div>

    @else

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 sm:p-5">
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 w-9 h-9 rounded-xl bg-white border border-red-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" viewBox="0 0 24 24" fill="none">
                            <path d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 0 0 4.53 20h14.94a2 2 0 0 0 1.74-3.14l-7.5-13a2 2 0 0 0-3.42 0Z"
                                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-extrabold text-red-700 mb-1">{{ __('message.incidence_error_title') }}</div>
                        <ul class="list-disc pl-5 space-y-1 text-red-700">
                            @foreach ($errors->all() as $error)
                                <li class="font-medium">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-8 text-center">
            <div class="mx-auto inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 shadow-sm">
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none">
                    <path d="M12 20h9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <h1 class="mt-4 text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                {{ __('message.incidence_heading') }}
            </h1>
        </div>

        <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-6 sm:p-8 space-y-6">

                <div>
                    <label class="block text-sm font-extrabold text-gray-700 mb-2">
                        {{ __('message.incidence_date') }}
                    </label>

                    <input type="date" name="fecha" value="{{ old('fecha') }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50
                                  focus:outline-none focus:ring-4 focus:ring-indigo-200 focus:border-indigo-300">
                </div>

                <div>
                    <label class="block text-sm font-extrabold text-gray-700 mb-2">
                        {{ __('message.incidence_reason') }}
                    </label>

                    <textarea name="motivo" required rows="5"
                              placeholder="{{ __('message.incidence_reason_placeholder') }}"
                              class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50
                                     focus:outline-none focus:ring-4 focus:ring-indigo-200 focus:border-indigo-300"
                    >{{ old('motivo') }}</textarea>
                </div>

                {{-- UPLOAD LIMPIO --}}
                <div>
                    <label class="block text-sm font-extrabold text-gray-700 mb-2">
                        {{ __('message.incidence_attachment') }}
                    </label>

                    <label class="group w-full cursor-pointer block">
                        <div class="w-full rounded-2xl border-2 border-dashed border-indigo-200 bg-white
                                    p-6 flex items-center gap-4
                                    group-hover:bg-indigo-50/40 transition">

                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M7 10l5-5 5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 5v12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-gray-800">Adjuntar archivo</div>

                                <div id="fileMeta" class="mt-2 hidden">
                                    <div class="inline-flex items-center gap-2 rounded-xl bg-indigo-50 border border-indigo-100 px-3 py-1.5">
                                        <span id="fileName" class="text-sm font-bold text-indigo-700 truncate max-w-[220px]"></span>
                                        <span id="fileSize" class="text-xs font-semibold text-indigo-600/80"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input id="adjuntoInput" type="file" name="adjunto" class="hidden" accept=".pdf,image/*" />
                    </label>
                </div>
            </div>

            <button type="submit"
                    class="w-full py-4 rounded-2xl font-extrabold text-white
                           bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 transition
                           shadow-xl shadow-indigo-600/20 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                {{ __('message.incidence_submit') }}
            </button>
        </form>

        <script>
            (function () {
                const input = document.getElementById('adjuntoInput');
                const meta = document.getElementById('fileMeta');
                const fileName = document.getElementById('fileName');
                const fileSize = document.getElementById('fileSize');

                if (!input) return;

                const humanSize = (bytes) => {
                    const units = ['B','KB','MB','GB'];
                    let i = 0;
                    let n = bytes;
                    while (n >= 1024 && i < units.length - 1) { n /= 1024; i++; }
                    return `${n.toFixed(i === 0 ? 0 : 1)} ${units[i]}`;
                };

                input.addEventListener('change', function () {
                    const f = this.files && this.files[0];
                    if (!f) {
                        meta.classList.add('hidden');
                        return;
                    }
                    meta.classList.remove('hidden');
                    fileName.textContent = f.name;
                    fileSize.textContent = humanSize(f.size);
                });
            })();
        </script>

    @endif
</div>
@endsection
