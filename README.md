Cómo instalar el proyecto
Configurar el archivo .env
Duplica el archivo .env.example y renómbralo a .env. Luego, ajusta los siguientes parámetros:
DB_CONNECTION=mysql           # Tipo de conexión (generalmente mysql)
DB_HOST=127.0.0.1             # Dirección del host (usualmente localhost)
DB_PORT=3306                  # Puerto para la conexión MySQL
DB_DATABASE=nombre_base_datos # Nombre de la base de datos
DB_USERNAME=usuario_bd        # Usuario de la base de datos
DB_PASSWORD=contraseña_bd     # Contraseña del usuario
SESSION_DRIVER=cookie         # Método de manejo de sesiones
CACHE_PREFIX=sync             # Prefijo para el cache
Clonar el repositorio

 git clone https://github.com/UCarbajo/Fitxategi-Duality.git


Instalar dependencias

 cd Fitxategi-Duality
composer install


Crear la base de datos y el usuario

 Usando HeidiSQL (o una herramienta similar), crea una base de datos y usuario con los valores correspondientes al archivo .env.


Generar la clave de la aplicación

 php artisan key:generate
