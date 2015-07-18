-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: nico
-- ------------------------------------------------------
-- Server version	5.6.24-enterprise-commercial-advanced-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `subastas`
--

DROP TABLE IF EXISTS `subastas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subastas` (
  `idSubastas` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(50) NOT NULL,
  `Fecha` date NOT NULL,
  `Fecha_venc` date NOT NULL,
  `Estado` varchar(15) NOT NULL,
  `Comision` tinyint(4) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Imagen` blob,
  `idCategorias` int(11) DEFAULT NULL,
  `idUsuarios` int(11) DEFAULT NULL,
  PRIMARY KEY (`idSubastas`),
  KEY `Categorias` (`idCategorias`),
  KEY `Usuarios` (`idUsuarios`),
  CONSTRAINT `Categorias` FOREIGN KEY (`idCategorias`) REFERENCES `categorias` (`idCategorias`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `Usuarios` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subastas`
--

LOCK TABLES `subastas` WRITE;
/*!40000 ALTER TABLE `subastas` DISABLE KEYS */;
INSERT INTO `subastas` VALUES (1,'Agua','2015-05-28','2016-05-28','Pendiente',40,'Comprame',NULL,2,1),(2,'Mesa','2015-05-29','2016-05-29','Completada',80,'No leer',NULL,1,1);
/*!40000 ALTER TABLE `subastas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-28 15:23:29
