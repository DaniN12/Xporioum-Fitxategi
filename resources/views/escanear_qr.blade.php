<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escanear QR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gray-900 text-white flex items-center justify-center px-6">
    <div class="w-full max-w-md text-center">

        <h1 class="text-2xl font-bold mb-3">Escanear código QR</h1>
        <p class="text-white/70 mb-6">Permite la cámara y apunta al QR del profesor.</p>

        @if(session('error'))
            <div class="mb-4 bg-red-600/20 border border-red-500/30 text-red-200 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        <div class="rounded-2xl border border-white/10 bg-black/30 p-3">
            <div id="reader" class="mx-auto" style="width: 100%; max-width: 320px;"></div>
        </div>

        <div id="status" class="mt-4 text-sm text-white/70">
            Iniciando cámara…
        </div>

        <div class="mt-5 flex flex-col gap-3">
            <button id="btnStart"
                class="w-full rounded-xl bg-indigo-600 hover:bg-indigo-700 transition px-4 py-3 font-semibold hidden">
                Activar cámara
            </button>

            <a href="{{ route('fichar.vista') }}"
               class="w-full rounded-xl bg-white/10 hover:bg-white/15 transition px-4 py-3 font-semibold border border-white/10">
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

        // auto start al cargar
        window.addEventListener('load', startCamera);
    </script>
</body>
</html>
