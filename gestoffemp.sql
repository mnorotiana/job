-- MySQL dump 10.16  Distrib 10.1.26-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: gestoffemp
-- ------------------------------------------------------
-- Server version	10.1.26-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `candidature`
--

DROP TABLE IF EXISTS `candidature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `candidature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidat_id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  `statut` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_reception` datetime DEFAULT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `motifs` longtext COLLATE utf8_unicode_ci,
  `date_test` datetime DEFAULT NULL,
  `date_entretien` datetime DEFAULT NULL,
  `commentaire_test` longtext COLLATE utf8_unicode_ci,
  `commentaire_entretien` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_E33BD3B88D0EB82` (`candidat_id`),
  KEY `IDX_E33BD3B84CC8505A` (`offre_id`),
  CONSTRAINT `FK_E33BD3B84CC8505A` FOREIGN KEY (`offre_id`) REFERENCES `offre` (`id`),
  CONSTRAINT `FK_E33BD3B88D0EB82` FOREIGN KEY (`candidat_id`) REFERENCES `profil` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidature`
--

LOCK TABLES `candidature` WRITE;
/*!40000 ALTER TABLE `candidature` DISABLE KEYS */;
INSERT INTO `candidature` VALUES (1,1,3,'test','2019-01-22 14:01:20',NULL,NULL,'2019-01-31 11:13:26',NULL,'0348503381',NULL),(2,2,2,'validation','2019-01-23 08:35:12','9','TRÈS INTELLIGENTE',NULL,NULL,NULL,NULL),(3,1,1,'test','2019-01-23 08:51:00',NULL,NULL,'2019-01-25 08:53:26',NULL,'test écrit et orale',NULL),(4,3,1,'test','2019-01-24 11:10:52',NULL,NULL,'2019-01-25 11:12:56',NULL,'0321234567',NULL),(5,2,1,'new','2019-01-24 18:57:41',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `candidature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domaine`
--

DROP TABLE IF EXISTS `domaine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domaine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domaine`
--

LOCK TABLES `domaine` WRITE;
/*!40000 ALTER TABLE `domaine` DISABLE KEYS */;
INSERT INTO `domaine` VALUES (1,'INFORMATIQUE'),(2,'CENTRE D\'APPEL');
/*!40000 ALTER TABLE `domaine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domaine_user`
--

DROP TABLE IF EXISTS `domaine_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domaine_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mot_cle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A62CAA4FA76ED395` (`user_id`),
  CONSTRAINT `FK_A62CAA4FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domaine_user`
--

LOCK TABLES `domaine_user` WRITE;
/*!40000 ALTER TABLE `domaine_user` DISABLE KEYS */;
INSERT INTO `domaine_user` VALUES (1,1,'ASTERISK'),(2,1,'VICIDIAL'),(3,1,'INFORMATIQUE');
/*!40000 ALTER TABLE `domaine_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offre`
--

DROP TABLE IF EXISTS `offre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `intitule` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `domaine` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `qualifications` longtext COLLATE utf8_unicode_ci NOT NULL,
  `lieu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_cloture` date DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_publication` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AF86866FA76ED395` (`user_id`),
  CONSTRAINT `FK_AF86866FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offre`
--

