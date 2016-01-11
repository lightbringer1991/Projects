-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2016 at 05:40 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `calculations`
--

-- --------------------------------------------------------

--
-- Table structure for table `ba_g`
--

CREATE TABLE IF NOT EXISTS `ba_g` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `start` varchar(255) NOT NULL,
  `end` varchar(255) NOT NULL,
  `A` varchar(255) NOT NULL,
  `E` varchar(255) NOT NULL,
  `I` varchar(255) NOT NULL,
  `crsec` varchar(255) NOT NULL,
  `p1` varchar(255) NOT NULL DEFAULT '',
  `p2` varchar(255) NOT NULL DEFAULT '',
  `p3` varchar(255) NOT NULL DEFAULT '',
  `rotation` varchar(255) NOT NULL,
  `matID` int(11) NOT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `ba_g`
--

INSERT INTO `ba_g` (`rcdNo`, `userscalcPK`, `start`, `end`, `A`, `E`, `I`, `crsec`, `p1`, `p2`, `p3`, `rotation`, `matID`) VALUES
(22, '91', '0', '100', '', '', '', 'AISC', 'W', 'W44', 'W44X335', '8', 0),
(23, '102', '0', '100', '', '', '', 'AISC', 'W', 'W44', 'W44X335', '8', 0),
(25, '103', '0', '800', '2', '4', '56', 'Rectangle', '522', '34', '', '45', 2),
(38, '104', '0', '500', '2', '4', '56', 'Rectangle', '522', '34', '', '45', 2),
(39, '104', '500', '900', '', '', '', 'Circular', '', '', '', '', 0),
(40, '104', '900', '1200', '', '', '', 'AISC', '', '', '', '', 2),
(44, '102', '100', '', '', '', '', 'AISC', 'L_uE', 'L6', 'L6X4X5/8', '', 0),
(51, '105', '0', '10', '', '', '', 'AISC', 'L_E', 'L5', 'L5X3X3/8', '', 0),
(52, '105', '10', '15', '', '', '', 'AISC', 'L_E', 'L5', 'L5X3X3/8', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ba_loading`
--

CREATE TABLE IF NOT EXISTS `ba_loading` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `geometry` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `startLocation` varchar(255) NOT NULL,
  `startValue` varchar(255) NOT NULL,
  `endLocation` varchar(255) NOT NULL,
  `endValue` varchar(255) NOT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `ba_loading`
--

INSERT INTO `ba_loading` (`rcdNo`, `userscalcPK`, `geometry`, `type`, `unit`, `startLocation`, `startValue`, `endLocation`, `endValue`, `visibility`) VALUES
(7, '91', 'Point', 'Force', 'lbf', '50', '50', '80', '25', 1),
(8, '91', 'Point', 'Moment', 'lbf-ft', '55.38', '40', '60', '20', 1),
(9, '102', 'Point', 'Force', 'lbf', '31.91', '50', '80', '25', 1),
(10, '102', 'Point', 'Moment', 'lbf-ft', '69.02', '40', '60', '20', 1),
(11, '103', 'Distributed', 'Force', 'lbf', '90', '120', '250', '-50', 1),
(12, '103', 'Point', 'Force', 'kips', '200', '-50', '290', '50', 1),
(13, '103', 'Point', 'Moment', 'lbf-ft', '311.03', '-50', '400', '50', 1),
(14, '103', 'Distributed', 'Moment', 'lbf-ft', '380.12', '-80', '535.12', '-50', 1),
(15, '103', 'Point', 'Moment', 'lbf-ft', '575.86', '50', '346', '2', 1),
(16, '104', 'Distributed', 'Force', 'lbf', '70.29', '120', '230.29', '-50', 0),
(17, '104', 'Point', 'Force', 'kips', '200', '-50', '290', '50', 1),
(18, '104', 'Point', 'Moment', 'lbf-ft', '311.03', '-50', '400', '50', 1),
(19, '104', 'Distributed', 'Moment', 'lbf-ft', '380.12', '-80', '535.12', '-50', 1),
(20, '104', 'Point', 'Moment', 'lbf-ft', '575.86', '50', '346', '2', 1),
(27, '105', 'Point', 'Force', 'lbf', '2', '5', '', '', 1),
(28, '105', 'Distributed', 'Moment', 'lbf-ft', '5', '18', '8', '-20', 1),
(29, '105', 'Point', 'Moment', 'lbf-ft', '13', '20', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ba_mat`
--

CREATE TABLE IF NOT EXISTS `ba_mat` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` int(11) NOT NULL,
  `org` varchar(255) NOT NULL,
  `standard` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `E` varchar(255) NOT NULL,
  `Rho` varchar(255) NOT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `ba_mat`
--

INSERT INTO `ba_mat` (`rcdNo`, `userscalcPK`, `org`, `standard`, `grade`, `name`, `E`, `Rho`) VALUES
(17, 103, 'ASTM', 'A139', '30', 'A139-30', '290', '642'),
(18, 103, 'ASTM', 'A139', '35', 'A139-35', '832', '112'),
(19, 103, 'ASTM', 'A572', '50', 'A572-50', '29000000.00', '11200000.00'),
(20, 103, 'ASTM', 'A572', '60', 'A572-60', '29000000.00', '11200000.00'),
(21, 103, 'ASTM', 'A570', '60', '', '', ''),
(22, 104, 'ASTM', 'A139', '30', 'A139-30', '290', '642'),
(23, 104, 'ASTM', 'A139', '35', 'A139-35', '832', '112'),
(27, 102, 'ASTM', 'A572', '65', 'wew', '', ''),
(28, 102, '', '', '', 'fvdfsd', 'weffcd', ''),
(33, 105, 'ASTM', 'A572', '60', 'A572-60', '29000000.00', '11200000.00');

-- --------------------------------------------------------

--
-- Table structure for table `ba_spt`
--

CREATE TABLE IF NOT EXISTS `ba_spt` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `ba_spt`
--

INSERT INTO `ba_spt` (`rcdNo`, `userscalcPK`, `location`, `type`) VALUES
(6, '103', '274.48', 'Fixed'),
(7, '103', '51.03', 'Pinned'),
(8, '103', '622.76', 'Roller'),
(9, '104', '274.48', 'Fixed'),
(10, '104', '51.03', 'Pinned'),
(11, '104', '622.76', 'Roller'),
(12, '104', '1000', 'Fixed');

-- --------------------------------------------------------

--
-- Table structure for table `menutree`
--

CREATE TABLE IF NOT EXISTS `menutree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) NOT NULL,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `tab` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `calcAppName` varchar(255) NOT NULL,
  `accessLevel` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `tooltip` varchar(255) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modifiedBy` int(11) NOT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=147 ;

--
-- Dumping data for table `menutree`
--

INSERT INTO `menutree` (`id`, `id_parent`, `id_user`, `tab`, `type`, `name`, `link`, `calcAppName`, `accessLevel`, `status`, `notes`, `tooltip`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(90, 0, 0, 'Code', 'link', '', '97', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2015-12-16 20:42:01'),
(92, 0, 0, 'Code', 'folder', 'test3', '', 'test3', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2015-12-15 16:34:17'),
(93, 92, 0, 'Code', 'file', 'Velocity Pressure', 'ALL/TIA/222/G/velocity_pressure.php', 'velocity_pressure', 'free', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2016-01-07 14:40:02'),
(94, 0, 0, 'Code', 'file', 'Velocity Pressure', 'qwe', 'qwe', 'free', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2015-12-30 01:18:07'),
(97, 0, 0, 'Code', 'file', 'Dim and properties', 'ALL/AISC/SCM/dim_and_properties.php', '', 'basic', 'active', 'Dim and properties notes', 'Dim and properties', 0, '0000-00-00 00:00:00', 0, '2015-12-17 16:48:41'),
(102, 92, 0, 'Code', 'folder', 'qweqw', 'qwe', 'qwe', 'basic', 'active', '', 'qweqwe', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(105, 92, 0, 'Code', 'file', 'dim_and_properties', 'ALL/AISC/SCM/dim_and_properties.php', '', 'basic', 'active', 'Dim and properties notes', 'Dim and properties', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(137, 0, 0, 'Discipline', 'link', '', '97', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2015-12-16 20:48:24'),
(138, 0, 0, 'Favorite', 'link', '', '97', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(139, 0, 0, 'Application', 'link', '', '94', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(140, 0, 0, 'Discipline', 'file', 'test2', 'test2.txt', 'test2', 'free', 'active', '', 'Q.Q', 0, '0000-00-00 00:00:00', 0, '2015-12-16 20:50:25'),
(141, 0, 0, 'Discipline', 'file', 'qweqwe', 'qwe', '111', 'free', 'inactive', '', 'qwe', 0, '0000-00-00 00:00:00', 0, '2015-12-16 20:51:44'),
(142, 0, 0, 'Application', 'link', '', '124', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(144, 0, 0, 'Discipline', 'link', '', '124', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(145, 0, 0, 'Application', 'file', 'Beam analysis', 'ALL/Application/beam_analysis/beam_analysis.php', 'beam_analysis', 'basic', 'active', 'Beam analysis notes', 'Beam analysis', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(146, 0, 0, 'Favorite', 'link', '', '145', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tia_222_g_gust_effect`
--

