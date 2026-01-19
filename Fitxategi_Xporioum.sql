CREATE DATABASE fitxategidb
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE fitxategidb;

CREATE TABLE idioma (
    id_idioma INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    codigo VARCHAR(5) NOT NULL UNIQUE
);


CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    dni VARCHAR(15) NOT NULL UNIQUE,
    idioma_id INT NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (idioma_id) REFERENCES idioma(id_idioma)
);


CREATE TABLE profesor (
    id_profesor INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id_usuario)
);


CREATE TABLE empresa (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    direccion VARCHAR(200),
    telefono VARCHAR(20),
    email_contacto VARCHAR(100)
);


CREATE TABLE alumno (
    id_alumno INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    profesor_id INT NOT NULL,
    empresa_id INT NOT NULL,
    fecha_alta DATE NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id_usuario),
    FOREIGN KEY (profesor_id) REFERENCES profesor(id_profesor),
    FOREIGN KEY (empresa_id) REFERENCES empresa(id_empresa)
);


CREATE TABLE normas (
    id_norma INT AUTO_INCREMENT PRIMARY KEY,
    idioma_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    archivo_pdf VARCHAR(255),
    FOREIGN KEY (idioma_id) REFERENCES idioma(id_idioma)
);


CREATE TABLE pin (
    id_pin INT AUTO_INCREMENT PRIMARY KEY,
    codigo_pin VARCHAR(10) NOT NULL,
    profesor_id INT NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion DATETIME,
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (profesor_id) REFERENCES profesor(id_profesor)
);


CREATE TABLE fichaje (
    id_fichaje INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    pin_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora_entrada TIME NOT NULL,
    hora_salida TIME,
    total_horas DECIMAL(5,2),
    FOREIGN KEY (alumno_id) REFERENCES alumno(id_alumno),
    FOREIGN KEY (pin_id) REFERENCES pin(id_pin)
);


CREATE TABLE pausa (
    id_pausa INT AUTO_INCREMENT PRIMARY KEY,
    fichaje_id INT NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME,
    duracion INT,
    FOREIGN KEY (fichaje_id) REFERENCES fichaje(id_fichaje)
);


CREATE TABLE incidencia (
    id_incidencia INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    profesor_id INT NOT NULL,
    fecha DATE NOT NULL,
    motivo TEXT NOT NULL,
    estado ENUM('pendiente', 'aceptada', 'rechazada') DEFAULT 'pendiente',
    FOREIGN KEY (alumno_id) REFERENCES alumno(id_alumno),
    FOREIGN KEY (profesor_id) REFERENCES profesor(id_profesor)
);


CREATE TABLE documento (
    id_documento INT AUTO_INCREMENT PRIMARY KEY,
    incidencia_id INT NOT NULL,
    nombre_archivo VARCHAR(150) NOT NULL,
    ruta_archivo VARCHAR(255) NOT NULL,
    tipo_archivo VARCHAR(50),
    fecha_subida DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (incidencia_id) REFERENCES incidencia(id_incidencia)
);
-- 1. Insertar un idioma necesario
INSERT INTO idioma (id_idioma, nombre, codigo) VALUES (1, 'Español', 'es');

-- 2. Insertar un usuario base
INSERT INTO usuario (id_usuario, email, contrasena, nombre, dni, idioma_id) 
VALUES (1, 'prueba@prueba.com', '1234', 'Usuario de Prueba', '12345678Z', 1);

-- 3. Insertar el profesor con ID 1
INSERT INTO profesor (id_profesor, usuario_id) VALUES (1, 1);

-- 4. Insertar una empresa necesaria
INSERT INTO empresa (id_empresa, nombre) VALUES (1, 'San Luis');

-- 5. Insertar el alumno con ID 1 vinculado al profesor 1
INSERT INTO alumno (id_alumno, usuario_id, profesor_id, empresa_id, fecha_alta) 
VALUES (1, 1, 1, 1, CURDATE());
