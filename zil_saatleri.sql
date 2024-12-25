-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 25 Ara 2024, 12:50:23
-- Sunucu sürümü: 8.0.40
-- PHP Sürümü: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `anonymous_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `zil_saatleri`
--

CREATE TABLE `zil_saatleri` (
  `id` int NOT NULL,
  `saat` time NOT NULL,
  `aciklama` varchar(255) DEFAULT NULL,
  `pazartesi` tinyint(1) DEFAULT '0',
  `sali` tinyint(1) DEFAULT '0',
  `carsamba` tinyint(1) DEFAULT '0',
  `persembe` tinyint(1) DEFAULT '0',
  `cuma` tinyint(1) DEFAULT '0',
  `cumartesi` tinyint(1) DEFAULT '0',
  `pazar` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Tablo döküm verisi `zil_saatleri`
--

INSERT INTO `zil_saatleri` (`id`, `saat`, `aciklama`, `pazartesi`, `sali`, `carsamba`, `persembe`, `cuma`, `cumartesi`, `pazar`) VALUES
(15, '13:00:00', 'öğle yemeği beyaz', 1, 1, 1, 1, 0, 0, 0),
(11, '08:00:00', 'giriş', 1, 1, 1, 1, 1, 0, 0),
(12, '09:45:00', '1. mola mavi', 1, 1, 1, 1, 1, 0, 0),
(13, '10:00:00', '1. mola beyaz', 1, 1, 1, 1, 1, 0, 0),
(14, '12:30:00', 'öğle yemeği mavi', 1, 1, 1, 1, 0, 0, 0),
(16, '10:15:00', '1. mola beyaz bitiş', 1, 1, 1, 1, 1, 0, 0),
(17, '13:30:00', 'öğle yemeği beyaz bitiş', 1, 1, 1, 1, 0, 0, 0),
(18, '12:15:00', 'cuma öğle arası', 0, 0, 0, 0, 1, 0, 0),
(19, '13:30:00', 'cuma öğle arası', 0, 0, 0, 0, 1, 0, 0),
(20, '15:45:00', '2. mola', 1, 1, 1, 1, 1, 0, 0),
(21, '16:00:00', '2. mola beyaz', 1, 1, 1, 1, 1, 0, 0),
(22, '16:15:00', '2. mola beyaz bitiş', 1, 1, 1, 1, 1, 0, 0),
(23, '18:00:00', 'bitiş', 1, 1, 1, 1, 1, 0, 0),
(31, '17:45:00', 'üretim etraf toplama', 1, 1, 1, 1, 1, 0, 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `zil_saatleri`
--
ALTER TABLE `zil_saatleri`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `zil_saatleri`
--
ALTER TABLE `zil_saatleri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
