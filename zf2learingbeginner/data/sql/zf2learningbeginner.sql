-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generato il: Apr 15, 2014 alle 11:33
-- Versione del server: 5.5.35-0+wheezy1
-- Versione PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zf2learningbeginner`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `BLOG`
--

CREATE TABLE IF NOT EXISTS `BLOG` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` text NOT NULL,
  `CONTENT` varchar(255) NOT NULL,
  `CATEGORY_ID` int(11) NOT NULL,
  `PRODUCT_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dump dei dati per la tabella `BLOG`
--

INSERT INTO `BLOG` (`ID`, `TITLE`, `CONTENT`, `CATEGORY_ID`, `PRODUCT_ID`) VALUES
(1, 'TITOLO TEST 1', 'test', 1, 2),
(2, 'Post test 2', 'contenuto test 2', 2, 2),
(3, 'Post test 3', 'cdcdcdcc', 1, 1),
(5, 'post 5', 'test post 5', 1, 2),
(7, 'post test 6', 'conetnuto post test 6', 1, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `CATEGORY`
--

CREATE TABLE IF NOT EXISTS `CATEGORY` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CAT_DESCRIPTION` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `CATEGORY`
--

INSERT INTO `CATEGORY` (`ID`, `CAT_DESCRIPTION`) VALUES
(1, 'Feauture'),
(2, 'Bugs');

-- --------------------------------------------------------

--
-- Struttura della tabella `PRODUCT`
--

CREATE TABLE IF NOT EXISTS `PRODUCT` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PROD_DESCRIPTION` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `PRODUCT`
--

INSERT INTO `PRODUCT` (`ID`, `PROD_DESCRIPTION`) VALUES
(1, 'Software'),
(2, 'Hardware');

-- --------------------------------------------------------

--
-- Struttura della tabella `USERS`
--

CREATE TABLE IF NOT EXISTS `USERS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(100) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `LASTNAME` varchar(255) DEFAULT NULL,
  `FIRSTNAME` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `PHONE` varchar(30) NOT NULL,
  `PICTURE` varchar(255) DEFAULT NULL,
  `ROLE` varchar(25) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `USERS`
--

INSERT INTO `USERS` (`ID`, `USERNAME`, `PASSWORD`, `LASTNAME`, `FIRSTNAME`, `EMAIL`, `PHONE`, `PICTURE`, `ROLE`) VALUES
(1, 'rennasalva', '26f204918670f209a176e0ef66cd7d3c', 'SALVATORI', 'RENATO', 'rennasalva@gmail.com', '33392838383', 'images.jpeg', 'member'),
(3, 'renato', 'd73769edfa6e33f64e2cc94d72349b6f', 'salvatorixx', 'renato', 'renato.s@cost.it', '333-8264571', 'images.jpeg', 'member');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
