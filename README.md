<p align="center">
  <h1 align="center">🚀 Xporium Fitxategi</h1>
</p>

<p align="center">
  <strong>Guía de instalación y configuración del proyecto</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/status-active-success.svg">
  <img src="https://img.shields.io/badge/framework-Laravel-red.svg">
  <img src="https://img.shields.io/badge/php-%3E%3D8.0-blue.svg">
</p>

---

## 🛠️ Cómo instalar el proyecto

Sigue los siguientes pasos para configurar el proyecto correctamente en tu entorno local.

---

## ⚙️ Configurar el archivo `.env`

Duplica el archivo de configuración:

```bash
.env.example → .env
Después edita el archivo .env y configura los siguientes valores:

env
Copiar código
DB_CONNECTION=mysql           # Tipo de conexión (normalmente MySQL)
DB_HOST=127.0.0.1             # Dirección del host (normalmente localhost)
DB_PORT=3306                  # Puerto para MySQL
DB_DATABASE=nombre_base_datos # Nombre de la base de datos
DB_USERNAME=usuario_bd        # Usuario de la base de datos
DB_PASSWORD=contraseña_bd     # Contraseña del usuario

SESSION_DRIVER=cookie         # Método de manejo de sesiones
CACHE_PREFIX=sync             # Prefijo del sistema de caché
📥 Clonar el repositorio
Clona el proyecto desde GitHub usando:

bash
Copiar código
git clone https://github.com/DaniN12/DaniN12-Xporioum-Fitxategi.git
📦 Instalar dependencias
Accede al directorio del proyecto e instala las dependencias con Composer:

bash
Copiar código
cd Xporioum_Fitxategi
composer install
🗄️ Crear la base de datos y el usuario
Usando HeidiSQL, phpMyAdmin o una herramienta similar:

Crea una base de datos

Crea un usuario

Asigna los permisos necesarios

Usa los mismos valores configurados en el archivo .env

🔐 Generar la clave de la aplicación
Ejecuta el siguiente comando:

bash
Copiar código
php artisan key:generate
Esto generará una clave única necesaria para que la aplicación funcione correctamente.
