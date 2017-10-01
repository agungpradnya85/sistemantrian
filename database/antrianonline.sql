/*
SQLyog Community v12.4.3 (64 bit)
MySQL - 10.1.22-MariaDB : Database - antrianonline
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`antrianonline` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `antrianonline`;

/*Table structure for table `citizen` */

DROP TABLE IF EXISTS `citizen`;

CREATE TABLE `citizen` (
  `nik` varchar(20) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `kelurahan` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `propinsi` varchar(50) NOT NULL,
  `kabupaten` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `citizen` */

insert  into `citizen`(`nik`,`tipe`,`tanggal_lahir`,`kelurahan`,`nama`,`propinsi`,`kabupaten`,`kecamatan`,`alamat`) values 
('5171030112850020','penduduk','1985-12-01','Panjer','Agung Pradnya','Bali','Denpasar','Denpasar Selatan','Jalan Tukad Pancoran Gang 2A No : 7'),
('5171030112850021','penduduk','2017-09-01','Panjer','Mirah Dwidaputri','Bali','Denpasar','Denpasar Selatan','Jalan Tukad Pancoran Gang 2A No : 7'),
('5171030112850022','penduduk','1998-12-25','Panjer','Ananta Tridaputra','Bali','Denpasar','Denpasar Selatan','Jalan Tukad Pancoran Gang 2A No : 7'),
('5171030112850023','penduduk','1988-12-27','Tanguntiti','Satcitananda','Bali','Tabanan','Selemadeg Kangin','Jalan Beraban'),
('5171030112850024','penduduk','1989-12-22','Tanguntiti','Nadia','Bali','Tabanan','Selemadeg Kangin','Jalan Beraban'),
('5171030112850025','penduduk','1989-07-06','Nusa Dua','Panji Nugraha','Bali','Badung','Kuta','Jalan Sahadewa'),
('5171030112850026','penduduk','2017-09-22','Nusa Dua','Gede Yudhistira','Bali','Badung','Kuta','Jalan Sahadewa');

/*Table structure for table `faskes` */

DROP TABLE IF EXISTS `faskes`;

CREATE TABLE `faskes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `tipe` enum('puskesmas','rumahsakit') NOT NULL,
  `kecamatan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kecamatan` (`kecamatan`),
  CONSTRAINT `faskes_ibfk_1` FOREIGN KEY (`kecamatan`) REFERENCES `kecamatan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `faskes` */

insert  into `faskes`(`id`,`nama`,`tipe`,`kecamatan`) values 
(1,'Puskesmas Pembantu Desa Sobangan','puskesmas',4),
(2,'Puskesmas Pembantu Desa Pererenan','puskesmas',4),
(5,'Rumah Sakit Umum Daerah Kabupaten Badung Mangusada','rumahsakit',3),
(6,'Puskesmas Pembantu Desa Buduk','puskesmas',4),
(7,'Puskesmas Pembantu Desa Cemagi','puskesmas',4),
(8,'Puskesmas Pembantu Desa gulingan','puskesmas',4),
(9,'Puskesmas Pembantu Desa Kuwum','puskesmas',4),
(10,'Puskesmas Pembantu Desa Lukluk','puskesmas',4),
(11,'Puskesmas Pembantu Desa Penarungan','puskesmas',4),
(12,'Puskesmas Pembantu Desa Pererenan','puskesmas',4),
(13,'Puskesmas Pembantu Desa Sembung','puskesmas',4),
(14,'Puskesmas Pembantu Desa Werdi Bhuwana','puskesmas',4);

/*Table structure for table `kecamatan` */

DROP TABLE IF EXISTS `kecamatan`;

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL DEFAULT '0',
  `nama` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `kecamatan` */

insert  into `kecamatan`(`id`,`slug`,`nama`) values 
(1,'abiansemal','ABIANSEMAL'),
(2,'petang','PETANG'),
(3,'kuta','KUTA'),
(4,'mengwi','MENGWI'),
(5,'kuta-utara','KUTA UTARA'),
(6,'kuta-selatan','KUTA SELATAN');

/*Table structure for table `klinik` */

DROP TABLE IF EXISTS `klinik`;

CREATE TABLE `klinik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_klinik` varchar(3) NOT NULL,
  `nama_klinik` varchar(30) NOT NULL,
  `id_faskes` int(11) NOT NULL,
  `jumlah_poli` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_faskes` (`id_faskes`),
  CONSTRAINT `klinik_ibfk_1` FOREIGN KEY (`id_faskes`) REFERENCES `faskes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `klinik` */

insert  into `klinik`(`id`,`kode_klinik`,`nama_klinik`,`id_faskes`,`jumlah_poli`) values 
(1,'A','Poli Umum',1,5),
(2,'B','Poli Gigi',2,8),
(3,'A','Poli Umum',2,7),
(4,'B','Poli Gigi',1,3),
(5,'C','KIA',1,4),
(6,'C','KIA',2,6),
(8,'A','Poli Umum',5,7),
(9,'B','Poli Gigi',5,5);

/*Table structure for table `klinik_map` */

DROP TABLE IF EXISTS `klinik_map`;

CREATE TABLE `klinik_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_antrian` varchar(11) NOT NULL,
  `id_klinik` int(11) NOT NULL,
  `id_pasien` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `status` smallint(3) NOT NULL DEFAULT '1' COMMENT 'status 0 : batal, status 1 : bisa hadir (default), 2 : sudah dipanggil',
  `time_exam` varchar(50) NOT NULL,
  `time_exam_start` datetime DEFAULT NULL,
  `time_exam_end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_klinik` (`id_klinik`),
  CONSTRAINT `klinik_map_ibfk_1` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `klinik_map` */

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `migration` */

insert  into `migration`(`version`,`apply_time`) values 
('m000000_000000_base',1501595649),
('m130524_201442_init',1501595654);

/*Table structure for table `noncitizen` */

DROP TABLE IF EXISTS `noncitizen`;

CREATE TABLE `noncitizen` (
  `identity_number` varchar(50) NOT NULL,
  `noncitizen_name` varchar(50) NOT NULL,
  `birth_date` date NOT NULL,
  `address` varchar(100) NOT NULL,
  PRIMARY KEY (`identity_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `noncitizen` */

insert  into `noncitizen`(`identity_number`,`noncitizen_name`,`birth_date`,`address`) values 
('3674041711860004','Chandrayana Putra','1985-10-02','Kapal');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `no_ktp` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `alamat` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'member',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `faskes_access` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `faskes_access` (`faskes_access`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`faskes_access`) REFERENCES `faskes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`nama`,`no_ktp`,`alamat`,`no_hp`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`role`,`status`,`created_at`,`updated_at`,`faskes_access`) values 
(1,'agungpradnya','agungpradnya','888777666555','Jalan Tukad Pancoran Gang 2A No 7','081558800262','BF2Mg-1d7Ye7ciNz6L74UpAekm3R9gaO','$2y$13$ASXXEjlBkLz0rdmXnwkAy.X0MwawAAXorSYhw6utiMPQTLUm0zTEG',NULL,NULL,'operator',10,1502968725,1502968725,NULL),
(2,'superadmin','superadmin','12345656788900','planet neptunus','0833421345','lnybcBwuBOaXbsdQzYJv604Ug_Sw8qXn','$2y$13$.2H774/uKffvdY3t7BC4Tubs7pm7QQESlpg9DLe1AtdzKrAhJCMYi',NULL,NULL,'admin',10,1502969483,1502969483,NULL),
(3,'gayatri','gayatri','8736495807','Dalung Permai','08123456788','2bSREf-bn1T0EhYXRBZ2oTO5qT7IbgVG','$2y$13$rxgeDavhawmG10BfESA6q.wvmS.KBSfPRNUnXpFb22ZZtRMd2HgJm',NULL,NULL,'operator',10,1502969628,1502969628,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
