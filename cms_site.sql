-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 25, 2012 at 07:14 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `cms_access_levels`
--

CREATE TABLE IF NOT EXISTS `cms_access_levels` (
  `access_lvl` tinyint(4) NOT NULL AUTO_INCREMENT,
  `access_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`access_lvl`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cms_access_levels`
--

INSERT INTO `cms_access_levels` (`access_lvl`, `access_name`) VALUES
(1, 'Users'),
(2, 'Moderator'),
(3, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `cms_articles`
--

CREATE TABLE IF NOT EXISTS `cms_articles` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `date_submitted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_published` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` varchar(255) NOT NULL DEFAULT '',
  `body` mediumtext NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `IdxArticle` (`author_id`,`date_submitted`),
  FULLTEXT KEY `IdxText` (`title`,`body`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `cms_articles`
--

INSERT INTO `cms_articles` (`article_id`, `author_id`, `is_published`, `date_submitted`, `date_published`, `title`, `body`) VALUES
(21, 1, 1, '2012-10-25 07:07:38', '2012-10-25 07:07:46', 'Article One', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum');

-- --------------------------------------------------------

--
-- Table structure for table `cms_comments`
--

CREATE TABLE IF NOT EXISTS `cms_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL DEFAULT '0',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_user` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `IdxComment` (`article_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cms_comments`
--

INSERT INTO `cms_comments` (`comment_id`, `article_id`, `comment_date`, `comment_user`, `comment`) VALUES
(1, 5, '2012-10-17 19:45:15', 1, 'comment'),
(2, 7, '2012-10-18 05:55:44', 1, 'comment! :)'),
(3, 7, '2012-10-18 05:58:04', 1, 'no way!'),
(4, 8, '2012-10-18 15:01:28', 1, 'Mind = blown!'),
(5, 9, '2012-10-18 15:35:48', 1, 'sdfja'),
(6, 18, '2012-10-25 07:01:20', 1, 'sdfsdfgasd');

-- --------------------------------------------------------

--
-- Table structure for table `cms_users`
--

CREATE TABLE IF NOT EXISTS `cms_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `access_lvl` tinyint(4) NOT NULL DEFAULT '1',
  `hometown` varchar(255) DEFAULT '',
  `age` varchar(3) DEFAULT '',
  `bio` varchar(500) DEFAULT '',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cms_users`
--

INSERT INTO `cms_users` (`user_id`, `email`, `password`, `name`, `access_lvl`, `hometown`, `age`, `bio`) VALUES
(1, 'rhode.jordan@gmail.com', 'f16ade123d0f907c8aed20b66df68a4ef5f04ef4', 'Admin', 3, 'Rhinelander', '21', 'I like to program and play ultimate frisbee!');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
