-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for acheron
CREATE DATABASE IF NOT EXISTS `acheron` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `acheron`;

-- Dumping structure for table acheron.map
CREATE TABLE IF NOT EXISTS `map` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'number of seconds after game start. 0 means visible from start',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'type (surfops position marker, signal, POI)',
  `longitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `latitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `visible_to_players` tinyint NOT NULL DEFAULT '0',
  `velocity` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table acheron.map: ~14 rows (approximately)
INSERT INTO `map` (`id`, `timestamp`, `type`, `longitude`, `latitude`, `title`, `visible_to_players`, `velocity`) VALUES
	(1, '2023-11-08 13:49:28', 'POI', '59.802614249571484', '17.604689564274832', 'Thermopylae', 1, NULL),
	(2, '2023-11-08 13:49:28', 'POI', '59.90613537039398', '17.751789236646793', 'Acheron', 1, NULL),
	(3, '2023-11-08 13:49:28', 'sensor', '59.89550057427903', '17.76108019063312', 'S1', 1, NULL),
	(4, '2023-11-08 13:49:28', 'sensor', '59.89181799240169', '17.87089225770469', 'S2', 1, NULL),
	(5, '2023-11-08 13:49:28', 'sensor', '59.94411276329685', '17.80667167971829', 'S3', 1, NULL),
	(6, '2023-11-08 13:49:28', 'sensor', '59.92659558208488', '17.83902910585483', 'S4', 1, NULL),
	(7, '2023-11-08 13:49:28', 'sensor', '59.905521652390576', '17.861303718915767', 'S5', 1, NULL),
	(8, '2023-11-08 13:49:28', 'sensor', '59.94143199171038', '17.85019775407321', 'S6', 1, NULL),
	(9, '2023-12-08 11:42:18', 'identified_signal', '59.88762074976222', '17.832902984524722', 'ES4821', 1, NULL),
	(10, '2023-12-08 12:12:31', 'unidentified_signal', '59.89752782405735', '17.832613960287603', NULL, 1, NULL),
	(11, '2023-12-08 12:44:28', 'surfops', '59.91263616439707', '17.794781764200234', NULL, 1, NULL),
	(12, '2023-12-08 13:29:28', 'surfops', '59.90808431570929', '17.801146498221584', NULL, 1, NULL),
	(13, '2023-12-08 13:39:28', 'surfops', '59.904024666465716', '17.814109963880888', NULL, 0, NULL),
	(14, '2023-12-08 13:49:28', 'surfops', '59.90449401544955', '17.829085808637007', NULL, 0, NULL);

-- Dumping structure for table acheron.master_map
CREATE TABLE IF NOT EXISTS `master_map` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int unsigned NOT NULL DEFAULT '0' COMMENT 'number of seconds after game start. 0 means visible from start',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'type (surfops position marker, signal, POI)',
  `latitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `longitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `visible_to_players` tinyint NOT NULL DEFAULT '0',
  `velocity` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table acheron.master_map: ~14 rows (approximately)
INSERT INTO `master_map` (`id`, `timestamp`, `type`, `latitude`, `longitude`, `title`, `visible_to_players`, `velocity`) VALUES
	(1, 0, 'POI', '59.802614249571484', '17.604689564274832', 'Thermopylae', 1, NULL),
	(2, 0, 'POI', '59.90613537039398', '17.751789236646793', 'Acheron', 1, NULL),
	(3, 0, 'sensor', '59.89550057427903', '17.76108019063312', 'S1', 1, NULL),
	(4, 0, 'sensor', '59.89181799240169', '17.87089225770469', 'S2', 1, NULL),
	(5, 0, 'sensor', '59.94411276329685', '17.80667167971829', 'S3', 1, NULL),
	(6, 0, 'sensor', '59.92659558208488', '17.83902910585483', 'S4', 1, NULL),
	(7, 0, 'sensor', '59.905521652390576', '17.861303718915767', 'S5', 1, NULL),
	(8, 0, 'sensor', '59.94143199171038', '17.85019775407321', 'S6', 1, NULL),
	(9, 0, 'identified_signal', '59.88762074976222', '17.832902984524722', 'ES4821', 1, NULL),
	(10, 0, 'unidentified_signal', '59.89752782405735', '17.832613960287603', NULL, 1, NULL),
	(11, 0, 'surfops', '59.91263616439707', '17.794781764200234', NULL, 1, NULL),
	(12, 600, 'surfops', '59.90808431570929', '17.801146498221584', NULL, 1, NULL),
	(13, 1200, 'surfops', '59.904024666465716', '17.814109963880888', NULL, 0, NULL),
	(14, 1800, 'surfops', '59.90449401544955', '17.829085808637007', NULL, 0, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
