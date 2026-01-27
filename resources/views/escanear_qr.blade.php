<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escanear QR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center px-6
             bg-gradient-to-br from-indigo-400 via-purple-400 to-pink-400 text-gray-900">

    <div class="w-full max-w-md text-center space-y-8">

        {{-- TÍTULO --}}
        <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 text-white drop-shadow-lg">Escanear código QR</h1>
        <p class="text-white/90 mb-6">Permite la cámara y apunta al QR del profesor.</p>

        {{-- MENSAJE DE ERROR --}}
        @if(session('error'))
            <div class="p-3 rounded-2xl bg-red-100/80 text-red-800 font-semibold shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        {{-- CONTENEDOR DEL ESCÁNER --}}
        <div class="rounded-3xl border border-white/20 bg-white/10 backdrop-blur-lg p-6 shadow-2xl hover:shadow-3xl transition-shadow duration-300">
            <div id="reader" class="mx-auto" style="width: 100%; max-width: 320px;"></div>
        </div>

        <div id="status" class="mt-3 text-sm text-white/80 font-medium drop-shadow">
            Iniciando cámara…
        </div>

        {{-- BOTONES --}}
        <div class="mt-6 flex flex-col gap-4">

            {{-- BOTÓN ACTIVAR --}}
            <button id="btnStart"
                class="w-full rounded-full bg-white text-gray-700 font-bold text-lg sm:text-xl py-4 shadow-lg
                       hover:scale-105 hover:shadow-2xl hover:bg-gray-100 transition-transform duration-300 hidden">
                Activar cámara
            </button>

            {{-- BOTÓN VOLVER --}}
            <a href="{{ route('fichar.vista') }}"
               class="w-full rounded-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
                      text-white font-bold text-lg sm:text-xl py-4 shadow-lg
                      shadow-lg shadow-indigo-200
                      hover:scale-105 hover:shadow-2xl hover:bg-gray-100 transition-transform duration-300">
                Volver
            </a>
        </div>

        <form id="qrForm" action="{{ route('fichar.qr.validar') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="token" id="token">
        </form>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const statusEl = document.getElementById('status');
        const btnStart = document.getElementById('btnStart');
        const form = document.getElementById('qrForm');
        const tokenInput = document.getElementById('token');

        let qr = null;
        let running = false;

        function onScanSuccess(decodedText) {
            if (!running) return;
            running = false;
            statusEl.textContent = "QR detectado. Registrando…";
            tokenInput.value = decodedText;
            try { qr.stop(); } catch(e) {}
            form.submit();
        }

        async function startCamera() {
            statusEl.textContent = "Solicitando permiso de cámara…";
            btnStart.classList.add('hidden');

            if (!qr) qr = new Html5Qrcode("reader");

            try {
                const cameras = await Html5Qrcode.getCameras();
                if (!cameras || cameras.length === 0) {
                    statusEl.textContent = "No se detectó cámara.";
                    return;
                }

                await qr.start(
                    { facingMode: "environment" },
                    { fps: 10, qrbox: 250 },
                    onScanSuccess
                );

                running = true;
                statusEl.textContent = "Cámara activa. Escanea el QR del profesor.";
            } catch (err) {
                console.error(err);
                statusEl.textContent = "No se pudo acceder a la cámara. Pulsa 'Activar cámara'.";
                btnStart.classList.remove('hidden');
            }
        }

        btnStart.addEventListener('click', startCamera);
        window.addEventListener('load', startCamera);
    </script>
</body>
</html>
