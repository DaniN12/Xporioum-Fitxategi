<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coworking San Luis - Panel</title>
    <style>
        body { background-color: #9ab4ff; margin: 0; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .app-container {
            width: 360px; height: 740px; background: #f8f9fa; border: 12px solid #000; border-radius: 55px;
            position: relative; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 30px 60px rgba(0,0,0,0.4);
        }
        /* Cabecera */
        .header { background: #000; color: white; padding: 40px 20px 20px; text-align: center; border-bottom-left-radius: 30px; border-bottom-right-radius: 30px; }
        .header h1 { margin: 0; font-size: 22px; text-transform: uppercase; letter-spacing: 1px; }

        /* Botón de Entrada/Salida (Reto Principal) */
        .check-container { padding: 30px 20px; text-align: center; }
        .btn-check {
            width: 140px; height: 140px; border-radius: 50%; border: none;
            background: #28a745; color: white; font-size: 18px; font-weight: bold;
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.4); cursor: pointer; transition: 0.3s;
        }
        .btn-check:active { transform: scale(0.9); }

        /* Menú de Opciones */
        .menu-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; padding: 20px; }
        .menu-item {
            background: white; padding: 20px; border-radius: 20px; text-align: center;
            text-decoration: none; color: #333; font-weight: bold; font-size: 14px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: 0.3s;
        }
        .menu-item:hover { background: #000; color: white; }
        .icon { font-size: 24px; display: block; margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="app-container">
        <div class="header">
            <h1>San Luis Coworking</h1>
        </div>

        <div class="check-container">
            <button class="btn-check">REGISTRAR<br>ENTRADA</button>
            <p style="color: #666; margin-top: 15px; font-weight: 500;">Estado: Fuera del centro</p>
        </div>

        <div class="menu-grid">
            <a href="{{ route('create.blade.php') }}" class="menu-item">
                <span class="icon">⚠️</span> Incidencias
            </a>
            <a href="{{ route('normas.index') }}" class="menu-item">
                <span class="icon">📜</span> Normas
            </a>
            <a href="#" class="menu-item">
                <span class="icon">📅</span> Mi Historial
            </a>
            <a href="#" class="menu-item">
                <span class="icon">👤</span> Perfil
            </a>
        </div>
    </div>
</body>
</html>
