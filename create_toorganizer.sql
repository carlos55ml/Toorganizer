-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.24-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para toorganizer
CREATE DATABASE IF NOT EXISTS `toorganizer` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `toorganizer`;

-- Volcando estructura para tabla toorganizer.chat_messages
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `sender` int(11) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`message_id`),
  KEY `FK_chat_messages_events` (`event_id`),
  KEY `FK_chat_messages_users` (`sender`),
  CONSTRAINT `FK_chat_messages_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_chat_messages_users` FOREIGN KEY (`sender`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla toorganizer.events
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(100) DEFAULT NULL,
  `game` varchar(100) DEFAULT NULL,
  `logo_url` varchar(100) DEFAULT 'https://i.imgur.com/0hTFTZf.png',
  `state` enum('pending','running','finished','canceled') DEFAULT 'pending',
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla toorganizer.event_organizers
CREATE TABLE IF NOT EXISTS `event_organizers` (
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  KEY `FK_event_organizers_events` (`event_id`),
  KEY `FK_event_organizers_users` (`user_id`),
  CONSTRAINT `FK_event_organizers_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_event_organizers_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla toorganizer.event_participants
CREATE TABLE IF NOT EXISTS `event_participants` (
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `phase_id` int(11) DEFAULT NULL,
  KEY `FK_event_participants_users` (`user_id`),
  KEY `FK_event_participants_events` (`event_id`),
  KEY `FK_event_participants_event_phases` (`phase_id`),
  CONSTRAINT `FK_event_participants_event_phases` FOREIGN KEY (`phase_id`) REFERENCES `event_phases` (`phase_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_event_participants_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_event_participants_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla toorganizer.event_phases
CREATE TABLE IF NOT EXISTS `event_phases` (
  `phase_id` int(11) NOT NULL AUTO_INCREMENT,
  `participantA` int(11) DEFAULT -1,
  `participantB` int(11) DEFAULT -1,
  `resultA` int(11) DEFAULT 0,
  `resultB` int(11) DEFAULT 0,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`phase_id`),
  KEY `FK_event_phases_users` (`participantA`),
  KEY `FK_event_phases_users_2` (`participantB`),
  KEY `FK_event_phases_events` (`event_id`),
  CONSTRAINT `FK_event_phases_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_event_phases_users` FOREIGN KEY (`participantA`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_event_phases_users_2` FOREIGN KEY (`participantB`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla toorganizer.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) DEFAULT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT 0,
  `avatar_url` varchar(255) DEFAULT 'https://i.imgur.com/qF8tRFr.png',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
