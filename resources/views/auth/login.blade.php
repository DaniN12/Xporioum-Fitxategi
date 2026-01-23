<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Fitxategi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .diagonal-pattern {
            background-image: repeating-linear-gradient(135deg, rgba(255,255,255,.35) 0 2px, transparent 2px 32px);
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    </style>
</head>
<body class="min-h-screen w-screen h-screen bg-gradient-to-br from-purple-100 to-blue-100 flex flex-col">
    <!-- Fondo con patrón -->
    <div class="fixed inset-0 -z-10 bg-[#FFFFFF]">
        <div class="absolute inset-0 opacity-20 diagonal-pattern"></div>
    </div>
    <!-- Contenedor principal FULL SCREEN -->
    <div class="flex-1 flex flex-col items-stretch justify-stretch p-0 w-full h-full">
        <div class="w-full h-full flex flex-col items-center justify-center">
            <div class="relative overflow-hidden rounded-none bg-white shadow-2xl ring-1 ring-black/10 w-full h-full min-h-screen flex flex-col items-center justify-center">
                <div class="flex flex-col items-center mb-6">
                   <img src="{{ asset('images/logofitxategi.png') }}" alt="Logo Fitxategi" class="h-16 w-16 rounded-full shadow-lg mb-2 bg-white object-contain">
                    <h1 class="text-2xl font-bold text-gray-800">Iniciar sesión</h1>
                    <p class="text-gray-500 text-sm">Accede a tu cuenta de Fitxategi</p>
                </div>
                <form method="POST" action="{{ route('login') }}" class="space-y-5 w-full max-w-sm">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
                        <input type="password" name="password" required class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400">
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-purple-700 text-white font-bold py-3 rounded-xl hover:shadow-lg transition">Entrar</button>
                </form>
                <div class="text-center mt-6 text-sm text-gray-500">
                    ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-purple-600 font-bold hover:underline">Regístrate</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
