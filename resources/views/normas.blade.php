<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Normas</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .diagonal-pattern { background-image: repeating-linear-gradient(135deg, rgba(255,255,255,.35) 0 2px, transparent 2px 32px); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); }
        .nav-active { position: relative; }
        .nav-active::after { content: ''; position: absolute; bottom: -12px; left: 50%; transform: translateX(-50%); width: 24px; height: 3px; background: white; border-radius: 2px; }
        .accordion-content { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .accordion-content.active { max-height: 500px; }
    </style>
</head>

<body class="min-h-screen bg-slate-100">
    <div class="fixed inset-0 -z-10 bg-[#7f95ff]">
        <div class="absolute inset-0 opacity-20 diagonal-pattern"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-sm sm:max-w-md md:max-w-6xl">
            <div class="relative overflow-hidden rounded-[28px] bg-white shadow-2xl ring-1 ring-black/10">

                <!-- HEADER -->
                <header class="h-14 bg-gradient-to-r from-gray-900 to-black text-white flex items-center justify-between px-4">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-xl shadow-lg">🐰</div>
                        <div class="hidden sm:block">
                            <div class="font-bold text-sm">Fitxategi</div>
                            <div class="text-xs text-gray-400">Control horario</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex items-center gap-2 text-xs bg-white/10 rounded-full px-3 py-1">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                            <span>En línea</span>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="h-8 w-8 rounded-full bg-white/10 hover:bg-white/20 transition flex items-center justify-center" title="Cerrar sesión">🚪</button>
                        </form>
                    </div>
                </header>

                <!-- MAIN -->
                <main class="bg-[#f2dcff] p-6 md:p-10 min-h-[520px]">
                    <div class="max-w-5xl mx-auto space-y-6 animate-fade-in">

                        <!-- TÍTULO -->
                        <div class="text-center mb-6">
                            <div class="text-5xl mb-3">📋</div>
                            <h1 class="text-3xl font-bold text-gray-800">Normas de fichaje</h1>
                            <p class="text-gray-600 mt-2">Consulta las reglas y políticas de control horario</p>
                        </div>

                        <!-- INFO -->
                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-lg p-6 text-white">
                            <div class="flex items-start gap-4">
                                <div class="text-3xl">ℹ️</div>
                                <div>
                                    <h3 class="font-bold text-lg mb-2">Importante</h3>
                                    <p class="text-sm opacity-90">
                                        El cumplimiento de estas normas es obligatorio para todos los empleados.
                                        Ante cualquier duda, contacta con Recursos Humanos.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- ACORDEÓN -->
                        <div class="space-y-3">
                            @foreach($normas as $i => $norma)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                                <button class="accordion-btn w-full p-5 flex items-center justify-between hover:bg-gray-50 transition" onclick="toggleAccordion(this)">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-xl">{{ $i+1 }}</div>
                                        <span class="font-bold">{{ $norma['titulo'] }}</span>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div class="accordion-content bg-gray-50 px-5 pb-5">
                                    <ul class="space-y-2 text-sm text-gray-700 pt-3">
                                        @foreach($norma['puntos'] as $punto)
                                            <li>• {{ $punto }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- BLOQUE DOCUMENTO + FIRMA -->
                        <div class="bg-white rounded-2xl shadow-md p-6">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h2 class="text-xl font-extrabold text-gray-900">Documento de normas (PDF)</h2>
                                    <p class="text-gray-500 text-sm mt-1">Firma el documento para que se guarde en “Mis documentos”.</p>
                                </div>

                                <span id="estadoFirma"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold border
                                           bg-amber-50 text-amber-700 border-amber-200">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    Pendiente
                                </span>
                            </div>

                            <div class="mt-5 grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <div class="lg:col-span-2">
                                    <div class="bg-gray-50 border rounded-2xl p-4">
                                        <iframe src="{{ asset('norma/Contrato.pdf') }}"
                                                class="w-full h-[520px] border rounded-xl"></iframe>
                                    </div>
                                </div>

                                <div>
                                    <div class="bg-white border rounded-2xl p-5 shadow-sm">
                                        <h3 class="text-lg font-extrabold text-gray-900">Acciones</h3>
                                        <p class="text-gray-500 mt-2">Elige una opción:</p>

                                        <div class="mt-4 grid grid-cols-1 gap-3">
                                            <button type="button"
                                                class="w-full py-3 rounded-xl font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 transition"
                                                onclick="openSignature()">
                                                Firmar
                                            </button>

                                            <a href="{{ asset('norma/Contrato.pdf') }}" target="_blank"
                                               class="w-full py-3 text-center rounded-xl font-extrabold bg-gray-100 hover:bg-gray-200 transition">
                                                Descargar PDF base
                                            </a>
                                        </div>

                                        <div class="mt-4 bg-gray-50 border rounded-xl p-4 text-sm text-gray-600">
                                            <span class="font-bold">Nota:</span>
                                            Al firmar guardaremos el PDF firmado en Mis documentos.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DUDAS -->
                        <div class="bg-white rounded-2xl shadow-md p-6 text-center">
                            <div class="text-3xl mb-3">💬</div>
                            <h3 class="font-bold text-gray-800 mb-2">¿Tienes dudas?</h3>
                            <p class="text-sm text-gray-600 mb-4">Nuestro equipo de RRHH está disponible para ayudarte</p>
                            <a href="mailto:rrhh@empresa.com" class="bg-gradient-to-r from-purple-500 to-purple-700 text-white font-bold py-3 px-6 rounded-xl hover:shadow-lg transition">
                                Contactar con RRHH
                            </a>
                        </div>

                    </div>
                </main>

            </div>
        </div>
    </div>

    <!-- MODAL FIRMA -->
    <div id="signatureModal"
         class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-xl">
            <h2 class="text-xl font-bold mb-4">Firmar documento</h2>

            <canvas id="signaturePad"
                    class="border rounded-xl w-full h-64 bg-gray-50"></canvas>

            <div class="flex justify-between mt-4 gap-3">
                <button onclick="clearSignature()"
                        class="px-4 py-2 bg-gray-200 rounded-lg font-bold w-1/2">
                    Limpiar
                </button>

                <button onclick="saveSignature()"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-bold w-1/2">
                    Guardar firma
                </button>
            </div>
        </div>
    </div>

    <script>
        // ACORDEÓN
        function toggleAccordion(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');
            const allContents = document.querySelectorAll('.accordion-content');
            const allIcons = document.querySelectorAll('.accordion-btn svg');

            allContents.forEach(item => { if (item !== content) { item.classList.remove('active'); } });
            allIcons.forEach(item => { if (item !== icon) { item.style.transform = 'rotate(0deg)'; } });

            content.classList.toggle('active');
            icon.style.transform = content.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
        }

        // FIRMA
        let canvas = null;
        let ctx = null;
        let drawing = false;

        function openSignature() {
            document.getElementById('signatureModal').classList.remove('hidden');
        }

        function clearSignature() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        async function saveSignature() {
            const signatureData = canvas.toDataURL("image/png");

            const res = await fetch("{{ route('alumno.normas.firmar') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                body: JSON.stringify({ signature: signatureData })
            });

            const data = await res.json().catch(() => ({}));

            if (!res.ok) {
                alert(data.message || "Error al firmar");
                return;
            }

            document.getElementById('estadoFirma').innerHTML = `
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                Completado
            `;
            document.getElementById('estadoFirma').className =
                "inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold border bg-green-50 text-green-700 border-green-200";

            document.getElementById('signatureModal').classList.add('hidden');

            window.location.href = "{{ route('alumno.documentos') }}";
        }

        window.onload = () => {
            canvas = document.getElementById("signaturePad");
            ctx = canvas.getContext("2d");

            canvas.addEventListener("mousedown", () => drawing = true);
            canvas.addEventListener("mouseup", () => {
                drawing = false;
                ctx.beginPath();
            });
            canvas.addEventListener("mousemove", (e) => {
                if (!drawing) return;
                ctx.lineWidth = 2;
                ctx.lineCap = "round";
                ctx.strokeStyle = "#000";
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.stroke();
                ctx.beginPath();
                ctx.moveTo(e.offsetX, e.offsetY);
            });
        };
    </script>
</body>
</html>
