-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2017 at 06:06 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antrianonline`
--

-- --------------------------------------------------------

--
-- Table structure for table `klinik`
--

CREATE TABLE `klinik` (
  `id` int(11) NOT NULL,
  `kode_klinik` varchar(3) NOT NULL,
  `nama_klinik` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `klinik`
--

INSERT INTO `klinik` (`id`, `kode_klinik`, `nama_klinik`) VALUES
(1, 'A', 'POLI UMUM'),
(2, 'B', 'Gigi');

-- --------------------------------------------------------

--
-- Table structure for table `klinik_map`
--

CREATE TABLE `klinik_map` (
  `id` int(11) NOT NULL,
  `no_antrian` varchar(11) NOT NULL,
  `id_klinik` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` smallint(3) NOT NULL DEFAULT '1' COMMENT 'status 0 : batal, status 1 : bisa hadir (default), 2 : sudah dipanggil',
  `time_exam` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `klinik_map`
--

INSERT INTO `klinik_map` (`id`, `no_antrian`, `id_klinik`, `id_pasien`, `tanggal`, `status`, `time_exam`) VALUES
(1, 'A1', 1, 7, '2017-08-15', 1, '08.00 - 10.00');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1501595649),
('m130524_201442_init', 1501595654);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
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
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `nama`, `no_ktp`, `alamat`, `no_hp`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'umami', 'Mamai', '', '', '', 'WSOYPtYyS9K3-fRfnbCS8JOoPRHuNMnH', '$2y$13$4z8g/Biap9ptDNrbHpBHSuFT/XVT5wJaG4GdKm0nAioFVcV2ajMF6', NULL, 'umami@gmail.com', 'member', 10, 1501597871, 1501597871),
(2, 'aaa', 'bbb', '', '', '', 'G8jF0LIowtr2qjH_6s0-l0Tp8NXEMkA8', '$2y$13$SpKWbCDRDdMnYtNWygd7k.RP3zyF6RizvDcF.K1tx0pIiodWYsxEa', NULL, NULL, 'member', 10, 1501601937, 1501601937),
(3, 'bbb', 'bababa', '111119999999', 'bh', '77777ooooooo', 'X72u40Nt9b2XDI0yKfD6EG4EriLIszhv', '$2y$13$SFfJYnojQxtVh/.cu0NIpeNiZxDl0LSvitgTjUTbYEWBFA7lF934y', NULL, NULL, 'member', 10, 1501602693, 1501602693),
(4, 'gayatri', 'gayatri', '008999999999999', 'dalung', '081558800262', '8nw-y9fcJmiCMhp9MeRaEpx_MN3TcsbA', '$2y$13$udI.KVixooUY6wV2TywvB.rEwCv8/HZCW29oKEDmgS/o.31B3MZnS', NULL, NULL, 'member', 10, 1501603146, 1501603146),
(5, 'agungpradnya', 'agungpradnya', '00000000000000000', 'tukad pancoran', '081558800262', 'OW_OBoojLCdPYJooBwGx5EeiPeaZ_0UV', '$2y$13$hmvnGzmBv96xulxcT1M7bOnKdc5aQMT6AWlFfCGIydN7rgO0l9PCW', NULL, NULL, 'admin', 10, 1501603591, 1501603591),
(7, 'madesaguna', 'madesaguna', '99999999999999', 'panjer', '9999999999999', 'iDF1v445IOlIpPsH5C29DstZJ8A5FRWW', '$2y$13$TWACv1nibiH9rIf75YbkBeVElcS0ZhB7NPWVXr9eoOU9e68BOAdbS', NULL, NULL, 'member', 10, 1501603644, 1501603644),
(8, 'andikaputra', 'andikaputra', '222344567788', 'Jalan Tukad Pancoran Gang 2 A NO 7', '081558800262', 'jY-tgQU7Q5lz0rC1QuXRAXAHau4sCiuW', '$2y$13$WA3R3iXvsZYo2ZXwavNrseK6GrTm1wq2RCKCPdnIzLIXwRsB9BF5C', NULL, NULL, 'member', 10, 1501663700, 1501663700),
(9, 'wiryawan', 'wiryawan', '08566789978', 'Jalan Indrajaya', '0876668768', '55OpKzKSoIjy7HIBfO6wzoywA0yHtf6Y', '$2y$13$Xo4j7RD3tPxBsSLSJM65cOkEfWkfFqmAitDF4Ag5lip042xSs/Mue', NULL, NULL, 'member', 10, 1501740402, 1501740402),
(10, 'mirahdwidaputri', 'mirahdwidaputri', '7869944403983849', 'jalan tukad pancoran gang 2 A No 7', '081222343432', 'Z-sVX79VH0J43Q5EH2OKNkW2lB78GnKX', '$2y$13$k0WvVLy0mVO8ruqfDpNKiupkESjxjFoJrzRdY8VVliFmH.lTqURii', NULL, NULL, 'member', 10, 1502256354, 1502256354),
(11, 'irfanbachdim', 'irfanbachdim', '8883333333333', 'gianyar', '0812343234', 'Qsad43IgdezCuoMul8TMJWunq2Ykh-he', '$2y$13$muts6GbG188SJx9JG8YotucrJ6vMLFxoNBn3RNFDafGbIhvRZpXYW', NULL, NULL, 'member', 10, 1502262051, 1502262051),
(12, 'jenifer', 'jenifer', '876798773345', 'tukad pancoran', '0876676577', '1E1fU2isP1dr8oo8kguM56NVo0TOQp4w', '$2y$13$i9QrEqVS.Wf9.sIiq72NKekfz8k0NA6QsSG7LCpu8GWqPCIaG3CaK', NULL, NULL, 'member', 10, 1502264536, 1502264536),
(13, 'dddd', 'fff', '333', '222', '4444', 'YJA5HcIpNlDtpvkxBqZwMlCgxABESebv', '$2y$13$qpHl8hGbUQHxNZ4Z0lFpu.hj3wMrp3jbfhM.XHgbYwCCobjEhPBa2', NULL, NULL, 'member', 10, 1502369111, 1502369111),
(14, '', 'fff', '333', '222', '4444', 'NDxPIVFtStNseV5TCnBHpaWHFjb6Tuzw', '$2y$13$J1NbjjKZFncm1qcxWbYHVuvTWEO1ZK.zmK8HgmX.geefJTbjFZw4O', NULL, NULL, 'member', 10, 1502369254, 1502369254),
(15, 'mas_poltak', 'fff', '333', '222', '4444', 'a_R6yQ3yiRmKH1itsAGexSC4hwOHxLdF', '$2y$13$G45FAVgrMXaGSyDWrHR5sODjalyWo6ETVEHLY8M.yH9VwEzz..ZCO', NULL, NULL, 'member', 10, 1502369539, 1502369539);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `klinik`
--
ALTER TABLE `klinik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klinik_map`
--
ALTER TABLE `klinik_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_klinik` (`id_klinik`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klinik`
--
ALTER TABLE `klinik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `klinik_map`
--
ALTER TABLE `klinik_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `klinik_map`
--
ALTER TABLE `klinik_map`
  ADD CONSTRAINT `klinik_map_ibfk_1` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
