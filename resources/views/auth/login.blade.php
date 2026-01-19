<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Login</title>
    <style>
        body { background-color: #9ab4ff; margin: 0; font-family: 'Arial', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .login-card {
            background: white; width: 90%; max-width: 800px; border-radius: 40px;
            display: flex; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.2); border: 8px solid black;
        }
        .left-side { width: 50%; padding: 40px; display: flex; align-items: center; justify-content: center; border-right: 4px solid #eee; }
        .right-side { width: 50%; padding: 50px; position: relative; }
        .lang-icons { position: absolute; top: 20px; right: 20px; display: flex; gap: 10px; }
        .lang-icons img { width: 30px; border-radius: 50%; border: 2px solid #ddd; }
        h2 { font-size: 32px; margin-bottom: 5px; font-weight: 900; }
        p { color: #666; margin-bottom: 30px; }
        .input-group { margin-bottom: 20px; text-align: left; }
        label { display: block; font-weight: bold; margin-bottom: 8px; font-size: 18px; }
        input { width: 100%; padding: 15px; border: 2px solid #ddd; border-radius: 15px; box-sizing: border-box; font-size: 16px; }
        .btn-login { width: 100%; padding: 20px; background: black; color: white; border: none; border-radius: 15px; font-size: 20px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .link-register { display: block; margin-top: 20px; text-align: center; color: #555; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="left-side">
            <img src="{{ asset('img/logo_conejo.png') }}" alt="Fitxategi Logo" style="width: 100%; max-width: 300px;">
        </div>
        <div class="right-side">
            <div class="lang-icons">
                <span>🇪🇸</span> <span>🚩</span>
            </div>
            <h2>Bienvenido a Fitxategi</h2>
            <p>Inicie sesión para continuar</p>

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label>Email:</label>
                    <input type="email" name="email" required placeholder="tu@email.com">
                </div>
                <div class="input-group">
                    <label>Contraseña:</label>
                    <input type="password" name="password" required placeholder="********">
                </div>
                <button type="submit" class="btn-login">Entrar</button>
                <a href="{{ route('register') }}" class="link-register">¿No tienes cuenta? Regístrate aquí</a>
            </form>
        </div>
    </div>
</body>
</html>
