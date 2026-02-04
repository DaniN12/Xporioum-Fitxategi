@extends('layout.masterpage')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-[#F7F9FE] relative overflow-hidden">

<div class="fixed top-4 left-1/2 -translate-x-1/2 sm:left-auto sm:right-6 sm:translate-x-0 z-50">
    <div class="flex items-center gap-2 rounded-full bg-white/75 backdrop-blur px-3 py-2 shadow-lg border border-slate-200">
        @php $loc = app()->getLocale(); @endphp

        <a href="{{ route('setLocale', 'es') }}"
           class="rounded-full p-1 {{ $loc === 'es' ? 'ring-2 ring-indigo-500' : 'hover:ring-2 hover:ring-slate-300' }}"
           aria-label="Español">
            <img src="{{ asset('img/español.png') }}" class="w-8 h-8 sm:w-10 sm:h-10" alt="Español">
        </a>

        <a href="{{ route('setLocale', 'en') }}"
           class="rounded-full p-1 {{ $loc === 'en' ? 'ring-2 ring-indigo-500' : 'hover:ring-2 hover:ring-slate-300' }}"
           aria-label="English">
            <img src="{{ asset('img/ingles.png') }}" class="w-8 h-8 sm:w-10 sm:h-10" alt="English">
        </a>

        <a href="{{ route('setLocale', 'eu') }}"
           class="rounded-full p-1 {{ $loc === 'eu' ? 'ring-2 ring-indigo-500' : 'hover:ring-2 hover:ring-slate-300' }}"
           aria-label="Euskera">
            <img src="{{ asset('img/euskera.png') }}" class="w-8 h-8 sm:w-10 sm:h-10" alt="Euskera">
        </a>
    </div>
</div>


    <div class="absolute -left-72 -bottom-72 w-[750px] h-[750px] rounded-full
                bg-[radial-gradient(circle,rgba(236,72,153,0.12),transparent_65%)]">
    </div>

    <div class="absolute -right-72 -top-80 w-[750px] h-[750px] rounded-full
                bg-[radial-gradient(circle,rgba(91,127,232,0.16),transparent_65%)]">
    </div>

    <div class="relative z-10 w-full max-w-lg bg-white rounded-2xl
                shadow-[0_25px_45px_rgba(15,23,42,0.12)]
                px-12 py-12 text-center">

        <img src="{{ asset('img/logo-fitxategi.png') }}"
             alt="Fitxategi"
             class="w-16 mx-auto mb-6">

        <h1 class="text-[32px] font-serif font-semibold text-slate-800">
            {{ __('message.login_title') }}
        </h1>

       
        {{-- ERROR GENERAL LOGIN --}}
        @if(session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50
                        px-4 py-3 text-left text-red-700 font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="text-left">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    {{ __('message.email') }}
                </label>

                <div class="relative">
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="{{ __('message.email_placeholder') }}"
                           class="w-full h-12 px-4 pr-12 rounded-xl border text-sm
                                  focus:outline-none focus:ring-4
                                  @error('email')
                                      border-red-400 focus:ring-red-200
                                  @else
                                      border-slate-200 focus:ring-blue-200 focus:border-blue-400
                                  @enderror">

                    <img src="{{ asset('img/correo.png') }}"
                         alt="Email"
                         class="absolute right-4 top-1/2 -translate-y-1/2
                                h-5 object-contain opacity-70 pointer-events-none">
                </div>

                @error('email')
                    <p class="mt-1 text-sm text-red-600 font-semibold">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    {{ __('message.password') }}
                </label>

                <div class="relative">
                    <input type="password"
                           id="password"
                           name="contrasena"
                           placeholder="••••••••"
                           class="w-full h-12 px-4 pr-12 rounded-xl border text-sm
                                  focus:outline-none focus:ring-4
                                  @error('contrasena')
                                      border-red-400 focus:ring-red-200
                                  @else
                                      border-slate-200 focus:ring-blue-200 focus:border-blue-400
                                  @enderror">

                    <button type="button"
                            id="togglePassword"
                            class="absolute right-4 top-1/2 -translate-y-1/2
                                   hover:bg-slate-100 rounded-md p-1 transition"
                            aria-label="{{ __('message.show_password') }}">

                        <span class="w-5 h-5 flex items-center justify-center">
                            <img id="eyeIcon"
                                 src="{{ asset('img/ojo-cerrado.png') }}"
                                 alt=""
                                 class="w-full h-full object-contain opacity-80">
                        </span>
                    </button>
                </div>

                @error('contrasena')
                    <p class="mt-1 text-sm text-red-600 font-semibold">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full h-12 rounded-xl
                           bg-[#4338ca] text-white text-sm font-semibold
                           hover:bg-[#372fb3] transition">
                {{ __('message.login_button') }}
            </button>

        </form>

        

    </div>
</div>

@endsection

@section('scripts')
<script>
    (function () {
        const btn = document.getElementById('togglePassword');
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        const eyeOpen = "{{ asset('img/ojo.png') }}";
        const eyeClosed = "{{ asset('img/ojo-cerrado.png') }}";

        if (!btn || !input || !icon) return;

        btn.addEventListener('click', () => {
            const hidden = input.type === 'password';

            input.type = hidden ? 'text' : 'password';
            icon.src = hidden ? eyeOpen : eyeClosed;

            btn.setAttribute(
                'aria-label',
                hidden ? "{{ __('message.hide_password') }}" : "{{ __('message.show_password') }}"
            );
        });
    })();
</script>
@endsection
