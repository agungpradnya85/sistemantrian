-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

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


DROP TABLE IF EXISTS `faskes`;
CREATE TABLE `faskes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `tipe` enum('puskesmas','rumahsakit') NOT NULL,
  `kecamatan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kecamatan` (`kecamatan`),
  CONSTRAINT `faskes_ibfk_1` FOREIGN KEY (`kecamatan`) REFERENCES `kecamatan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `faskes` (`id`, `nama`, `tipe`, `kecamatan`) VALUES
(1,	'Puskesmas Badung 1',	'puskesmas',	3),
(2,	'Puskesmas Badung 2',	'puskesmas',	3),
(5,	'Rumah Sakit Kapal',	'rumahsakit',	3);

DROP TABLE IF EXISTS `kecamatan`;
CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL DEFAULT '0',
  `nama` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `kecamatan` (`id`, `slug`, `nama`) VALUES
(1,	'abiansemal',	'ABIANSEMAL'),
(2,	'petang',	'PETANG'),
(3,	'badung',	'BADUNG'),
(4,	'mengwi',	'MENGWI'),
(5,	'kuta-utara',	'KUTA UTARA'),
(6,	'kuta-selatan',	'KUTA SELATAN');

DROP TABLE IF EXISTS `klinik`;
CREATE TABLE `klinik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_klinik` varchar(3) NOT NULL,
  `nama_klinik` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `klinik` (`id`, `kode_klinik`, `nama_klinik`) VALUES
(1,	'A',	'Poli Umum'),
(2,	'B',	'Poli Gigi');

DROP TABLE IF EXISTS `klinik_map`;
CREATE TABLE `klinik_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_antrian` varchar(11) NOT NULL,
  `id_klinik` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` smallint(3) NOT NULL DEFAULT '1' COMMENT 'status 0 : batal, status 1 : bisa hadir (default), 2 : sudah dipanggil',
  `time_exam` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_klinik` (`id_klinik`),
  CONSTRAINT `klinik_map_ibfk_1` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `klinik_map` (`id`, `no_antrian`, `id_klinik`, `id_pasien`, `tanggal`, `status`, `time_exam`) VALUES
