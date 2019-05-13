-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 13. Feb 2012 um 13:20
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `runewater`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fights`
--

CREATE TABLE IF NOT EXISTS `fights` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `attacker` bigint(20) NOT NULL,
  `defender` bigint(20) NOT NULL,
  `a_zcard` int(2) NOT NULL DEFAULT '0',
  `d_zcard` int(2) NOT NULL DEFAULT '0',
  `a_card1` int(2) NOT NULL DEFAULT '0',
  `a_card2` int(2) NOT NULL DEFAULT '0',
  `a_card3` int(2) NOT NULL DEFAULT '0',
  `a_card4` int(2) NOT NULL DEFAULT '0',
  `d_card1` int(2) NOT NULL DEFAULT '0',
  `d_card2` int(2) NOT NULL DEFAULT '0',
  `d_card3` int(2) NOT NULL DEFAULT '0',
  `d_card4` int(2) NOT NULL DEFAULT '0',
  `turn` int(1) NOT NULL DEFAULT '0',
  `a_card5` int(2) NOT NULL DEFAULT '0',
  `d_card5` int(2) NOT NULL DEFAULT '0',
  `a_life` smallint(3) NOT NULL DEFAULT '100',
  `d_life` smallint(3) NOT NULL DEFAULT '100',
  `a_choise` tinyint(1) NOT NULL DEFAULT '0',
  `d_choise` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `islands`
--

CREATE TABLE IF NOT EXISTS `islands` (
  `id` int(1) NOT NULL,
  `z2` int(1) NOT NULL,
  `z3` int(1) NOT NULL,
  `z4` int(1) NOT NULL,
  `mine` int(1) NOT NULL,
  `save` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `islands`
--

INSERT INTO `islands` (`id`, `z2`, `z3`, `z4`, `mine`, `save`) VALUES
(1, 1, 2, 3, 0, 1),
(0, 1, 2, 3, 0, 1),
(2, 1, 2, 3, 1, 1),
(3, 1, 2, 3, 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `typ` int(2) NOT NULL,
  `level` int(1) NOT NULL DEFAULT '0',
  `user` bigint(20) NOT NULL,
  `count` smallint(2) NOT NULL DEFAULT '1',
  `life` int(1) NOT NULL DEFAULT '8',
  `name` varchar(20) NOT NULL,
  `price` int(2) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `who` bigint(20) NOT NULL,
  `whom` bigint(20) NOT NULL,
  `typ` smallint(2) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `news`
--

INSERT INTO `news` (`id`, `who`, `whom`, `typ`, `date`) VALUES
(1, 0, 1, 0, '2012-01-04 21:19:07'),
(2, 0, 2, 0, '2012-01-06 10:31:58'),
(3, 1, 0, 0, '2012-01-06 10:34:24'),
(4, 0, 2, 1, '2012-01-06 10:34:54'),
(5, 1, 0, 0, '2012-01-06 10:36:06'),
(6, 0, 2, 0, '2012-01-06 10:36:59'),
(7, 2, 0, 1, '2012-01-06 10:37:15'),
(8, 0, 2, 1, '2012-01-06 10:37:39'),
(9, 2, 1, 0, '2012-01-06 10:37:56');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item` bigint(20) NOT NULL,
  `cost` mediumint(3) NOT NULL,
  `user` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `text` varchar(300) NOT NULL,
  `typ` tinyint(1) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` bigint(20) NOT NULL,
  `visits` mediumint(4) NOT NULL DEFAULT '0',
  `pins` mediumint(4) NOT NULL DEFAULT '1',
  `vote` bigint(20) NOT NULL DEFAULT '0',
  `forum` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `topics`
--

INSERT INTO `topics` (`id`, `text`, `typ`, `date`, `user`, `visits`, `pins`, `vote`, `forum`) VALUES
(1, 'Willkomen im Forum. Alle Einträge werden hier nach einiger Zeit gelöscht, achte also darauf, das hier keine wichtgen Sachen eingetragen werden. Falls der Post sich auf ein Vote bezieht, so kann man ihn anzeigen lassen. Aber das findet ihr schon heraus. Also, lasst euch überraschen und Viel Spass!', 0, '2011-12-25 17:00:34', 20, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `md5_id` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_name` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_email` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_level` tinyint(4) NOT NULL DEFAULT '1',
  `pwd` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `users_ip` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `approved` int(1) NOT NULL DEFAULT '0',
  `activation_code` int(10) NOT NULL DEFAULT '0',
  `banned` int(1) NOT NULL DEFAULT '0',
  `ckey` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ctime` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `job` tinyint(1) NOT NULL,
  `level` tinyint(2) NOT NULL DEFAULT '1',
  `exp` smallint(4) NOT NULL DEFAULT '0',
  `botlevel` tinyint(2) NOT NULL DEFAULT '1',
  `botexp` smallint(4) NOT NULL DEFAULT '0',
  `plusexp` tinyint(2) NOT NULL DEFAULT '0',
  `pluslife` tinyint(2) NOT NULL DEFAULT '0',
  `plusatk` tinyint(2) NOT NULL DEFAULT '0',
  `plusdef` tinyint(2) NOT NULL DEFAULT '0',
  `atklevel` tinyint(1) NOT NULL,
  `minelevel` tinyint(1) NOT NULL,
  `craftlevel` tinyint(1) NOT NULL,
  `island` tinyint(1) NOT NULL,
  `mine1` int(2) NOT NULL DEFAULT '0',
  `mine2` int(2) NOT NULL DEFAULT '0',
  `mine3` int(2) NOT NULL DEFAULT '0',
  `equit_weapon` bigint(20) NOT NULL,
  `equit_rune` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`user_email`),
  FULLTEXT KEY `idx_search` (`user_email`,`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=58 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `md5_id`, `user_name`, `user_email`, `user_level`, `pwd`, `date`, `users_ip`, `approved`, `activation_code`, `banned`, `ckey`, `ctime`, `job`, `level`, `exp`, `botlevel`, `botexp`, `plusexp`, `pluslife`, `plusatk`, `plusdef`, `atklevel`, `minelevel`, `craftlevel`, `island`, `mine1`, `mine2`, `mine3`, `equit_weapon`, `equit_rune`) VALUES
(20, '', 'admin', 'admin@localhost', 5, '4c09e75fa6fe36038ac240e9e4e0126cedef6d8c85cf0a1ae', '2010-05-04', '', 1, 0, 0, 'fc4et2n', '1329134710', 0, 1, 0, 1, 0, 0, 0, 0, 0, 2, 1, 0, 2, 0, 0, 0, 3, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `vote` bigint(20) NOT NULL,
  `opt` smallint(2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `island` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
