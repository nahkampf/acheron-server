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
	('green', '2024-07-15 02:03:55');
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

-- Dumping data for table acheron.biomonitor_modes: ~8 rows (approximately)
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
  `number_of_cws` int NOT NULL,
  `carrierwave1_frequency` int DEFAULT NULL COMMENT 'The approximate frequency of the carrier wave (only applicable to static)',
  `carrierwave2_frequency` int DEFAULT NULL COMMENT 'The approximate frequency of the carrier wave (only applicable to static)',
  `carrierwave3_frequency` int DEFAULT NULL,
  `datacluster_start` enum('Y','N') NOT NULL,
  `datacluster_middle` enum('Y','N') NOT NULL,
  `datacluster_end` enum('Y','N') NOT NULL,
  `spectrogram_sample` varchar(255) DEFAULT NULL COMMENT 'The file name of the spectrogram sample for this emitter type',
  `waveform_file` varchar(255) DEFAULT NULL,
  `known_max_velocity` tinytext,
  `fingerprint_description` text,
  `orgnotes` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`waveform_file`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Contains all the types of emitters (e.g alien machine types)';

-- Dumping data for table acheron.emitter_types: ~16 rows (approximately)
DELETE FROM `emitter_types`;
/*!40000 ALTER TABLE `emitter_types` DISABLE KEYS */;
INSERT INTO `emitter_types` (`id`, `number`, `name`, `type`, `visible_to_players`, `number_of_cws`, `carrierwave1_frequency`, `carrierwave2_frequency`, `carrierwave3_frequency`, `datacluster_start`, `datacluster_middle`, `datacluster_end`, `spectrogram_sample`, `waveform_file`, `known_max_velocity`, `fingerprint_description`, `orgnotes`) VALUES
	(5, 'XM01', 'Strip Miner', 'static', 'Y', 1, 89, NULL, NULL, 'N', 'Y', 'N', 'cw1_89_mid.wav.png', 'cw1_89_mid.wav', 'N/A', '', ''),
	(12, 'XM02', 'Refinery Complex', 'static', 'Y', 1, 1550, NULL, NULL, 'N', 'N', 'Y', 'cw1_1550_end.wav.png', 'cw1_1550_end.wav', 'N/A', NULL, NULL),
	(13, 'XM03', 'Fabber', 'static', 'Y', 1, 150, NULL, NULL, 'Y', 'N', 'N', 'cw1_150_start.wav.png', 'cw1_150_start.wav', 'N/A', NULL, NULL),
	(14, 'XM04', 'Spore Chimney', 'static', 'Y', 1, 437, NULL, NULL, 'N', 'N', 'Y', 'cw1_437_end.wav.png', 'cw1_437_end.wav', 'N/A', NULL, NULL),
	(15, 'XM05', 'Orbital Tug', 'aerial', 'Y', 1, 2445, NULL, NULL, 'Y', 'N', 'N', 'cw1_2445_start.wav.png', 'cw1_2445_start.wav', '150', NULL, NULL),
	(16, 'XM06', 'Heavy Air Cargo Transport', 'aerial', 'Y', 1, 2445, NULL, NULL, 'Y', 'N', 'Y', 'cw1_2445_start_end.wav.png', 'cw1_2445_start_end.wav', NULL, NULL, NULL),
	(17, 'XM07', 'Light Air Cargo Transport', 'aerial', 'Y', 2, 3768, 150, NULL, 'Y', 'Y', 'N', 'cw1_3768_cw2_150_start_mid.wav.png', 'cw1_3768_cw2_150_start+mid.wav', NULL, NULL, NULL),
	(18, 'XM08', 'Land Train', 'ground', 'Y', 3, 437, 1043, 3768, 'Y', 'Y', 'N', 'cw1_437_cw2_1043_cw3_3768_start_mid.wav.png', 'cw1_437_cw2_1043_cw3_3768_start_mid.wav', NULL, NULL, NULL),
	(19, 'XM09', 'Tracked Ground Transport', 'ground', 'Y', 0, NULL, NULL, NULL, 'Y', 'N', 'N', 'start.wav.png', 'start.wav', NULL, NULL, NULL),
	(20, 'XM10', 'Spider Transport', 'ground', 'Y', 1, 2445, NULL, NULL, 'N', 'Y', 'N', 'cw1_2445_mid.wav.png', 'cw1_2445_mid.wav', NULL, NULL, NULL),
	(21, 'XM11', 'Airlift', 'aerial', 'Y', 1, 806, NULL, NULL, 'Y', 'N', 'N', 'cw1_806_start.wav.png', 'cw1_806_start.wav', NULL, NULL, NULL),
	(22, 'XM12', 'Mulcher', 'ground', 'Y', 1, 437, NULL, NULL, 'Y', 'Y', 'N', 'cw1_437_start_mid.wav.png', 'cw1_437_start_mid.wav', NULL, NULL, NULL),
	(23, 'XM13', 'Drop Pod', 'aerial', 'Y', 1, 89, 1550, NULL, 'N', 'Y', 'N', 'cw1_89_cw2_1550_mid.wav.png', 'cw1_89_cw2_1550_mid.wav', NULL, NULL, NULL),
	(24, 'XM14', 'Heavy Bomber', 'aerial', 'Y', 2, 203, 806, NULL, 'Y', 'Y', 'Y', 'cw1_806_cw2_203_start_mid_end.wav.png', 'cw1_806_cw2_203_start_mid_end.wav', '200', NULL, NULL),
	(25, 'XM15', 'Mosquito', 'aerial', 'Y', 1, 806, NULL, NULL, 'Y', 'N', 'Y', 'cw1_806_start_end.wav.png', 'cw1_806_start_end.wav', '450', NULL, NULL),
	(26, 'XM16', 'Sunfield', 'static', 'Y', 1, 1550, NULL, NULL, 'Y', 'Y', 'N', 'cw1_1550_start_mid.wav.png', 'cw1_1550_start_mid.wav', 'N/A', NULL, NULL);
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
  `cleartext_message` text,
  `utf8_message` text,
  `cp437_message` text,
  `phraseIds` text,
  `user_decrypted_text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table acheron.messages: ~3 rows (approximately)
DELETE FROM `messages`;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`id`, `cleartext_message`, `utf8_message`, `cp437_message`, `phraseIds`, `user_decrypted_text`) VALUES
	(11, 'POSITION / NOTHING TO REPORT / REBOOTING / REQUEST TRANSPORT / SHUTTING DOWN / THREAT DETECTED / SYSTEMS DEGRADED / RESUMING ACTIVITY / ALL SYSTEMS NOMINAL / ', NULL, '211 45 201 140 143 97 242 151 140 180 155 168 170 122 159 40 163 167 214 140 41 47 99 218 98 175 78 54 128 106 236 225 35 106 132 147 72 85 170 197 109 176 157 119 251 201 42 122 162 216 35 229 56 219 236 219 236 153 61 61 125 52 226 58 91 238 56 97 144 170 112 61 252 54 176 238 92 252 59 86 252 119 226 115 64 109 154 237 68 248 176 93 150 60 238 117 92 161 177 93 196 111 163 195 212 253 228 100 139 127 109 61 150 242 163 166 131 122 204 45 153 233 165 243 37 228 141 143 80 184 71 47 48 157 131 188 237 156 153 112 88 150 208 239 131 160 39 42 39 206 32 66 110 206 188 72 182 169 153 150 174 162 77 224 110 107 89 63 248 151 144 60 115 247 74 158 180 189 102 76 168 158 159 94 160 175 189 63 54 142 73 140 88 212 220 129 176 57 93 118 120 164 109 111 152 174 192 206 48 174 80 240 88 89 66 144 202 149 89 192 106 ', '4;3;15;24;16;9;6;13;5', NULL),
	(12, 'ALL SYSTEMS NOMINAL / CONTINUING / EXTRACTING RESOURCES / ', NULL, '146 200 190 53 127 203 176 57 93 118 120 163 75 180 100 42 165 119 144 58 126 182 187 78 232 37 228 194 93 137 215 187 194 248 215 188 152 39 150 62 38 190 165 161 87 63 57 163 34 72 181 181 177 80 223 122 73 69 54 44 33 167 142 175 171 102 121 237 247 245 140 68 211 104 239 134 102 203 189 227 204 57 251 48 191 227 87 253 166 ', '5;21;11', NULL);
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
	(1, 'NOTHING TO REPORT', '95 178 201 72 94 146', 1),
	(2, 'NOTHING TO REPORT', '130 179 157 123', 1),
	(3, 'NOTHING TO REPORT', '106 236 225 35', 1),
	(4, 'POSITION', '180 155 168 170 122', 1),
	(5, 'ALL SYSTEMS NOMINAL', '176 57 93 118 120', 1),
	(6, 'SYSTEMS DEGRADED', '182 169 153 150 174 162', 1),
	(7, 'ANOMALY DETECTED', '187 165 178 219 240 105', 1),
	(8, 'FUEL LOW', '219 117 92 81 176', 1),
	(9, 'THREAT DETECTED', '47 48 157 131 188 237', 1),
	(10, 'COLLECTING SAMPLES', '203 241 220 232 156 71', 1),
	(11, 'EXTRACTING RESOURCES', '44 33 167 142 175 171', 1),
	(12, 'RETURNING TO ORIGIN', '166 128 165 116 226 238', 1),
	(13, 'RESUMING ACTIVITY', '189 102 76 168 158', 1),
	(14, 'HOLDING POSITION', '164 87 108 94 190', 1),
	(15, 'REBOOTING', '219 236 219 236 153 61 61', 1),
	(16, 'SHUTTING DOWN', '163 166 131 122 204 45', 1),
	(17, 'ENGAGING THREAT', '155 154 208 197 221 234', 1),
	(18, 'EVASIVE MANEUVRES', '165 58 120 218 159', 1),
	(19, 'IGNORING', '214 142 152 228 229', 1),
	(20, 'INVESTIGATING', '166 51 157 110 125 75', 1),
	(21, 'CONTINUING', '150 62 38 190 165 161', 1),
	(22, 'REQUEST ADDITIONAL UNITS', '145 100 78 193 177 242', 1),
	(23, 'REQUEST SUPPORT', '114 144 119 251 230 181', 1),
	(24, 'REQUEST TRANSPORT', '64 109 154 237 68', 1),
	(25, 'REQUEST REPAIR', '116 100 230 166 83 153', 1),
	(26, 'REQUEST RE-ARMING', '141 152 155 170 83', 1),
	(27, 'REQUEST REFUELLING', '101 50 191 125 60', 1),
	(28, 'EMERGENCY FREEZE', '219 237 93 93 228 199 157 188 238 72', 0);
/*!40000 ALTER TABLE `message_corpus` ENABLE KEYS */;

-- Dumping structure for table acheron.sensors
DROP TABLE IF EXISTS `sensors`;
CREATE TABLE IF NOT EXISTS `sensors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `battery_level` tinyint NOT NULL DEFAULT '0',
  `status` enum('online','offline','degraded') NOT NULL DEFAULT 'online',
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
  `encrypted_message` int DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `designated_type` int DEFAULT NULL,
  `intercepted` datetime DEFAULT NULL,
  `intercepting_operator` varchar(255) DEFAULT NULL,
  `handled` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `FK_signals_emitter_types` (`emitter`),
  KEY `FK_encrypted_message` (`encrypted_message`),
  CONSTRAINT `FK_encrypted_message` FOREIGN KEY (`encrypted_message`) REFERENCES `messages` (`id`),
  CONSTRAINT `FK_signals_emitter_types` FOREIGN KEY (`emitter`) REFERENCES `emitter_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Contains a list of signals';

-- Dumping data for table acheron.signals: ~2 rows (approximately)
DELETE FROM `signals`;
/*!40000 ALTER TABLE `signals` DISABLE KEYS */;
INSERT INTO `signals` (`id`, `timestamp`, `emitter`, `lat`, `lng`, `velocity`, `heading`, `message`, `encrypted_message`, `designation`, `designated_type`, `intercepted`, `intercepting_operator`, `handled`) VALUES
	(2, '2024-05-24 15:44:17', 5, 52.5128051, 13.7718202, 2, 123, 'ASDASD ASD ASD ', 11, 'A4', 5, '2024-07-15 01:42:25', 'asdasdasd', 'Y'),
	(18, '2024-07-17 01:57:40', 20, 52.5128011, 13.7718187, 23, 22, NULL, NULL, 'A5', 20, '2024-07-17 01:58:12', 'Reed', 'Y');
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

-- Dumping structure for table acheron.surfops_positions
DROP TABLE IF EXISTS `surfops_positions`;
CREATE TABLE IF NOT EXISTS `surfops_positions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `latitude` varchar(255) NOT NULL DEFAULT '0',
  `longitude` varchar(255) NOT NULL DEFAULT '0',
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table acheron.surfops_positions: ~3 rows (approximately)
DELETE FROM `surfops_positions`;
/*!40000 ALTER TABLE `surfops_positions` DISABLE KEYS */;
INSERT INTO `surfops_positions` (`id`, `latitude`, `longitude`, `timestamp`) VALUES
	(1, '52.85395399439836', '13.718727355579874', '2024-07-12 01:31:39'),
	(2, '52.853113177483586', '13.7192872110585', '2024-07-12 01:36:27'),
	(3, '52.853284993253546', '13.725331548731422', '2024-07-12 02:23:12'),
	(9, '52.861', '13.733', '2024-07-13 00:54:57');
/*!40000 ALTER TABLE `surfops_positions` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
