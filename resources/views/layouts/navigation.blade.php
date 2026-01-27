<nav x-data="{ open: false }" class="bg-gradient-to-r from-[#d7a6ff] to-[#e5b8ff] shadow">
    <div class="max-w-7xl mx-auto px-4">

        <div class="flex justify-between h-14 items-center">

            <!-- Logo -->
            <div class="flex items-center gap-2 font-bold">
                🐰 <span>Fitxategi</span>
            </div>

            <!-- Desktop menu -->
            <div class="hidden sm:flex gap-8 font-semibold">

                <a href="{{ route('profile.edit') }}"
                   class="{{ request()->routeIs('profile.*') ? 'underline text-purple-700' : '' }}">
                    Perfil
                </a>

                <a href="{{ route('horas') }}"
                   class="{{ request()->routeIs('horas') ? 'underline text-purple-700' : '' }}">
                    Tus horas
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="hover:underline">
                        Cerrar sesión
                    </button>
                </form>

            </div>

            <!-- Hamburger -->
            <div class="sm:hidden">
                <button @click="open = !open" class="text-gray-700">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" class="sm:hidden px-4 pb-4 space-y-2 font-semibold">

        <a href="{{ route('profile.edit') }}" class="block">
            Perfil
        </a>

        <a href="{{ route('horas') }}" class="block">
            Tus horas
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="block w-full text-left">
                Cerrar sesión
            </button>
        </form>

    </div>
</nav>
