-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 01 Eki 2019, 21:39:04
-- Sunucu sürümü: 10.4.6-MariaDB
-- PHP Sürümü: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `secsectir`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anket_cevap1`
--

CREATE TABLE `anket_cevap1` (
  `no` bigint(255) UNSIGNED NOT NULL,
  `anket_no` bigint(255) UNSIGNED DEFAULT NULL,
  `kullanici_id` bigint(255) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anket_cevap2`
--

CREATE TABLE `anket_cevap2` (
  `no` bigint(255) UNSIGNED NOT NULL,
  `anket_no` bigint(255) UNSIGNED DEFAULT NULL,
  `kullanici_id` bigint(255) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anket_cevap3`
--

CREATE TABLE `anket_cevap3` (
  `no` bigint(255) UNSIGNED NOT NULL,
  `anket_no` bigint(255) UNSIGNED DEFAULT NULL,
  `kullanici_id` bigint(255) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anket_cevap4`
--

CREATE TABLE `anket_cevap4` (
  `no` bigint(255) UNSIGNED NOT NULL,
  `anket_no` bigint(255) UNSIGNED DEFAULT NULL,
  `kullanici_id` bigint(255) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anket_cevap5`
--

CREATE TABLE `anket_cevap5` (
  `no` bigint(255) UNSIGNED NOT NULL,
  `anket_no` bigint(255) UNSIGNED DEFAULT NULL,
  `kullanici_id` bigint(255) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anket_yorumlar`
--

CREATE TABLE `anket_yorumlar` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `yorum_tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `anket_id` bigint(255) UNSIGNED DEFAULT NULL,
  `yyapan_id` bigint(255) UNSIGNED DEFAULT NULL,
  `yorum` longtext COLLATE utf8_bin DEFAULT NULL,
  `yyapan_nick` longtext COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bildirimler`
--

CREATE TABLE `bildirimler` (
  `bild_id` bigint(255) UNSIGNED NOT NULL,
  `anket_id` bigint(255) UNSIGNED NOT NULL DEFAULT 0,
  `bildirim_sahibi_id` bigint(255) UNSIGNED NOT NULL DEFAULT 0,
  `bildirim_icerik` longtext COLLATE utf8_bin NOT NULL DEFAULT '0',
  `bildirim_sahibi_nick` longtext COLLATE utf8_bin NOT NULL DEFAULT '0',
  `bildirim_yyapan_nick` longtext COLLATE utf8_bin NOT NULL DEFAULT '0',
  `bildirim_tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urhoba_anketler`
--

CREATE TABLE `urhoba_anketler` (
  `anket_no` bigint(255) UNSIGNED NOT NULL,
  `soru_sayi` int(10) DEFAULT NULL,
  `anket_video` int(10) DEFAULT NULL,
  `anket_tarih` timestamp NULL DEFAULT current_timestamp(),
  `anket_aciklama` longtext COLLATE utf8_bin DEFAULT NULL,
  `cevap1` longtext COLLATE utf8_bin DEFAULT NULL,
  `cevap2` longtext COLLATE utf8_bin DEFAULT NULL,
  `cevap3` longtext COLLATE utf8_bin DEFAULT NULL,
  `cevap4` longtext COLLATE utf8_bin DEFAULT NULL,
  `cevap5` longtext COLLATE utf8_bin DEFAULT NULL,
  `url1` longtext COLLATE utf8_bin DEFAULT NULL,
  `url2` longtext COLLATE utf8_bin DEFAULT NULL,
  `url3` longtext COLLATE utf8_bin DEFAULT NULL,
  `url4` longtext COLLATE utf8_bin DEFAULT NULL,
  `url5` longtext COLLATE utf8_bin DEFAULT NULL,
  `etiket` longtext COLLATE utf8_bin DEFAULT NULL,
  `anket_sahibi_id` bigint(255) UNSIGNED DEFAULT NULL,
  `anket_sahibi_nick` longtext COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urhoba_anket_begen`
--

CREATE TABLE `urhoba_anket_begen` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `begenen_id` bigint(255) UNSIGNED DEFAULT NULL,
  `begenilen_anket_id` bigint(255) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urhoba_anket_dbegen`
--

CREATE TABLE `urhoba_anket_dbegen` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `anket_begenmeyen_id` bigint(255) UNSIGNED DEFAULT NULL,
  `begenilmeyen_anket_id` bigint(255) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urhoba_engellenen_mailler`
--

CREATE TABLE `urhoba_engellenen_mailler` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `mail_mail` longtext COLLATE utf8_bin DEFAULT NULL,
  `time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urhoba_hesaplar`
--

CREATE TABLE `urhoba_hesaplar` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `kullanici_adi` longtext COLLATE utf8_bin DEFAULT NULL,
  `ad` longtext COLLATE utf8_bin DEFAULT NULL,
  `soyad` longtext COLLATE utf8_bin DEFAULT NULL,
  `sifre` longtext COLLATE utf8_bin DEFAULT NULL,
  `mail` longtext COLLATE utf8_bin DEFAULT NULL,
  `profil_foto` longtext COLLATE utf8_bin DEFAULT 'tema/pp1.jpg',
  `kapak_foto` longtext COLLATE utf8_bin DEFAULT 'tema/wallpaper1.jpg',
  `hakkinda` longtext COLLATE utf8_bin DEFAULT NULL,
  `ip` longtext COLLATE utf8_bin DEFAULT NULL,
  `kayit_tarihi` timestamp NULL DEFAULT current_timestamp(),
  `dogum_tarihi` date DEFAULT NULL,
  `ban` int(10) DEFAULT 0,
  `aktif` int(10) DEFAULT 0,
  `aktiflestirme_kodu` longtext COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urhoba_takip`
--

CREATE TABLE `urhoba_takip` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `takip_eden` longtext COLLATE utf8_bin DEFAULT NULL,
  `takip_eden_id` bigint(255) UNSIGNED DEFAULT NULL,
  `takip_edilen_id` bigint(255) UNSIGNED DEFAULT NULL,
  `takip_durumu` bigint(255) UNSIGNED DEFAULT NULL,
  `takip_edilen` longtext COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `anket_cevap1`
--
ALTER TABLE `anket_cevap1`
  ADD PRIMARY KEY (`no`);

--
-- Tablo için indeksler `anket_cevap2`
--
ALTER TABLE `anket_cevap2`
  ADD PRIMARY KEY (`no`);

--
-- Tablo için indeksler `anket_cevap3`
--
ALTER TABLE `anket_cevap3`
  ADD PRIMARY KEY (`no`);

--
-- Tablo için indeksler `anket_cevap4`
--
ALTER TABLE `anket_cevap4`
  ADD PRIMARY KEY (`no`);

--
-- Tablo için indeksler `anket_cevap5`
--
ALTER TABLE `anket_cevap5`
  ADD PRIMARY KEY (`no`);

--
-- Tablo için indeksler `anket_yorumlar`
--
ALTER TABLE `anket_yorumlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `bildirimler`
--
ALTER TABLE `bildirimler`
  ADD PRIMARY KEY (`bild_id`);

--
-- Tablo için indeksler `urhoba_anketler`
--
ALTER TABLE `urhoba_anketler`
  ADD PRIMARY KEY (`anket_no`);

--
-- Tablo için indeksler `urhoba_anket_begen`
--
ALTER TABLE `urhoba_anket_begen`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urhoba_anket_dbegen`
--
ALTER TABLE `urhoba_anket_dbegen`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urhoba_engellenen_mailler`
--
ALTER TABLE `urhoba_engellenen_mailler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urhoba_hesaplar`
--
ALTER TABLE `urhoba_hesaplar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urhoba_takip`
--
ALTER TABLE `urhoba_takip`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `anket_cevap1`
--
ALTER TABLE `anket_cevap1`
  MODIFY `no` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `anket_cevap2`
--
ALTER TABLE `anket_cevap2`
  MODIFY `no` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `anket_cevap3`
--
ALTER TABLE `anket_cevap3`
  MODIFY `no` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `anket_cevap4`
--
ALTER TABLE `anket_cevap4`
  MODIFY `no` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `anket_cevap5`
--
ALTER TABLE `anket_cevap5`
  MODIFY `no` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `anket_yorumlar`
--
ALTER TABLE `anket_yorumlar`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `bildirimler`
--
ALTER TABLE `bildirimler`
  MODIFY `bild_id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urhoba_anketler`
--
ALTER TABLE `urhoba_anketler`
  MODIFY `anket_no` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urhoba_anket_begen`
--
ALTER TABLE `urhoba_anket_begen`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urhoba_anket_dbegen`
--
ALTER TABLE `urhoba_anket_dbegen`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urhoba_engellenen_mailler`
--
ALTER TABLE `urhoba_engellenen_mailler`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urhoba_hesaplar`
--
ALTER TABLE `urhoba_hesaplar`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urhoba_takip`
--
ALTER TABLE `urhoba_takip`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
