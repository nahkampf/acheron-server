-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5332
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for acheron
DROP DATABASE IF EXISTS `acheron`;
CREATE DATABASE IF NOT EXISTS `acheron` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `acheron`;

-- Dumping structure for table acheron.alert_state
DROP TABLE IF EXISTS `alert_state`;
CREATE TABLE IF NOT EXISTS `alert_state` (
  `current_state` enum('green','blue','red') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'green',
  `time_set` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`current_state`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table acheron.alert_state: ~1 rows (approximately)
DELETE FROM `alert_state`;
/*!40000 ALTER TABLE `alert_state` DISABLE KEYS */;
INSERT INTO `alert_state` (`current_state`, `time_set`) VALUES
	('green', '2024-07-03 13:12:40');
/*!40000 ALTER TABLE `alert_state` ENABLE KEYS */;

-- Dumping structure for table acheron.biomonitor_modes
DROP TABLE IF EXISTS `biomonitor_modes`;
CREATE TABLE IF NOT EXISTS `biomonitor_modes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pulse_low` smallint NOT NULL,
  `pulse_high` smallint NOT NULL,
  `spo2_low` tinyint NOT NULL,
  `spo2_high` tinyint NOT NULL,
  `bp_low` smallint NOT NULL,
  `bp_high` smallint NOT NULL,
  `color` varchar(50) NOT NULL DEFAULT '#00AA00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table acheron.biomonitor_modes: ~6 rows (approximately)
DELETE FROM `biomonitor_modes`;
/*!40000 ALTER TABLE `biomonitor_modes` DISABLE KEYS */;
INSERT INTO `biomonitor_modes` (`id`, `name`, `pulse_low`, `pulse_high`, `spo2_low`, `spo2_high`, `bp_low`, `bp_high`, `color`) VALUES
	(1, 'AT REST', 60, 75, 93, 99, 12, 16, '#00AA00'),
	(2, 'LIGHT ACTIVITY', 75, 100, 93, 99, 14, 20, '#55FF55'),
	(3, 'HEAVY ACTIVITY', 110, 145, 92, 97, 40, 50, '#55FF55'),
	(4, 'PANIC', 150, 185, 87, 92, 60, 70, '#aa911b'),
	(5, 'LIGHT WOUND', 90, 115, 80, 92, 14, 20, '#AA0000'),
	(6, 'DISCONNECTED', 0, 0, 0, 0, 0, 0, '#555555'),
	(7, 'SEVERE WOUND', 50, 75, 50, 71, 6, 10, '#FF5555'),
	(8, 'DECEASED', 0, 0, 0, 0, 0, 0, '#181918'),
	(9, 'DYING', 5, 30, 30, 45, 1, 5, '#FF5555');
/*!40000 ALTER TABLE `biomonitor_modes` ENABLE KEYS */;

-- Dumping structure for table acheron.biomonitor_states
DROP TABLE IF EXISTS `biomonitor_states`;
CREATE TABLE IF NOT EXISTS `biomonitor_states` (
  `surferId` int NOT NULL,
  `currentState` int NOT NULL,
  `setAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `fk_surfer` (`surferId`),
  KEY `fk_mode` (`currentState`),
  CONSTRAINT `fk_mode` FOREIGN KEY (`currentState`) REFERENCES `biomonitor_modes` (`id`),
  CONSTRAINT `fk_surfer` FOREIGN KEY (`surferId`) REFERENCES `surfops_people` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table acheron.biomonitor_states: ~8 rows (approximately)
DELETE FROM `biomonitor_states`;
/*!40000 ALTER TABLE `biomonitor_states` DISABLE KEYS */;
INSERT INTO `biomonitor_states` (`surferId`, `currentState`, `setAt`) VALUES
	(1, 5, '2024-07-11 00:02:22'),
	(3, 1, '2024-07-10 23:45:04'),
	(4, 1, '2024-05-28 13:00:27'),
	(5, 2, '2024-07-11 00:02:10'),
	(6, 1, '2024-07-10 16:33:46'),
	(7, 1, '2024-05-28 13:00:27'),
	(8, 1, '2024-07-10 22:35:44'),
	(2, 1, '2024-05-28 13:05:44');
/*!40000 ALTER TABLE `biomonitor_states` ENABLE KEYS */;

-- Dumping structure for table acheron.clients
DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `last_report` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uq` (`id`,`ip`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Holds a list of all clients that have registered themselves';

-- Dumping data for table acheron.clients: ~0 rows (approximately)
DELETE FROM `clients`;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;

-- Dumping structure for table acheron.emitters
DROP TABLE IF EXISTS `emitters`;
CREATE TABLE IF NOT EXISTS `emitters` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type` int unsigned NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_emitters_emitter_types` (`type`),
  CONSTRAINT `FK_emitters_emitter_types` FOREIGN KEY (`type`) REFERENCES `emitter_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Contains emitters (e.g alien machines) that send signals. One emitter may have sent many signals.';

-- Dumping data for table acheron.emitters: ~0 rows (approximately)
DELETE FROM `emitters`;
/*!40000 ALTER TABLE `emitters` DISABLE KEYS */;
/*!40000 ALTER TABLE `emitters` ENABLE KEYS */;

-- Dumping structure for table acheron.emitter_types
DROP TABLE IF EXISTS `emitter_types`;
CREATE TABLE IF NOT EXISTS `emitter_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(255) NOT NULL DEFAULT 'ground',
  `name` varchar(255) NOT NULL,
  `type` enum('aerial','ground','static','unknown','orbital') NOT NULL DEFAULT 'ground',
  `visible_to_players` enum('Y','N') NOT NULL DEFAULT 'Y',
  `carrierwave1_frequency` int DEFAULT NULL COMMENT 'The approximate frequency of the carrier wave (only applicable to static)',
  `carrierwave2_frequency` int DEFAULT NULL COMMENT 'The approximate frequency of the carrier wave (only applicable to static)',
  `carrierwave3_frequency` enum('static','modulating') DEFAULT NULL,
  `datacluster_start` enum('Y','N') NOT NULL,
  `datacluster_middle` enum('Y','N') NOT NULL,
  `datacluster_end` enum('Y','N') NOT NULL,
  `spectrogram_sample` tinytext COMMENT 'The file name of the spectrogram sample for this emitter type',
  `waveform_file` tinytext,
  `known_max_velocity` tinytext,
  `fingerprint_description` text,
  `orgnotes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Contains all the types of emitters (e.g alien machine types)';

-- Dumping data for table acheron.emitter_types: ~7 rows (approximately)
DELETE FROM `emitter_types`;
/*!40000 ALTER TABLE `emitter_types` DISABLE KEYS */;
INSERT INTO `emitter_types` (`id`, `number`, `name`, `type`, `visible_to_players`, `carrierwave1_frequency`, `carrierwave2_frequency`, `carrierwave3_frequency`, `datacluster_start`, `datacluster_middle`, `datacluster_end`, `spectrogram_sample`, `waveform_file`, `known_max_velocity`, `fingerprint_description`, `orgnotes`) VALUES
	(5, 'XM01', 'PLACEHOLDER', 'aerial', 'Y', 420, 2445, NULL, 'Y', 'Y', 'N', 'cw1_420hz_cw2_2445_start+mid.wav.png', 'cw1_420hz_cw2_2445_start+mid.wav', NULL, '', ''),
	(6, 'XM02', 'PLACEHOLDER', 'aerial', 'Y', 420, 2445, NULL, 'Y', 'Y', 'Y', 'cw1_420hz_cw2_2445_start+mid+end.wav.png', 'cw1_420hz_cw2_2445_start+mid+end.wav', NULL, '                ', '                '),
	(7, 'XM03', 'PLACEHOLDER', 'aerial', 'Y', 1043, NULL, NULL, 'Y', 'N', 'Y', 'cw1_1043hz_start+end.wav.png', 'cw1_1043hz_start+end.wav', NULL, '                ', '                '),
	(8, 'XM04', 'PLACEHOLDER', 'aerial', 'Y', 1043, NULL, NULL, 'Y', 'Y', 'Y', 'cw1_1043hz_start+mid+end.wav.png', 'cw1_1043hz_start+mid+end.wav', NULL, '                ', '                '),
	(9, 'XM203', 'SIREN', 'static', 'N', 450, 4120, NULL, 'Y', 'N', 'Y', NULL, NULL, '0', NULL, 'This is SIREN, the target of OPERATION KEYHOLE, not disclosed at the start of the game'),
	(10, 'XM204', 'test', 'unknown', 'Y', 123, NULL, NULL, 'N', 'Y', 'N', '', '', '3', '        asdfasdfasdf        ', '                '),
	(11, 'XM205', 'rwar1', 'aerial', 'Y', 1, NULL, NULL, 'N', 'N', 'N', '', '', NULL, '                ', '                ');
/*!40000 ALTER TABLE `emitter_types` ENABLE KEYS */;

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

-- Dumping data for table acheron.map: ~0 rows (approximately)
DELETE FROM `map`;
/*!40000 ALTER TABLE `map` DISABLE KEYS */;
INSERT INTO `map` (`id`, `timestamp`, `type`, `longitude`, `latitude`, `title`, `visible_to_players`, `velocity`) VALUES
	(15, '2024-02-06 14:49:41', 'POI', '13.682466520411188', '52.85168195917985', 'ACHERON', 1, NULL);
/*!40000 ALTER TABLE `map` ENABLE KEYS */;

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

-- Dumping data for table acheron.map_settings: ~0 rows (approximately)
DELETE FROM `map_settings`;
/*!40000 ALTER TABLE `map_settings` DISABLE KEYS */;
INSERT INTO `map_settings` (`boundary_north`, `boundary_south`, `boundary_west`, `boundary_east`, `center_lat`, `center_lng`, `default_zoom`) VALUES
	(2.6512847442851353, 52.536569560706845, 13.589778740039401, 13.905509501535349, 52.59905927193015, 13.744135878074324, 10);
/*!40000 ALTER TABLE `map_settings` ENABLE KEYS */;

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

-- Dumping data for table acheron.master_map: ~15 rows (approximately)
DELETE FROM `master_map`;
/*!40000 ALTER TABLE `master_map` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `master_map` ENABLE KEYS */;

-- Dumping structure for table acheron.messages
DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cleartext_message` text NOT NULL,
  `encrypted_message` text NOT NULL,
  `decrypted_message` text NOT NULL,
  `decrypted_timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table acheron.messages: ~0 rows (approximately)
DELETE FROM `messages`;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

-- Dumping structure for table acheron.message_corpus
DROP TABLE IF EXISTS `message_corpus`;
CREATE TABLE IF NOT EXISTS `message_corpus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `phrase` varchar(255) NOT NULL,
  `sequence` varchar(255) NOT NULL,
  `known_to_players` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Contains all the machine "phrases" and ther respective code sequence';

-- Dumping data for table acheron.message_corpus: ~28 rows (approximately)
DELETE FROM `message_corpus`;
/*!40000 ALTER TABLE `message_corpus` DISABLE KEYS */;
INSERT INTO `message_corpus` (`id`, `phrase`, `sequence`, `known_to_players`) VALUES
	(1, 'NOTHING TO REPORT', '%ZQØ', 1),
	(2, 'NOTHING TO REPORT', '±|D', 1),
	(3, 'NOTHING TO REPORT', 'N9#§X', 1),
	(4, 'POSITION', '▼∑7Z', 1),
	(5, 'ALL SYSTEMS NOMINAL', 'P▓«¥9', 1),
	(6, 'SYSTEMS DEGRADED', '╚Æ}F&s', 1),
	(7, 'ANOMALY DETECTED', '*5V]Ñ√%', 1),
	(8, 'FUEL LOW', '+)K«', 1),
	(9, 'THREAT DETECTED', 'É_▓Φ', 1),
	(10, 'COLLECTING SAMPLES', '╤₧ëx3', 1),
	(11, 'EXTRACTING RESOURCES', 'ú┤ ▄±', 1),
	(12, 'RETURNING TO ORIGIN', '╚ß■Ü', 1),
	(13, 'RESUMING ACTIVITY', 'ÑP3>', 1),
	(14, 'HOLDING POSITION', '^£┬', 1),
	(15, 'REBOOTING', '█▐█▐▌°', 1),
	(16, 'SHUTTING DOWN', 'π║j3_^', 1),
	(17, 'ENGAGING THREAT', 'Æ^%»', 1),
	(18, 'EVASIVE MANEUVRES', '¼┼ ▄', 1),
	(19, 'IGNORING', '╙▓╗_Ω', 1),
	(20, 'INVESTIGATING', '3_i^>L', 1),
	(21, 'CONTINUING', '$)>-^', 1),
	(22, 'REQUEST ADDITIONAL UNITS', '¿½ÿ┴', 1),
	(23, 'REQUEST SUPPORT', '┤Yv=', 1),
	(24, 'REQUEST TRANSPORT', '┌█Φ╪_3', 1),
	(25, 'REQUEST REPAIR', '╒Ç{d', 1),
	(26, 'REQUEST RE-ARMING', '-/:§^', 1),
	(27, 'REQUEST REFUELLING', '4h)9_¨', 1),
	(28, 'EMERGENCY FREEZE', 'µ9¥▓S6#<<<±G', 0);
/*!40000 ALTER TABLE `message_corpus` ENABLE KEYS */;

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

-- Dumping data for table acheron.sensors: ~7 rows (approximately)
DELETE FROM `sensors`;
/*!40000 ALTER TABLE `sensors` DISABLE KEYS */;
INSERT INTO `sensors` (`id`, `name`, `lat`, `lng`, `battery_level`, `status`) VALUES
	(1, 'ALPHA', 52.847574913386524, 13.695081624526386, 100, 'online'),
	(2, 'BRAVO', 52.852765038110206, 13.693627011573856, 100, 'online'),
	(3, 'CHARLIE', 52.838515151434194, 13.701548647866206, 100, 'online'),
	(4, 'DELTA', 52.603680009970105, 13.82035783975232, 100, 'online'),
	(5, 'ECHO', 52.625620354685196, 13.80324582981024, 100, 'online'),
	(6, 'FOXTROT', 52.58341432322206, 13.793773334775583, 65, 'online'),
	(7, 'GOLF', 52.63141203926695, 13.682337705067553, 89, 'online');
/*!40000 ALTER TABLE `sensors` ENABLE KEYS */;

-- Dumping structure for table acheron.signals
DROP TABLE IF EXISTS `signals`;
CREATE TABLE IF NOT EXISTS `signals` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emitter` int unsigned NOT NULL,
  `lat` double NOT NULL DEFAULT '0',
  `lng` double NOT NULL DEFAULT '0',
  `velocity` double NOT NULL DEFAULT '0',
  `heading` smallint DEFAULT NULL COMMENT 'The heading (360 degree) of the emitter when transmitting the signal (must be null if velocity = 0)',
  `message` text,
  `encrypted_message` text,
  `designation` varchar(255) DEFAULT NULL,
  `designated_type` int DEFAULT NULL,
  `intercepted` datetime DEFAULT NULL,
  `intercepting_operator` varchar(255) DEFAULT NULL,
  `handled` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `FK_signals_emitter_types` (`emitter`),
  CONSTRAINT `FK_signals_emitter_types` FOREIGN KEY (`emitter`) REFERENCES `emitter_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Contains a list of signals';

-- Dumping data for table acheron.signals: ~3 rows (approximately)
DELETE FROM `signals`;
/*!40000 ALTER TABLE `signals` DISABLE KEYS */;
INSERT INTO `signals` (`id`, `timestamp`, `emitter`, `lat`, `lng`, `velocity`, `heading`, `message`, `encrypted_message`, `designation`, `designated_type`, `intercepted`, `intercepting_operator`, `handled`) VALUES
	(1, '2024-03-31 22:57:16', 6, 52.5728056, 13.6718191, 4, 221, 'MESSEGE HERE LATER', '1234 asd aS 234 FSED FSD ', 'A2', 2, '2024-03-31 17:08:26', NULL, 'Y'),
	(2, '2024-05-24 15:44:17', 5, 52.5128051, 13.7718202, 2, 123, 'test', 'test', 'A4', 2, '2024-07-03 12:10:33', 'asdasdasd', 'Y'),
	(17, '2024-07-04 10:02:46', 6, 52.5728012, 13.7718102, 2, 242, NULL, NULL, 'A5', NULL, '2024-07-04 10:02:48', 'reed', 'Y');
/*!40000 ALTER TABLE `signals` ENABLE KEYS */;

-- Dumping structure for table acheron.surfops_people
DROP TABLE IF EXISTS `surfops_people`;
CREATE TABLE IF NOT EXISTS `surfops_people` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rank` varchar(50) NOT NULL DEFAULT 'Private',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `portrait` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table acheron.surfops_people: ~8 rows (approximately)
DELETE FROM `surfops_people`;
/*!40000 ALTER TABLE `surfops_people` DISABLE KEYS */;
INSERT INTO `surfops_people` (`id`, `rank`, `name`, `portrait`) VALUES
	(1, 'Sergeant', 'Walker', 'walker.gif'),
	(2, 'Corporal', 'Dubois', 'dubois.gif'),
	(3, 'Private', 'Harding', 'harding.gif'),
	(4, 'Private', 'Hook', 'hook.gif'),
	(5, 'Private', 'Milner', 'milner.gif'),
	(6, 'Private', 'Palastra', 'palastra.gif'),
	(7, 'Private', 'Tabor', 'tabor.gif'),
	(8, 'Private', 'Bishop', 'bishop.gif');
/*!40000 ALTER TABLE `surfops_people` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
