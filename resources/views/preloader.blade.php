<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargando...</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div id="preloader">
    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="fade" style="max-width: 160px; margin-bottom: 15px;">
    <img src="{{ asset('img/logo-nombre.png') }}" alt="Logo con nombre" class="fade" style="max-width: 260px;">
    <div class="spinner"></div>
</div>

<script>
    setTimeout(() => {
        window.location.href = "{{ route('login.form') }}";
    }, 1800);
</script>

</body>
</html>
