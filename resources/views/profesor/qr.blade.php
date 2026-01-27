<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor - QR</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-slate-950 text-white flex items-center justify-center px-6">
    <div class="w-full max-w-md bg-white/5 border border-white/10 rounded-2xl p-6 text-center">
        <h1 class="text-2xl font-bold mb-2">QR de entrada</h1>
        <p class="text-white/70 mb-6">Se regenera automáticamente cada 5 segundos.</p>

        <div class="bg-white rounded-2xl p-4 inline-block">
            <canvas id="qrCanvas"></canvas>
        </div>

        <div id="info" class="mt-4 text-sm text-white/70">Generando…</div>

        <div class="mt-6 space-y-3">
            <a href="{{ route('profesor.dashboard') }}" class="block w-full bg-white/10 hover:bg-white/15 rounded-xl py-3 font-semibold border border-white/10">
                Volver
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script>
        const info = document.getElementById('info');
        const canvas = document.getElementById('qrCanvas');

        async function generar() {
            info.textContent = "Generando token…";
            const res = await fetch("{{ route('profesor.qr.generar') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({})
            });

            const data = await res.json();
            if (data.error) {
                info.textContent = data.error;
                return;
            }

            await QRCode.toCanvas(canvas, data.token, { width: 240 });
            info.textContent = "Válido hasta: " + data.expires_at;
        }

        // primera vez + cada 5s
        generar();
        setInterval(generar, 5000);
    </script>
</body>
</html>
