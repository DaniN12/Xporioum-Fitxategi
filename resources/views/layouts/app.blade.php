<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema')</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f0f2f5;
        }
        main {
            padding: 20px;
        }
    </style>
</head>
<body>

<main>
    @yield('content')
</main>

</body>
</html>
