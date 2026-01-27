<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .diagonal-pattern {
            background-image: repeating-linear-gradient(135deg, rgba(255,255,255,.35) 0 2px, transparent 2px 32px);
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center">
    <div class="fixed inset-0 -z-10 bg-[#7f95ff]">
        <div class="absolute inset-0 opacity-20 diagonal-pattern"></div>
    </div>
    <div class="w-full max-w-md mx-auto p-6 animate-fade-in">
        <div class="bg-white rounded-3xl shadow-2xl p-8 flex flex-col items-center">
            <img src="{{ asset('images/fitxategi.png') }}" alt="Logo Fitxategi" class="w-24 h-24 mb-4 rounded-full shadow-lg bg-white object-contain">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Crear cuenta en Fitxategi</h1>
            <p class="text-gray-500 mb-6 text-center">Regístrate para acceder al control horario</p>
            <form method="POST" action="{{ route('register') }}" class="w-full space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre completo</label>
                    <input id="name" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                    <input id="password_confirmation" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold py-3 rounded-xl shadow-lg hover:from-purple-600 hover:to-pink-600 transition">Registrarse</button>
            </form>
            <div class="mt-6 text-sm text-gray-500">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-purple-600 hover:underline">Inicia sesión</a>
            </div>
        </div>
        <div class="text-center text-xs text-gray-400 mt-6">
            <p>Fitxategi &copy; 2026</p>
        </div>
    </div>
</body>
</html>
