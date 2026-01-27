<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Incidencia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .diagonal-pattern {
            background-image: repeating-linear-gradient(
                135deg,
                rgba(255,255,255,.35) 0 2px,
                transparent 2px 32px
            );
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        .nav-active {
            position: relative;
        }
        .nav-active::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 3px;
            background: white;
            border-radius: 2px;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 to-blue-100 flex flex-col">
    <div class="fixed inset-0 -z-10 bg-[#FFFFFF]">
        <div class="absolute inset-0 opacity-20 diagonal-pattern"></div>
    </div>

    <div class="flex-1 flex flex-col w-full">
        <header class="h-14 flex-none bg-gradient-to-r from-gray-900 to-black text-white flex items-center justify-between px-4 z-10">
            <div class="flex items-center gap-3">
                <img src="<?php echo e(asset('images/fitxategi.png')); ?>" alt="Logo Fitxategi" class="h-9 w-9 rounded-full shadow-lg object-contain bg-white">

                <div class="hidden xs:block">
                    <div class="font-bold text-sm text-white">Fitxategi</div>
                    <div class="text-xs text-gray-400">Control horario</div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button class="h-8 w-8 rounded-full overflow-hidden hover:scale-110 transition shadow-sm border border-white/10">
                    <img src="<?php echo e(asset('images/euskalherria.png')); ?>" class="w-full h-full object-cover">
                </button>
                <button class="h-8 w-8 rounded-full overflow-hidden hover:scale-110 transition shadow-sm border border-white/10">
                    <img src="<?php echo e(asset('images/españa.png')); ?>" class="w-full h-full object-cover">
                </button>
            </div>
        </header>

        <nav class="hidden md:flex flex-none items-center justify-center gap-10 bg-gradient-to-r from-[#d7a6ff] to-[#e5b8ff] py-3 font-bold text-black shadow-sm">
            <a href="<?php echo e(url('/perfil')); ?>" class="<?php echo e(request()->is('perfil*') ? 'nav-active' : ''); ?> hover:text-purple-800 transition">Perfil</a>
            <a href="<?php echo e(route('normas.index')); ?>" class="<?php echo e(request()->is('normas*') ? 'nav-active' : ''); ?> hover:text-purple-800 transition">Normas</a>
            <a href="<?php echo e(url('/incidencias')); ?>" class="<?php echo e(request()->is('incidencias*') ? 'nav-active' : ''); ?> hover:text-purple-800 transition">Incidencias</a>
            <a href="<?php echo e(url('/fichaje')); ?>" class="<?php echo e(request()->is('fichaje*') ? 'nav-active' : ''); ?> hover:text-purple-800 transition">Fichar</a>
            <a href="<?php echo e(url('/horas')); ?>" class="<?php echo e(request()->is('horas*') ? 'nav-active' : ''); ?> hover:text-purple-800 transition">Tus horas</a>
        </nav>

        <main class="bg-[#f2dcff] p-6 md:p-10 flex-1 pb-24">
            <div class="max-w-xl mx-auto space-y-6 animate-fade-in">

                <?php if(session('status')): ?>
                    <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl shadow-lg p-8 text-white text-center">
                        <div class="text-5xl mb-4">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div class="font-black text-2xl mb-4 uppercase tracking-tight"><?php echo e(session('status')); ?></div>
                        <a href="<?php echo e(route('incidencias.create')); ?>" class="inline-block bg-white text-green-700 font-black py-3 px-8 rounded-xl shadow-md hover:bg-green-50 transition active:scale-95">
                            HACER OTRA INCIDENCIA
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center mb-8">
                        <div class="text-5xl mb-3">📝</div>
                        <h1 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Registrar incidencia</h1>
                        <p class="text-gray-600 mt-2 font-medium">Justifica tu incidencia</p>
                    </div>

                    <form action="<?php echo e(route('incidencias.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
                        <?php echo csrf_field(); ?>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-purple-100 space-y-5">
                            <div>
                                <label class="block text-sm font-black text-gray-700 mb-2 uppercase tracking-wide">Fecha de la incidencia</label>
                                <input type="date" name="fecha" required class="w-full p-4 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-400 focus:border-transparent transition bg-gray-50 font-medium">
                            </div>
                            <div>
                                <label class="block text-sm font-black text-gray-700 mb-2 uppercase tracking-wide">Motivo detallado</label>
                                <textarea name="motivo" required rows="4" placeholder="Explica brevemente lo ocurrido..." class="w-full p-4 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-400 focus:border-transparent transition bg-gray-50 font-medium"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-black text-gray-700 mb-2 uppercase tracking-wide">Adjuntar justificante (opcional)</label>
                                <div class="flex items-center justify-center w-full">
                                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <span class="text-2xl mb-2">📁</span>
                                            <p class="text-xs text-gray-500 font-bold uppercase">Click para subir archivo</p>
                                        </div>
                                        <input type="file" name="adjunto" class="hidden" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-black text-white font-black py-5 rounded-2xl hover:bg-gray-800 transition-all active:scale-[0.98] shadow-xl uppercase tracking-widest">
                            Registrar ahora
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </main>

        <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-200 z-50">
            <div class="grid grid-cols-5 h-16">
                <a href="<?php echo e(url('/perfil')); ?>" class="flex flex-col items-center justify-center gap-1 <?php echo e(request()->is('perfil*') ? 'text-purple-600' : 'text-gray-400'); ?>">
                    <span class="text-xl">👤</span>
                    <span class="text-[10px] font-bold uppercase text-center">Perfil</span>
                </a>
                <a href="<?php echo e(route('normas.index')); ?>" class="flex flex-col items-center justify-center gap-1 <?php echo e(request()->is('normas*') ? 'text-purple-600' : 'text-gray-400'); ?>">
                    <span class="text-xl">📋</span>
                    <span class="text-[10px] font-bold uppercase text-center">Normas</span>
                </a>
                <a href="<?php echo e(url('/incidencias')); ?>" class="flex flex-col items-center justify-center gap-1 <?php echo e(request()->is('incidencias*') ? 'text-purple-600' : 'text-gray-400'); ?>">
                    <span class="text-xl">⚠️</span>
                    <span class="text-[10px] font-bold uppercase text-center">Incidencias</span>
                </a>
                <a href="<?php echo e(url('/fichaje')); ?>" class="flex flex-col items-center justify-center gap-1 <?php echo e(request()->is('fichaje*') ? 'text-purple-600' : 'text-gray-400'); ?>">
                    <span class="text-xl">⏱️</span>
                    <span class="text-[10px] font-bold uppercase text-center">Fichar</span>
                </a>
                <a href="<?php echo e(url('/horas')); ?>" class="flex flex-col items-center justify-center gap-1 <?php echo e(request()->is('horas*') ? 'text-purple-600' : 'text-gray-400'); ?>">
                    <span class="text-xl">📊</span>
                    <span class="text-[10px] font-bold uppercase text-center">Horas</span>
                </a>
            </div>
        </nav>
    </div>
</body>
</html>
<?php /**PATH D:\Joane\UniServerZ\www\Fitxategi-Joane\resources\views/incidencias/create.blade.php ENDPATH**/ ?>