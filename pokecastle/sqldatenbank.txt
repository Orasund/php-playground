-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 16. Februar 2011 um 11:33
-- Server Version: 5.0.51
-- PHP-Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `db1225392-main`
--
CREATE DATABASE `db1225392-main` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db1225392-main`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `itemdex`
--

CREATE TABLE IF NOT EXISTS `itemdex` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `typ` smallint(3) NOT NULL,
  `wert` smallint(10) NOT NULL default '1',
  `zahl` varchar(4) NOT NULL default '0',
  `text` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `itemdex`
--

INSERT INTO `itemdex` (`id`, `name`, `typ`, `wert`, `zahl`, `text`) VALUES
(1, 'Trank', 1, 25, '3', 'Standart Trank. Erfrischt erschöpfte Pokemon.'),
(2, 'Pokeball', 2, 100, '10', 'Mit dem Ball kann man Schwache Pokemon fangen.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` bigint(20) NOT NULL auto_increment,
  `user` bigint(20) NOT NULL,
  `number` smallint(4) NOT NULL default '1',
  `dexid` smallint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `items`
--

INSERT INTO `items` (`id`, `user`, `number`, `dexid`) VALUES
(5, 54, 2, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `maps`
--

CREATE TABLE IF NOT EXISTS `maps` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `typ` tinyint(1) NOT NULL default '1',
  `left` bigint(20) NOT NULL default '0',
  `up` bigint(20) NOT NULL default '0',
  `down` bigint(20) NOT NULL default '0',
  `right` bigint(20) NOT NULL default '0',
  `info` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `maps`
--

INSERT INTO `maps` (`id`, `name`, `typ`, `left`, `up`, `down`, `right`, `info`) VALUES
(1, 'Alabastia', 2, 0, 2, 0, 0, 'das letzte Dorf vor Kanto'),
(2, 'Route 1', 1, 0, 0, 1, 0, 'ein kleiner Pfad, der an die Grenze zwischen Kanto und Johto führt');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(20) NOT NULL auto_increment,
  `theme` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `user` bigint(20) NOT NULL,
  `message` varchar(5000) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `messages`
--

INSERT INTO `messages` (`id`, `theme`, `date`, `user`, `message`) VALUES
(4, 1, '2011-02-14 16:37:23', 54, '[b]Das Forum ist fertig![/b]\r\nOh ja!!!!\r\n\r\nokey, bei den Items gabs noch probleme... und dann kann ich mal alles abschließen. juhuuu'),
(5, 1, '2011-02-14 16:49:25', 54, 'irgendwas stimmt noch nicht');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `title` varchar(30) character set latin1 collate latin1_general_ci NOT NULL,
  `message` varchar(500) character set latin1 collate latin1_general_ci NOT NULL,
  `userid` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `id` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `news`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `poke_rassen`
--

CREATE TABLE IF NOT EXISTS `poke_rassen` (
  `id` bigint(20) NOT NULL auto_increment,
  `poke1` tinyint(3) NOT NULL,
  `poke2` tinyint(3) NOT NULL,
  `poke3` tinyint(3) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

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
(7, 19, 20, 20);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pokedex`
--

CREATE TABLE IF NOT EXISTS `pokedex` (
  `id` tinyint(3) unsigned zerofill NOT NULL,
  `name` varchar(20) NOT NULL,
  `typ` tinyint(4) NOT NULL,
  `intelligence` tinyint(4) NOT NULL,
  `strength` tinyint(4) NOT NULL,
  `beauty` tinyint(4) NOT NULL,
  `endurance` tinyint(4) NOT NULL,
  `evolution` tinyint(3) unsigned zerofill NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `pokedex`
--

INSERT INTO `pokedex` (`id`, `name`, `typ`, `intelligence`, `strength`, `beauty`, `endurance`, `evolution`) VALUES
(001, 'Bisasam', 5, 4, 3, 3, 4, 002),
(002, 'Bisaknosp', 5, 5, 3, 2, 5, 003),
(003, 'Bisaflor', 5, 3, 5, 2, 5, 000),
(004, 'Glumanda', 2, 5, 5, 3, 3, 005),
(005, 'Glutexo', 2, 4, 4, 3, 2, 006),
(006, 'Glurak', 2, 2, 3, 3, 5, 000),
(007, 'Schiggy', 3, 4, 3, 3, 4, 008),
(008, 'Schillok', 3, 5, 3, 4, 4, 009),
(009, 'Turtok', 3, 3, 5, 3, 5, 000),
(010, 'Raupy', 7, 4, 3, 3, 3, 011),
(011, 'Safcon', 7, 1, 3, 3, 5, 012),
(012, 'Smettbo', 7, 3, 3, 4, 3, 000),
(013, 'Hornliu', 7, 4, 4, 3, 3, 014),
(014, 'Kokuna', 7, 1, 3, 3, 5, 015),
(015, 'Bibor', 7, 4, 4, 4, 2, 000),
(016, 'Taubsi', 6, 4, 3, 5, 3, 017),
(017, 'Tauboga', 6, 3, 3, 4, 4, 018),
(018, 'Tauboss', 6, 3, 5, 4, 4, 000),
(019, 'Rattfratz', 1, 3, 3, 5, 3, 020),
(020, 'Rattikarl', 1, 3, 4, 5, 3, 000);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pokemons`
--

CREATE TABLE IF NOT EXISTS `pokemons` (
  `id` bigint(20) NOT NULL auto_increment,
  `userid` bigint(20) NOT NULL,
  `dexid` tinyint(3) unsigned zerofill NOT NULL,
  `level` tinyint(4) NOT NULL default '5',
  `exp` bigint(20) NOT NULL default '0',
  `love` tinyint(4) NOT NULL default '10',
  `intelligence` tinyint(4) NOT NULL,
  `strength` tinyint(4) NOT NULL,
  `beauty` tinyint(4) NOT NULL,
  `endurance` tinyint(4) NOT NULL,
  `loved` datetime NOT NULL default '2011-05-01 01:56:21',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `pokemons`
--

INSERT INTO `pokemons` (`id`, `userid`, `dexid`, `level`, `exp`, `love`, `intelligence`, `strength`, `beauty`, `endurance`, `loved`) VALUES
(1, 54, 001, 12, 62, 69, 48, 36, 36, 48, '2011-02-15 10:27:59');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `themes`
--

CREATE TABLE IF NOT EXISTS `themes` (
  `id` bigint(20) NOT NULL auto_increment,
  `title` varchar(30) character set latin1 collate latin1_general_ci NOT NULL,
  `text` varchar(5000) character set latin1 collate latin1_general_ci NOT NULL,
  `typ` tinyint(2) NOT NULL default '1',
  `pens` bigint(6) NOT NULL default '0',
  `date` datetime NOT NULL,
  `user` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `themes`
--

INSERT INTO `themes` (`id`, `title`, `text`, `typ`, `pens`, `date`, `user`) VALUES
(1, 'PokeCastle wird aufgebaut', 'Bis jetzt läuft alles relativ schnell. Shop, Kampfsystem und Welt sind schon halbwegs wertig. Alle bis jetzigen Freatures sind stabil und laufen gut.', 1, 0, '2011-01-30 19:57:02', 54),
(2, 'was', 'ist hier los?', 1, 0, '2011-02-14 16:50:58', 54);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `typs`
--

CREATE TABLE IF NOT EXISTS `typs` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  `Normal` tinyint(1) NOT NULL default '2',
  `Feuer` tinyint(1) NOT NULL default '2',
  `Wasser` tinyint(1) NOT NULL default '2',
  `Elektro` tinyint(1) NOT NULL default '2',
  `Pflanze` tinyint(1) NOT NULL default '2',
  `Flug` tinyint(1) NOT NULL default '2',
  `Käfer` tinyint(1) NOT NULL default '2',
  `Gift` tinyint(1) NOT NULL default '2',
  `Gestein` tinyint(1) NOT NULL default '2',
  `Boden` tinyint(1) NOT NULL default '2',
  `Kampf` tinyint(1) NOT NULL default '2',
  `Eis` tinyint(1) NOT NULL default '2',
  `Psycho` tinyint(1) NOT NULL default '2',
  `Geist` tinyint(1) NOT NULL default '2',
  `Drachen` tinyint(1) NOT NULL default '2',
  `Stahl` tinyint(1) NOT NULL default '2',
  `Unlicht` tinyint(1) NOT NULL default '2'
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
  `id` bigint(20) NOT NULL auto_increment,
  `md5_id` varchar(200) collate latin1_general_ci NOT NULL default '',
  `full_name` tinytext collate latin1_general_ci NOT NULL,
  `user_name` varchar(200) collate latin1_general_ci NOT NULL default '',
  `user_email` varchar(220) collate latin1_general_ci NOT NULL default '',
  `user_level` tinyint(4) NOT NULL default '1',
  `pwd` varchar(220) collate latin1_general_ci NOT NULL default '',
  `address` text collate latin1_general_ci NOT NULL,
  `country` varchar(200) collate latin1_general_ci NOT NULL default '',
  `tel` varchar(200) collate latin1_general_ci NOT NULL default '',
  `fax` varchar(200) collate latin1_general_ci NOT NULL default '',
  `website` text collate latin1_general_ci NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `users_ip` varchar(200) collate latin1_general_ci NOT NULL default '',
  `approved` int(1) NOT NULL default '0',
  `activation_code` int(10) NOT NULL default '0',
  `banned` int(1) NOT NULL default '0',
  `ckey` varchar(220) collate latin1_general_ci NOT NULL default '',
  `ctime` varchar(220) collate latin1_general_ci NOT NULL default '',
  `map` bigint(20) NOT NULL default '1',
  `online` datetime NOT NULL default '2010-01-01 01:01:01',
  `money` smallint(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_email` (`user_email`),
  FULLTEXT KEY `idx_search` (`full_name`,`address`,`user_email`,`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=55 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `md5_id`, `full_name`, `user_name`, `user_email`, `user_level`, `pwd`, `address`, `country`, `tel`, `fax`, `website`, `date`, `users_ip`, `approved`, `activation_code`, `banned`, `ckey`, `ctime`, `map`, `online`, `money`) VALUES
(54, '', 'admin', 'admin', 'admin@localhost', 5, '4c09e75fa6fe36038ac240e9e4e0126cedef6d8c85cf0a1ae', 'admin', 'Switzerland', '4433093999', '', '', '2010-05-04', '', 1, 0, 0, 'bw7nfqk', '1297789866', 1, '2011-02-15 07:36:04', 60);
