-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 22. April 2011 um 07:26
-- Server Version: 5.5.8
-- PHP-Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `db1225392-main`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `itemdex`
--

CREATE TABLE IF NOT EXISTS `itemdex` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `typ` smallint(3) NOT NULL,
  `wert` smallint(10) NOT NULL DEFAULT '1',
  `zahl` varchar(4) NOT NULL DEFAULT '0',
  `text` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `itemdex`
--

INSERT INTO `itemdex` (`id`, `name`, `typ`, `wert`, `zahl`, `text`) VALUES
(1, 'Trank', 1, 25, '3', 'Standart Trank. Erfrischt erschöpfte Pokemon.'),
(2, 'Pokeball', 2, 100, '5', 'Mit dem Ball kann man Schwache Pokemon fangen.'),
(3, 'Supertrank', 1, 60, '8', 'Besserer Trank. Heilt verwundete Pokemon.'),
(4, 'Fluchtseil', 3, 50, '0', 'Bringt den Spieler sofort zur seinem Haus.'),
(5, 'E-Ball', 2, 250, '4', 'Ein neuer, mit Strom betriebener Ball'),
(6, 'Süßer Kaffee', 1, 5, '1', 'muntert entäuschte Pokemon wieder auf.'),
(7, 'Raserei', 4, 500, '1', 'Raserei erlaubt dir Schnellstraßen zu benützen'),
(8, 'Superball', 2, 300, '10', 'Standart Ball, fängt bereits Entwickelte Pokemon.'),
(9, 'Schwimmen', 4, 700, '2', 'Mit Schwimmen kannst du die Wasserwegen Benützen.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pokedex`
--

CREATE TABLE IF NOT EXISTS `pokedex` (
  `id` smallint(3) NOT NULL,
  `name` varchar(20) NOT NULL,
  `typ` tinyint(4) NOT NULL,
  `intelligence` tinyint(4) NOT NULL,
  `strength` tinyint(4) NOT NULL,
  `beauty` tinyint(4) NOT NULL,
  `endurance` tinyint(4) NOT NULL,
  `evolution` smallint(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `pokedex`
--

INSERT INTO `pokedex` (`id`, `name`, `typ`, `intelligence`, `strength`, `beauty`, `endurance`, `evolution`) VALUES
(1, 'Bisasam', 5, 4, 3, 3, 4, 2),
(2, 'Bisaknosp', 5, 5, 3, 2, 5, 3),
(3, 'Bisaflor', 5, 3, 5, 2, 5, 0),
(4, 'Glumanda', 2, 5, 5, 3, 3, 5),
(5, 'Glutexo', 2, 4, 4, 3, 2, 6),
(6, 'Glurak', 2, 2, 3, 3, 5, 0),
(7, 'Schiggy', 3, 4, 3, 3, 4, 8),
(8, 'Schillok', 3, 5, 3, 4, 4, 9),
(9, 'Turtok', 3, 3, 5, 3, 5, 0),
(10, 'Raupy', 7, 4, 3, 3, 3, 11),
(11, 'Safcon', 7, 1, 3, 3, 5, 12),
(12, 'Smettbo', 7, 3, 3, 4, 3, 0),
(13, 'Hornliu', 7, 4, 4, 3, 3, 14),
(14, 'Kokuna', 7, 1, 3, 3, 5, 15),
(15, 'Bibor', 7, 4, 4, 4, 2, 0),
(16, 'Taubsi', 6, 4, 3, 5, 3, 17),
(17, 'Tauboga', 6, 3, 3, 4, 4, 18),
(18, 'Tauboss', 6, 3, 5, 4, 4, 0),
(19, 'Rattfratz', 1, 3, 3, 5, 3, 20),
(20, 'Rattikarl', 1, 3, 4, 5, 3, 0),
(25, 'Pikachu', 4, 4, 4, 4, 4, 26),
(172, 'Pichu', 4, 5, 3, 4, 3, 25),
(26, 'Raichu', 4, 5, 5, 3, 5, 0),
(21, 'Habitak', 6, 3, 4, 5, 3, 22),
(22, 'Ibitak', 6, 3, 5, 4, 3, 0),
(27, 'Sandan', 10, 5, 3, 4, 3, 28),
(28, 'Sandamer', 10, 5, 4, 3, 3, 0),
(173, 'Pii', 1, 4, 1, 5, 3, 35),
(35, 'Piepi', 1, 5, 3, 5, 4, 36),
(36, 'Pixi', 1, 5, 3, 3, 5, 0),
(174, 'Fluffeluff', 1, 3, 3, 4, 4, 39),
(39, 'Pummeluff', 1, 4, 3, 5, 5, 40),
(40, 'Knuddeluff', 1, 4, 4, 3, 5, 0),
(41, 'Zubat', 8, 4, 3, 5, 3, 42),
(42, 'Golbat', 8, 3, 3, 5, 4, 169),
(169, 'Iksbat', 8, 3, 3, 5, 2, 0),
(46, 'Paras', 7, 4, 3, 5, 3, 47),
(47, 'Parasek', 7, 4, 4, 3, 5, 0),
(56, 'Menki', 11, 4, 3, 4, 2, 57),
(57, 'Rasaff', 11, 1, 5, 3, 3, 0),
(74, 'Kleinstein', 9, 2, 3, 2, 4, 75),
(75, 'Georok', 9, 2, 4, 2, 4, 76),
(76, 'Geowaz', 9, 2, 4, 2, 4, 0),
(129, 'Karpador', 3, 3, 4, 5, 5, 130),
(130, 'Garados', 3, 2, 4, 3, 4, 0),
(60, 'Quapsel', 3, 3, 2, 4, 5, 61),
(61, 'Quaputzi', 3, 4, 3, 3, 4, 62),
(62, 'Quappo', 3, 4, 5, 2, 5, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `poke_rassen`
--

CREATE TABLE IF NOT EXISTS `poke_rassen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `poke1` smallint(3) NOT NULL,
  `poke2` smallint(3) NOT NULL,
  `poke3` smallint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Daten für Tabelle `poke_rassen`
--

INSERT INTO `poke_rassen` (`id`, `poke1`, `poke2`, `poke3`) VALUES
(1, 1, 2, 3),
(2, 4, 5, 6),
(3, 7, 8, 9),
(4, 10, 11, 12),
(5, 13, 14, 15),
(6, 16, 17, 18),
(7, 19, 20, 20),
(10, 172, 25, 26),
(8, 21, 22, 22),
(11, 27, 28, 28),
(14, 173, 35, 36),
(16, 174, 39, 40),
(17, 41, 42, 169),
(19, 46, 47, 47),
(24, 56, 57, 57),
(31, 74, 75, 76),
(26, 60, 61, 62),
(63, 129, 130, 130);
