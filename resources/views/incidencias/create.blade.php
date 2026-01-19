<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias</title>
    <style>
        body {
            background-color: #9ab4ff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .container {
            background: white;
            width: 95%;
            max-width: 600px;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            text-align: center;
        }

        /* ESTO ES LO QUE TIENE QUE VERSE BIEN */
        .mensaje-exito {
            background-color: #28a745; /* Verde fuerte */
            color: white !important;
            padding: 40px;
            border-radius: 20px;
            font-size: 35px; /* LETRA GIGANTE */
            font-weight: bold;
            line-height: 1.2;
            margin: 20px 0;
            border: 5px solid #1e7e34;
        }

        h1 { font-size: 50px; font-weight: 900; margin-bottom: 30px; }

        form { display: flex; flex-direction: column; gap: 20px; text-align: left; }

        label { font-size: 24px; font-weight: bold; color: #333; }

        input, textarea {
            width: 100%;
            padding: 20px;
            font-size: 20px;
            border: 3px solid #ccc;
            border-radius: 15px;
            box-sizing: border-box;
        }

        .btn-enviar {
            background: black;
            color: white;
            padding: 25px;
            font-size: 25px;
            font-weight: bold;
            border-radius: 20px;
            cursor: pointer;
            text-transform: uppercase;
        }

        .btn-volver {
            display: inline-block;
            margin-top: 30px;
            padding: 20px 40px;
            background: black;
            color: white;
            text-decoration: none;
            border-radius: 15px;
            font-size: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        @if(session('status'))
            <div class="mensaje-exito">
                ✅ <br>
                {{ session('status') }}
            </div>
            <a href="{{ route('incidencias.create') }}" class="btn-volver">HACER OTRA INCIDENCIA</a>
        @else
            <h1>INCIDENCIA</h1>
            <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label>FECHA</label>
                    <input type="date" name="fecha" required>
                </div>
                <div>
                    <label>MOTIVO</label>
                    <textarea name="motivo" required></textarea>
                </div>
                <div>
                    <label>ARCHIVO</label>
                    <input type="file" name="adjunto">
                </div>
                <button type="submit" class="btn-enviar">REGISTRAR AHORA</button>
            </form>
        @endif
    </div>

</body>
</html>
