-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Czas generowania: 27 Lis 2022, 17:04
-- Wersja serwera: 10.5.15-MariaDB-10+deb11u1
-- Wersja PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `to3k_8`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `access_log`
--

CREATE TABLE `access_log` (
  `id` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `url` text COLLATE latin1_general_ci NOT NULL,
  `HTTP_CLIENT_IP` text COLLATE latin1_general_ci NOT NULL,
  `HTTP_X_FORWARDED_FOR` text COLLATE latin1_general_ci NOT NULL,
  `HTTP_X_FORWARDED` text COLLATE latin1_general_ci NOT NULL,
  `HTTP_FORWARDED_FOR` text COLLATE latin1_general_ci NOT NULL,
  `HTTP_FORWARDED` text COLLATE latin1_general_ci NOT NULL,
  `REMOTE_ADDR` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `connections`
--

CREATE TABLE `connections` (
  `id` int(11) NOT NULL,
  `twitter_login` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `twitter_verified` tinyint(1) NOT NULL,
  `mastodon_login` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `mastodon_verified` tinyint(1) NOT NULL,
  `twitter_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter_img` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `mastodon_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mastodon_img` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stats_users`
--

CREATE TABLE `stats_users` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `all_users` int(11) NOT NULL,
  `verified_users` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stats_views`
--

CREATE TABLE `stats_views` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `stats_users`
--
ALTER TABLE `stats_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `stats_views`
--
ALTER TABLE `stats_views`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `connections`
--
ALTER TABLE `connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `stats_users`
--
ALTER TABLE `stats_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `stats_views`
--
ALTER TABLE `stats_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
