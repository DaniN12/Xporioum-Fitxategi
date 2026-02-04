<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi</title>

    {{-- Tailwind (Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')
</head>
<body>
    @yield('content')

    {{-- Scripts específicos de cada vista --}}
    @yield('scripts')
</body>
</html>
