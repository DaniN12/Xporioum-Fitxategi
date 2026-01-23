<!-- Dashboard moderno -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .diagonal-pattern { background-image: repeating-linear-gradient(135deg, rgba(255,255,255,.35) 0 2px, transparent 2px 32px); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); }
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
                <!-- Contenido principal -->
                <main class="bg-[#f2dcff] p-6 md:p-10 min-h-[520px]">
                    <div class="max-w-3xl mx-auto space-y-6 animate-fade-in">
                        <div class="text-center mb-8">
                            <div class="text-5xl mb-3">👋</div>
                            <h1 class="text-3xl font-bold text-gray-800">¡Bienvenido/a, {{ Auth::user()->name }}!</h1>
                            <p class="text-gray-600 mt-2">Accede rápidamente a tus secciones principales</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <a href="{{ route('profile.edit') }}" class="bg-white rounded-2xl shadow-md p-6 card-hover flex items-center gap-4">
                                <span class="text-3xl">👤</span>
                                <span class="font-bold text-lg">Perfil</span>
                            </a>
                            <a href="#" class="bg-white rounded-2xl shadow-md p-6 card-hover flex items-center gap-4">
                                <span class="text-3xl">📋</span>
                                <span class="font-bold text-lg">Normas</span>
                            </a>
                            <a href="#" class="bg-white rounded-2xl shadow-md p-6 card-hover flex items-center gap-4">
                                <span class="text-3xl">⏱️</span>
                                <span class="font-bold text-lg">Fichar</span>
                            </a>
                            <a href="{{ route('horas.usuario') }}" class="bg-white rounded-2xl shadow-md p-6 card-hover flex items-center gap-4">
                                <span class="text-3xl">📊</span>
                                <span class="font-bold text-lg">Tus horas</span>
                            </a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
</html>
