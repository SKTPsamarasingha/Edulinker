-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.31 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for edu
CREATE DATABASE IF NOT EXISTS `edu` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `edu`;

-- Dumping structure for table edu.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edu.admin: ~0 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
	(1, 'ihara', 'ihara@gmail.com', '1234');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table edu.grade
CREATE TABLE IF NOT EXISTS `grade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edu.grade: ~2 rows (approximately)
/*!40000 ALTER TABLE `grade` DISABLE KEYS */;
INSERT INTO `grade` (`id`, `name`) VALUES
	(1, 'Grade 06'),
	(2, 'Grade 07'),
	(3, 'Grade 08');
/*!40000 ALTER TABLE `grade` ENABLE KEYS */;

-- Dumping structure for table edu.review
CREATE TABLE IF NOT EXISTS `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `rate` int DEFAULT NULL,
  `feedback` text,
  PRIMARY KEY (`id`),
  KEY `FK_review_session` (`session_id`),
  KEY `FK_review_student` (`student_id`),
  CONSTRAINT `FK_review_session` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_review_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edu.review: ~0 rows (approximately)
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` (`id`, `session_id`, `student_id`, `rate`, `feedback`) VALUES
	(2, 2, 1, 2, 'nice');
/*!40000 ALTER TABLE `review` ENABLE KEYS */;

-- Dumping structure for table edu.session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `teacher_grade_subject_id` int DEFAULT NULL,
  `session_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `hours` int DEFAULT NULL,
  `status` int DEFAULT '0',
  `session_type_id` int DEFAULT NULL,
  `path` text,
  `note` text,
  PRIMARY KEY (`id`),
  KEY `FK_session_session_type` (`session_type_id`),
  KEY `FK_session_teacher_has_grade_has_subject` (`teacher_grade_subject_id`),
  KEY `FK_session_student` (`student_id`),
  CONSTRAINT `FK_session_session_type` FOREIGN KEY (`session_type_id`) REFERENCES `session_type` (`id`),
  CONSTRAINT `FK_session_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_session_teacher_has_grade_has_subject` FOREIGN KEY (`teacher_grade_subject_id`) REFERENCES `teacher_has_grade_has_subject` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edu.session: ~4 rows (approximately)
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` (`id`, `student_id`, `teacher_grade_subject_id`, `session_date`, `start_time`, `hours`, `status`, `session_type_id`, `path`, `note`) VALUES
	(2, 1, 3, '2024-09-30', '15:00:00', 2, 3, 1, 'libk//ffd', ''),
	(4, 1, 4, '2024-10-10', '19:45:00', 3, 0, 2, NULL, NULL),
	(5, 1, 3, '2024-10-30', '14:00:00', 4, 1, 2, 'http://localhost/edu/teacher/my-session.php', 'ok'),
	(6, 1, 7, '2024-09-27', '09:00:00', 2, 0, 1, 'http://localhost/edu/teacher/my-session.php', '');
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

-- Dumping structure for table edu.session_payment
CREATE TABLE IF NOT EXISTS `session_payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `card_no` varchar(50) DEFAULT NULL,
  `cvv` varchar(50) DEFAULT NULL,
  `exp_date` varchar(50) DEFAULT NULL,
  `session_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_session_payment_session` (`session_id`),
  CONSTRAINT `FK_session_payment_session` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edu.session_payment: ~2 rows (approximately)
/*!40000 ALTER TABLE `session_payment` DISABLE KEYS */;
INSERT INTO `session_payment` (`id`, `card_no`, `cvv`, `exp_date`, `session_id`) VALUES
	(1, '45423 3423 234', '123', '12/12', 2),
	(3, '3453535', '455', '345', 5);
/*!40000 ALTER TABLE `session_payment` ENABLE KEYS */;

-- Dumping structure for table edu.session_type
CREATE TABLE IF NOT EXISTS `session_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edu.session_type: ~2 rows (approximately)
/*!40000 ALTER TABLE `session_type` DISABLE KEYS */;
INSERT INTO `session_type` (`id`, `name`) VALUES
	(1, 'Online'),
	(2, 'Physical');
/*!40000 ALTER TABLE `session_type` ENABLE KEYS */;

-- Dumping structure for table edu.student
CREATE TABLE IF NOT EXISTS `student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `status` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edu.student: ~0 rows (approximately)
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` (`id`, `fname`, `lname`, `email`, `password`, `status`) VALUES
	(1, 'qwer', 'ghjk', 'ihara@gmail.com', '$2y$10$ArAyCnmLOdw717K5EHbefOmlCWMlr1p.uRTPuVsLy3cx958adLMUq', 1);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;

-- Dumping structure for table edu.subject
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edu.subject: ~4 rows (approximately)
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` (`id`, `name`) VALUES
	(1, 'Mathematics'),
	(2, 'Sinhala'),
	(3, 'English'),
	(4, 'History');
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;

-- Dumping structure for table edu.teacher
CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mobile` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `qulification` text,
  `status` int DEFAULT '0',
  `profile` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edu.teacher: ~2 rows (approximately)
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
INSERT INTO `teacher` (`id`, `fname`, `lname`, `email`, `mobile`, `password`, `qulification`, `status`, `profile`) VALUES
	(3, 'ihara', 'Thathsara', 'ihara@gmail.com', '0763947527', '$2y$10$Wtl.gGf0088JqNua1KjuE.7VihjD6.XSctcv7H4H/C3mOgrZxkaji', 'School Teacher \r\nDigree holder..', 1, 'resources/newuser.svg'),
	(4, 'Wijesiri', 'Thathsara', 'iharathathsara0@gmail.com', '0763947527', '$2y$10$3lZp/Tr0CJiXm1qrZOL9vOLyb3UNgpv8o0d.7tvttl9DHFxbyNtn.', '', 1, 'resources/newuser.svg'),
	(5, 'kasun', 'kalhara', 'kasun@gmail.com', '0776574839', '$2y$10$qlYhstttunUPslYlR8QHX.bT2rDw9gPjfiKdfbtYdE58gS.9pcLgW', '', 1, 'resources//66f5adf4855a7.png');
/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;

-- Dumping structure for table edu.teacher_has_grade_has_subject
CREATE TABLE IF NOT EXISTS `teacher_has_grade_has_subject` (
  `id` int NOT NULL AUTO_INCREMENT,
  `grade_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `teacher_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_grade_has_subject_grade` (`grade_id`),
  KEY `FK_grade_has_subject_subject` (`subject_id`),
  KEY `FK_teacher_has_grade_has_subject_teacher` (`teacher_id`),
  CONSTRAINT `FK_grade_has_subject_grade` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_grade_has_subject_subject` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_teacher_has_grade_has_subject_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edu.teacher_has_grade_has_subject: ~5 rows (approximately)
/*!40000 ALTER TABLE `teacher_has_grade_has_subject` DISABLE KEYS */;
INSERT INTO `teacher_has_grade_has_subject` (`id`, `grade_id`, `subject_id`, `teacher_id`) VALUES
	(3, 2, 1, 3),
	(4, 3, 2, 4),
	(5, 2, 3, 4),
	(6, 3, 1, 3),
	(7, 1, 2, 3),
	(8, 1, 4, 5),
	(9, 2, 4, 5);
/*!40000 ALTER TABLE `teacher_has_grade_has_subject` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
