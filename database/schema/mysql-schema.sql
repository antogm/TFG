/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `asignacion_rutinas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asignacion_rutinas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rutina_id` bigint unsigned NOT NULL,
  `usuario_id` bigint unsigned NOT NULL,
  `entrenador_id` bigint unsigned NOT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_asignacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_fin` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asignacion_rutinas_rutina_id_usuario_id_unique` (`rutina_id`,`usuario_id`),
  KEY `asignacion_rutinas_rutina_id_foreign` (`rutina_id`),
  KEY `asignacion_rutinas_usuario_id_foreign` (`usuario_id`),
  KEY `asignacion_rutinas_entrenador_id_foreign` (`entrenador_id`),
  CONSTRAINT `asignacion_rutinas_entrenador_id_foreign` FOREIGN KEY (`entrenador_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `asignacion_rutinas_rutina_id_foreign` FOREIGN KEY (`rutina_id`) REFERENCES `rutinas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `asignacion_rutinas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cliente_entrenadors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente_entrenadors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `entrenador_id` bigint unsigned NOT NULL,
  `cliente_id` bigint unsigned NOT NULL,
  `fecha_solicitud` datetime DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `valoracion` decimal(2,1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cliente_entrenadors_entrenador_id_cliente_id_activa_unique` (`entrenador_id`,`cliente_id`),
  KEY `cliente_entrenadors_cliente_id_foreign` (`cliente_id`),
  CONSTRAINT `cliente_entrenadors_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cliente_entrenadors_entrenador_id_foreign` FOREIGN KEY (`entrenador_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conversations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_one_id` bigint unsigned NOT NULL,
  `user_two_id` bigint unsigned NOT NULL,
  `last_message_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `conversations_user_one_id_user_two_id_unique` (`user_one_id`,`user_two_id`),
  KEY `conversations_user_one_id_index` (`user_one_id`),
  KEY `conversations_user_two_id_index` (`user_two_id`),
  KEY `conversations_last_message_id_foreign` (`last_message_id`),
  CONSTRAINT `conversations_last_message_id_foreign` FOREIGN KEY (`last_message_id`) REFERENCES `messages` (`id`) ON DELETE SET NULL,
  CONSTRAINT `conversations_user_one_id_foreign` FOREIGN KEY (`user_one_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `conversations_user_two_id_foreign` FOREIGN KEY (`user_two_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `dia_entreno_ejercicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dia_entreno_ejercicios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dia_entreno_id` bigint unsigned NOT NULL,
  `ejercicio_id` bigint unsigned NOT NULL,
  `series` smallint unsigned NOT NULL,
  `repeticiones` smallint unsigned NOT NULL,
  `carga` smallint unsigned DEFAULT NULL,
  `duracion_segundos` int unsigned DEFAULT NULL,
  `orden` smallint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dia_entreno_ejercicios_dia_entreno_id_orden_unique` (`dia_entreno_id`,`orden`),
  KEY `dia_entreno_ejercicios_ejercicio_id_foreign` (`ejercicio_id`),
  CONSTRAINT `dia_entreno_ejercicios_dia_entreno_id_foreign` FOREIGN KEY (`dia_entreno_id`) REFERENCES `dia_entrenos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dia_entreno_ejercicios_ejercicio_id_foreign` FOREIGN KEY (`ejercicio_id`) REFERENCES `ejercicios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `dia_entrenos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dia_entrenos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rutina_id` bigint unsigned NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden` tinyint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dia_entrenos_rutina_id_orden_unique` (`rutina_id`,`orden`),
  CONSTRAINT `dia_entrenos_rutina_id_foreign` FOREIGN KEY (`rutina_id`) REFERENCES `rutinas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ejercicio_grupo_muscular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ejercicio_grupo_muscular` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ejercicio_id` bigint unsigned NOT NULL,
  `grupo_muscular_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ejercicio_grupo_muscular_ejercicio_id_grupo_muscular_id_unique` (`ejercicio_id`,`grupo_muscular_id`),
  KEY `ejercicio_grupo_muscular_grupo_muscular_id_foreign` (`grupo_muscular_id`),
  CONSTRAINT `ejercicio_grupo_muscular_ejercicio_id_foreign` FOREIGN KEY (`ejercicio_id`) REFERENCES `ejercicios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ejercicio_grupo_muscular_grupo_muscular_id_foreign` FOREIGN KEY (`grupo_muscular_id`) REFERENCES `grupos_musculares` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ejercicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ejercicios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grupo_muscular` bigint unsigned DEFAULT NULL,
  `link_youtube` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ejercicios_grupo_muscular_foreign` (`grupo_muscular`),
  CONSTRAINT `ejercicios_grupo_muscular_foreign` FOREIGN KEY (`grupo_muscular`) REFERENCES `grupos_musculares` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `entrenadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entrenadores` (
  `id` bigint unsigned NOT NULL,
  `precio_mensual` decimal(8,2) DEFAULT NULL,
  `calificacion_media` tinyint unsigned DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `numero_valoraciones` int unsigned NOT NULL DEFAULT '0',
  `numero_clientes` int unsigned DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ocultar_lista_publica` tinyint(1) NOT NULL DEFAULT '0',
  `bloquear_solicitudes_entrantes` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `entrenadores_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `entrenadores_rating_check` CHECK (((`rating` is null) or ((`rating` >= 0.0) and (`rating` <= 5.0))))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `grupos_musculares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupos_musculares` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grupos_musculares_parent_id_foreign` (`parent_id`),
  CONSTRAINT `grupos_musculares_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `grupos_musculares` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `conversation_id` bigint unsigned NOT NULL,
  `sender_id` bigint unsigned NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_conversation_id_created_at_index` (`conversation_id`,`created_at`),
  KEY `messages_sender_id_index` (`sender_id`),
  CONSTRAINT `messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `registro_corporal_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_corporal_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `registro_corporal_id` bigint unsigned NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registro_corporal_images_registro_corporal_id_foreign` (`registro_corporal_id`),
  CONSTRAINT `registro_corporal_images_registro_corporal_id_foreign` FOREIGN KEY (`registro_corporal_id`) REFERENCES `registro_corporals` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `registro_corporals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_corporals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned NOT NULL,
  `fecha_registro` date NOT NULL,
  `peso` decimal(5,2) NOT NULL,
  `masa_muscular` decimal(5,2) DEFAULT NULL,
  `porcentaje_grasa` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fecha_edicion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registro_corporals_usuario_id_fecha_registro_unique` (`usuario_id`,`fecha_registro`),
  CONSTRAINT `registro_corporals_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `registro_ejercicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_ejercicios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `registro_entrenamiento_id` bigint unsigned NOT NULL,
  `dia_entreno_ejercicio_id` bigint unsigned NOT NULL,
  `series_realizadas` smallint unsigned DEFAULT NULL,
  `repeticiones_realizadas` smallint unsigned DEFAULT NULL,
  `peso_utilizado` decimal(5,2) DEFAULT NULL,
  `duracion` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registro_ejercicios_registro_entrenamiento_id_foreign` (`registro_entrenamiento_id`),
  KEY `registro_ejercicios_dia_entreno_ejercicio_id_foreign` (`dia_entreno_ejercicio_id`),
  CONSTRAINT `registro_ejercicios_dia_entreno_ejercicio_id_foreign` FOREIGN KEY (`dia_entreno_ejercicio_id`) REFERENCES `dia_entreno_ejercicios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `registro_ejercicios_registro_entrenamiento_id_foreign` FOREIGN KEY (`registro_entrenamiento_id`) REFERENCES `registro_entrenamientos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `registro_entrenamientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_entrenamientos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned NOT NULL,
  `asignacion_rutina_id` bigint unsigned NOT NULL,
  `dia_entreno_id` bigint unsigned NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_entrenamiento` date NOT NULL,
  `pasos_realizados` mediumint unsigned NOT NULL,
  `adherencia_dieta` tinyint(1) DEFAULT NULL,
  `notas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registro_entrenamientos_usuario_id_foreign` (`usuario_id`),
  KEY `registro_entrenamientos_asignacion_rutina_id_foreign` (`asignacion_rutina_id`),
  KEY `registro_entrenamientos_dia_entreno_id_foreign` (`dia_entreno_id`),
  CONSTRAINT `registro_entrenamientos_asignacion_rutina_id_foreign` FOREIGN KEY (`asignacion_rutina_id`) REFERENCES `asignacion_rutinas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `registro_entrenamientos_dia_entreno_id_foreign` FOREIGN KEY (`dia_entreno_id`) REFERENCES `dia_entrenos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `registro_entrenamientos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `rutinas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rutinas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `autor_id` bigint unsigned NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kcal_objetivo` smallint unsigned DEFAULT NULL,
  `pasos_objetivo` mediumint unsigned DEFAULT NULL,
  `duracion_aproximada_min` smallint unsigned DEFAULT NULL,
  `dias_entreno` tinyint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rutinas_autor_id_foreign` (`autor_id`),
  CONSTRAINT `rutinas_autor_id_foreign` FOREIGN KEY (`autor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'usuario',
  `genero` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Prefiero no especificarlo',
  `altura` smallint unsigned DEFAULT NULL,
  `objetivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sin objetivo marcado',
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default-pp.png',
  `bloquear_mensajes_desconocidos` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2026_01_16_132348_add_rol_to_users_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2026_03_31_123356_create_conversations_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2026_03_31_123403_create_messages_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2026_03_31_133420_add_last_message_id_to_conversations_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2026_04_08_203646_remove_read_at_and_deleted_at_from_messages_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2026_04_08_203840_remove_updated_at_from_messages_table',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2026_04_10_001658_create_ejercicios_table',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2026_04_10_001948_create_cliente_entrenadors_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2026_04_10_003724_create_rutinas_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2026_04_10_005722_create_asignacion_rutinas_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2026_04_11_162035_create_dia_entrenos_table',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2026_04_11_162441_create_dia_entreno_ejercicios_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2026_04_11_163021_create_registro_corporals_table',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2026_04_11_172051_create_registro_entrenamientos_table',13);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2026_04_11_174844_create_registro_ejercicios_table',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2026_04_11_175951_create_entrenadores_table',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2026_04_15_195859_change_default_estado_in_cliente_entrenadors_table',16);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2026_04_28_000001_add_imagen_to_ejercicios_table',17);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2026_04_28_000002_create_grupos_musculares_table',18);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2026_04_28_000003_create_ejercicio_grupo_muscular_table',18);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2026_04_30_000002_convert_grupo_muscular_to_int_on_ejercicios_table',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2026_04_30_000003_make_fecha_inicio_nullable_on_cliente_entrenadors_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2026_04_30_000004_use_user_id_as_entrenadores_primary_key',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2026_05_04_000001_add_fecha_solicitud_to_cliente_entrenadors_table',22);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2026_05_04_000002_change_fechas_to_datetime_on_cliente_entrenadors_table',23);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2026_05_06_000001_add_leido_to_messages_table',24);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2026_05_06_000002_add_genero_to_users_table',25);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2026_05_06_000003_add_on_update_cascade_to_ejercicio_grupo_muscular_table',26);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2026_05_12_000001_add_privacy_options_to_entrenadores_table',27);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2026_05_12_000002_add_message_privacy_to_users_table',27);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2026_05_15_000001_move_altura_to_users_and_add_objetivo',28);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2026_05_15_000002_add_imagen_to_users_table',29);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2026_05_17_113232_add_masa_muscular_to_registro_corporals_table',30);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2026_05_18_000001_add_duracion_segundos_to_dia_entreno_ejercicios_table',31);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2026_05_18_000001_add_fecha_edicion_to_registro_corporals_table',32);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2026_05_22_000001_add_adherencia_dieta_to_registro_entrenamientos_table',33);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2026_05_22_000002_add_duracion_segundos_realizados_to_registro_ejercicios_table',34);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2026_05_23_000001_add_nombre_to_registro_entrenamientos_table',35);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2026_05_25_000001_create_registro_corporal_images_table',36);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2026_05_28_000001_add_rating_to_entrenadores_table',37);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2026_05_28_000002_add_valoracion_to_cliente_entrenadors_table',38);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2026_05_28_000003_add_numero_valoraciones_to_entrenadores_table',39);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2026_05_28_000001_encrypt_existing_message_bodies',40);
