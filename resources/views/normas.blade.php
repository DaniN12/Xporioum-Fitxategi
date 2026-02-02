<!-- Vista moderna de normas -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Normas</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        <div class="w-full max-w-sm sm:max-w-md md:max-w-4xl">
            <div class="relative overflow-hidden rounded-[28px] bg-white shadow-2xl ring-1 ring-black/10">
                <!-- Header -->
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
                <!-- Nav desktop -->

                <!-- Contenido principal -->
                <main class="bg-[#f2dcff] p-6 md:p-10 min-h-[520px]">
                    <div class="max-w-3xl mx-auto space-y-6 animate-fade-in">
                        <div class="text-center mb-8">
                            <div class="text-5xl mb-3">📋</div>
                            <h1 class="text-3xl font-bold text-gray-800">Normas de fichaje</h1>
                            <p class="text-gray-600 mt-2">Consulta las reglas y políticas de control horario</p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-lg p-6 text-white">
                            <div class="flex items-start gap-4">
                                <div class="text-3xl">ℹ️</div>
                                <div>
                                    <h3 class="font-bold text-lg mb-2">Importante</h3>
                                    <p class="text-sm opacity-90">El cumplimiento de estas normas es obligatorio para todos los empleados. Ante cualquier duda, contacta con Recursos Humanos.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Acordeones de normas -->
                        <div class="space-y-3">
                            @foreach($normas as $i => $norma)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                                <button class="accordion-btn w-full p-5 flex items-center justify-between hover:bg-gray-50 transition" onclick="toggleAccordion(this)">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-xl">{{ $i+1 }}</div>
                                        <span class="font-bold">{{ $norma['titulo'] }}</span>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
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
                        <div class="bg-white rounded-2xl shadow-md p-6 text-center">
                            <div class="text-3xl mb-3">💬</div>
                            <h3 class="font-bold text-gray-800 mb-2">¿Tienes dudas?</h3>
                            <p class="text-sm text-gray-600 mb-4">Nuestro equipo de RRHH está disponible para ayudarte</p>
                            <a href="mailto:rrhh@empresa.com" class="bg-gradient-to-r from-purple-500 to-purple-700 text-white font-bold py-3 px-6 rounded-xl hover:shadow-lg transition">Contactar con RRHH</a>
                        </div>
                    </div>
                </main>
                <!-- Bottom nav móvil -->

            </div>
        </div>
    </div>
    <script>
        function toggleAccordion(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');
            const allContents = document.querySelectorAll('.accordion-content');
            const allIcons = document.querySelectorAll('.accordion-btn svg');
            allContents.forEach(item => { if (item !== content) { item.classList.remove('active'); } });
            allIcons.forEach(item => { if (item !== icon) { item.style.transform = 'rotate(0deg)'; } });
            content.classList.toggle('active');
            if (content.classList.contains('active')) { icon.style.transform = 'rotate(180deg)'; } else { icon.style.transform = 'rotate(0deg)'; }
        }
    </script>
</body>
</html>
