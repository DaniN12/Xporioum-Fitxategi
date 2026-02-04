@extends('layouts.alumno')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#F7F9FE]">
    <div class="w-full max-w-xl bg-white rounded-2xl shadow-[0_25px_45px_rgba(15,23,42,0.12)] px-10 py-10 text-center">

        <img src="{{ asset('img/logo-fitxategi.png') }}" alt="Fitxategi" class="w-16 mx-auto mb-6">

        {{-- Título cambiado --}}
        <h1 class="text-[32px] font-serif font-semibold text-slate-800">
            Te damos la bienvenida a <span class="text-indigo-600">Fitxategi</span>
        </h1>

        {{-- Quitado el subtítulo --}}
        {{--
        <p class="text-sm text-slate-500 mt-2 mb-8">
            {{ __('message.fichar_subtitle') }}
        </p>
        --}}

        {{-- Mantengo el espacio para que no quede pegado --}}
        <div class="mt-8"></div>

        @if(session('success'))
            <div class="mb-4 p-3 rounded-xl bg-emerald-50 text-emerald-700 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 rounded-xl bg-red-50 text-red-700 font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-3">

            {{-- 1) Botón principal según estado --}}
            @if($estado === 'esperando_qr')
                <a href="{{ route('fichar.qr') }}"
                   class="block w-full h-12 rounded-xl bg-[#4338ca] text-white text-sm font-semibold
                          hover:bg-[#372fb3] transition shadow-sm leading-[48px]">
                    {{ __('message.fichar_btn_clock_in') }}
                </a>

            @elseif($estado === 'descanso')
                <form method="POST" action="{{ route('fichar.descanso') }}">
                    @csrf
                    <button type="submit"
                            class="w-full h-12 rounded-xl bg-[#4338ca] text-white text-sm font-semibold
                                   hover:bg-[#372fb3] transition shadow-sm">
                        {{ __('message.fichar_btn_break') }}
                    </button>
                </form>

            @elseif($estado === 'retomar')
                <form method="POST" action="{{ route('fichar.retomar') }}">
                    @csrf
                    <button type="submit"
                            class="w-full h-12 rounded-xl bg-[#4338ca] text-white text-sm font-semibold
                                   hover:bg-[#372fb3] transition shadow-sm">
                        {{ __('message.fichar_btn_resume') }}
                    </button>
                </form>

            @elseif($estado === 'salida')
                <form method="POST" action="{{ route('fichar.salida') }}">
                    @csrf
                    <button type="submit"
                            class="w-full h-12 rounded-xl bg-[#4338ca] text-white text-sm font-semibold
                                   hover:bg-[#372fb3] transition shadow-sm">
                        {{ __('message.fichar_btn_exit') }}
                    </button>
                </form>

            @elseif($estado === 'finalizado')
                <button disabled
                        class="w-full h-12 rounded-xl bg-slate-300 text-white text-sm font-semibold cursor-not-allowed">
                    {{ __('message.fichar_btn_finished') }}
                </button>
            @endif

            {{-- 2) Botón fijo: AUSENCIAS --}}
            <a href="{{ route('incidencias.create') }}"
               class="block w-full h-12 rounded-xl bg-slate-100 text-slate-700 text-sm font-semibold
                      hover:bg-slate-200 transition shadow-sm leading-[48px]">
                {{ __('message.fichar_btn_absences') }}
            </a>
        </div>

        {{-- Quitado el footer --}}
        {{--
        <p class="mt-8 text-xs text-slate-400 text-center">
            {{ __('message.fichar_footer') }}
        </p>
        --}}
    </div>
</div>
@endsection
