-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 18, 2018 at 06:46 PM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `1)introduction`
--

DROP TABLE IF EXISTS `1)introduction`;
CREATE TABLE IF NOT EXISTS `1)introduction` (
  `Section` varchar(50) NOT NULL,
  `Theory` text NOT NULL,
  `Question` varchar(100) NOT NULL,
  `Case1` varchar(50) NOT NULL,
  `Case2` varchar(50) NOT NULL,
  `Case3` varchar(50) NOT NULL,
  `Case4` varchar(50) NOT NULL,
  `Answers` varchar(100) NOT NULL,
  PRIMARY KEY (`Question`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `1)introduction`
--

INSERT INTO `1)introduction` (`Section`, `Theory`, `Question`, `Case1`, `Case2`, `Case3`, `Case4`, `Answers`) VALUES
('Intro in JavaScript', 'JavaScript is one of the most popular programming languages in the world, and it uses to add interactivity for web pages.', 'Choose the right expression:', '1', '2', '3', '', '1;2;'),
('Your first JavaScript code', 'JavaScript code needs to be inserted between tags : <script> and </script>', 'Which tag includes JavaScript code?', 'script', 'code', 'style', 'body', 'script;'),
('TARGET', 'TARGET', 'SELECT TARGET', 'right1', 'hello', 'right3', 'hi', 'right1;right3;');

-- --------------------------------------------------------

--
-- Table structure for table `2)basic components`
--

DROP TABLE IF EXISTS `2)basic components`;
CREATE TABLE IF NOT EXISTS `2)basic components` (
  `Section` varchar(50) NOT NULL,
  `Theory` text NOT NULL,
  `Question` varchar(100) NOT NULL,
  `Case1` varchar(50) NOT NULL,
  `Case2` varchar(50) NOT NULL,
  `Case3` varchar(50) NOT NULL,
  `Case4` varchar(50) NOT NULL,
  `Answers` varchar(100) NOT NULL,
  PRIMARY KEY (`Question`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `3)objects`
--

DROP TABLE IF EXISTS `3)objects`;
CREATE TABLE IF NOT EXISTS `3)objects` (
  `Section` varchar(50) DEFAULT NULL,
  `Theory` text NOT NULL,
  `Question` varchar(100) NOT NULL,
  `Case1` varchar(50) DEFAULT NULL,
  `Case2` varchar(50) DEFAULT NULL,
  `Case3` varchar(50) DEFAULT NULL,
  `Case4` varchar(50) DEFAULT NULL,
  `Answers` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Question`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `3)objects`
--

INSERT INTO `3)objects` (`Section`, `Theory`, `Question`, `Case1`, `Case2`, `Case3`, `Case4`, `Answers`) VALUES
('arrays', 'Arrays are very important', 'Select the valid array', 'right=array(1,2,3,4)', 'array(cars[])', 'cars[]', 'cars.array[]', 'right=array(1,2,3,4);');

-- --------------------------------------------------------

--
-- Table structure for table `popular_passwords`
--

DROP TABLE IF EXISTS `popular_passwords`;
CREATE TABLE IF NOT EXISTS `popular_passwords` (
  `password` varchar(30) NOT NULL,
  UNIQUE KEY `password` (`password`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `popular_passwords`
--

INSERT INTO `popular_passwords` (`password`) VALUES
('!qaz2wsx'),
('000000'),
('11111'),
('111111'),
('121212'),
('123'),
('123123'),
('1234'),
('12345'),
('123456'),
('1234567'),
('12345678'),
('123456789'),
('1234567890'),
('131313'),
('1q2w3e4r'),
('1qaz2wsx'),
('1qaz@wsx'),
('1qazxsw2'),
('55555'),
('654321'),
('666666'),
('696969'),
('7777777'),
('987654321'),
('abc123'),
('abcd1234'),
('affair'),
('amanda'),
('andrew'),
('anthony'),
('asdfasdf'),
('asdfg'),
('asdfgh'),
('asdfghjkl'),
('ashley'),
('ashleymadison'),
('asshole'),
('baseball'),
('batman'),
('beautiful'),
('bigdick'),
('buster'),
('charlie'),
('cheater'),
('cocacola'),
('computer'),
('corvette'),
('cowboys'),
('dallas'),
('DEFAULT'),
('dragon'),
('ferrari'),
('football'),
('freedom'),
('fuckme'),
('fuckoff'),
('fuckyou'),
('george'),
('harley'),
('hello'),
('hockey'),
('horny'),
('hosts'),
('hunter'),
('ihateyou'),
('iloveme'),
('iloveyou'),
('jackson'),
('jennifer'),
('jessica'),
('jordan'),
('jordan23'),
('kazuga'),
('killer'),
('letmein'),
('liverpool'),
('looking'),
('madison'),
('maggie'),
('master'),
('matthew'),
('mercedes'),
('michael'),
('money'),
('monkey'),
('mustang'),
('password'),
('password1'),
('pepper'),
('playboy'),
('princess'),
('pussy'),
('qazwsx'),
('qwert'),
('qwerty'),
('qwertyuiop'),
('ranger'),
('robert'),
('secret'),
('shadow'),
('soccer'),
('steelers'),
('summer'),
('sunshine'),
('superman'),
('thomas'),
('tigger'),
('trustno1'),
('whatever'),
('william'),
('yankees'),
('zaq12wsx'),
('zxcvbnm');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `token` varchar(16) NOT NULL,
  `Role` varchar(5) DEFAULT NULL,
  `Messages` text NOT NULL,
  `Completed` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `token`, `Role`, `Messages`, `Completed`) VALUES
(1, 'Admin', '$2y$10$SEO/h8hTuxuZpHRWBW3AL.8NBBlhuHfbHd0iLbLZtFqIrJ62p8nAe', '', 'admin', '{\"Carol\":[\"messagC\",\"test\",\"test2\"],\"Bob\":[\"messageB\",\"  Hello, I have a question about task \'Choose the right expression:\' in module \'introduction\' section \'Intro in JavaScript\'\"]}', '{\"1\":[\"Intro in JavaScript\",\"Your first JavaScript code\",\"TARGET\"]}'),
(2, 'Bob', '$2y$10$PZNtNIZ4O66TV/Zce7slz.HNcE1ihfoOVbUCBUHZB3BgGjHAzOi3C', '', 'user', '{\"Admin\":[\"hello\"]}', ''),
(3, 'Carol', '$2y$10$/7/2AI14429GfNYjl99orOsSHWoykm9C.pfZOOyqpM.cB4lfIb8z.', '', 'user', '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
