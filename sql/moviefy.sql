-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2015 at 10:39 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moviefy`
--

-- --------------------------------------------------------

--
-- Table structure for table `mf_accounts`
--

CREATE TABLE IF NOT EXISTS `mf_accounts` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_loggin` varchar(255) NOT NULL,
  `flag` tinyint(4) NOT NULL COMMENT '1-admin 2-moderator'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mf_accounts`
--

INSERT INTO `mf_accounts` (`id`, `username`, `password`, `last_loggin`, `flag`) VALUES
(1, 'hyperlogin', '1f6c734d5d64b371cbb42154efd5b6736e8ebd31', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mf_episodes`
--

CREATE TABLE IF NOT EXISTS `mf_episodes` (
  `uid` int(10) unsigned NOT NULL,
  `season` tinyint(4) NOT NULL,
  `episode` tinyint(4) NOT NULL,
  `series_id` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `poster_image` varchar(500) NOT NULL,
  `backdrop_image` varchar(500) NOT NULL,
  `overview` varchar(500) NOT NULL,
  `episode_date` varchar(100) NOT NULL,
  `last_updated` varchar(100) NOT NULL,
  `stream_link` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mf_movies`
--

CREATE TABLE IF NOT EXISTS `mf_movies` (
  `id` int(11) NOT NULL,
  `movie_title` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `overview` varchar(1000) NOT NULL,
  `release_year` varchar(4) NOT NULL,
  `added_date` varchar(200) NOT NULL,
  `updated_date` varchar(255) NOT NULL,
  `poster_image` varchar(255) NOT NULL,
  `backdrop_image` varchar(255) NOT NULL,
  `trailer_link` varchar(255) NOT NULL,
  `imdb_rating` varchar(4) NOT NULL,
  `critics` varchar(4) NOT NULL,
  `audience` varchar(4) NOT NULL,
  `imdb_id` varchar(100) NOT NULL,
  `stream_links` varchar(255) NOT NULL,
  `age_restrict` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='*TODO - Casts';

-- --------------------------------------------------------

--
-- Table structure for table `mf_series`
--

CREATE TABLE IF NOT EXISTS `mf_series` (
  `id` int(11) NOT NULL,
  `series_title` varchar(255) NOT NULL,
  `original_title` varchar(255) NOT NULL,
  `series_desc` varchar(1000) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `total_season` int(11) NOT NULL,
  `total_episodes` int(11) NOT NULL,
  `airing_date` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `poster_image` varchar(500) NOT NULL,
  `backdrop_image` varchar(500) NOT NULL,
  `series_library` varchar(500) NOT NULL,
  `series_code` varchar(100) NOT NULL,
  `added_date` varchar(150) NOT NULL,
  `updated_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mf_accounts`
--
ALTER TABLE `mf_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mf_episodes`
--
ALTER TABLE `mf_episodes`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `mf_movies`
--
ALTER TABLE `mf_movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mf_series`
--
ALTER TABLE `mf_series`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mf_accounts`
--
ALTER TABLE `mf_accounts`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mf_episodes`
--
ALTER TABLE `mf_episodes`
  MODIFY `uid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mf_movies`
--
ALTER TABLE `mf_movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mf_series`
--
ALTER TABLE `mf_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
