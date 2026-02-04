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

        {{-- ✅ Mostrar error si el QR es inválido/caducado --}}
        @if(session('error'))
            <p class="text-sm text-red-600 mb-3">{{ session('error') }}</p>
        @endif

        <div class="mx-auto w-full max-w-md rounded-2xl border border-slate-200 bg-slate-50/40
                    h-56 flex items-center justify-center mb-4 overflow-hidden">

            <div id="reader" class="w-full h-full flex items-center justify-center">
                <span class="text-sm text-slate-400">{{ __('message.qr_camera_preview') }}</span>
            </div>
        </div>

        <p id="msgCam" class="text-xs text-slate-500 mb-6">
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

@endsection


@section('scripts')
<script src="{{ asset('js/html5-qrcode.min.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {

  const btn = document.getElementById('btnActivarCamara');
  const msg = document.getElementById('msgCam');
  const readerEl = document.getElementById('reader');

  let html5QrCode = null;
  let running = false;
  let processing = false;

  // Devuelve SOLO el token (aunque venga dentro de una URL /qr/{token})
  function extraerTokenDesdeTexto(texto) {
      const m = texto.match(/\/qr\/([0-9a-fA-F-]{20,})/);
      if (m && m[1]) return m[1];

      const m2 = texto.match(/[0-9a-fA-F-]{20,}/);
      if (m2) return m2[0];

      return null;
  }

  async function iniciarCamara() {
      if (running) return;

      if (typeof Html5Qrcode === "undefined") {
          msg.textContent = "La librería QR no cargó. Revisa public/js/html5-qrcode.min.js";
          return;
      }

      msg.textContent = "Buscando cámara...";
      btn.disabled = true;
      readerEl.innerHTML = "";

      try {
          const cameras = await Html5Qrcode.getCameras();

          if (!cameras || cameras.length === 0) {
              msg.textContent = "No se detectó ninguna webcam.";
              btn.disabled = false;
              return;
          }

          const cameraId = cameras[0].id;

          html5QrCode = new Html5Qrcode("reader");

          await html5QrCode.start(
              { deviceId: { exact: cameraId } },
              { fps: 10, qrbox: { width: 250, height: 250 } },
              async (decodedText) => {
                  if (processing) return;

                  const token = extraerTokenDesdeTexto(decodedText);
                  if (!token) return;

                  processing = true;
                  msg.textContent = "QR detectado";

                  try {
                      await html5QrCode.stop();
                      await html5QrCode.clear();
                  } catch (e) {
                      // no rompemos nada si falla el stop/clear
                  }

                  document.getElementById('tokenInput').value = token;
                  document.getElementById('formValidar').submit();
              }
          );

          running = true;
          processing = false;
          msg.textContent = "Cámara activa";
          btn.textContent = "Cámara activa";
          btn.disabled = false; // ✅ por si quieres permitir reinicio manual

      } catch (e) {
          console.error(e);
          msg.textContent = "Error accediendo a la cámara. Revisa permisos del navegador.";
          btn.disabled = false;
          running = false;
          processing = false;
      }
  }

  btn.addEventListener('click', iniciarCamara);
});
</script>
@endsection
