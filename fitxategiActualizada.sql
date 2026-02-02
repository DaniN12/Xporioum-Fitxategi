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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.alumno: ~5 rows (aproximadamente)
INSERT INTO `alumno` (`id_alumno`, `usuario_id`, `profesor_id`, `empresa_id`, `fecha_alta`) VALUES
	(1, 1, 1, 1, '2026-01-19'),
	(2, 3, 1, 1, '2026-01-26'),
	(3, 4, 1, 1, '2026-01-29'),
	(9, 10, 1, 1, '2026-01-29'),
	(10, 11, 1, 1, '2026-01-30');

-- Volcando estructura para tabla fitxategi.documento
CREATE TABLE IF NOT EXISTS `documento` (
  `id_documento` int NOT NULL AUTO_INCREMENT,
  `incidencia_id` int NOT NULL,
  `nombre_archivo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ruta_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_archivo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_subida` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_documento`),
  KEY `incidencia_id` (`incidencia_id`),
  CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`incidencia_id`) REFERENCES `incidencia` (`id_incidencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.documento: ~0 rows (aproximadamente)

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
  `pin_id` int NOT NULL,
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
  CONSTRAINT `fichaje_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id_alumno`),
  CONSTRAINT `fichaje_ibfk_2` FOREIGN KEY (`pin_id`) REFERENCES `pin` (`id_pin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.fichaje: ~0 rows (aproximadamente)

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.incidencia: ~1 rows (aproximadamente)
INSERT INTO `incidencia` (`id_incidencia`, `alumno_id`, `profesor_id`, `fecha`, `motivo`, `estado`, `adjunto_path`, `adjunto_nombre`) VALUES
	(1, 1, 1, '2026-01-29', 'Prueba de ausencia', 'pendiente', NULL, NULL);

-- Volcando estructura para tabla fitxategi.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fitxategi.migrations: ~2 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2026_01_20_073920_add_descanso_to_fichaje_table', 1),
	(2, '2026_01_20_074113_create_qr_tokens_table', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.pausa: ~0 rows (aproximadamente)

-- Volcando estructura para tabla fitxategi.pin
CREATE TABLE IF NOT EXISTS `pin` (
  `id_pin` int NOT NULL AUTO_INCREMENT,
  `codigo_pin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `profesor_id` int NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_expiracion` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_pin`),
  KEY `profesor_id` (`profesor_id`),
  CONSTRAINT `pin_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id_profesor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.pin: ~0 rows (aproximadamente)

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
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fitxategi.qr_tokens: ~19 rows (aproximadamente)
INSERT INTO `qr_tokens` (`id`, `token`, `tipo`, `expires_at`, `created_at`, `updated_at`) VALUES
	(112, 'ccbd6a1e-081b-4777-b61e-8f1e3d7d1def', 'entrada', '2026-01-30 10:40:19', '2026-01-30 09:20:19', '2026-01-30 09:20:19'),
	(113, '25a7e0ea-1e23-43cd-8925-5022b8426dae', 'entrada', '2026-01-30 10:41:19', '2026-01-30 09:21:19', '2026-01-30 09:21:19'),
	(114, '1ed94896-08f8-4bc1-b99c-dbde6b1d241f', 'entrada', '2026-01-30 10:41:39', '2026-01-30 09:21:39', '2026-01-30 09:21:39'),
	(115, 'a2114ff0-4712-4e49-8c5b-da05ba548797', 'entrada', '2026-01-30 10:41:59', '2026-01-30 09:21:59', '2026-01-30 09:21:59'),
	(116, 'c49a75b4-debb-425c-8eff-b0b96ee401da', 'entrada', '2026-01-30 10:42:20', '2026-01-30 09:22:20', '2026-01-30 09:22:20'),
	(117, 'f4197f4f-1ff9-45ca-9a5a-827634d7b208', 'entrada', '2026-01-30 10:42:40', '2026-01-30 09:22:40', '2026-01-30 09:22:40'),
	(118, '2c6ba583-9c18-4398-a46b-a994b0193a60', 'entrada', '2026-01-30 10:43:00', '2026-01-30 09:23:00', '2026-01-30 09:23:00'),
	(119, 'deb996c4-bfce-4f94-ba8a-032437358b3f', 'entrada', '2026-01-30 10:43:20', '2026-01-30 09:23:20', '2026-01-30 09:23:20'),
	(120, 'cc638cc9-f079-471d-9c83-e82d9af20af2', 'entrada', '2026-01-30 10:43:40', '2026-01-30 09:23:40', '2026-01-30 09:23:40'),
	(121, '6b665c73-d6da-4693-92c6-78ba67ae9cde', 'entrada', '2026-01-30 10:44:00', '2026-01-30 09:24:00', '2026-01-30 09:24:00'),
	(122, '17d4f2ed-1b5b-4f4f-a595-f8645ac4049e', 'entrada', '2026-01-30 10:44:20', '2026-01-30 09:24:20', '2026-01-30 09:24:20'),
	(123, '9bc80b98-89e5-479d-aa9a-d4b0a52d4611', 'entrada', '2026-01-30 10:45:06', '2026-01-30 09:25:06', '2026-01-30 09:25:06'),
	(124, 'efdb1027-5b98-4ce5-a775-2e0db1ad12de', 'entrada', '2026-01-30 10:45:26', '2026-01-30 09:25:26', '2026-01-30 09:25:26'),
	(125, '530402af-5077-4a5f-9486-3c422e959850', 'entrada', '2026-01-30 10:45:46', '2026-01-30 09:25:46', '2026-01-30 09:25:46'),
	(126, 'a4ca92f3-7a28-4cb0-8964-d139833697db', 'entrada', '2026-01-30 10:46:06', '2026-01-30 09:26:06', '2026-01-30 09:26:06'),
	(127, 'bd75fc8b-1544-4299-bba8-0a1f28523abf', 'entrada', '2026-01-30 10:46:26', '2026-01-30 09:26:26', '2026-01-30 09:26:26'),
	(128, 'a39053f4-fef3-443d-a168-fc89875662a1', 'entrada', '2026-01-30 10:46:46', '2026-01-30 09:26:46', '2026-01-30 09:26:46'),
	(129, '396def6f-51ed-45d6-8185-0d7c414c7f61', 'entrada', '2026-01-30 10:59:41', '2026-01-30 09:39:41', '2026-01-30 09:39:41'),
	(130, '91f0b87e-ec16-4152-8c97-6267201b0394', 'entrada', '2026-01-30 11:00:00', '2026-01-30 09:40:00', '2026-01-30 09:40:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla fitxategi.usuario: ~8 rows (aproximadamente)
INSERT INTO `usuario` (`id_usuario`, `email`, `contrasena`, `nombre`, `dni`, `idioma_id`, `fecha_creacion`, `activo`) VALUES
	(1, 'deiner@gmail.com', '$2y$12$QEhxR0unMQkY33J0Q0p3lemxkhMwrPbHCfk/tmbO9uZxZ3xUYJqXS', 'deiner', '12345678A', 1, '2026-01-19 09:56:58', 1),
	(2, 'profesor@gmail.com', '$2y$12$IJfB.6QR6ZFtSC7ZULm0K.AngnHngRryKcojtGrjmDZfR2EwKmsqi', 'profesor', '111111111B', 1, '2026-01-19 12:56:09', 1),
	(3, 'beverly@gmail.com', '$2y$12$1KlC5AB04paqWa8u2pgXNOvx/77HoobSX3qxT6Q.8i8LHkXO3aqBm', 'beverly', '1233444566B', 1, '2026-01-26 10:48:07', 1),
	(4, 'daniela@gmail.com', '$2y$12$/bpyh1Iz.11T5XkEIdJLeOQZBOo5SAHF2rhX8eV4tqJ4pkATloasS', 'Daniela', '79437969B', 1, '2026-01-29 12:39:22', 1),
	(5, 'joane@gmail.com', '$2y$12$q58//YFuW/2aadO9gYeFXepRPCC3DJNcXA5PMYXdPhtPof.A7fxbS', 'Joane', '987654321J', 1, '2026-01-29 12:40:52', 1),
	(6, 'alcubilla@gmail.com', '$2y$12$TE4vteyuxqGl7jAmTCOlLOpZQ7LnCdOgEOuqJBieBbbIPo6rxyM3K', 'Joane', '88888888A', 1, '2026-01-29 13:23:30', 1),
	(10, 'deineruyuquipa@gmail.com', '$2y$12$LKzkuxhPE3rV8lkKDyIn/euui.fnxc51OqM5/lsUZJL3KxrqfrfIC', 'Deiner', '22222222D', 1, '2026-01-30 00:34:47', 1),
	(11, 'balboa@gmail.com', '$2y$12$1733TPUGUswRQ7.TDGccr.3Kp3Fv01ySS/UVqsbNrR2xRiBuSJgh2', 'Beverly balboa', '22222222A', 1, '2026-01-30 11:37:27', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
