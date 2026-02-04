@extends('layouts.alumno')

@section('content')
<div class="w-full flex justify-center">
    <div class="w-full max-w-2xl">

        <div class="mb-6 pt-16 md:pt-0">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                {{ __('message.account_title') }}
            </h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1">
                {{ __('message.account_subtitle') }}
            </p>
        </div>

        @php
            $rDatos = \Illuminate\Support\Facades\Route::has('alumno.cuenta.datos') ? 'alumno.cuenta.datos' : 'cuenta.datos';
            $rDocs  = \Illuminate\Support\Facades\Route::has('alumno.cuenta.documentos') ? 'alumno.cuenta.documentos' : 'cuenta.documentos';
            $rNoti  = \Illuminate\Support\Facades\Route::has('alumno.cuenta.notificaciones') ? 'alumno.cuenta.notificaciones' : 'cuenta.notificaciones';
            $rPass  = \Illuminate\Support\Facades\Route::has('alumno.cuenta.password') ? 'alumno.cuenta.password' : 'cuenta.password';
        @endphp

        <div class="grid grid-cols-1 gap-4">

            {{-- Mi perfil --}}
            <button type="button"
                data-sheet-title="{{ __('message.account_profile_title') }}"
                data-sheet-url="{{ route($rDatos) }}?sheet=1"
                class="sheet-open group w-full bg-white rounded-2xl shadow p-5 hover:shadow-lg transition border border-transparent hover:border-indigo-100 text-left">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="font-bold text-gray-900">{{ __('message.account_profile_title') }}</div>
                        <div class="text-sm text-gray-500">{{ __('message.account_profile_desc') }}</div>
                    </div>
                    <span class="text-gray-400 group-hover:text-indigo-600 transition text-xl leading-none">›</span>
                </div>
            </button>

            {{-- Mis documentos --}}
            <button type="button"
                data-sheet-title="{{ __('message.account_docs_title') }}"
                data-sheet-url="{{ route($rDocs) }}?sheet=1"
                class="sheet-open group w-full bg-white rounded-2xl shadow p-5 hover:shadow-lg transition border border-transparent hover:border-indigo-100 text-left">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="font-bold text-gray-900">{{ __('message.account_docs_title') }}</div>
                        <div class="text-sm text-gray-500">{{ __('message.account_docs_desc') }}</div>
                    </div>
                    <span class="text-gray-400 group-hover:text-indigo-600 transition text-xl leading-none">›</span>
                </div>
            </button>

            {{-- Notificaciones --}}
            <button type="button"
                data-sheet-title="{{ __('message.account_notifications_title') }}"
                data-sheet-url="{{ route($rNoti) }}?sheet=1"
                class="sheet-open group w-full bg-white rounded-2xl shadow p-5 hover:shadow-lg transition border border-transparent hover:border-indigo-100 text-left">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="font-bold text-gray-900">{{ __('message.account_notifications_title') }}</div>
                        <div class="text-sm text-gray-500">{{ __('message.account_notifications_desc') }}</div>
                    </div>
                    <span class="text-gray-400 group-hover:text-indigo-600 transition text-xl leading-none">›</span>
                </div>
            </button>

            {{-- Contraseña --}}
            <button type="button"
                data-sheet-title="{{ __('message.account_password_title') }}"
                data-sheet-url="{{ route($rPass) }}?sheet=1"
                class="sheet-open group w-full bg-white rounded-2xl shadow p-5 hover:shadow-lg transition border border-transparent hover:border-indigo-100 text-left">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="font-bold text-gray-900">{{ __('message.account_password_title') }}</div>
                        <div class="text-sm text-gray-500">{{ __('message.account_password_desc') }}</div>
                    </div>
                    <span class="text-gray-400 group-hover:text-indigo-600 transition text-xl leading-none">›</span>
                </div>
            </button>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit"
                        class="w-full bg-white rounded-2xl shadow p-5 hover:shadow-lg transition border border-red-100 hover:border-red-200 text-left">
                    <div class="font-bold text-red-600">{{ __('message.account_logout_title') }}</div>
                    <div class="text-sm text-gray-500">{{ __('message.account_logout_desc') }}</div>
                </button>
            </form>

        </div>
    </div>
</div>

<div id="sheetRoot" class="fixed inset-0 z-50 hidden">
    {{-- overlay --}}
    <div id="sheetOverlay"
         class="absolute inset-0 bg-black/30 opacity-0 transition-opacity duration-200"></div>

    {{-- panel --}}
    <div id="sheetPanel"
         class="absolute inset-x-0 bottom-0 translate-y-full transition-transform duration-300 ease-out">
        <div class="mx-auto w-full max-w-2xl bg-white rounded-t-3xl shadow-2xl overflow-hidden">
            {{-- handle --}}
            <div class="flex justify-center pt-3">
                <div class="h-1.5 w-10 rounded-full bg-slate-200"></div>
            </div>

            {{-- header --}}
            <div class="px-5 py-4 flex items-center justify-between border-b">
                <button id="sheetClose" type="button" class="text-sm text-slate-500 hover:text-slate-700">
                    {{ __('message.cancel') }}
                </button>
                <div id="sheetTitle" class="text-sm font-semibold text-slate-900">
                    —
                </div>
                <div class="w-16"></div>
            </div>

            {{-- content --}}
            <div class="h-[78vh] bg-gray-100">
                <iframe id="sheetFrame" class="w-full h-full" src="" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
(() => {
    const root   = document.getElementById('sheetRoot');
    const overlay= document.getElementById('sheetOverlay');
    const panel  = document.getElementById('sheetPanel');
    const frame  = document.getElementById('sheetFrame');
    const title  = document.getElementById('sheetTitle');
    const close  = document.getElementById('sheetClose');

    function openSheet(url, t) {
        title.textContent = t || '';
        frame.src = url;

        root.classList.remove('hidden');
        requestAnimationFrame(() => {
            overlay.classList.remove('opacity-0');
            panel.classList.remove('translate-y-full');
        });
        document.body.style.overflow = 'hidden';
    }

    function closeSheet() {
        overlay.classList.add('opacity-0');
        panel.classList.add('translate-y-full');

        setTimeout(() => {
            root.classList.add('hidden');
            frame.src = '';
            document.body.style.overflow = '';
        }, 250);
    }

    document.querySelectorAll('.sheet-open').forEach(btn => {
        btn.addEventListener('click', () => {
            openSheet(btn.dataset.sheetUrl, btn.dataset.sheetTitle);
        });
    });

    overlay.addEventListener('click', closeSheet);
    close.addEventListener('click', closeSheet);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !root.classList.contains('hidden')) closeSheet();
    });
})();
</script>
@endsection
