-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 10. April 2011 um 09:27
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
-- Tabellenstruktur für Tabelle `guild`
--

CREATE TABLE IF NOT EXISTS `guild` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `leader` bigint(20) NOT NULL,
  `text` varchar(250) NOT NULL DEFAULT 'Keine Beschreibung',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `guild`
--

INSERT INTO `guild` (`id`, `name`, `leader`, `text`) VALUES
(4, '3Stars', 54, 'Keine Beschreibung');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

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
(7, 'Raserei', 4, 500, '1', 'Raserei erlaubt dir Schnellstraßen zu benützen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `number` smallint(4) NOT NULL DEFAULT '1',
  `dexid` smallint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Daten für Tabelle `items`
--

INSERT INTO `items` (`id`, `user`, `number`, `dexid`) VALUES
(12, 54, 1, 4),
(8, 54, 7, 2),
(14, 54, 1, 7);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `theme` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `user` bigint(20) NOT NULL,
  `message` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Daten für Tabelle `messages`
--

INSERT INTO `messages` (`id`, `theme`, `date`, `user`, `message`) VALUES
(9, 1, '2011-03-21 16:26:25', 54, '[img]http://localhost/pokecastle/maps/sprites/21.png[/img]\r\ndas ist ein Edit');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `title` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `message` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `userid` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `id` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `news`
--


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
  `evolution` tinyint(3) NOT NULL
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
(26, 'Raichu', 4, 5, 5, 3, 5, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pokemons`
--

CREATE TABLE IF NOT EXISTS `pokemons` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `dexid` smallint(3) NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '5',
  `exp` bigint(20) NOT NULL DEFAULT '0',
  `love` tinyint(4) NOT NULL DEFAULT '-10',
  `intelligence` tinyint(4) NOT NULL,
  `strength` tinyint(4) NOT NULL,
  `beauty` tinyint(4) NOT NULL,
  `endurance` tinyint(4) NOT NULL,
  `loved` datetime NOT NULL DEFAULT '2011-02-01 01:56:21',
  `sort` tinyint(1) NOT NULL,
  `abilities` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `pokemons`
--

INSERT INTO `pokemons` (`id`, `userid`, `dexid`, `level`, `exp`, `love`, `intelligence`, `strength`, `beauty`, `endurance`, `loved`, `sort`, `abilities`) VALUES
(1, 54, 2, 16, 4, 53, 70, 54, 58, 70, '2011-04-09 12:22:03', 0, 0),
(5, 54, 19, 15, 19, 44, 78, 63, 75, 78, '2011-04-07 18:08:40', 1, 1),
(7, 58, 4, 5, 10, 9, 25, 25, 15, 15, '2011-03-22 16:14:45', 0, 0),
(9, 54, 172, 14, 0, 55, 70, 42, 56, 42, '2011-04-09 12:23:43', 0, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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
(10, 172, 25, 26);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quest`
--

CREATE TABLE IF NOT EXISTS `quest` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `art` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `num` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `quest`
--

INSERT INTO `quest` (`id`, `art`, `userid`, `num`) VALUES
(3, 2, 58, 2),
(4, 1, 54, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `themes`
--

CREATE TABLE IF NOT EXISTS `themes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `text` varchar(5000) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `typ` tinyint(2) NOT NULL DEFAULT '1',
  `pens` bigint(6) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `user` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `themes`
--

INSERT INTO `themes` (`id`, `title`, `text`, `typ`, `pens`, `date`, `user`) VALUES
(1, 'PokeCastle wird aufgebaut', 'Bis jetzt läuft alles relativ schnell. Shop, Kampfsystem und Welt sind schon halbwegs wertig. Alle bis jetzigen Freatures sind stabil und laufen gut.', 1, 0, '2011-01-30 19:57:02', 54),
(3, 'Bugliste', 'Hier kommen alle Bugs rein, und auch ob sie behoben wurden.\r\n\r\n[b]Hier die Bugs:[/b]\r\n\r\nVerliert man bei einem Kampf verÃ¤ndert sich die Id deiner Eigenen Pokemon.', 1, 0, '2011-02-25 23:28:07', 54),
(4, 'Gilden - FAQ', 'Hier sind einige Fragen die vielleicht gestellt werden. Bitte zuerst durchlesen, bevor hier ein neues Thema er&Atilde;&para;ffnet wird.\r\n\r\nInhaltsverzeichnis:\r\n[ol]\r\n[li]Was sind Gilden?[/li]\r\n[li]Wie bekommen Gilden ihr Geld?[/li]\r\n[li]Was sind Firmen?[/li]\r\n[li]Wie kann man in einer Firma arbeiten?[/li]\r\n[li]Was bringt den Gilden und den Firma dieses Forum?[/li]\r\n[/ol]\r\n\r\n[ol]\r\n[li]Was sind Gilden?[/li]\r\n[ul]\r\n[li]Gilden sind Gruppen von Spielern, die versuchen gemeinsam Geld zu verdienen.[/li]\r\n[li]Das Ziel aller Gilden ist es eine Firma zu werden.[/li]\r\n[li]Doch um dies zu erreichen m&Atilde;&frac14;ssen sie einer der Acht gr&Atilde;&para;&Atilde;Ÿten Gilden sein.[/li]\r\n[/ul]\r\n[li]Wie bekommen Gilden ihr Geld?[/li]\r\n[ul]\r\n[li]Gilden k&Atilde;&para;nnen durch Spenden, Wettbewerbe und Minispiele an Geld kommen.[/li]\r\n[li]Verdienen Gilden ein wenig Geld, so wird es sofort auf alle Mitglieder gleichm&Atilde;&curren;&Atilde;Ÿig verteilt.[/li]\r\n[/ul]\r\n[li]Was sind Firmen?[/li]\r\n[ul]\r\n[li]Firmen besitzen ein eigenes Haus auf der Map und werden im Spiel von NPCs erw&Atilde;&curren;hnt.[/li]\r\n[li]Auch gibt es kleine Bereiche im Spiel, die nur von bestimmten Firmen betreten k&Atilde;&para;nnen.[/li]\r\n[li]Im Vergleich zu Gilden sind Firmen nicht mehr von Minispielen abh&Atilde;&curren;ngig sondern bekommen W&Atilde;&para;chentlich eine Fixe Summe.[/li]\r\n[li]Firmen regieren aber auch in einer Stadt und  sind in dauernd im Kontakt mit einem Admin.[/li]\r\n[/ul]\r\n[li]Wie kann man in einer Firma arbeiten?[/li]\r\n[ul]\r\n[li]Um bei einer Firma zu arbeiten, muss man ein Haus in der Stadt mieten, in der die Firma regiert und nat&Atilde;&frac14;rlich Mitglied der Firma sein.[/li]\r\n[li]An jeden Sonntag Abend werden alle Arbeiter in ihr Haus geschickt, egal wo sie davor waren.[/li]\r\n[li]W&Atilde;&curren;rend der Arbeit verdient die Firma nicht nur Geld, sondern auch noch Bonuspunkte, mit der sie ihre Firma verbessern k&Atilde;&para;nnen.[/li]\r\n[/ul]\r\n[li]Was bringt den Gilden und den Firma dieses Forum?[/li]\r\n[ul]\r\n[li]Gilden und Firmen haben die M&Atilde;&para;glichkeit sich in diesem Forum zu pr&Atilde;&curren;sentieren.[/li]\r\n[/ul]\r\n[/ol]', 2, 0, '2011-04-02 08:41:55', 54),
(6, '', '', 1, 0, '2011-04-07 18:03:23', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `typs`
--

CREATE TABLE IF NOT EXISTS `typs` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  `Normal` tinyint(1) NOT NULL DEFAULT '2',
  `Feuer` tinyint(1) NOT NULL DEFAULT '2',
  `Wasser` tinyint(1) NOT NULL DEFAULT '2',
  `Elektro` tinyint(1) NOT NULL DEFAULT '2',
  `Pflanze` tinyint(1) NOT NULL DEFAULT '2',
  `Flug` tinyint(1) NOT NULL DEFAULT '2',
  `Käfer` tinyint(1) NOT NULL DEFAULT '2',
  `Gift` tinyint(1) NOT NULL DEFAULT '2',
  `Gestein` tinyint(1) NOT NULL DEFAULT '2',
  `Boden` tinyint(1) NOT NULL DEFAULT '2',
  `Kampf` tinyint(1) NOT NULL DEFAULT '2',
  `Eis` tinyint(1) NOT NULL DEFAULT '2',
  `Psycho` tinyint(1) NOT NULL DEFAULT '2',
  `Geist` tinyint(1) NOT NULL DEFAULT '2',
  `Drachen` tinyint(1) NOT NULL DEFAULT '2',
  `Stahl` tinyint(1) NOT NULL DEFAULT '2',
  `Unlicht` tinyint(1) NOT NULL DEFAULT '2'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `typs`
--

INSERT INTO `typs` (`id`, `name`, `Normal`, `Feuer`, `Wasser`, `Elektro`, `Pflanze`, `Flug`, `Käfer`, `Gift`, `Gestein`, `Boden`, `Kampf`, `Eis`, `Psycho`, `Geist`, `Drachen`, `Stahl`, `Unlicht`) VALUES
(1, 'Normal', 2, 2, 2, 2, 2, 2, 2, 2, 1, 2, 2, 2, 2, 1, 2, 1, 2),
(2, 'Feuer', 2, 1, 1, 2, 3, 2, 3, 2, 1, 2, 2, 3, 2, 2, 1, 3, 2),
(3, 'Wasser', 2, 3, 1, 2, 1, 2, 2, 2, 3, 3, 2, 2, 2, 2, 1, 2, 2),
(4, 'Elektro', 2, 2, 3, 1, 1, 3, 2, 2, 2, 1, 2, 2, 2, 2, 1, 2, 2),
(5, 'Pflanze', 2, 1, 3, 2, 1, 1, 1, 1, 2, 3, 2, 2, 2, 2, 1, 1, 2),
(6, 'Flug', 2, 2, 2, 1, 3, 2, 3, 2, 1, 2, 3, 2, 2, 2, 2, 1, 2),
(7, 'Käfer', 2, 1, 2, 2, 3, 1, 2, 1, 2, 2, 1, 2, 3, 1, 2, 1, 3),
(8, 'Gift', 2, 2, 2, 2, 3, 2, 2, 1, 1, 1, 2, 2, 2, 1, 2, 1, 2),
(9, 'Gestein', 2, 3, 2, 2, 2, 3, 3, 2, 2, 1, 1, 3, 2, 2, 2, 1, 2),
(10, 'Boden', 2, 3, 2, 3, 1, 1, 1, 3, 3, 2, 2, 2, 2, 2, 2, 3, 2),
(11, 'Kampf', 3, 2, 2, 2, 2, 1, 1, 1, 3, 2, 2, 3, 1, 1, 2, 3, 3),
(12, 'Eis', 2, 1, 1, 2, 3, 3, 2, 2, 2, 3, 2, 1, 2, 2, 3, 1, 2),
(13, 'Psycho', 2, 2, 2, 2, 2, 2, 2, 3, 2, 2, 3, 2, 1, 2, 2, 1, 1),
(14, 'Geist', 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 2, 1, 1),
(15, 'Drachen', 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 1, 2),
(16, 'Stahl', 2, 1, 1, 1, 2, 2, 2, 2, 3, 2, 2, 3, 2, 2, 2, 1, 2),
(17, 'Unlicht', 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 2, 3, 3, 2, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `md5_id` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `full_name` tinytext COLLATE latin1_general_ci NOT NULL,
  `user_name` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_email` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_level` tinyint(4) NOT NULL DEFAULT '1',
  `pwd` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `address` text COLLATE latin1_general_ci NOT NULL,
  `country` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `tel` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `fax` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `website` text COLLATE latin1_general_ci NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `users_ip` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `approved` int(1) NOT NULL DEFAULT '0',
  `activation_code` int(10) NOT NULL DEFAULT '0',
  `banned` int(1) NOT NULL DEFAULT '0',
  `ckey` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ctime` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `map` bigint(20) NOT NULL DEFAULT '1',
  `online` datetime NOT NULL DEFAULT '2010-01-01 01:01:01',
  `money` smallint(10) NOT NULL DEFAULT '20',
  `energie` smallint(10) NOT NULL DEFAULT '50',
  `profil` smallint(2) NOT NULL,
  `save` smallint(3) NOT NULL DEFAULT '1',
  `guild` bigint(20) NOT NULL DEFAULT '0',
  `citys` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`user_email`),
  FULLTEXT KEY `idx_search` (`full_name`,`address`,`user_email`,`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=59 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `md5_id`, `full_name`, `user_name`, `user_email`, `user_level`, `pwd`, `address`, `country`, `tel`, `fax`, `website`, `date`, `users_ip`, `approved`, `activation_code`, `banned`, `ckey`, `ctime`, `map`, `online`, `money`, `energie`, `profil`, `save`, `guild`, `citys`) VALUES
(54, '', 'admin', 'admin', 'admin@localhost', 5, '4c09e75fa6fe36038ac240e9e4e0126cedef6d8c85cf0a1ae', 'admin', 'Switzerland', '4433093999', '', '', '2010-05-04', '', 1, 0, 0, 'y3g29cq', '1302415309', 10, '2011-04-10 08:26:29', 75, 50, 21, 0, 4, 2),
(55, '', '', 'Big Bear', 'BigBear@lilme.com', 1, 'a9aa8362828adb931900cd93a9d879a7e8df18c8107ce75d7', '', '', '', '', '', '2011-02-17', '', 1, 0, 0, '', '', 1, '2010-01-01 01:01:01', 0, 0, 24, 0, 0, 1),
(58, '66f041e16a60928b05a7e228a89c3799', '', 'Orasund', 'orasund@gmail.com', 1, '896e0bfbd8bb26af76415a0e05783feac0697b99d323ffe1a', '', '', '', '', '', '2011-02-26', '127.0.0.1', 1, 7189, 0, '', '', 501, '2011-03-22 16:10:40', 40, 50, 20, 0, 0, 1);
