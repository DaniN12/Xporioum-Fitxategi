<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Fitxategi</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            width: 420px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        h1 {
            color: #000000;
            margin-bottom: 10px;
            font-size: 28px;
        }

        h2 {
            color: #000000;
            margin-bottom: 30px;
            font-size: 18px;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 6px;
            font-weight: bold;
            color: #000000;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 2px solid #000000;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #000000;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            color: #ffffff;
        }

        button:hover {
            background: #ffffff;
            color: #000000;
            border: 2px solid #000000;
        }
    </style>
</head>

<body class="">
        <div class="">
            <div class="logo-img">
                    <img class="w-100" src="img/logo fitxategi.png" alt="logo">
            </div>
        </div>


    <div class="container">
    <h1>Bienvenido a Fitxategi</h1>
    <h2>Inicie sesión</h2>

    <form>
        <label>Email:</label>
        <input type="email" placeholder="Introduce tu email">

        <label>Contraseña:</label>
        <input type="password" placeholder="Introduce tu contraseña">

        <button type="submit">Entrar</button>
    </form>
</div>



</body>
</html>
