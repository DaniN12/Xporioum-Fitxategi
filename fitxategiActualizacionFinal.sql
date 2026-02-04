-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.2.0 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para fitxategi
CREATE DATABASE IF NOT EXISTS `fitxategi` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `fitxategi`;

-- Volcando estructura para tabla fitxategi.alumno
CREATE TABLE IF NOT EXISTS `alumno` (
  `id_alumno` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `profesor_id` int NOT NULL,
  `empresa_id` int NOT NULL,
  `fecha_alta` date NOT NULL,
  PRIMARY KEY (`id_alumno`),
  UNIQUE KEY `usuario_id` (`usuario_id`),
  KEY `profesor_id` (`profesor_id`),
  KEY `empresa_id` (`empresa_id`),
  CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `alumno_ibfk_2` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id_profesor`),
  CONSTRAINT `alumno_ibfk_3` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.alumno: ~16 rows (aproximadamente)
INSERT INTO `alumno` (`id_alumno`, `usuario_id`, `profesor_id`, `empresa_id`, `fecha_alta`) VALUES
	(1, 1, 1, 1, '2026-01-19'),
	(2, 3, 1, 1, '2026-01-26'),
	(3, 4, 1, 1, '2026-01-29'),
	(9, 10, 1, 1, '2026-01-29'),
	(10, 11, 1, 1, '2026-01-30'),
	(11, 12, 1, 1, '2026-02-01'),
	(12, 13, 1, 1, '2026-02-03'),
	(13, 14, 1, 1, '2026-02-03'),
	(14, 15, 1, 1, '2026-02-03'),
	(15, 16, 1, 1, '2026-02-03'),
	(16, 17, 1, 1, '2026-02-03'),
	(17, 18, 1, 1, '2026-02-03'),
	(18, 19, 1, 1, '2026-02-03'),
	(19, 20, 1, 1, '2026-02-03'),
	(20, 21, 1, 1, '2026-02-03'),
	(21, 22, 1, 1, '2026-02-03');

-- Volcando estructura para tabla fitxategi.documento
CREATE TABLE IF NOT EXISTS `documento` (
  `id_documento` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `incidencia_id` int DEFAULT NULL,
  `nombre_archivo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ruta_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_archivo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_subida` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_documento`),
  KEY `incidencia_id` (`incidencia_id`),
  CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`incidencia_id`) REFERENCES `incidencia` (`id_incidencia`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.documento: ~3 rows (aproximadamente)
INSERT INTO `documento` (`id_documento`, `id_usuario`, `incidencia_id`, `nombre_archivo`, `ruta_archivo`, `tipo_archivo`, `fecha_subida`) VALUES
	(1, 1, NULL, 'Contrato_firmado_20260203_225143.pdf', 'documentos/1/Contrato_firmado_20260203_225143.pdf', 'norma_firmada', '2026-02-03 23:51:43'),
	(2, 20, NULL, 'Contrato_firmado_20260203_231356.pdf', 'documentos/20/Contrato_firmado_20260203_231356.pdf', 'norma_firmada', '2026-02-04 00:13:56'),
	(3, 22, NULL, 'Contrato_firmado_20260203_235404.pdf', 'documentos/22/Contrato_firmado_20260203_235404.pdf', 'norma_firmada', '2026-02-04 00:54:04');

-- Volcando estructura para tabla fitxategi.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `id_empresa` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_contacto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.empresa: ~1 rows (aproximadamente)
INSERT INTO `empresa` (`id_empresa`, `nombre`, `direccion`, `telefono`, `email_contacto`) VALUES
	(1, 'Nike', 'autonomia', '123456789', 'nike111@gmail.com');

-- Volcando estructura para tabla fitxategi.fichaje
CREATE TABLE IF NOT EXISTS `fichaje` (
  `id_fichaje` int NOT NULL AUTO_INCREMENT,
  `alumno_id` int NOT NULL,
  `pin_id` int DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time DEFAULT NULL,
  `total_horas` decimal(5,2) DEFAULT NULL,
  `descanso_inicio` datetime DEFAULT NULL,
  `minutos_descanso` int NOT NULL DEFAULT '0',
  `hora_inicio_descanso` time DEFAULT NULL,
  `hora_fin_descanso` time DEFAULT NULL,
  PRIMARY KEY (`id_fichaje`),
  KEY `alumno_id` (`alumno_id`),
  KEY `pin_id` (`pin_id`),
  CONSTRAINT `fichaje_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id_alumno`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.fichaje: ~10 rows (aproximadamente)
INSERT INTO `fichaje` (`id_fichaje`, `alumno_id`, `pin_id`, `fecha`, `hora_entrada`, `hora_salida`, `total_horas`, `descanso_inicio`, `minutos_descanso`, `hora_inicio_descanso`, `hora_fin_descanso`) VALUES
	(3, 1, NULL, '2026-02-03', '00:16:40', '00:17:49', 0.02, '2026-02-03 00:17:40', 0, '00:17:40', '00:17:43'),
	(4, 13, NULL, '2026-02-03', '19:12:58', '19:13:07', 0.00, '2026-02-03 19:13:04', 0, '19:13:04', '19:13:05'),
	(5, 14, NULL, '2026-02-03', '19:35:48', NULL, NULL, '2026-02-03 19:35:55', 0, '19:35:55', NULL),
	(6, 15, NULL, '2026-02-03', '19:39:41', '19:39:56', 0.00, '2026-02-03 19:39:46', 0, '19:39:46', '19:39:51'),
	(7, 16, NULL, '2026-02-03', '19:47:26', NULL, NULL, NULL, 0, NULL, NULL),
	(8, 17, NULL, '2026-02-03', '19:50:07', '19:50:31', 0.01, '2026-02-03 19:50:23', 0, '19:50:23', '19:50:27'),
	(9, 18, NULL, '2026-02-03', '23:05:11', '23:05:28', 0.00, '2026-02-03 23:05:17', 0, '23:05:17', '23:05:22'),
	(10, 19, NULL, '2026-02-03', '23:11:57', '23:12:10', 0.00, '2026-02-03 23:12:03', 0, '23:12:03', '23:12:07'),
	(11, 20, NULL, '2026-02-03', '23:44:13', '23:44:30', 0.00, '2026-02-03 23:44:20', 0, '23:44:20', '23:44:24'),
	(12, 21, NULL, '2026-02-03', '23:52:03', '23:52:19', 0.00, '2026-02-03 23:52:10', 0, '23:52:10', '23:52:15');

-- Volcando estructura para tabla fitxategi.idioma
CREATE TABLE IF NOT EXISTS `idioma` (
  `id_idioma` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `codigo` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_idioma`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.idioma: ~3 rows (aproximadamente)
INSERT INTO `idioma` (`id_idioma`, `nombre`, `codigo`) VALUES
	(1, 'Español', 'es'),
	(2, 'Ingles', 'en'),
	(3, 'Euskera', 'eu');

-- Volcando estructura para tabla fitxategi.incidencia
CREATE TABLE IF NOT EXISTS `incidencia` (
  `id_incidencia` int NOT NULL AUTO_INCREMENT,
  `alumno_id` int NOT NULL,
  `profesor_id` int NOT NULL,
  `fecha` date NOT NULL,
  `motivo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('pendiente','aceptada','rechazada') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'pendiente',
  `adjunto_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adjunto_nombre` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_incidencia`),
  KEY `alumno_id` (`alumno_id`),
  KEY `profesor_id` (`profesor_id`),
  CONSTRAINT `incidencia_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id_alumno`),
  CONSTRAINT `incidencia_ibfk_2` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id_profesor`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.incidencia: ~3 rows (aproximadamente)
INSERT INTO `incidencia` (`id_incidencia`, `alumno_id`, `profesor_id`, `fecha`, `motivo`, `estado`, `adjunto_path`, `adjunto_nombre`) VALUES
	(1, 1, 1, '2026-01-29', 'Prueba de ausencia', 'aceptada', NULL, NULL),
	(2, 1, 1, '2025-01-01', 'hola', 'pendiente', 'justificantes/NdoBo7c93HcjYYWFtCeRVwRpTy4lIiWZUIRk8Ocg.jpg', '2.jpg'),
	(3, 1, 1, '2025-12-05', 'holaaaaaaaaaa 2', 'pendiente', 'justificantes/YJKbpDHvAMbrGqv6JsfGTAyd8VMDadz3Q7gimLlq.jpg', 'npgN4lG9ZVNgHAG1uWjJ.jpg');

-- Volcando estructura para tabla fitxategi.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fitxategi.migrations: ~3 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2026_01_20_073920_add_descanso_to_fichaje_table', 1),
	(2, '2026_01_20_074113_create_qr_tokens_table', 1),
	(3, '2026_02_03_215506_add_id_usuario_to_documento_table', 2);

-- Volcando estructura para tabla fitxategi.normas
CREATE TABLE IF NOT EXISTS `normas` (
  `id_norma` int NOT NULL AUTO_INCREMENT,
  `idioma_id` int NOT NULL,
  `titulo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `archivo_pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_norma`),
  KEY `idioma_id` (`idioma_id`),
  CONSTRAINT `normas_ibfk_1` FOREIGN KEY (`idioma_id`) REFERENCES `idioma` (`id_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.normas: ~0 rows (aproximadamente)

-- Volcando estructura para tabla fitxategi.pausa
CREATE TABLE IF NOT EXISTS `pausa` (
  `id_pausa` int NOT NULL AUTO_INCREMENT,
  `fichaje_id` int NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time DEFAULT NULL,
  `duracion` int DEFAULT NULL,
  PRIMARY KEY (`id_pausa`),
  KEY `fichaje_id` (`fichaje_id`),
  CONSTRAINT `pausa_ibfk_1` FOREIGN KEY (`fichaje_id`) REFERENCES `fichaje` (`id_fichaje`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.pausa: ~9 rows (aproximadamente)
INSERT INTO `pausa` (`id_pausa`, `fichaje_id`, `hora_inicio`, `hora_fin`, `duracion`) VALUES
	(1, 3, '00:17:40', '00:17:43', 0),
	(2, 4, '19:13:04', '19:13:05', 0),
	(3, 5, '19:35:55', NULL, NULL),
	(4, 6, '19:39:46', '19:39:51', 0),
	(5, 8, '19:50:23', '19:50:27', 0),
	(6, 9, '23:05:17', '23:05:22', 0),
	(7, 10, '23:12:03', '23:12:07', 0),
	(8, 11, '23:44:20', '23:44:24', 0),
	(9, 12, '23:52:10', '23:52:15', 0);

-- Volcando estructura para tabla fitxategi.profesor
CREATE TABLE IF NOT EXISTS `profesor` (
  `id_profesor` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  PRIMARY KEY (`id_profesor`),
  UNIQUE KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `profesor_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.profesor: ~1 rows (aproximadamente)
INSERT INTO `profesor` (`id_profesor`, `usuario_id`) VALUES
	(1, 2);

-- Volcando estructura para tabla fitxategi.qr_tokens
CREATE TABLE IF NOT EXISTS `qr_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'entrada',
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `qr_tokens_token_unique` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=329 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fitxategi.qr_tokens: ~6 rows (aproximadamente)
INSERT INTO `qr_tokens` (`id`, `token`, `tipo`, `expires_at`, `created_at`, `updated_at`) VALUES
	(321, '0bf61526-a0ca-4324-8e3c-868080e0e316', 'entrada', '2026-02-04 00:02:53', '2026-02-03 22:42:53', '2026-02-03 22:42:53'),
	(322, '000b771d-8a98-4a6a-a4f6-9edefd26eaa8', 'entrada', '2026-02-04 00:03:13', '2026-02-03 22:43:13', '2026-02-03 22:43:13'),
	(323, 'eb54296f-7eb9-47a4-9524-b1bcb7b42110', 'entrada', '2026-02-04 00:03:33', '2026-02-03 22:43:33', '2026-02-03 22:43:33'),
	(325, 'e24437ad-5b54-4436-8f5e-452f06f78ee8', 'entrada', '2026-02-04 00:07:07', '2026-02-03 22:47:07', '2026-02-03 22:47:07'),
	(326, 'e6bd7709-292f-4eb3-b01f-d73b46a948e4', 'entrada', '2026-02-04 00:07:27', '2026-02-03 22:47:27', '2026-02-03 22:47:27'),
	(327, 'eb7b13bc-42ce-4d5e-91ef-697805abe609', 'entrada', '2026-02-04 00:11:16', '2026-02-03 22:51:16', '2026-02-03 22:51:16');

-- Volcando estructura para tabla fitxategi.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `usuario_id` int DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.sessions: ~11 rows (aproximadamente)
INSERT INTO `sessions` (`id`, `user_id`, `usuario_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('bGMSwG2AHnZFYRgBTV7MuYgcBkh1PwvmMA6qj5pM', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ2o2WjRIOWlkM0FleEFHRUQzaURZZ1l0aVkzV2hDYVQ2S2JBeEZ6dyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly9sb2NhbGhvc3QvRGFuaU4xMi1YcG9yaW91bS1GaXR4YXRlZ2kvcHVibGljL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1NzoiaHR0cDovL2xvY2FsaG9zdC9EYW5pTjEyLVhwb3Jpb3VtLUZpdHhhdGVnaS9wdWJsaWMvcGVyZmlsIjt9fQ==', 1769594536),
	('c0L8OluXd9dUqx5d4HadlijXxlPBiYBWPlfZd2Vv', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTk8xbUVTUEd6RlVpMmg3TkoycnhsZXNWQ2FmdVk4NEJyZ2daNEk3aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9sb2NhbGhvc3QvWHBvcmlvdW0tRml0eGF0ZWdpL3B1YmxpYyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769419311),
	('HoUp0IXITGjGtfoAQCcebfrGCdIMSr6pycXVk2kP', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTo0OntzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MToiaHR0cDovL2xvY2FsaG9zdC9YcG9yaW91bS1GaXR4YXRlZ2kvcHVibGljL3Byb2Zlc29yIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6ImlVN0N5bkF3bWZFbThVZnBEZUxzZWhxbFpuYmFEQVZCamZRMUFET0UiO3M6MTA6ImlkX3VzdWFyaW8iO2k6Mjt9', 1769431371),
	('i71phEvMdwcBXkr5FIGCvnKzXClH3hKTKQtE0IRj', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0ODoiaHR0cDovL2xvY2FsaG9zdC9YcG9yaW91bS1GaXR4YXRlZ2kvcHVibGljL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6IngxcDFHdEd2N09GamQ1aVBRQTI3YUVwRWpvUTRldkU4endVTEMxQVEiO30=', 1769067588),
	('llGnFNcTs3jW1j3VDJzmTD9Iegz8t4s1eKNVSz3v', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWkZmeVVsbERGNUFEQXFxSG5tbFZqeTIxR1FNSkRTUVdncVhmVmxLRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly9sb2NhbGhvc3QvRml0eGF0ZWdpLUpvYW5lL3B1YmxpYy9pbmNpZGVuY2lhcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769593996),
	('mODezf53PISE40tIUEA9xV8uKt7jHPShdCiEPUSd', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTWxkM1daTlpZTk4xOWlTTmJsUXhOMFpDdHBsMGFhZjBjeW53ck1VbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly9sb2NhbGhvc3QvWHBvcmlvdW0tRml0eGF0ZWdpL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769413397),
	('ngNesGG4yvQs7UVJkCkk7xKbubIEvk9Hr4V7Hfdm', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiblVLNFhiTndmR1V6SkJ6SnVwMFYyWDJJUTJBcVFtdWhXczNpTTFEMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9sb2NhbGhvc3QvRml0eGF0ZWdpLUpvYW5lL3B1YmxpYy9ub3JtYXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1769591172),
	('pJ8y0oiiTLZeiL6y6XSkKBCAQxeV3RlTQoWEmdSc', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNmdNS0FJc2s2S0lNbms5cDQyMWRUTXRZU0dLaW0zbVRhVndmelBOayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly9sb2NhbGhvc3QvWHBvcmlvdW0tRml0eGF0ZWdpL3B1YmxpYy9maWNoYXIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjEwOiJpZF91c3VhcmlvIjtpOjE7fQ==', 1769589304),
	('QdS6PfBmhTp9nICvy1V8Vs7dwUHyrL8SPkCtLiSS', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQzRhWEJCd0xqTDB0WDZWUVUwTWdVVmVRc3pMNlY1dXBLTFpZcFlWRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9sb2NhbGhvc3QvRml0eGF0ZWdpLUpvYW5lL3B1YmxpYy9ub3JtYXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1769591469),
	('vpagY2N797BvYikuBMOMvhYAQiShg1s6I7XlgvIF', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiamhwRDFlU0phWFppblVaM1VhMTRZdmMwZnREd3UwZG4xNThnVWlZaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9sb2NhbGhvc3QvWHBvcmlvdW0tRml0eGF0ZWdpL3B1YmxpYyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769413983),
	('xto7dNkkIw3NvPThQvuC7sYHa2RDNHlMR9mMaKqg', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTo0OntzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MjoiaHR0cDovL2xvY2FsaG9zdC9YcG9yaW91bS1GaXR4YXRlZ2kvcHVibGljL2ZpY2hhci9xciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NjoiX3Rva2VuIjtzOjQwOiJOZkREcnBrSVJjRzFURTY1ZG9CZFpzckh4QlZzZTZzdFo5Y2kwcHN6IjtzOjEwOiJpZF91c3VhcmlvIjtpOjE7fQ==', 1769511622);

-- Volcando estructura para tabla fitxategi.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contrasena` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dni` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idioma_id` int NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `dni` (`dni`),
  KEY `idioma_id` (`idioma_id`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idioma_id`) REFERENCES `idioma` (`id_idioma`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.usuario: ~19 rows (aproximadamente)
INSERT INTO `usuario` (`id_usuario`, `email`, `contrasena`, `nombre`, `dni`, `idioma_id`, `fecha_creacion`, `activo`) VALUES
	(1, 'deiner@gmail.com', '$2y$12$QEhxR0unMQkY33J0Q0p3lemxkhMwrPbHCfk/tmbO9uZxZ3xUYJqXS', 'deiner', '12345678A', 1, '2026-01-19 09:56:58', 1),
	(2, 'profesor@gmail.com', '$2y$12$IJfB.6QR6ZFtSC7ZULm0K.AngnHngRryKcojtGrjmDZfR2EwKmsqi', 'profesor', '111111111B', 1, '2026-01-19 12:56:09', 1),
	(3, 'beverly@gmail.com', '$2y$12$1KlC5AB04paqWa8u2pgXNOvx/77HoobSX3qxT6Q.8i8LHkXO3aqBm', 'beverly', '1233444566B', 1, '2026-01-26 10:48:07', 1),
	(4, 'daniela@gmail.com', '$2y$12$/bpyh1Iz.11T5XkEIdJLeOQZBOo5SAHF2rhX8eV4tqJ4pkATloasS', 'Daniela', '79437969B', 1, '2026-01-29 12:39:22', 1),
	(5, 'joane@gmail.com', '$2y$12$q58//YFuW/2aadO9gYeFXepRPCC3DJNcXA5PMYXdPhtPof.A7fxbS', 'Joane', '987654321J', 1, '2026-01-29 12:40:52', 1),
	(6, 'alcubilla@gmail.com', '$2y$12$TE4vteyuxqGl7jAmTCOlLOpZQ7LnCdOgEOuqJBieBbbIPo6rxyM3K', 'Joane', '88888888A', 1, '2026-01-29 13:23:30', 1),
	(10, 'deineruyuquipa@gmail.com', '$2y$12$LKzkuxhPE3rV8lkKDyIn/euui.fnxc51OqM5/lsUZJL3KxrqfrfIC', 'Deiner', '22222222D', 1, '2026-01-30 00:34:47', 1),
	(11, 'balboa@gmail.com', '$2y$12$1733TPUGUswRQ7.TDGccr.3Kp3Fv01ySS/UVqsbNrR2xRiBuSJgh2', 'Beverly balboa', '22222222A', 1, '2026-01-30 11:37:27', 1),
	(12, 'sonia@gmail.com', '$2y$12$316ZbB/OrfC.Wvtg0BAumO63v768uu8B/qLyFOHN4AULRffT5qlby', 'Sonia', '111111111S', 1, '2026-02-01 20:13:08', 1),
	(13, 'pepito@gmail.com', '$2y$12$06uXfI8rpnr/SCh0y3h.2uzzZSGRNrWb/68Hn8aTVGuIwWhLwazfe', 'pepito', '44444444P', 1, '2026-02-03 01:36:29', 1),
	(14, 'unai@gmail.com', '$2y$12$8s/MOdJTIsVFGPDfKmbrueyrzBanT.aOeKMnfxOwY9AH5RcpSLB6.', 'Unai', '1111111U', 1, '2026-02-03 20:07:14', 1),
	(15, 'alejandro@gmail.com', '$2y$12$HoKRAmcKH9RUh5Wqdd8y6OUWAti3NA5ZtJzjxYsqZmeteBcFVnsDa', 'alejandro', '111112222A', 1, '2026-02-03 20:25:49', 1),
	(16, 'alberto@gmail.com', '$2y$12$nLB0Kksl/lSTuyDhf6vSouSdt/HOy8HaD3IBhkyg4kYfKiPjo3dvC', 'alberto', '66666666A', 1, '2026-02-03 20:36:54', 1),
	(17, 'iban@gmail.com', '$2y$12$h3VRFhfYunc.oD6NGebu..p49JHh3OBbhdg4yrNo3uWBTpy63eBJe', 'iban', '8888888I', 1, '2026-02-03 20:43:50', 1),
	(18, 'usuario@gmail.com', '$2y$12$pYyHFGC8rOMhoSDpUyl8SuweTcsbQuUMxPcpuGzAF58lWABnLQE7u', 'usuario', '111111111111A', 1, '2026-02-03 20:48:55', 1),
	(19, 'user@gmail.com', '$2y$12$naoXbSPxKpsE.5PCWCfsHOiJhJTn7RRf6nbaBhmfi.tsWvdKmiX0q', 'user', '11111111111U', 1, '2026-02-04 00:00:40', 1),
	(20, 'javier@gmail.com', '$2y$12$I9zJ.JhOonSKcgvyE.Y8M.7r13GaTel2SdV16xEJRbXZyahJFMK4y', 'javier', '234567765F', 1, '2026-02-04 00:09:44', 1),
	(21, 'deinerj@gmail.com', '$2y$12$vpS5HiGhf3v8pXRz1cRY6.TjMUlEW.za.ALCIBuIpAF.mBAeUGY.2', 'deiner', '888888888Q', 1, '2026-02-04 00:42:14', 1),
	(22, 'deineru@gmail.com', '$2y$12$Hnqp062N7APqkEAPCubWq.PnPtNBlUQMbFb3wzcpcSVA79a.emHrq', 'deiner', '2323232323A', 1, '2026-02-04 00:45:39', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
