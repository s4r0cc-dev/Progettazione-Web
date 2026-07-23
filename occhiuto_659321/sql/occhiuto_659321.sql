-- Progettazione Web 
DROP DATABASE if exists occhiuto_659321; 
CREATE DATABASE occhiuto_659321; 
USE occhiuto_659321; 
-- MySQL dump 10.13  Distrib 5.7.28, for Win64 (x86_64)
--
-- Host: localhost    Database: occhiuto_659321
-- ------------------------------------------------------
-- Server version	5.7.28

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
-- Table structure for table `film`
--

DROP TABLE IF EXISTS `film`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `film` (
  `id_film` varchar(50) NOT NULL,
  `titolo` varchar(100) NOT NULL,
  `durata` int(11) NOT NULL,
  `genere` varchar(100) NOT NULL,
  `trama` varchar(255) NOT NULL,
  `stato` enum('in programmazione','novità') NOT NULL,
  PRIMARY KEY (`id_film`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `film`
--

LOCK TABLES `film` WRITE;
/*!40000 ALTER TABLE `film` DISABLE KEYS */;
INSERT INTO `film` VALUES ('COCO','Coco',104,'Animazione, Musicale','Il giovane Miguel sogna di diventare un musicista e, per un magico incidente, si ritrova nell\'incredibile e coloratissimo Mondo dei Morti alla scoperta della sua storia familiare.','in programmazione'),('ELIO','Elio',97,'Animazione, Fantascienza','Un ragazzino con una fervida immaginazione viene inavvertitamente rapito dagli alieni e scambiato per l\'ambasciatore ufficiale del pianeta Terra nello spazio.','in programmazione'),('INSIDE-OUT-2','Inside Out 2',96,'Animazione, Drammatico','Riley è ormai un\'adolescente e il quartier generale della sua mente viene improvvisamente stravolto dall\'arrivo di nuove, inaspettate ed esuberanti emozioni.','in programmazione'),('LILO-E-STITCH','Lilo e Stitch',111,'Animazione, Fantascienza, Avventura','Nelle paradisiache isole Hawaii, la piccola e solitaria Lilo adotta quello che crede essere un buffo cagnolino, rivelatosi in realtà un pericoloso alieno in fuga.','in programmazione'),('LUCA','Luca',95,'Animazione, Fantasy','Ambientato in una splendida città di mare della Riviera italiana, un giovane ragazzo vive un\'estate indimenticabile nascondendo un segreto: è un mostro marino.','in programmazione'),('MONSTERS-UNIVERSITY','Monsters University',104,'Animazione, Commedia','Il prequel che racconta come la storica ed esilarante coppia di mostri formata da Mike e Sulley si sia conosciuta e formata ai tempi dei difficili anni del college.','in programmazione'),('RATATOUILLE','Ratatouille',116,'Animazione, Commedia','Un simpatico topo di nome Remy sogna di diventare un grande chef francese, stringendo un\'alleanza segreta con il giovane e maldestro sguattero Linguini.','in programmazione'),('TOY-STORY-5','Toy Story 5',102,'Animazione, Avventura','Buzz, Woody e l\'intera banda di giocattoli affrontano una nuova e tecnologica avventura contro l\'avanzata dei dispositivi elettronici.','novità'),('WALL-E','Wall-E',98,'Animazione, Fantascienza','In un futuro lontano e solitario, un piccolo robot compattatore di rifiuti rimasto sulla Terra intraprende un viaggio nello spazio che cambierà il destino dell\'umanità.','in programmazione'),('ZOOTROPOLIS-2','Zootropolis 2',107,'Animazione, Commedia, Giallo','Gli iconici agenti Judy Hopps e Nick Wilde tornano in azione per risolvere un nuovo e bizzarro caso intricato nella metropoli dei mammiferi.','in programmazione');
/*!40000 ALTER TABLE `film` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preferiti`
--

DROP TABLE IF EXISTS `preferiti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preferiti` (
  `id_utente` int(11) NOT NULL,
  `id_film` varchar(50) NOT NULL,
  PRIMARY KEY (`id_utente`,`id_film`),
  KEY `id_film` (`id_film`),
  CONSTRAINT `preferiti_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id_utente`) ON DELETE CASCADE,
  CONSTRAINT `preferiti_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preferiti`
--

LOCK TABLES `preferiti` WRITE;
/*!40000 ALTER TABLE `preferiti` DISABLE KEYS */;
/*!40000 ALTER TABLE `preferiti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prenotazioni`
--

DROP TABLE IF EXISTS `prenotazioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prenotazioni` (
  `id_prenotazione` int(11) NOT NULL AUTO_INCREMENT,
  `id_utente` int(11) NOT NULL,
  `id_proiezione` int(11) NOT NULL,
  `posto` varchar(5) NOT NULL,
  PRIMARY KEY (`id_prenotazione`),
  KEY `id_utente` (`id_utente`),
  KEY `id_proiezione` (`id_proiezione`),
  CONSTRAINT `prenotazioni_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id_utente`) ON DELETE CASCADE,
  CONSTRAINT `prenotazioni_ibfk_2` FOREIGN KEY (`id_proiezione`) REFERENCES `programmazione` (`id_proiezione`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prenotazioni`
--

LOCK TABLES `prenotazioni` WRITE;
/*!40000 ALTER TABLE `prenotazioni` DISABLE KEYS */;
/*!40000 ALTER TABLE `prenotazioni` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programmazione`
--

DROP TABLE IF EXISTS `programmazione`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programmazione` (
  `id_proiezione` int(11) NOT NULL AUTO_INCREMENT,
  `id_film` varchar(50) NOT NULL,
  `nome_sala` varchar(20) NOT NULL,
  `data_ora` datetime NOT NULL,
  PRIMARY KEY (`id_proiezione`),
  KEY `id_film` (`id_film`),
  KEY `nome_sala` (`nome_sala`),
  CONSTRAINT `programmazione_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`) ON DELETE CASCADE,
  CONSTRAINT `programmazione_ibfk_2` FOREIGN KEY (`nome_sala`) REFERENCES `sala` (`nome_sala`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programmazione`
--

LOCK TABLES `programmazione` WRITE;
/*!40000 ALTER TABLE `programmazione` DISABLE KEYS */;
INSERT INTO `programmazione` VALUES (1,'COCO','Pisa','2026-08-01 15:00:00'),(2,'COCO','Milano','2026-08-01 18:00:00'),(3,'ELIO','Roma','2026-08-01 15:00:00'),(4,'ELIO','Venezia','2026-08-01 21:30:00'),(5,'MONSTERS-UNIVERSITY','Venezia','2026-08-01 18:00:00'),(6,'MONSTERS-UNIVERSITY','Pisa','2026-08-01 21:30:00'),(7,'LILO-E-STITCH','Venezia','2026-08-01 15:00:00'),(8,'INSIDE-OUT-2','Pisa','2026-08-01 18:00:00'),(9,'LUCA','Milano','2026-08-01 15:00:00'),(10,'RATATOUILLE','Roma','2026-08-01 18:00:00'),(11,'WALL-E','Roma','2026-08-01 21:30:00'),(12,'ZOOTROPOLIS-2','Milano','2026-08-01 21:30:00'),(13,'COCO','Roma','2026-08-02 18:00:00'),(14,'ELIO','Pisa','2026-08-02 18:00:00'),(15,'MONSTERS-UNIVERSITY','Milano','2026-08-02 18:00:00'),(16,'LILO-E-STITCH','Milano','2026-08-02 21:30:00'),(17,'LILO-E-STITCH','Pisa','2026-08-02 15:00:00'),(18,'INSIDE-OUT-2','Milano','2026-08-02 15:00:00'),(19,'INSIDE-OUT-2','Venezia','2026-08-02 18:00:00'),(20,'LUCA','Venezia','2026-08-02 15:00:00'),(21,'LUCA','Roma','2026-08-02 21:30:00'),(22,'RATATOUILLE','Venezia','2026-08-02 21:30:00'),(23,'WALL-E','Pisa','2026-08-02 21:30:00'),(24,'ZOOTROPOLIS-2','Roma','2026-08-02 15:00:00'),(25,'COCO','Venezia','2026-08-03 15:00:00'),(26,'ELIO','Milano','2026-08-03 15:00:00'),(27,'MONSTERS-UNIVERSITY','Roma','2026-08-03 18:00:00'),(28,'LILO-E-STITCH','Roma','2026-08-03 15:00:00'),(29,'INSIDE-OUT-2','Roma','2026-08-03 21:30:00'),(30,'LUCA','Pisa','2026-08-03 18:00:00'),(31,'RATATOUILLE','Milano','2026-08-03 18:00:00'),(32,'RATATOUILLE','Pisa','2026-08-03 15:00:00'),(33,'WALL-E','Milano','2026-08-03 21:30:00'),(34,'WALL-E','Venezia','2026-08-03 18:00:00'),(35,'ZOOTROPOLIS-2','Venezia','2026-08-03 21:30:00'),(36,'ZOOTROPOLIS-2','Pisa','2026-08-03 21:30:00'),(37,'TOY-STORY-5','Venezia','2026-08-10 15:00:00'),(38,'TOY-STORY-5','Roma','2026-08-11 18:00:00'),(39,'TOY-STORY-5','Milano','2026-08-11 21:30:00');
/*!40000 ALTER TABLE `programmazione` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sala`
--

DROP TABLE IF EXISTS `sala`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sala` (
  `nome_sala` varchar(20) NOT NULL,
  `posti_totali` int(11) DEFAULT '50',
  PRIMARY KEY (`nome_sala`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sala`
--

LOCK TABLES `sala` WRITE;
/*!40000 ALTER TABLE `sala` DISABLE KEYS */;
INSERT INTO `sala` VALUES ('Milano',50),('Pisa',50),('Roma',50),('Venezia',50);
/*!40000 ALTER TABLE `sala` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utenti`
--

DROP TABLE IF EXISTS `utenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utenti` (
  `id_utente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `domanda_sicurezza` varchar(100) NOT NULL,
  `risposta_sicurezza` varchar(100) NOT NULL,
  PRIMARY KEY (`id_utente`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utenti`
--

LOCK TABLES `utenti` WRITE;
/*!40000 ALTER TABLE `utenti` DISABLE KEYS */;
INSERT INTO `utenti` VALUES (1,'Mario','Rossi','Mario01','mariorossi@test.it','$2y$10$arvveeLPpS2kps8QKrPjtuzLWPWZp7iWoyCLATT8JfdU7poF5Uq4q','squadra_cuore','$2y$10$REwifRc.ZCHAlcd8g5NVpOf2m5Ia3dpucbO9qabgHQscUtXnjL/1W'),(2,'Luca','Verdi','Luca02','lucaverdi@test.it','$2y$10$g7pzFrIaZaieQLzIsaqzW.zIVF7l.suyU1CWCVzApfm5f63tKPaqO','squadra_cuore','$2y$10$H4NfLyxPwQ6BGwbaBAw6Uu/25Nyd3EJR.nckKLBH/KZeNBbs5Qi9y'),(3,'Andrea','Gialli','Andrea03','andreagialli@test.it','$2y$10$/kWcoHi.iAutJ3HjNUNLhe2I0K.rfjcknMpPPHaU2/dvw/rD5o4IS','squadra_cuore','$2y$10$FNtxiUIpLqOzQi5WtcqY1uLHv/fMC5mk9wQnjl0oDqtVLUf1DZHuK'),(4,'Paolo','Neri','Paolo04','paoloneri@test.it','$2y$10$O35vN/o1LVSn08mNrFiZlO/JI946ashFTpzq.nZMx9MscC5wkLXQK','squadra_cuore','$2y$10$aCFJxDbSpWX1RDxfuQJUlOI7eEYhOA0uvAoIe3PjAu79yUnRPA/8W');
/*!40000 ALTER TABLE `utenti` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-22 10:52:03
