<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? __('message.t_panel_title') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="hidden md:flex md:w-72 md:flex-col bg-white border-r border-slate-200">

        <div class="px-6 py-6 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo-fitxategi.png') }}" class="w-10 h-10" alt="Logo">
                <div>
                    <div class="font-extrabold text-lg leading-5">{{ __('message.t_role_teacher') }}</div>
                    <div class="text-xs text-slate-500">{{ __('message.t_panel_subtitle') }}</div>
                </div>
            </div>
        </div>

        <nav class="p-4 space-y-2 text-slate-700">

            <a href="{{ route('teacher.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('teacher.dashboard') ? 'bg-indigo-50 text-indigo-700 font-extrabold' : 'hover:bg-slate-50' }}">
                <i class="bi bi-person-plus"></i>
                <span>{{ __('message.t_nav_register_student') }}</span>
            </a>

            <a href="{{ route('teacher.students.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('teacher.students.*') ? 'bg-indigo-50 text-indigo-700 font-extrabold' : 'hover:bg-slate-50' }}">
                <i class="bi bi-people"></i>
                <span>{{ __('message.t_nav_manage_students') }}</span>
            </a>

            <a href="{{ route('teacher.attendance.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('teacher.attendance.*') ? 'bg-indigo-50 text-indigo-700 font-extrabold' : 'hover:bg-slate-50' }}">
                <i class="bi bi-check2-square"></i>
                <span>{{ __('message.t_nav_attendance') }}</span>
            </a>

            <a href="{{ route('teacher.absences.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('teacher.absences.*') ? 'bg-indigo-50 text-indigo-700 font-extrabold' : 'hover:bg-slate-50' }}">
                <i class="bi bi-calendar2-x"></i>
                <span>{{ __('message.t_nav_absences') }}</span>
            </a>

            <a href="{{ route('teacher.qr') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('teacher.qr*') ? 'bg-indigo-50 text-indigo-700 font-extrabold' : 'hover:bg-slate-50' }}">
                <i class="bi bi-qr-code"></i>
                <span>{{ __('message.t_nav_generate_qr') }}</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-4">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-200
                               text-red-600 font-extrabold hover:bg-red-50 transition">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>{{ __('message.logout') }}</span>
                </button>
            </form>

        </nav>

        <div class="mt-auto p-4 border-t border-slate-200 text-xs text-slate-500">
            {{ auth()->user()->email ?? '' }}
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1 min-w-0">

        {{-- TOPBAR --}}
        <header class="bg-white border-b border-slate-200">
            <div class="px-4 md:px-8 py-4 flex items-center justify-between">

                <div>
                    <div class="font-extrabold text-lg">{{ $title ?? __('message.t_panel_title') }}</div>
                    <div class="text-xs text-slate-500 hidden sm:block">
                        {{ __('message.t_panel_description') }}
                    </div>
                </div>

                <div class="flex items-center gap-6">

                    {{-- 🌍 SELECTOR DE IDIOMA --}}
                    <div class="flex gap-2">
                        <a href="{{ route('setLocale', 'es') }}">
                            <img src="{{ asset('img/español.png') }}" class="w-8 hover:scale-110 transition" alt="Español">
                        </a>
                        <a href="{{ route('setLocale', 'en') }}">
                            <img src="{{ asset('img/ingles.png') }}" class="w-8 hover:scale-110 transition" alt="English">
                        </a>
                        <a href="{{ route('setLocale', 'eu') }}">
                            <img src="{{ asset('img/euskera.png') }}" class="w-8 hover:scale-110 transition" alt="Euskera">
                        </a>
                    </div>

                    <div class="text-right">
                        <div class="text-sm font-extrabold">{{ auth()->user()->name ?? __('message.t_role_teacher') }}</div>
                        <div class="text-xs text-slate-500 hidden sm:block">{{ auth()->user()->email ?? '' }}</div>
                    </div>

                </div>

            </div>
        </header>

        <main class="p-4 md:p-8 pb-24 md:pb-8">
            <div class="w-full max-w-6xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
</div>

{{-- BOTTOM NAV MOBILE --}}
<nav class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 shadow z-50">
    <div class="max-w-md mx-auto px-4 py-2 flex items-center justify-between">

        <a href="{{ route('teacher.dashboard') }}"
           class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('teacher.dashboard') ? 'text-indigo-600 font-extrabold bg-indigo-50' : 'text-slate-600' }}">
            <i class="bi bi-person-plus text-xl"></i>
            <span class="text-[11px]">{{ __('message.t_nav_create') }}</span>
        </a>

        <a href="{{ route('teacher.students.index') }}"
           class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('teacher.students.*') ? 'text-indigo-600 font-extrabold bg-indigo-50' : 'text-slate-600' }}">
            <i class="bi bi-people text-xl"></i>
            <span class="text-[11px]">{{ __('message.t_nav_students') }}</span>
        </a>

        <a href="{{ route('teacher.attendance.index') }}"
           class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('teacher.attendance.*') ? 'text-indigo-600 font-extrabold bg-indigo-50' : 'text-slate-600' }}">
            <i class="bi bi-check2-square text-xl"></i>
            <span class="text-[11px]">{{ __('message.t_nav_attendance') }}</span>
        </a>

        <a href="{{ route('teacher.qr') }}"
           class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('teacher.qr*') ? 'text-indigo-600 font-extrabold bg-indigo-50' : 'text-slate-600' }}">
            <i class="bi bi-qr-code text-xl"></i>
            <span class="text-[11px]">QR</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl text-red-600">
                <i class="bi bi-box-arrow-right text-xl"></i>
                <span class="text-[11px]">{{ __('message.logout_short') }}</span>
            </button>
        </form>

    </div>
</nav>

</body>
</html>