CREATE TABLE IF NOT EXISTS `tia_222_g_gust_effect` (
  `RcdNo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `strTYP` varchar(45) DEFAULT NULL,
  `h` double DEFAULT NULL,
  `str_sptd_on_other_str` varchar(45) DEFAULT NULL,
  `G_h` double DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`RcdNo`),
  UNIQUE KEY `abc_ndx` (`RcdNo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `tia_222_g_gust_effect`
--

INSERT INTO `tia_222_g_gust_effect` (`RcdNo`, `userscalcPK`, `strTYP`, `h`, `str_sptd_on_other_str`, `G_h`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(50, '79', '', 1223, '', 1, '', 0, '2015-11-20 01:15:31', 0, '0000-00-00 00:00:00'),
(51, '79', NULL, 111, NULL, NULL, NULL, 0, '2015-11-20 01:15:31', 0, '0000-00-00 00:00:00'),
(52, '77', '', 111, '', 0.85, '', 0, '2015-11-20 01:15:31', 0, '0000-00-00 00:00:00'),
(53, '83', NULL, 67, NULL, 0.85, NULL, NULL, '2015-11-20 04:48:55', NULL, '0000-00-00 00:00:00'),
(55, '101', NULL, 6, NULL, 0.85, NULL, NULL, '2015-11-27 04:13:40', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tia_222_g_vp`
--

CREATE TABLE IF NOT EXISTS `tia_222_g_vp` (
  `RcdNo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `expCAT` varchar(45) DEFAULT NULL,
  `Z_g` double DEFAULT NULL,
  `alpha` double DEFAULT NULL,
  `K_zmin` double DEFAULT NULL,
  `K_e` double DEFAULT NULL,
  `z` double DEFAULT NULL,
  `K_z` double DEFAULT NULL,
  `topCAT` int(2) DEFAULT NULL,
  `K_t` double DEFAULT NULL,
  `f` double DEFAULT NULL,
  `H` double DEFAULT NULL,
  `K_h` double DEFAULT NULL,
  `K_zt` double DEFAULT NULL,
  `strTYP` varchar(45) DEFAULT NULL,
  `crosSEC` varchar(45) DEFAULT NULL,
  `K_d` double DEFAULT NULL,
  `V` double DEFAULT NULL,
  `strCLAS` varchar(45) DEFAULT NULL,
  `str_type` varchar(255) DEFAULT NULL,
  `str_cros_sec` varchar(255) DEFAULT NULL,
  `str_class` varchar(255) DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`RcdNo`),
  UNIQUE KEY `abc_ndx` (`RcdNo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `tia_222_g_vp`
--

INSERT INTO `tia_222_g_vp` (`RcdNo`, `userscalcPK`, `expCAT`, `Z_g`, `alpha`, `K_zmin`, `K_e`, `z`, `K_z`, `topCAT`, `K_t`, `f`, `H`, `K_h`, `K_zt`, `strTYP`, `crosSEC`, `K_d`, `V`, `strCLAS`, `str_type`, `str_cros_sec`, `str_class`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(36, '68', 'D', 700, 6, 0.6, 0.7, 0, 0.6, 1, 0, 0, 0, NULL, 1, NULL, NULL, 0, 90, 'I', '', '', '', NULL, 0, '2015-11-14 03:31:39', 0, '0000-00-00 00:00:00'),
(35, '63', 'D', 700, 6, 0.6, 0.7, 0, 0.6, 1, 0, 0, 0, 0, 1, '', '', 0, 90, 'I', '', '', '', '', 0, '2015-11-14 03:31:39', 0, '0000-00-00 00:00:00'),
(37, NULL, 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-17 05:13:19', NULL, '0000-00-00 00:00:00'),
(38, NULL, 'B', 1200, 7, 0.7, 0.9, NULL, 0.7, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-17 05:37:32', NULL, '0000-00-00 00:00:00'),
(39, NULL, 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-17 05:38:21', NULL, '0000-00-00 00:00:00'),
(40, NULL, 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-17 05:39:08', NULL, '0000-00-00 00:00:00'),
(41, NULL, 'B', 1200, 7, 0.7, 0.9, NULL, 0.7, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-17 05:45:26', NULL, '0000-00-00 00:00:00'),
(42, NULL, 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, 12, 1, 2.027776, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-18 01:04:59', NULL, '0000-00-00 00:00:00'),
(43, '69', 'C', 900, 5, 0.5, 0.8, 0, 0.5, 3, 0.53, 2, 0, 0, 0, '', '', 0.85, 90, '[Null]', 'latticed', 'triangular', 'I', '', 0, '2015-11-18 01:26:20', 0, '0000-00-00 00:00:00'),
(44, NULL, 'B', 1200, 7, 0.7, 0.9, 341, 1.40305306039, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-18 01:51:50', NULL, '0000-00-00 00:00:00'),
(47, '64', 'D', 700, 11.5, 1.03, 0.7, 111, 1.45916613712, 3, 0.53, 2, 0, 0, 1, '', '', 0.85, 90, '[Null]', 'latticed', 'triangular', 'I', '', NULL, '2015-11-19 03:11:47', NULL, '0000-00-00 00:00:00'),
(48, '73', 'B', 900, 7, 0.7, 0.9, 11, 0.7, 3, 0.53, 2, 0, 0, 1, '', '', 0.85, 90, '[Null]', '', '', '', '', 0, '2015-11-18 01:52:03', 0, '0000-00-00 00:00:00'),
(49, '73', 'D', 700, 6, 0.6, 0.7, 111, 1.08793856135, 4, 0.72, 1.5, 322, 1.67703462933, 1.69137949508, '', '', 0.85, 90, '[Null]', '', '', '', '', 0, '2015-11-19 03:51:19', 0, '0000-00-00 00:00:00'),
(69, '98', 'D', NULL, 11.5, 1.03, NULL, 0, 1.03, 3, 0.53, 2, 0, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-27 04:09:13', NULL, '0000-00-00 00:00:00'),
(51, '75', 'B', 900, 5, 0.5, 0.8, 1111, 0.5, 3, 0.53, 2, 0, 0, 1, '', '', 0.85, 90, '[Null]', '', '', '', '', 0, '2015-11-19 04:37:51', 0, '0000-00-00 00:00:00'),
(52, '75', 'C', 900, 5, 0.5, 0.8, 0, 0.5, 3, 0.53, 2, 0, NULL, 1, NULL, NULL, 0.85, 90, NULL, '', '', '', NULL, 0, '2015-11-18 01:26:20', 0, '0000-00-00 00:00:00'),
(54, '80', 'C', NULL, 5, 0.5, NULL, 112, 0.873345853665, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, NULL, NULL, NULL, NULL, NULL, '2015-11-20 03:42:36', NULL, '0000-00-00 00:00:00'),
(55, '84', 'B', NULL, 7, 0.7, NULL, 566, 1.6216195349, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-20 04:49:39', NULL, '0000-00-00 00:00:00'),
(56, '72', 'C', NULL, 9.5, 0.85, NULL, 123, 1.3219964515, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-25 00:43:53', NULL, '0000-00-00 00:00:00'),
(57, '85', 'D', NULL, 11.5, 1.03, NULL, 123, 1.48545040598, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-25 04:21:02', NULL, '0000-00-00 00:00:00'),
(59, '87', 'D', NULL, 11.5, 1.03, NULL, 0, 1.03, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-25 05:22:16', NULL, '0000-00-00 00:00:00'),
(60, '88', 'D', NULL, 11.5, 1.03, NULL, 0, 1.03, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-25 05:23:14', NULL, '0000-00-00 00:00:00'),
(61, '89', 'C', NULL, 9.5, 0.85, NULL, NULL, 0.85, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-25 05:25:31', NULL, '0000-00-00 00:00:00'),
(63, '91', 'C', NULL, 9.5, 0.85, NULL, NULL, 0.85, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-25 05:29:59', NULL, '0000-00-00 00:00:00'),
(64, '92', 'C', NULL, 9.5, 0.85, NULL, 0, 0.85, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-25 05:35:17', NULL, '0000-00-00 00:00:00'),
(65, '93', 'C', NULL, 9.5, 0.85, NULL, NULL, 0.85, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-25 05:35:57', NULL, '0000-00-00 00:00:00'),
(70, '99', 'C', NULL, 9.5, 0.85, NULL, 45, 1.06978130895, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-27 04:48:18', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `userscalc`
--

CREATE TABLE IF NOT EXISTS `userscalc` (
  `RcdNo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) DEFAULT NULL,
  `projectID` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `CalcID` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `usersname4Calc` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `calcAppName` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `iconText` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`RcdNo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=106 ;

--
-- Dumping data for table `userscalc`
--

INSERT INTO `userscalc` (`RcdNo`, `userID`, `projectID`, `CalcID`, `usersname4Calc`, `calcAppName`, `iconText`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(64, 0, '30', '20151113C64', '22222', 'TIA_222_G_vp', '22222', '22222', 0, '2015-11-14 03:03:03', NULL, '2015-11-14 03:03:03'),
(66, 0, '37', '20151113C66', '212112', 'TIA_222_G_vp', '21212', '212121', 0, '2015-11-14 05:36:42', NULL, '2015-11-14 05:36:42'),
(67, 0, '38', '20151113C67', 'qweqwe', 'TIA_222_G_vp', 'qweqwe', 'qweqwe', 0, '2015-11-14 05:47:27', NULL, '2015-11-14 05:47:27'),
(68, 0, '37', '20151113C68', '4444444', 'TIA_222_G_vp', '12', '12', 0, '2015-11-14 06:06:37', NULL, '2015-11-14 06:06:37'),
(69, 0, '25', '20151117C69', 'qwesd', 'TIA_222_G_vp', 'zxc', 'sad', 0, '2015-11-18 01:25:22', NULL, '2015-11-18 01:25:22'),
(72, 0, '13', '20151118C72', 'wqeq', 'TIA_222_G_vp', '123sf', 'sdgse', 0, '2015-11-19 03:44:58', NULL, '2015-11-19 03:44:58'),
(73, 0, '13', '20151118C73', 'er333', 'TIA_222_G_vp', 'qwe', 'qwe', 0, '2015-11-19 03:50:55', NULL, '2015-11-19 03:50:55'),
(98, 0, '30', '20151126C001', '111111111', 'TIA_222_G_vp', '1111111', '111111', 0, '2015-11-27 04:07:52', NULL, '2015-11-27 04:07:52'),
(75, 0, '25', '20151118C75', '1q1q1q', 'TIA_222_G_vp', 'ww', 'wrr', 0, '2015-11-19 04:40:14', NULL, '2015-11-19 04:40:14'),
(77, 0, '14', '20151119C001', 're333', 'TIA_222_G_gust_effect', 'cxv', 'zcxv', 0, '2015-11-19 23:26:15', NULL, '2015-11-19 23:26:15'),
(79, 0, '14', '20151119C002', 'e1e1wwww', 'TIA_222_G_gust_effect', 'dcv', 'xcvbxc', 0, '2015-11-20 01:30:37', NULL, '2015-11-20 01:30:37'),
(80, 0, '14', '20151119C003', 'wwwwr', 'TIA_222_G_vp', 'xcv', 'vn', 0, '2015-11-20 03:39:35', NULL, '2015-11-20 03:39:35'),
(82, 0, '14', '20151119C005', 'ghfbnvbn', 'TIA_222_G_gust_effect', 'xcv', 'zxc', 0, '2015-11-20 04:45:32', NULL, '2015-11-20 04:45:32'),
(83, 0, '14', '20151119C006', 'tjhjfghj', 'TIA_222_G_gust_effect', 'n', 'vb', 0, '2015-11-20 04:48:35', NULL, '2015-11-20 04:48:35'),
(84, 0, '14', '20151119C007', 'nbnmnb', 'TIA_222_G_vp', 'zxc', ',,yy', 0, '2015-11-20 04:49:14', NULL, '2015-11-20 04:49:14'),
(85, 0, '13', '20151124C001', '123123123', 'TIA_222_G_vp', NULL, NULL, 0, '2015-11-25 04:04:57', NULL, '2015-11-25 04:04:57'),
(87, 0, '25', '20151124C003', '123123123123123123', 'TIA_222_G_vp', '12312', NULL, 0, '2015-11-25 05:21:59', NULL, '2015-11-25 05:21:59'),
(88, 0, '14', '20151124C004', '777', 'TIA_222_G_vp', '222', '333', 0, '2015-11-25 05:22:34', NULL, '2015-11-25 05:22:34'),
(89, 0, '30', '20151124C005', 'www', 'TIA_222_G_vp', 'www', NULL, 0, '2015-11-25 05:25:06', NULL, '2015-11-25 05:25:06'),
(91, 0, '14', '20151124C007', 'rrrr', 'TIA_222_G_vp', NULL, NULL, 0, '2015-11-25 05:29:42', NULL, '2015-11-25 05:29:42'),
(92, 0, '25', '20151124C008', 'qwerrr', 'TIA_222_G_vp', NULL, NULL, 0, '2015-11-25 05:35:00', NULL, '2015-11-25 05:35:00'),
(93, 0, '25', '20151124C009', 'tttttt', 'TIA_222_G_vp', NULL, NULL, 0, '2015-11-25 05:35:30', NULL, '2015-11-25 05:35:30'),
(99, 0, '13', '20151126C003', 'e2e2e2e2e2e2e', 'TIA_222_G_vp', 'e2e2e2e2e2e', 'e2e2e2e2', 0, '2015-11-27 04:10:18', NULL, '2015-11-27 04:10:18'),
(101, 0, '13', '20151126C005', '242363', 'TIA_222_G_gust_effect', '123123', '345345', 0, '2015-11-27 04:12:52', NULL, '2015-11-27 04:12:52'),
(102, 0, '13', '20151225C001', '55555', 'beam_analysis', '777777', '888888', 0, '2015-12-25 15:51:25', NULL, '2015-12-25 15:51:25'),
(103, 0, '14', '20151225C002', 'q1q1q1', 'beam_analysis', '777777', '888888', 0, '2015-12-25 15:51:25', NULL, '2015-12-25 15:51:25'),
(104, 0, '14', '20151225C003', 'werwer', 'beam_analysis', 'werwer', 'ertert', 0, '2015-12-25 16:02:14', NULL, '2015-12-25 16:02:14');

-- --------------------------------------------------------

--
-- Table structure for table `vp`
--

CREATE TABLE IF NOT EXISTS `vp` (
  `RcdNo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `expCAT` varchar(45) DEFAULT NULL,
  `Z_g` double DEFAULT NULL,
  `alpha` double DEFAULT NULL,
  `K_zmin` double DEFAULT NULL,
  `K_e` double DEFAULT NULL,
  `z` double DEFAULT NULL,
  `K_z` double DEFAULT NULL,
  `topCAT` int(2) DEFAULT NULL,
  `K_t` double NOT NULL,
  `f` double NOT NULL,
  `H` double DEFAULT NULL,
  `K_h` double DEFAULT NULL,
  `K_zt` double DEFAULT NULL,
  `strTYP` varchar(45) DEFAULT NULL,
  `crosSEC` varchar(45) DEFAULT NULL,
  `K_d` double DEFAULT NULL,
  `V` double DEFAULT NULL,
  `strCLAS` varchar(45) DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`RcdNo`),
  UNIQUE KEY `abc_ndx` (`RcdNo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=106 ;

--
-- Dumping data for table `vp`
--

INSERT INTO `vp` (`RcdNo`, `userscalcPK`, `expCAT`, `Z_g`, `alpha`, `K_zmin`, `K_e`, `z`, `K_z`, `topCAT`, `K_t`, `f`, `H`, `K_h`, `K_zt`, `strTYP`, `crosSEC`, `K_d`, `V`, `strCLAS`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(85, '118', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(84, '117', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(65, '98', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:01:42', NULL, '0000-00-00 00:00:00'),
(78, '111', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(76, '109', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(77, '110', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(86, '119', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(103, '137', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:43:44', NULL, '0000-00-00 00:00:00'),
(104, '138', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(105, '139', 'C', 900, 5, 0.5, 0.8, 0, 0.5, 3, 0.53, 2, 0, 0, 0, '', '', 0.85, 90, '', '', 0, '2015-11-19 07:18:57', 0, '0000-00-00 00:00:00'),
(93, '126', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:43:44', NULL, '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
