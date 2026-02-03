@extends('layout.masterpage')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-[#F7F9FE] relative overflow-hidden">

    <div class="absolute top-6 right-6 flex gap-2 z-20">
        <a href="{{ route('setLocale', 'es') }}">
            <img src="{{ asset('img/español.png') }}" class="w-10 hover:scale-110 transition-transform" alt="Español">
        </a>
        <a href="{{ route('setLocale', 'en') }}">
            <img src="{{ asset('img/ingles.png') }}" class="w-10 hover:scale-110 transition-transform" alt="English">
        </a>
        <a href="{{ route('setLocale', 'eu') }}">
            <img src="{{ asset('img/euskera.png') }}" class="w-10 hover:scale-110 transition-transform" alt="Euskera">
        </a>
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
            {{ __('message.qr_title') }}
        </h1>

        <p class="text-sm text-slate-500 mt-2 mb-8">
            {{ __('message.qr_subtitle') }}
        </p>

        <div class="mx-auto w-full max-w-md rounded-2xl border border-slate-200 bg-slate-50/40
                    h-32 flex items-center justify-center mb-4 overflow-hidden">

            <div id="reader" class="w-full h-full flex items-center justify-center">
                <span class="text-sm text-slate-400">{{ __('message.qr_camera_preview') }}</span>
            </div>
        </div>

        <p id="msgCam" class="text-xs text-slate-500 mb-8">
            {{ __('message.qr_camera_error_initial') }}
        </p>

        <div class="space-y-3">
            <button type="button"
                    id="btnActivarCamara"
                    class="w-full h-12 rounded-xl bg-[#4338ca] text-white text-sm font-semibold
                           hover:bg-[#372fb3] transition shadow-sm">
                {{ __('message.qr_activate_camera') }}
            </button>

            <a href="{{ url()->previous() }}"
               class="block w-full h-12 rounded-xl bg-slate-100 text-slate-700 text-sm font-semibold
                      hover:bg-slate-200 transition leading-[48px]">
                {{ __('message.qr_back') }}
            </a>
        </div>

        <p class="mt-8 text-xs text-slate-400 text-center">
            {{ __('message.qr_footer') }}
        </p>

        <form id="formValidar" method="POST" action="{{ route('fichar.qr.validar') }}" class="hidden">
            @csrf
            <input type="hidden" name="token" id="tokenInput">
        </form>

    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.10/html5-qrcode.min.js"></script>

<script>
const btn = document.getElementById('btnActivarCamara');
const msg = document.getElementById('msgCam');
const readerEl = document.getElementById('reader');

let html5QrCode = null;
let running = false;

function extraerTokenDesdeTexto(texto) {
    const m = texto.match(/\/qr\/([0-9a-fA-F-]{20,})/);
    if (m && m[1]) return { type: 'url', token: m[1], url: texto };

    const m2 = texto.match(/[0-9a-fA-F-]{20,}/);
    if (m2) return { type: 'token', token: m2[0] };

    return null;
}

async function iniciarCamara() {
    if (running) return;

    msg.textContent = "{{ __('message.qr_camera_starting') }}";
    btn.disabled = true;
    readerEl.innerHTML = "";

    html5QrCode = new Html5Qrcode("reader");

    try {
        const config = { fps: 10, qrbox: { width: 220, height: 220 } };

        await html5QrCode.start(
            { facingMode: "environment" },
            config,
            (decodedText) => {
                const info = extraerTokenDesdeTexto(decodedText);
                if (!info) return;

                running = false;
                html5QrCode.stop().catch(() => {});
                html5QrCode.clear().catch(() => {});

                msg.textContent = "{{ __('message.qr_detected') }}";

                if (info.type === 'url') {
                    window.location.href = decodedText;
                    return;
                }

                document.getElementById('tokenInput').value = info.token;
                document.getElementById('formValidar').submit();
            }
        );

        running = true;
        msg.textContent = "{{ __('message.qr_camera_active') }}";
        btn.textContent = "{{ __('message.qr_camera_active_btn') }}";

    } catch (e) {
        console.error(e);
        msg.textContent = "{{ __('message.qr_camera_error') }}";
        btn.disabled = false;
        readerEl.innerHTML = '<span class="text-sm text-slate-400">{{ __('message.qr_camera_preview') }}</span>';
    }
}

btn.addEventListener('click', iniciarCamara);
</script>

@endsection
