-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 13. Mrz 2022 um 22:44
-- Server-Version: 10.3.34-MariaDB-0ubuntu0.20.04.1
-- PHP-Version: 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `DomGridApi`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_element`
--

CREATE TABLE `app_element` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `app_element_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `app_element_description` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `app_element_status` tinyint(4) NOT NULL,
  `app_element_type` tinyint(4) NOT NULL,
  `app_element_environment` tinyint(4) NOT NULL,
  `app_element_source` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `app_element_version` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stable_date_start` date NOT NULL,
  `stable_date_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `custom_element`
--

CREATE TABLE `custom_element` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `custom_package_id` int(11) NOT NULL,
  `app_element_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `custom_package`
--

CREATE TABLE `custom_package` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_name` varchar(250) COLLATE utf16_unicode_ci NOT NULL,
  `package_description` varchar(250) COLLATE utf16_unicode_ci NOT NULL,
  `package_version` varchar(30) COLLATE utf16_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `element_status`
--

CREATE TABLE `element_status` (
  `id` int(11) NOT NULL,
  `status_text` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status_value` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `element_status`
--

INSERT INTO `element_status` (`id`, `status_text`, `status_value`) VALUES
(1, 'Entwicklung', 1),
(2, 'Produktiv', 2),
(3, 'Veraltet', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `element_type`
--

CREATE TABLE `element_type` (
  `id` int(11) NOT NULL,
  `type_text` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `type_value` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `element_type`
--

INSERT INTO `element_type` (`id`, `type_text`, `type_value`) VALUES
(1, 'component', 1),
(2, 'core', 2),
(3, 'element', 3),
(4, 'module', 4),
(5, 'route', 5),
(6, 'service', 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `environment_type`
--

CREATE TABLE `environment_type` (
  `id` int(11) NOT NULL,
  `environment_text` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `environment_value` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `environment_type`
--

INSERT INTO `environment_type` (`id`, `environment_text`, `environment_value`) VALUES
(1, 'Basis Element', 1),
(2, 'Interne Erweiterung', 2),
(3, 'Externe Erweiterung', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(1) NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `realname` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `app_element`
--
ALTER TABLE `app_element`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `custom_element`
--
ALTER TABLE `custom_element`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `custom_packge_id` (`custom_package_id`),
  ADD KEY `app_element_id` (`app_element_id`);

--
-- Indizes für die Tabelle `custom_package`
--
ALTER TABLE `custom_package`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `element_status`
--
ALTER TABLE `element_status`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `element_type`
--
ALTER TABLE `element_type`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `environment_type`
--
ALTER TABLE `environment_type`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pass` (`pass`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `realname` (`realname`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `app_element`
--
ALTER TABLE `app_element`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT für Tabelle `custom_element`
--
ALTER TABLE `custom_element`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `custom_package`
--
ALTER TABLE `custom_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT für Tabelle `element_status`
--
ALTER TABLE `element_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `element_type`
--
ALTER TABLE `element_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `environment_type`
--
ALTER TABLE `environment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