(1,	'A1',	1,	1,	'2017-08-20',	2,	'08.00 - 10.00'),
(2,	'A2',	1,	1,	'2017-08-20',	1,	'08.00 - 10.00'),
(3,	'A3',	1,	1,	'2017-08-20',	2,	'08.00 - 10.00'),
(4,	'A1',	1,	1,	'2017-08-21',	1,	'08.00 - 10.00'),
(5,	'A1',	1,	2,	'2017-08-22',	2,	'08.00 - 10.00'),
(6,	'A2',	1,	2,	'2017-08-22',	1,	'08.00 - 10.00'),
(7,	'A3',	1,	2,	'2017-08-22',	1,	'08.00 - 10.00'),
(8,	'A4',	1,	2,	'2017-08-22',	1,	'08.00 - 10.00'),
(9,	'A5',	1,	2,	'2017-08-22',	1,	'08.00 - 10.00'),
(10,	'A6',	1,	2,	'2017-08-22',	1,	'08.00 - 10.00'),
(11,	'A7',	1,	2,	'2017-08-22',	1,	'08.00 - 10.00'),
(12,	'A8',	1,	2,	'2017-08-22',	1,	'08.00 - 10.00'),
(13,	'A9',	1,	2,	'2017-08-22',	1,	'08.00 - 10.00'),
(14,	'A10',	1,	2,	'2017-08-22',	1,	'08.00 - 10.00'),
(15,	'A11',	1,	2,	'2017-08-22',	0,	'08.00 - 10.00'),
(16,	'A12',	1,	2,	'2017-08-22',	1,	'08.00 - 10.00'),
(17,	'A13',	1,	2,	'2017-08-22',	0,	'10.00 - 12.00'),
(18,	'A14',	1,	2,	'2017-08-22',	0,	'10.00 - 12.00'),
(19,	'A15',	1,	2,	'2017-08-22',	1,	'10.00 - 12.00'),
(20,	'A1',	1,	1,	'2017-08-23',	1,	'08.00 - 10.00'),
(21,	'A1',	1,	2,	'2017-08-27',	1,	'08.00 - 10.00'),
(22,	'A1',	1,	2,	'2017-08-28',	1,	'08.00 - 10.00'),
(23,	'A2',	1,	2,	'2017-08-28',	1,	'08.00 - 10.00'),
(24,	'A3',	1,	2,	'2017-08-28',	1,	'08.00 - 10.00'),
(25,	'A4',	1,	2,	'2017-08-28',	1,	'08.00 - 10.00'),
(26,	'A5',	1,	1,	'2017-08-28',	1,	'08.00 - 10.00'),
(27,	'A6',	1,	1,	'2017-08-28',	1,	'08.00 - 10.00'),
(28,	'A7',	1,	1,	'2017-08-28',	1,	'08.00 - 10.00'),
(29,	'A8',	1,	1,	'2017-08-28',	1,	'08.00 - 10.00'),
(30,	'A9',	1,	1,	'2017-08-28',	1,	'08.00 - 10.00'),
(31,	'A10',	1,	1,	'2017-08-28',	1,	'08.00 - 10.00'),
(32,	'A11',	1,	1,	'2017-08-28',	1,	'08.00 - 10.00'),
(33,	'A12',	1,	1,	'2017-08-28',	1,	'08.00 - 10.00'),
(34,	'A13',	1,	1,	'2017-08-28',	1,	'10.00 - 12.00'),
(35,	'A14',	1,	1,	'2017-08-28',	1,	'10.00 - 12.00'),
(36,	'A1',	1,	1,	'2017-08-29',	2,	'08.00 - 10.00'),
(37,	'A2',	1,	3,	'2017-08-29',	1,	'08.00 - 10.00'),
(38,	'A3',	1,	3,	'2017-08-29',	1,	'08.00 - 10.00'),
(39,	'A4',	1,	3,	'2017-08-29',	1,	'08.00 - 10.00'),
(40,	'A5',	1,	3,	'2017-08-29',	1,	'08.00 - 10.00'),
(41,	'A6',	1,	3,	'2017-08-29',	1,	'08.00 - 10.00'),
(42,	'A7',	1,	3,	'2017-08-29',	1,	'08.00 - 10.00'),
(43,	'A8',	1,	3,	'2017-08-29',	1,	'08.00 - 10.00'),
(44,	'A9',	1,	2,	'2017-08-29',	1,	'08.00 - 10.00'),
(45,	'A1',	1,	3,	'2017-08-31',	1,	'08.00 - 10.00'),
(46,	'A1',	1,	3,	'2017-09-03',	1,	'08.00 - 10.00'),
(47,	'A2',	1,	3,	'2017-09-03',	1,	'08.00 - 10.00'),
(48,	'A3',	1,	3,	'2017-09-03',	1,	'08.00 - 10.00'),
(49,	'A4',	1,	3,	'2017-09-03',	1,	'08.00 - 10.00'),
(50,	'A5',	1,	3,	'2017-09-03',	1,	'08.00 - 10.00'),
(51,	'A6',	1,	2,	'2017-09-03',	1,	'08.00 - 10.00'),
(52,	'A7',	1,	3,	'2017-09-03',	1,	'08.00 - 10.00'),
(53,	'A8',	1,	3,	'2017-09-03',	1,	'08.00 - 10.00'),
(54,	'A9',	1,	3,	'2017-09-03',	1,	'08.00 - 10.00'),
(55,	'A10',	1,	3,	'2017-09-03',	1,	'08.00 - 10.00'),
(56,	'A11',	1,	3,	'2017-09-03',	0,	'08.00 - 10.00'),
(57,	'A12',	1,	3,	'2017-09-03',	1,	'08.00 - 10.00'),
(58,	'B1',	2,	3,	'2017-09-03',	0,	'08.00 - 10.00'),
(59,	'B2',	2,	3,	'2017-09-03',	0,	'08.00 - 10.00'),
(60,	'A13',	1,	3,	'2017-09-03',	1,	'10.00 - 12.00'),
(61,	'A14',	1,	3,	'2017-09-03',	0,	'10.00 - 12.00'),
(62,	'A15',	1,	3,	'2017-09-03',	1,	'10.00 - 12.00'),
(63,	'A16',	1,	3,	'2017-09-03',	0,	'10.00 - 12.00'),
(64,	'A17',	1,	3,	'2017-09-03',	1,	'10.00 - 12.00'),
(65,	'A18',	1,	3,	'2017-09-03',	1,	'10.00 - 12.00'),
(66,	'A19',	1,	3,	'2017-09-03',	0,	'10.00 - 12.00'),
(67,	'A20',	1,	3,	'2017-09-03',	1,	'10.00 - 12.00'),
(68,	'A21',	1,	3,	'2017-09-03',	1,	'10.00 - 12.00'),
(69,	'A22',	1,	3,	'2017-09-03',	1,	'10.00 - 12.00'),
(70,	'A23',	1,	3,	'2017-09-03',	1,	'10.00 - 12.00'),
(71,	'A24',	1,	3,	'2017-09-03',	1,	'10.00 - 12.00'),
(72,	'A25',	1,	3,	'2017-09-03',	1,	'12.00 - 14.00'),
(73,	'A26',	1,	3,	'2017-09-03',	0,	'12.00 - 14.00'),
(74,	'A27',	1,	3,	'2017-09-03',	1,	'12.00 - 14.00'),
(75,	'A28',	1,	3,	'2017-09-03',	1,	'12.00 - 14.00'),
(76,	'A29',	1,	3,	'2017-09-03',	1,	'12.00 - 14.00'),
(77,	'A30',	1,	3,	'2017-09-03',	1,	'12.00 - 14.00'),
(78,	'A31',	1,	3,	'2017-09-03',	0,	'12.00 - 14.00'),
(79,	'A32',	1,	3,	'2017-09-03',	0,	'12.00 - 14.00'),
(80,	'A33',	1,	3,	'2017-09-03',	1,	'12.00 - 14.00'),
(81,	'A1',	1,	3,	'2017-09-04',	1,	'08.00 - 10.00'),
(82,	'A2',	1,	3,	'2017-09-04',	1,	'08.00 - 10.00'),
(83,	'A3',	1,	2,	'2017-09-04',	1,	'08.00 - 10.00'),
(84,	'A4',	1,	3,	'2017-09-04',	1,	'08.00 - 10.00'),
(85,	'A5',	1,	3,	'2017-09-04',	1,	'08.00 - 10.00'),
(86,	'A6',	1,	3,	'2017-09-04',	1,	'08.00 - 10.00'),
(87,	'A7',	1,	3,	'2017-09-04',	1,	'08.00 - 10.00'),
(88,	'A8',	1,	3,	'2017-09-04',	1,	'08.00 - 10.00'),
(89,	'A9',	1,	1,	'2017-09-04',	1,	'08.00 - 10.00');

DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base',	1501595649),
('m130524_201442_init',	1501595654);

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`id`, `username`, `nama`, `no_ktp`, `alamat`, `no_hp`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1,	'agungpradnya',	'agungpradnya',	'888777666555',	'Jalan Tukad Pancoran Gang 2A No 7',	'081558800262',	'BF2Mg-1d7Ye7ciNz6L74UpAekm3R9gaO',	'$2y$13$ASXXEjlBkLz0rdmXnwkAy.X0MwawAAXorSYhw6utiMPQTLUm0zTEG',	NULL,	NULL,	'member',	10,	1502968725,	1502968725),
(2,	'superadmin',	'superadmin',	'12345656788900',	'planet neptunus',	'0833421345',	'lnybcBwuBOaXbsdQzYJv604Ug_Sw8qXn',	'$2y$13$.2H774/uKffvdY3t7BC4Tubs7pm7QQESlpg9DLe1AtdzKrAhJCMYi',	NULL,	NULL,	'admin',	10,	1502969483,	1502969483),
(3,	'gayatri',	'gayatri',	'8736495807',	'Dalung Permai',	'08123456788',	'2bSREf-bn1T0EhYXRBZ2oTO5qT7IbgVG',	'$2y$13$rxgeDavhawmG10BfESA6q.wvmS.KBSfPRNUnXpFb22ZZtRMd2HgJm',	NULL,	NULL,	'member',	10,	1502969628,	1502969628);

-- 2017-09-06 06:17:49
