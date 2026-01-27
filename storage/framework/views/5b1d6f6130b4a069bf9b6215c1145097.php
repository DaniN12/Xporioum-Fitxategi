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
<body class="min-h-screen bg-slate-100">
    <div class="fixed inset-0 -z-10 bg-[#7f95ff]"> <!-- Fondo degradado azul QUITAR-->
        <div class="absolute inset-0 opacity-20 diagonal-pattern"></div>
    </div>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-sm">
            <div class="relative overflow-hidden rounded-[28px] bg-white shadow-2xl ring-1 ring-black/10 p-8 animate-fade-in">
                <div class="flex flex-col items-center mb-6">
                   <img src="<?php echo e(asset('images/logofitxategi.png')); ?>" alt="Logo Fitxategi" class="h-16 w-16 rounded-full shadow-lg mb-2 bg-white object-contain">
                    <h1 class="text-2xl font-bold text-gray-800">Iniciar sesión</h1>
                    <p class="text-gray-500 text-sm">Accede a tu cuenta de Fitxategi</p>
                </div>
                <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>
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
                    ¿No tienes cuenta? <a href="<?php echo e(route('register')); ?>" class="text-purple-600 font-bold hover:underline">Regístrate</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\Joane\UniServerZ\www\DaniN12-Xporioum-Fitxategi\resources\views/auth/login.blade.php ENDPATH**/ ?>