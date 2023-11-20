-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: appAgenda
-- ------------------------------------------------------
-- Server version	10.6.12-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `clinics`
--

DROP TABLE IF EXISTS `clinics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clinics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `indirizzo` varchar(255) DEFAULT NULL,
  `localita` varchar(255) DEFAULT NULL,
  `cap` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `attivo` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clinics`
--

LOCK TABLES `clinics` WRITE;
/*!40000 ALTER TABLE `clinics` DISABLE KEYS */;
INSERT INTO `clinics` VALUES (1,2,'Dalmazia','Piazza Dalmazia, 34','Firenze','50134','FI','055652314',1,'2023-11-13 11:22:32','2023-11-14 13:16:23'),(2,2,'Sodo','Via Gianfilippo Braccini, 4','Firenze','50141','FI','301211115',1,'2023-11-14 09:58:02','2023-11-14 13:16:38');
/*!40000 ALTER TABLE `clinics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attivo` tinyint(1) NOT NULL DEFAULT 1,
  `email` varchar(255) DEFAULT NULL,
  `ragione_sociale` varchar(255) NOT NULL,
  `indirizzo` varchar(255) DEFAULT NULL,
  `localita` varchar(255) DEFAULT NULL,
  `cap` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `piva` varchar(20) DEFAULT NULL,
  `iban` varchar(30) DEFAULT NULL,
  `telefono` varchar(40) DEFAULT NULL,
  `cellulare` varchar(40) DEFAULT NULL,
  `codice_destinatario` varchar(7) DEFAULT NULL,
  `pec` varchar(255) DEFAULT NULL,
  `privato` tinyint(1) NOT NULL DEFAULT 0,
  `pubblico` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `companies_piva_unique` (`piva`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,1,'info@s-mart.biz','Network SAS','Via Emidio Spinucci 41','Firenze','50141','FI','','05345670482','IT0123569874521023152125412','055430352','3393012514','TRS30H9','',1,0,NULL,NULL),(2,1,'arcibaldo29@email.it','Rossi-Bianco SPA','Strada Ricci 615','Rossetti a mare','82953','MA',NULL,'86613385814','AT883810012714665143','+96 32 3116674','+33 94 8530307','O/DRLHM','eusebio.mancini@yahoo.it',0,0,'2023-11-15 13:08:54','2023-11-15 13:08:54'),(3,1,'uneri@bruno.com','Palmieri, Conte e Longo Group','Incrocio Grassi 49','Tommaso umbro','43633','RW',NULL,'27165699733','RS97538614757439555120','+38 300 33392443','+98 28 1250333','BZ6NK9/','arturo.ferraro@fiore.net',0,0,'2023-11-15 13:09:40','2023-11-15 13:09:40'),(4,1,'ilario.sanna@ferraro.it','Ricci SPA','Incrocio Valentini 8 Appartamento 62','Settimo Boris nell\'emilia','65396','IY',NULL,'12318021757','BA528421579934244435','382 065 977','+30 006 27595506','EH5R442','wrusso@hotmail.com',0,0,'2023-11-16 09:07:11','2023-11-16 09:07:11');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_services`
--

DROP TABLE IF EXISTS `company_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_services` (
  `company_id` bigint(20) unsigned NOT NULL,
  `service_id` bigint(20) unsigned NOT NULL,
  KEY `company_services_company_id_foreign` (`company_id`),
  KEY `company_services_service_id_foreign` (`service_id`),
  CONSTRAINT `company_services_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `company_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_services`
--

LOCK TABLES `company_services` WRITE;
/*!40000 ALTER TABLE `company_services` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor_clinics`
--

DROP TABLE IF EXISTS `doctor_clinics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctor_clinics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `clinic_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_clinics_doctor_id_foreign` (`doctor_id`),
  KEY `doctor_clinics_clinic_id_foreign` (`clinic_id`),
  CONSTRAINT `doctor_clinics_clinic_id_foreign` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`),
  CONSTRAINT `doctor_clinics_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_clinics`
--

LOCK TABLES `doctor_clinics` WRITE;
/*!40000 ALTER TABLE `doctor_clinics` DISABLE KEYS */;
/*!40000 ALTER TABLE `doctor_clinics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor_users`
--

DROP TABLE IF EXISTS `doctor_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctor_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_users_user_id_foreign` (`user_id`),
  KEY `doctor_users_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `doctor_users_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`),
  CONSTRAINT `doctor_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_users`
--

LOCK TABLES `doctor_users` WRITE;
/*!40000 ALTER TABLE `doctor_users` DISABLE KEYS */;
INSERT INTO `doctor_users` VALUES (1,3,2,'2023-11-15 16:05:42','2023-11-15 16:05:46'),(2,4,2,'2023-11-15 16:05:56','2023-11-15 16:05:59'),(3,5,2,'2023-11-15 16:06:15','2023-11-15 16:06:16'),(4,6,2,'2023-11-15 16:06:24','2023-11-15 16:06:26'),(5,3,7,'2023-11-16 10:09:19','2023-11-16 10:09:23');
/*!40000 ALTER TABLE `doctor_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `clinic_id` bigint(20) unsigned NOT NULL,
  `denominazione` varchar(255) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `ora` time DEFAULT NULL,
  `stato` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `events_doctor_id_foreign` (`doctor_id`),
  KEY `events_clinic_id_foreign` (`clinic_id`),
  CONSTRAINT `events_clinic_id_foreign` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`),
  CONSTRAINT `events_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,2,NULL,1,'aaa','2023-11-16','16:48:19',1,'2023-11-16 15:48:24','2023-11-16 15:48:27');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `messaggio` text NOT NULL,
  `ticket_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_ticket_id_foreign` (`ticket_id`),
  KEY `messages_user_id_foreign` (`user_id`),
  CONSTRAINT `messages_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_04_19_074118_create_companies_table',1),(2,'2014_10_10_090028_create_user_types_table',1),(3,'2014_10_12_000000_create_users_table',1),(4,'2014_10_12_100000_create_password_reset_tokens_table',1),(5,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),(6,'2019_08_19_000000_create_failed_jobs_table',1),(7,'2019_12_14_000001_create_personal_access_tokens_table',1),(8,'2023_03_22_080844_create_sessions_table',1),(9,'2023_03_23_091705_create_permission_tables',1),(10,'2023_05_03_072232_create_services_table',1),(11,'2023_05_03_074744_create_ticket_types_table',1),(12,'2023_05_03_075415_create_tickets_table',1),(13,'2023_05_09_092412_create_messages_table',1),(14,'2023_05_09_093035_create_ticket_users_table',1),(15,'2023_05_09_144158_create_company_services_table',1),(16,'2023_11_09_132835_create_schedules_table',1),(17,'2023_11_09_132848_create_prescriptions_table',1),(18,'2023_11_09_132904_create_timetalbe_table',1),(19,'2023_11_09_133129_create_clinics_table',1),(20,'2023_11_09_133137_create_events_table',1),(21,'2023_11_09_137742_create_doctor_clinics_table',1),(22,'2023_11_15_155859_create_doctor_users_table',2),(23,'2020_05_21_100000_create_teams_table',3),(24,'2020_05_21_200000_create_team_user_table',3),(25,'2020_05_21_300000_create_team_invitations_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(2,'App\\Models\\User',3),(4,'App\\Models\\User',4),(4,'App\\Models\\User',6),(4,'App\\Models\\User',7);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'user.create','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(2,'user.edit','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(3,'user.list','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(4,'company.create','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(5,'company.list','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(6,'company.edit','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(7,'customers.create','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(8,'customers.list','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(9,'customers.edit','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(10,'tickets.create','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(11,'tickets.list','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(12,'tickets.edit','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(13,'services.create','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(14,'services.list','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(15,'services.edit','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(16,'tipiTickets.create','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(17,'tipiTickets.list','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(18,'tipiTickets.edit','web','2023-11-13 09:10:44','2023-11-13 09:10:44');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prescriptions`
--

DROP TABLE IF EXISTS `prescriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `farmaci` varchar(255) DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `attiva` tinyint(1) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prescriptions`
--

LOCK TABLES `prescriptions` WRITE;
/*!40000 ALTER TABLE `prescriptions` DISABLE KEYS */;
INSERT INTO `prescriptions` VALUES (1,2,4,'visita cardiologica ','malattia cronica',1,3,'2023-11-13 13:52:18','2023-11-14 13:30:35'),(2,2,4,'tachipirina 1000, brufen 600','Influenza',0,1,'2023-10-13 13:31:01','2023-11-16 12:56:23'),(3,2,4,'colesterolo, glicemia, transaminasi','controllo annuale',1,2,'2023-11-15 14:25:28','2023-11-16 12:56:45');
/*!40000 ALTER TABLE `prescriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(1,2),(1,3),(1,4),(2,1),(2,2),(2,3),(2,4),(3,1),(3,2),(3,3),(3,4),(4,1),(4,2),(4,3),(4,4),(5,1),(5,2),(5,3),(5,4),(6,1),(6,2),(6,3),(6,4),(7,1),(7,2),(7,3),(7,4),(8,1),(8,2),(8,3),(8,4),(9,1),(9,2),(9,3),(9,4),(10,1),(10,2),(10,3),(10,4),(11,1),(11,2),(11,3),(11,4),(12,1),(12,2),(12,3),(12,4),(13,1),(13,2),(13,3),(13,4),(14,1),(14,2),(14,3),(14,4),(15,1),(15,2),(15,3),(15,4),(16,1),(16,2),(16,3),(16,4),(17,1),(17,2),(17,3),(17,4),(18,1),(18,2),(18,3),(18,4);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'amministratore','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(2,'medico','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(3,'segretaria','web','2023-11-13 09:10:44','2023-11-13 09:10:44'),(4,'paziente','web','2023-11-13 09:10:44','2023-11-13 09:10:44');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) NOT NULL,
  `clinic_id` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `quantita` int(11) DEFAULT NULL,
  `minuti` int(11) DEFAULT NULL,
  `giorno` int(11) DEFAULT NULL,
  `inizio` varchar(5) DEFAULT NULL,
  `attivo` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (1,2,1,1,10,15,1,'08:00',1,'2023-11-15 08:54:11','2023-11-16 13:26:18'),(2,2,1,1,10,15,2,'09:30',1,'2023-11-16 13:36:13','2023-11-16 13:44:48'),(3,2,1,1,10,20,3,'09:00',1,'2023-11-16 13:46:07','2023-11-16 13:50:47'),(4,2,1,1,12,20,4,'15:00',1,'2023-11-16 13:51:33','2023-11-16 13:51:33');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_company_id_foreign` (`company_id`),
  CONSTRAINT `services_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_invitations`
--

DROP TABLE IF EXISTS `team_invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_invitations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_invitations_team_id_email_unique` (`team_id`,`email`),
  CONSTRAINT `team_invitations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_invitations`
--

LOCK TABLES `team_invitations` WRITE;
/*!40000 ALTER TABLE `team_invitations` DISABLE KEYS */;
/*!40000 ALTER TABLE `team_invitations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_user`
--

DROP TABLE IF EXISTS `team_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_user_team_id_user_id_unique` (`team_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_user`
--

LOCK TABLES `team_user` WRITE;
/*!40000 ALTER TABLE `team_user` DISABLE KEYS */;
INSERT INTO `team_user` VALUES (1,1,1,NULL,NULL,NULL),(2,1,2,NULL,NULL,NULL),(3,1,3,NULL,NULL,NULL),(4,1,4,NULL,NULL,NULL),(5,1,5,NULL,NULL,NULL),(6,1,6,NULL,NULL,NULL);
/*!40000 ALTER TABLE `team_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `personal_team` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teams_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,1,'Gruppo M',1,NULL,NULL),(2,7,'Gruppo A',2,NULL,NULL);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_types`
--

DROP TABLE IF EXISTS `ticket_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  `company_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_types_company_id_foreign` (`company_id`),
  CONSTRAINT `ticket_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_types`
--

LOCK TABLES `ticket_types` WRITE;
/*!40000 ALTER TABLE `ticket_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_users`
--

DROP TABLE IF EXISTS `ticket_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_users_ticket_id_foreign` (`ticket_id`),
  KEY `ticket_users_user_id_foreign` (`user_id`),
  CONSTRAINT `ticket_users_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  CONSTRAINT `ticket_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_users`
--

LOCK TABLES `ticket_users` WRITE;
/*!40000 ALTER TABLE `ticket_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ticket` varchar(255) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `ora` time DEFAULT NULL,
  `stato` int(11) NOT NULL DEFAULT 1,
  `customer_id` bigint(20) unsigned DEFAULT NULL,
  `service_id` bigint(20) unsigned DEFAULT NULL,
  `ticket_type_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_customer_id_foreign` (`customer_id`),
  KEY `tickets_service_id_foreign` (`service_id`),
  KEY `tickets_ticket_type_id_foreign` (`ticket_type_id`),
  CONSTRAINT `tickets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  CONSTRAINT `tickets_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  CONSTRAINT `tickets_ticket_type_id_foreign` FOREIGN KEY (`ticket_type_id`) REFERENCES `ticket_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timetalbes`
--

DROP TABLE IF EXISTS `timetalbes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timetalbes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ora` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timetalbes`
--

LOCK TABLES `timetalbes` WRITE;
/*!40000 ALTER TABLE `timetalbes` DISABLE KEYS */;
/*!40000 ALTER TABLE `timetalbes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descrizione` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_types`
--

LOCK TABLES `user_types` WRITE;
/*!40000 ALTER TABLE `user_types` DISABLE KEYS */;
INSERT INTO `user_types` VALUES (1,'amministratore',NULL,NULL),(2,'medico',NULL,NULL),(3,'paziente',NULL,NULL),(4,'segretaria',NULL,NULL);
/*!40000 ALTER TABLE `user_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `indirizzo` varchar(255) DEFAULT NULL,
  `localita` varchar(255) DEFAULT NULL,
  `cap` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `user_type_id` bigint(20) unsigned DEFAULT NULL,
  `current_team_id` bigint(20) unsigned DEFAULT NULL,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_user_type_id_foreign` (`user_type_id`),
  KEY `users_company_id_foreign` (`company_id`),
  CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `users_user_type_id_foreign` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Amministratore','luca@s-mart.biz','$2y$10$t/xnyMqDBVIC0jxu79yBaeXuQNkoUgG.4H2.jcK3IU8hlYvQzPSvS',NULL,NULL,NULL,'2023-11-13 14:15:46','Via Vittorio Emanuele II, 279','Firenze','50134','FI',NULL,NULL,1,1,1,'profile-photos/dc14QSUBkiERcAiUXpvjpCEXuBTwUEVc1jpa3gAE.jpg','2023-11-13 09:10:44','2023-11-13 14:15:46'),(2,'Luca Mistretta','lucanetworksas@gmail.com','$2y$10$mwKUtBx7fpQbuywK29YZ1uTAvGg20WBt08Nzz4rUQ9Jno1wOhNu7i',NULL,NULL,NULL,'2023-11-13 14:15:14','Via Vittorio Emanuele II, 279','Firenze','50134','FI',NULL,NULL,2,1,1,'profile-photos/lN86FHwz5Sn5MwmZlLiBphkmWHEZtLmkmB2zLic5.png','2023-11-13 09:10:44','2023-11-13 14:15:14'),(3,'Segretaria','segretaria@nwk.it','$2y$10$uiLyJNBZoleyEiiAn0hy/ehsyoPrrkyJjd3lS7gnq3WbjBjhDinsS',NULL,NULL,NULL,NULL,'Piazza Dalmazia, 5','Firenze','50134','FI',NULL,NULL,4,1,1,'profile-photos/dyFYaOOjTdBQGGQDt3Rg8XxRP9Ak8EAGdHB7JETe.png','2023-11-13 09:10:44','2023-11-13 09:17:20'),(4,'Paolo Rossi Paziente','paolo@nwk.it','$2y$10$//KGEXphXLVRUeCXAMi02.S3g26hZRTP/dp9JN/ydwVSazD3kin4u',NULL,NULL,NULL,NULL,'Via Emidio Spinucci 41','Firenze','50141','FI',NULL,NULL,3,1,1,'profile-photos/YjVD9n1Zm7mqnwWXPEQ6jXRe5DyioGQ65G2rxhtl.jpg','2023-11-13 09:10:44','2023-11-13 09:17:37'),(5,'Enrica Palumbo','donati.oreste@example.org','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,'2023-11-15 13:08:54','Borgo Evita 9 Appartamento 30','Borgo Erminia del friuli','63769','YX',NULL,'Vqiz9eetoU',3,1,2,NULL,'2023-11-15 13:08:54','2023-11-15 13:08:54'),(6,'Ing. Neri Santoro','claudia29@example.net','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,'2023-11-15 13:09:40','Contrada De luca 161 Appartamento 45','Marco laziale','14263','DY',NULL,'7xANawwICg',3,1,3,NULL,'2023-11-15 13:09:40','2023-11-15 13:09:40'),(7,'Davide Grassi','olo.barbieri@example.org','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,'2023-11-16 09:07:11','Piazza Fortunata 6 Appartamento 72','Ferretti laziale','09867','OD',NULL,'9CiBbXPu50',2,2,4,NULL,'2023-11-16 09:07:11','2023-11-16 09:07:11');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-20 10:11:39
