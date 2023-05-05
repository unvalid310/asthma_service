-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table asthma.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL DEFAULT 'Male',
  `password` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table asthma.user: ~1 rows (approximately)
INSERT INTO `user` (`id`, `email`, `fullname`, `dob`, `gender`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'anonim@email.com', 'anonim', '1997-05-06', 'Male', '$2y$10$etmx0VRhXjOT//EERLt/bOXnKhv21Gh7UD..neqKLp2Z8jBq4oskq', '2023-04-30 11:31:37', '2023-05-01 09:43:06', NULL);

-- Dumping structure for table asthma.body
DROP TABLE IF EXISTS `body`;
CREATE TABLE IF NOT EXISTS `body` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `heart_rate` int(11) NOT NULL DEFAULT 0,
  `spo2` int(11) NOT NULL DEFAULT 0,
  `sleeping_quality` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__user` (`user_id`),
  CONSTRAINT `FK__user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table asthma.body: ~3 rows (approximately)
INSERT INTO `body` (`id`, `user_id`, `heart_rate`, `spo2`, `sleeping_quality`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 60, 20, 80, '2023-04-30 10:20:10', '2023-05-01 10:20:10', NULL),
	(2, 1, 60, 100, 50, '2023-05-01 10:20:10', '2023-05-01 10:29:46', NULL),
	(3, 1, 80, 50, 60, '2023-05-02 00:10:27', '2023-05-02 00:10:27', NULL);

-- Dumping structure for table asthma.environment
DROP TABLE IF EXISTS `environment`;
CREATE TABLE IF NOT EXISTS `environment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `temperature` int(11) NOT NULL DEFAULT 0,
  `humidity` int(11) NOT NULL DEFAULT 0,
  `co2` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_environment_user` (`user_id`),
  CONSTRAINT `FK_environment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table asthma.environment: ~3 rows (approximately)
INSERT INTO `environment` (`id`, `user_id`, `temperature`, `humidity`, `co2`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 45, 20, 50, '2023-04-30 10:20:39', '2023-05-01 10:20:39', NULL),
	(2, 1, 45, 100, 100, '2023-05-01 10:20:39', '2023-05-01 10:29:26', NULL),
	(3, 1, 50, 80, 100, '2023-05-02 00:10:35', '2023-05-02 00:10:35', NULL);

-- Dumping structure for table asthma.history
DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `body` double DEFAULT 0,
  `envi` double DEFAULT 0,
  `mind` double DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`date`),
  KEY `FK_history_asthma.user` (`user_id`),
  CONSTRAINT `FK_history_asthma.user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table asthma.history: ~3 rows (approximately)
INSERT INTO `history` (`id`, `user_id`, `date`, `body`, `envi`, `mind`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, '2023-04-30', 53.33, 38.33, 3.7, '2023-05-01 10:20:10', '2023-05-01 10:20:45', NULL),
	(5, 1, '2023-05-01', 70, 81.67, 5, '2023-05-01 10:20:10', '2023-05-01 10:29:46', NULL),
	(6, 1, '2023-05-02', 63.33, 76.67, 2.7, '2023-05-02 00:10:27', '2023-05-02 00:10:59', NULL);

-- Dumping structure for table asthma.mind
DROP TABLE IF EXISTS `mind`;
CREATE TABLE IF NOT EXISTS `mind` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `q1` int(11) NOT NULL DEFAULT 0,
  `q2` int(11) NOT NULL DEFAULT 0,
  `q3` int(11) NOT NULL DEFAULT 0,
  `q4` int(11) NOT NULL DEFAULT 0,
  `q5` int(11) NOT NULL DEFAULT 0,
  `q6` int(11) NOT NULL DEFAULT 0,
  `q7` int(11) NOT NULL DEFAULT 0,
  `q8` int(11) NOT NULL DEFAULT 0,
  `q9` int(11) NOT NULL DEFAULT 0,
  `q10` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_mind_user` (`user_id`),
  CONSTRAINT `FK_mind_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table asthma.mind: ~3 rows (approximately)
INSERT INTO `mind` (`id`, `user_id`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `q10`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 3, 2, 4, 4, 4, 4, 4, 4, 4, 4, '2023-04-30 10:20:45', '2023-05-01 10:20:45', NULL),
	(2, 1, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, '2023-05-01 10:20:45', '2023-05-01 10:29:03', NULL),
	(3, 1, 5, 5, 5, 2, 2, 1, 1, 1, 2, 3, '2023-05-02 00:10:51', '2023-05-02 00:10:59', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
