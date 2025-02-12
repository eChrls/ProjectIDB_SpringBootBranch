-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: apiWeb
-- ------------------------------------------------------
-- Server version	8.4.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alumns`
--

DROP TABLE IF EXISTS `alumns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumns` (
  `id_alumn` bigint NOT NULL AUTO_INCREMENT,
  `age` int NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `grade` tinyint DEFAULT NULL,
  `grade_date` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `timestamp` datetime(6) DEFAULT NULL,
  `schools` bigint DEFAULT NULL,
  PRIMARY KEY (`id_alumn`),
  KEY `FK_SCHOOL` (`schools`),
  CONSTRAINT `FK_SCHOOL` FOREIGN KEY (`schools`) REFERENCES `schools` (`id_school`),
  CONSTRAINT `alumns_chk_1` CHECK ((`grade` between 0 and 2))
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumns`
--

LOCK TABLES `alumns` WRITE;
/*!40000 ALTER TABLE `alumns` DISABLE KEYS */;
INSERT INTO `alumns` VALUES (7,20,'MARBELLA','EMC2@GMAIL.COM',1,'2025-01-01','EINSTEIN','ALBERT',NULL,1),(8,30,'SAN PEDRO','MICROSOFT@OUTLOOK.COM',0,'2025-02-02','GATES','BILL',NULL,1),(9,35,'FUENGIROLA','ALBERTI@GMAIL.COM',2,'2024-01-01','ALBERTI','RAFAEL',NULL,1),(10,40,'MALAGA','BTS@GMAIL.COM',1,'2025-02-02','GOODMAN','SAUL',NULL,2),(11,20,'MALAGA','PINKMAN@OUTLOOK.ES',1,'2025-01-02','PINKMAN','JESSE',NULL,2),(12,40,'MALAGA','PHERMANOS@GMAIL.COM',2,'2024-01-01','FRING','GUS',NULL,2);
/*!40000 ALTER TABLE `alumns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schools` (
  `id_school` bigint NOT NULL AUTO_INCREMENT,
  `password` varchar(255) DEFAULT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `user` bigint DEFAULT NULL,
  PRIMARY KEY (`id_school`),
  UNIQUE KEY `UKadyev2mx749y2qa4r1t13wfjd` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schools`
--

LOCK TABLES `schools` WRITE;
/*!40000 ALTER TABLE `schools` DISABLE KEYS */;
INSERT INTO `schools` VALUES (1,'1234','IES GUADALPIN',29601),(2,'1234','IES MAR DE ALBORAN',29680),(3,'1234','PRUEBA',1234);
/*!40000 ALTER TABLE `schools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'apiWeb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-11 11:32:04