LOCK TABLES `offre` WRITE;
/*!40000 ALTER TABLE `offre` DISABLE KEYS */;
INSERT INTO `offre` VALUES (1,3,'DEVELOPPEUR FULL STACK','INFORMATIQUE','Nous sommes à la recherche d\'un développeur WEB FULL STACK.','- Symfony\r\n- Node.js\r\n- Angular','Antananarivo','0348503381','2019-01-31','published','2','2019-01-22'),(2,3,'DEVELOPPEUR SYMFONY','INFORMATIQUE','Nous sommes à la recherche d\'un expert en Symfony.','- Symfony','Fianarantsoa','0348503381','2019-01-23','published','5','2019-01-22'),(3,3,'TELEOPERATRICE','CENTRE D\'APPEL','Nous recrutons des téléoperatrices pour un shift nuit.','- Maîtrise parfaite du français à l\'oral\r\n- Expérience réussi en qualification et détection de projet','Antananarivo','0348503381','2019-01-26','published','10','2019-01-24');
/*!40000 ALTER TABLE `offre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profil`
--

DROP TABLE IF EXISTS `profil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidat_id` int(11) NOT NULL,
  `sexe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `situation_matrimoniale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_postal` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pseudo_skype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domaine_competence` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diplome1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `etablissement1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_obtention1` date DEFAULT NULL,
  `diplome2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `etablissement2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_obtention2` date DEFAULT NULL,
  `diplome3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `etablissement3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_obtention3` date DEFAULT NULL,
  `intitule_poste1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `societe1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duree1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referent1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mail_referent1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone_referent1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domaine_poste1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intitule_poste2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `societe2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duree2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referent2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mail_referent2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone_referent2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domaine_poste2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cv` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diplome` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duree_preavis` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E6D6B2978D0EB82` (`candidat_id`),
  CONSTRAINT `FK_E6D6B2978D0EB82` FOREIGN KEY (`candidat_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profil`
--

LOCK TABLES `profil` WRITE;
/*!40000 ALTER TABLE `profil` DISABLE KEYS */;
INSERT INTO `profil` VALUES (1,1,'Feminin','Celibataire','ANDRITIANA','Tsiriniaina','1991-07-01','Ambositra','Manakambahiny','Antananarivo','101','0348503381','tsirytiana@gmail.com','tsiry.an',NULL,'Ingenieur en Informatique','ENI','2013-03-15',NULL,NULL,NULL,NULL,NULL,NULL,'TELEPROSPECTEUR','Monte-Cristo','20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'CV_MANASSE.pdf',NULL,NULL,'salarie',NULL),(2,4,'Feminin','Celibataire','MIHARINAVALONTSOA','Norotiana','1980-01-10',NULL,NULL,NULL,NULL,NULL,'nourouh@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'chercheur',NULL),(3,6,'Masculin','Celibataire','RAZAFIMANDIMBY','Michael','2000-11-14',NULL,NULL,NULL,NULL,'0321234567',NULL,NULL,NULL,'Licence en informatique','ENI','2019-01-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'chercheur',NULL);
/*!40000 ALTER TABLE `profil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region`
--

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regle_user`
--

DROP TABLE IF EXISTS `regle_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regle_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dossier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mot_cle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DF57B9ADA76ED395` (`user_id`),
  CONSTRAINT `FK_DF57B9ADA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regle_user`
--

LOCK TABLES `regle_user` WRITE;
/*!40000 ALTER TABLE `regle_user` DISABLE KEYS */;
INSERT INTO `regle_user` VALUES (3,4,'domaine','informatique','informatique'),(4,4,'societe','S&MI','S&MI'),(7,5,'domaine','TOP','TELEOPERATRICE'),(8,1,'domaine','TOP','TELEOPERATRICE'),(9,1,'domaine','DEV','DÉVELOPPEUR ');
/*!40000 ALTER TABLE `regle_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `removed_offre`
--

DROP TABLE IF EXISTS `removed_offre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `removed_offre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2EB6A7B1A76ED395` (`user_id`),
  KEY `IDX_2EB6A7B14CC8505A` (`offre_id`),
  CONSTRAINT `FK_2EB6A7B14CC8505A` FOREIGN KEY (`offre_id`) REFERENCES `offre` (`id`),
  CONSTRAINT `FK_2EB6A7B1A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `removed_offre`
--

LOCK TABLES `removed_offre` WRITE;
/*!40000 ALTER TABLE `removed_offre` DISABLE KEYS */;
/*!40000 ALTER TABLE `removed_offre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `societe_user`
--

DROP TABLE IF EXISTS `societe_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `societe_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `societe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EFBCEA58FCF77503` (`societe_id`),
  KEY `IDX_EFBCEA58A76ED395` (`user_id`),
  CONSTRAINT `FK_EFBCEA58A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_EFBCEA58FCF77503` FOREIGN KEY (`societe_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `societe_user`
--

LOCK TABLES `societe_user` WRITE;
/*!40000 ALTER TABLE `societe_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `societe_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `nom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nif` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Tsiry','tsiry','tsirytiana@gmail.com','tsirytiana@gmail.com',1,NULL,'$2y$13$BJipY4gqEkxq.VmGdKChA.McbhF/RnzU.pIoK4YNuEqw0/ldSwutK','2019-01-24 10:40:44',NULL,NULL,'a:1:{i:0;s:13:\"ROLE_CANDIDAT\";}','Tsiry',NULL,NULL,NULL,NULL),(2,'Andry','andry','t.andritiana@sandmicall.com','t.andritiana@sandmicall.com',1,NULL,'$2y$13$z75InOKQ/4aPvwhcAJd.4O/yOzWxRhsbKO4OMC2lrI9fPCc48Ckcq','2019-01-15 10:08:51',NULL,NULL,'a:1:{i:0;s:12:\"ROLE_SOCIETE\";}','Andry',NULL,NULL,NULL,NULL),(3,'Princy','princy','t.andritiana@sandimicall.com','t.andritiana@sandimicall.com',1,NULL,'$2y$13$q/RzzvCdRs78oOxoqp6a1.esbFVayQ1orceTSTy.PoEX349Q6bRzO','2019-01-24 18:59:25',NULL,NULL,'a:1:{i:0;s:12:\"ROLE_SOCIETE\";}','S&MI','Ambatoroka','0348503381',NULL,NULL),(4,'ntina','ntina','nourouh@gmail.com','nourouh@gmail.com',1,NULL,'$2y$13$P.hPMzqSqRRsb0zHvGBEmu4W9YYgieN5Q8lLq8CmmUVHZXKKI2V8i','2019-01-24 18:56:29',NULL,NULL,'a:1:{i:0;s:13:\"ROLE_CANDIDAT\";}','norotiana','ivandry','0343859010',NULL,NULL),(5,'Sandrina','sandrina','sandrina@gmail.com','sandrina@gmail.com',1,NULL,'$2y$13$WXcYsiZ87lS2QLvNz7cRmecCL9xd.OZl2hU34aJTIUviO6JPg.HPm','2019-01-22 12:03:12',NULL,NULL,'a:1:{i:0;s:13:\"ROLE_CANDIDAT\";}','Sandrina','Ambatoroka','0348503381',NULL,NULL),(6,'Michael','michael','michael@test.com','michael@test.com',1,NULL,'$2y$13$Ua0AkQ4P1g0sLSEl1o8ns.seQvRDD5jOT8DCcjGE.lNfd9wVrxOw2','2019-01-24 11:08:00',NULL,NULL,'a:1:{i:0;s:13:\"ROLE_CANDIDAT\";}','RAZAFIMANDIMBY Michael','Ambatoroka','0348503381',NULL,NULL),(7,'admin','admin','administrator@jobfinder.com','administrator@jobfinder.com',1,NULL,'$2y$13$nh619IdLK0qsBZ7xrCcKcu95ksQkzObIsw2b5.Pp/Tnj0P6o4qn4q','2019-01-24 18:58:47',NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}','Administrator','DGPE','0000000000',NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-29 17:56:25
