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
DROP DATABASE IF EXISTS `acheron`;
CREATE DATABASE IF NOT EXISTS `acheron` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `acheron`;

-- Dumping structure for table acheron.clients
DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `last_report` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uq` (`id`,`ip`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Holds a list of all clients that have registered themselves';

-- Dumping data for table acheron.clients: ~2 rows (approximately)
INSERT INTO `clients` (`id`, `ip`, `last_report`) VALUES
	('SURCOM-1', '127.0.0.1', '2024-02-09 15:12:11'),
	('SURCOM-1', '192.168.0.3', '2024-02-09 12:12:26');

-- Dumping structure for table acheron.emitters
DROP TABLE IF EXISTS `emitters`;
CREATE TABLE IF NOT EXISTS `emitters` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_emitters_emitter_types` (`type`),
  CONSTRAINT `FK_emitters_emitter_types` FOREIGN KEY (`type`) REFERENCES `emitter_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Contains emitters (e.g alien machines) that send signals. One emitter may have sent many signals.';

-- Dumping data for table acheron.emitters: ~0 rows (approximately)

-- Dumping structure for table acheron.emitter_types
DROP TABLE IF EXISTS `emitter_types`;
CREATE TABLE IF NOT EXISTS `emitter_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `visible_to_players` enum('Y','N') NOT NULL DEFAULT 'Y',
  `carrierwave1_frequency` int DEFAULT NULL COMMENT 'The approximate frequency of the carrier wave (only applicable to static)',
  `carrirewave1_type` enum('static','modulating') DEFAULT NULL,
  `carrierwave2_frequency` int DEFAULT NULL COMMENT 'The approximate frequency of the carrier wave (only applicable to static)',
  `carrierwave2_type` enum('static','modulating') DEFAULT NULL,
  `datacluster_start` enum('Y','N') NOT NULL,
  `datacluster_start_threshold_low` int DEFAULT '0' COMMENT 'This determines the lower bound of the frequency of the data cluster',
  `datacluster_start_threshold_high` int DEFAULT '0' COMMENT 'This determines the upper bound of the frequency of the data cluster',
  `datacluster_end` enum('Y','N') NOT NULL,
  `datacluster_end_threshold_low` int DEFAULT NULL COMMENT 'This determines the lower bound of the frequency of the data cluster',
  `datacluster_end_threshold_high` int DEFAULT NULL COMMENT 'This determines the upper bound of the frequency of the data cluster',
  `spectrogram_sample` tinytext COMMENT 'The file name of the spectrogram sample for this emitter type',
  `fingerprint_description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Contains all the types of emitters (e.g alien machine types)';

-- Dumping data for table acheron.emitter_types: ~3 rows (approximately)
INSERT INTO `emitter_types` (`id`, `name`, `visible_to_players`, `carrierwave1_frequency`, `carrirewave1_type`, `carrierwave2_frequency`, `carrierwave2_type`, `datacluster_start`, `datacluster_start_threshold_low`, `datacluster_start_threshold_high`, `datacluster_end`, `datacluster_end_threshold_low`, `datacluster_end_threshold_high`, `spectrogram_sample`, `fingerprint_description`) VALUES
	(1, 'XM13/PUPPET MASTER', 'Y', 1240, 'static', NULL, NULL, 'Y', 400, 700, 'N', NULL, NULL, 'xm13.jpg', 'One single static carrier wave at around 1240 Hz, with a one second data cluster at the start ranging from 400 to 700 Hz.'),
	(2, 'XM18/CARGO HAULER', 'Y', NULL, NULL, NULL, NULL, 'Y', 0, 0, 'Y', NULL, NULL, NULL, NULL),
	(3, 'XM12/RHINO', 'Y', NULL, NULL, NULL, NULL, 'Y', 0, 0, 'Y', NULL, NULL, NULL, NULL);

-- Dumping structure for table acheron.map
DROP TABLE IF EXISTS `map`;
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table acheron.map: ~2 rows (approximately)
INSERT INTO `map` (`id`, `timestamp`, `type`, `longitude`, `latitude`, `title`, `visible_to_players`, `velocity`) VALUES
	(15, '2024-02-06 14:49:41', 'POI', '13.744135878074324', '52.59905927193015', 'ACHERON', 1, NULL);

-- Dumping structure for table acheron.map_settings
DROP TABLE IF EXISTS `map_settings`;
CREATE TABLE IF NOT EXISTS `map_settings` (
  `boundary_north` double NOT NULL,
  `boundary_south` double NOT NULL,
  `boundary_west` double NOT NULL,
  `boundary_east` double NOT NULL,
  `center_lat` double NOT NULL,
  `center_lng` double NOT NULL,
  `default_zoom` tinyint NOT NULL DEFAULT '22',
  UNIQUE KEY `boundary_north` (`boundary_north`),
  UNIQUE KEY `boundary_south` (`boundary_south`),
  UNIQUE KEY `boundary_west` (`boundary_west`),
  UNIQUE KEY `boundary_east` (`boundary_east`),
  UNIQUE KEY `default_zoom` (`default_zoom`),
  UNIQUE KEY `center_point` (`center_lng`) USING BTREE,
  UNIQUE KEY `center_lat` (`center_lat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='The setup for the map';

-- Dumping data for table acheron.map_settings: ~1 rows (approximately)
INSERT INTO `map_settings` (`boundary_north`, `boundary_south`, `boundary_west`, `boundary_east`, `center_lat`, `center_lng`, `default_zoom`) VALUES
	(2.6512847442851353, 52.536569560706845, 13.589778740039401, 13.905509501535349, 52.59905927193015, 13.744135878074324, 10);

-- Dumping structure for table acheron.master_map
DROP TABLE IF EXISTS `master_map`;
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table acheron.master_map: ~13 rows (approximately)
INSERT INTO `master_map` (`id`, `timestamp`, `type`, `latitude`, `longitude`, `title`, `visible_to_players`, `velocity`) VALUES
	(2, 0, 'POI', '52.84422641250793', '13.767919873729296', 'Acheron', 1, NULL),
	(3, 0, 'sensor', '52.61840914760089', '13.741008893066414', 'S1', 1, NULL),
	(4, 0, 'sensor', '52.58124344983073', '13.737450209508395', 'S2', 1, NULL),
	(5, 0, 'sensor', '52.60150710712316', '13.730180302739994', 'S3', 1, NULL),
	(6, 0, 'sensor', '52.60482761096874', '13.809417141673253', 'S4', 1, NULL),
	(7, 0, 'sensor', '52.62745086773211', '13.767355374666138', 'S5', 1, NULL),
	(8, 0, 'sensor', '52.58889867758881', '13.795638545678678', 'S6', 1, NULL),
	(9, 0, 'identified_signal', '52.59733752706854', '13.789922453370444', '4432', 1, NULL),
	(10, 0, 'unidentified_signal', '52.605331117851456', '13.735074664246632', '4433', 1, NULL),
	(11, 0, 'surfops', '52.85184419223207', '13.775978512243224', 'SURFOPS', 1, NULL),
	(15, 120, 'surfops', '52.85093731003274', '13.779837580713519', 'SURFOPS', 1, NULL),
	(16, 300, 'surfops', '52.85116984480228', '13.785958838253075', NULL, 1, NULL),
	(17, 550, 'surfops', '52.85263731575558', '13.79593129137452', NULL, 1, NULL),
	(18, 620, 'surfops', '52.85285111533686', '13.798720788720734', NULL, 1, NULL),
	(19, 700, 'surfops', '52.85465865148753', '13.798136067162273', NULL, 1, NULL);

-- Dumping structure for table acheron.sensors
DROP TABLE IF EXISTS `sensors`;
CREATE TABLE IF NOT EXISTS `sensors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `battery_level` tinyint NOT NULL DEFAULT '0',
  `status` enum('online','offline') NOT NULL DEFAULT 'online',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='A list of all sensors available to MISCON';

-- Dumping data for table acheron.sensors: ~6 rows (approximately)
INSERT INTO `sensors` (`id`, `name`, `lat`, `lng`, `battery_level`, `status`) VALUES
	(1, 'ALPHA', 52.60426957076796, 13.678197582625994, 100, 'online'),
	(2, 'BRAVO', 52.63895842289921, 13.756652099685693, 100, 'online'),
	(3, 'CHARLIE', 52.56929627978658, 13.733900433977057, 100, 'online'),
	(4, 'DELTA', 52.603680009970105, 13.82035783975232, 100, 'online'),
	(5, 'ECHO', 52.625620354685196, 13.80324582981024, 100, 'online'),
	(6, 'FOXTROT', 52.58341432322206, 13.793773334775583, 100, 'online'),
	(7, 'GOLF', 52.63141203926695, 13.682337705067553, 89, 'online');

-- Dumping structure for table acheron.signals
DROP TABLE IF EXISTS `signals`;
CREATE TABLE IF NOT EXISTS `signals` (
  `id` int unsigned NOT NULL,
  `emitter` int unsigned NOT NULL,
  `lat` double NOT NULL DEFAULT '0',
  `lng` double NOT NULL DEFAULT '0',
  `velocity` double NOT NULL DEFAULT '0',
  `heading` smallint DEFAULT NULL COMMENT 'The heading (360 degree) of the emitter when transmitting the signal (must be null if velocity = 0)',
  `message` text,
  `encrypted_message` text,
  `designated_type` int DEFAULT NULL,
  `intercepted` datetime DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Contains a list of signals';

-- Dumping data for table acheron.signals: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
