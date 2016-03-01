-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2016 at 11:49 PM
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
-- Table structure for table `ba_ilcs`
--

CREATE TABLE IF NOT EXISTS `ba_ilcs` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `ilc` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `geometry` varchar(255) NOT NULL,
  `component` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `startLocation` varchar(255) NOT NULL,
  `startValue` varchar(255) NOT NULL,
  `endLocation` varchar(255) NOT NULL,
  `endValue` varchar(255) NOT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT '1',
  `note` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=103 ;

--
-- Dumping data for table `ba_ilcs`
--

INSERT INTO `ba_ilcs` (`rcdNo`, `userscalcPK`, `ilc`, `geometry`, `component`, `unit`, `startLocation`, `startValue`, `endLocation`, `endValue`, `visibility`, `note`) VALUES
(91, '14', 'D', 'Point', 'FX', 'lbf', '2', '9', '', '', 1, ''),
(93, '14', 'WLX', 'Distributed', 'FX', 'lbf', '1', '6', '5', '-8', 1, ''),
(94, '14', 'WLY', 'Distributed', 'MZ', 'kips-ft', '4', '6', '8', '-3', 1, ''),
(95, '14', 'DX', 'Point', 'MZ', 'lbf-ft', '0.5', '3', '', '', 1, ''),
(96, '14', 'DY', 'Point', 'MZ', 'lbf-ft', '9.5', '-6', '', '', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `ba_lcs`
--

CREATE TABLE IF NOT EXISTS `ba_lcs` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `lc` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `note` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `ba_lcs`
--

INSERT INTO `ba_lcs` (`rcdNo`, `userscalcPK`, `lc`, `params`, `note`) VALUES
(25, '14', 'LC1', '{"91":"1","92":"1","93":"1","94":"1"}', ''),
(26, '14', 'LC1', '{"91":"2","92":"1","93":"1","94":"1"}', '');

-- --------------------------------------------------------

--
-- Table structure for table `ba_materials`
--

CREATE TABLE IF NOT EXISTS `ba_materials` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` int(11) NOT NULL,
  `org` varchar(255) NOT NULL,
  `standard` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `E` varchar(255) NOT NULL,
  `Rho` varchar(255) NOT NULL,
  `G` varchar(255) NOT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `ba_materials`
--

INSERT INTO `ba_materials` (`rcdNo`, `userscalcPK`, `org`, `standard`, `grade`, `name`, `E`, `Rho`, `G`) VALUES
(19, 14, 'ASTM', 'A355', 'BD', 'A354-BD', '0.00', '0.0000000000', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `ba_nodes`
--

CREATE TABLE IF NOT EXISTS `ba_nodes` (
  `rcdNo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `name` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `x` double(5,2) DEFAULT NULL,
  `y` double(5,2) DEFAULT NULL,
  `z` double(5,2) DEFAULT NULL,
  `dx` tinyint(4) NOT NULL,
  `dy` tinyint(4) NOT NULL,
  `dz` tinyint(4) NOT NULL,
  `mx` tinyint(4) NOT NULL,
  `my` tinyint(4) NOT NULL,
  `mz` tinyint(4) NOT NULL,
  `note` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`rcdNo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=177 ;

--
-- Dumping data for table `ba_nodes`
--

INSERT INTO `ba_nodes` (`rcdNo`, `userscalcPK`, `name`, `x`, `y`, `z`, `dx`, `dy`, `dz`, `mx`, `my`, `mz`, `note`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(173, '14', 'N3', 0.00, 10.00, 0.00, 1, 0, 0, 0, 0, 1, '', 0, '2016-02-22 19:46:01', 0, '0000-00-00 00:00:00'),
(172, '14', 'N2', 0.00, 3.00, 0.00, 1, 0, 0, 0, 0, 1, '', 0, '2016-02-22 19:44:47', 0, '0000-00-00 00:00:00'),
(171, '14', 'N1', 0.00, 0.00, 0.00, 1, 0, 0, 0, 0, 1, '', 0, '2016-02-22 19:44:45', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ba_sections`
--

CREATE TABLE IF NOT EXISTS `ba_sections` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `n_start` varchar(255) NOT NULL,
  `n_end` varchar(255) NOT NULL,
  `A_start` varchar(255) NOT NULL,
  `A_end` varchar(255) NOT NULL,
  `e` varchar(255) NOT NULL,
  `crsec` varchar(255) NOT NULL,
  `shape` varchar(255) NOT NULL DEFAULT '',
  `size1` varchar(255) NOT NULL,
  `size2` varchar(255) NOT NULL DEFAULT '',
  `od_start` varchar(255) NOT NULL,
  `od_end` varchar(255) NOT NULL DEFAULT '',
  `width_start` varchar(255) NOT NULL,
  `width_end` varchar(255) NOT NULL,
  `height_start` varchar(255) NOT NULL,
  `height_end` varchar(255) NOT NULL,
  `Ix_start` varchar(256) NOT NULL,
  `Ix_end` varchar(255) NOT NULL,
  `Iy_start` varchar(255) NOT NULL,
  `Iy_end` varchar(255) NOT NULL,
  `rotation` varchar(255) NOT NULL,
  `matID` int(11) NOT NULL,
  `s_eq_e` tinyint(4) NOT NULL,
  `slope` varchar(255) NOT NULL,
  `crfrc_start` varchar(255) DEFAULT NULL,
  `crfrc_end` varchar(255) DEFAULT NULL,
  `f2f_start` varchar(255) DEFAULT NULL,
  `f2f_end` varchar(255) DEFAULT NULL,
  `fwth_start` varchar(255) DEFAULT NULL,
  `fwth_end` varchar(255) DEFAULT NULL,
  `thk` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `ba_sections`
--

INSERT INTO `ba_sections` (`rcdNo`, `userscalcPK`, `n_start`, `n_end`, `A_start`, `A_end`, `e`, `crsec`, `shape`, `size1`, `size2`, `od_start`, `od_end`, `width_start`, `width_end`, `height_start`, `height_end`, `Ix_start`, `Ix_end`, `Iy_start`, `Iy_end`, `rotation`, `matID`, `s_eq_e`, `slope`, `crfrc_start`, `crfrc_end`, `f2f_start`, `f2f_end`, `fwth_start`, `fwth_end`, `thk`) VALUES
(63, '14', '171', '172', '1', '', '', 'Customer', '', '', '', '', '', '', '', '', '', '1', '', '1', '', '', 1, 1, '', '', '', '', '', '', '', ''),
(64, '14', '172', '173', '3.75', '2.75', '', 'Rectangular', '', '', '', '', '', '4', '3', '4', '3', '8.828125', '3.4947916666667', '8.828125', '3.4947916666667', '', 1, 0, '', '', '', '', '', '', '', '0.25');

-- --------------------------------------------------------

--
-- Table structure for table `ba_supports`
--

CREATE TABLE IF NOT EXISTS `ba_supports` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `ba_supports`
--

INSERT INTO `ba_supports` (`rcdNo`, `userscalcPK`, `location`, `type`) VALUES
(35, '14', '0', 'Pinned'),
(36, '14', '9', 'Roller');

-- --------------------------------------------------------

--
-- Table structure for table `ba_units`
--

CREATE TABLE IF NOT EXISTS `ba_units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dbtable` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `var` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `unit` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `notes` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(10) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(10) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `ba_units`
--

INSERT INTO `ba_units` (`id`, `dbtable`, `var`, `unit`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(1, 'ba_materials', 'e', 'ksi', '', 0, '2016-01-29 17:37:50', 0, '0000-00-00 00:00:00'),
(2, 'ba_materials', 'rho', 'pcf', '', 0, '2016-01-29 17:37:50', 0, '0000-00-00 00:00:00'),
(3, 'ba_nodes', 'x', 'in.', '', 0, '2016-01-29 17:37:50', 0, '0000-00-00 00:00:00'),
(4, 'ba_nodes', 'y', 'ft', '', 0, '2016-01-29 17:38:20', 0, '0000-00-00 00:00:00'),
(5, 'ba_nodes', 'z', 'ft', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(6, 'ba_sections', 'od', 'in.', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(8, 'ba_sections', 'width', 'in.', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(10, 'ba_sections', 'height', 'in.', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(12, 'ba_sections', 'crfrc', 'in.', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(14, 'ba_sections', 'f2f', 'in.', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(16, 'ba_sections', 'fwth', 'in.', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(18, 'ba_sections', 'thk', 'in.', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(19, 'ba_sections', 'slope', 'in/ft', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(20, 'ba_sections', 'rotation', 'degree', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(21, 'ba_sections', 'A', 'in.^2', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(23, 'ba_sections', 'Ix', 'in.^4', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(24, 'ba_sections', 'Iy', 'in.^4', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(25, 'ba_sections', 'Iz', 'in.^4', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(26, 'ba_nodes', 'ly_end', 'in.^4', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(27, 'ba_ilcs', 'loc_start', 'ft', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00'),
(28, 'ba_ilcs', 'loc_end', 'ft', '', 0, '2016-01-29 17:38:32', 0, '0000-00-00 00:00:00');

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
(90, 0, 0, 'Code', 'link', '', '97', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2015-12-16 13:42:01'),
(91, 0, 0, 'Code', 'file', 'test2', 'test2', 'test2', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(92, 0, 0, 'Code', 'folder', 'test3', '', 'test3', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2015-12-15 09:34:17'),
(93, 92, 0, 'Code', 'file', 'test4', 'test4', 'test4', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(94, 0, 0, 'Code', 'file', 'qweqwe', 'qwe', 'qwe', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(97, 0, 0, 'Code', 'file', 'Dim and properties', 'ALL/AISC/SCM/dim_and_properties.php', '', 'basic', 'active', 'Dim and properties notes', 'Dim and properties', 0, '0000-00-00 00:00:00', 0, '2015-12-17 09:48:41'),
(102, 92, 0, 'Code', 'folder', 'qweqw', 'qwe', 'qwe', 'basic', 'active', '', 'qweqwe', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(103, 0, 0, 'Code', 'folder', 'qwe', '', '', 'free', 'active', 'qwe', 'qwe', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(105, 92, 0, 'Code', 'file', 'dim_and_properties', 'ALL/AISC/SCM/dim_and_properties.php', '', 'basic', 'active', 'Dim and properties notes', 'Dim and properties', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(124, 0, 0, 'Code', 'file', 'tyret', 'erter', 'tertert', 'basic', 'active', '', 'ertert', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(137, 0, 0, 'Discipline', 'link', '', '97', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2015-12-16 13:48:24'),
(138, 0, 0, 'Favorite', 'link', '', '97', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(139, 0, 0, 'Application', 'link', '', '94', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(140, 0, 0, 'Discipline', 'file', 'test2', 'test2.txt', 'test2', 'free', 'active', '', 'Q.Q', 0, '0000-00-00 00:00:00', 0, '2015-12-16 13:50:25'),
(141, 0, 0, 'Discipline', 'file', 'qweqwe', 'qwe', '111', 'free', 'inactive', '', 'qwe', 0, '0000-00-00 00:00:00', 0, '2015-12-16 13:51:44'),
(142, 0, 0, 'Application', 'link', '', '124', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(144, 0, 0, 'Discipline', 'link', '', '124', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(145, 0, 0, 'Application', 'file', 'Beam Analysis', 'ALL/Application/beam_analysis/beam_analysis.php', 'beam_analysis', 'basic', 'active', 'Beam analysis notes', 'Beam analysis', 0, '0000-00-00 00:00:00', 0, '2016-02-19 20:44:16'),
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
(50, '79', '', 1223, '', 1, '', 0, '2015-11-19 18:15:31', 0, '0000-00-00 00:00:00'),
(51, '79', NULL, 111, NULL, NULL, NULL, 0, '2015-11-19 18:15:31', 0, '0000-00-00 00:00:00'),
(52, '77', '', 111, '', 0.85, '', 0, '2015-11-19 18:15:31', 0, '0000-00-00 00:00:00'),
(53, '83', NULL, 67, NULL, 0.85, NULL, NULL, '2015-11-19 21:48:55', NULL, '0000-00-00 00:00:00'),
(55, '101', NULL, 6, NULL, 0.85, NULL, NULL, '2015-11-26 21:13:40', NULL, '0000-00-00 00:00:00');

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
(36, '68', 'D', 700, 6, 0.6, 0.7, 0, 0.6, 1, 0, 0, 0, NULL, 1, NULL, NULL, 0, 90, 'I', '', '', '', NULL, 0, '2015-11-13 20:31:39', 0, '0000-00-00 00:00:00'),
(35, '63', 'D', 700, 6, 0.6, 0.7, 0, 0.6, 1, 0, 0, 0, 0, 1, '', '', 0, 90, 'I', '', '', '', '', 0, '2015-11-13 20:31:39', 0, '0000-00-00 00:00:00'),
(37, NULL, 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-16 22:13:19', NULL, '0000-00-00 00:00:00'),
(38, NULL, 'B', 1200, 7, 0.7, 0.9, NULL, 0.7, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-16 22:37:32', NULL, '0000-00-00 00:00:00'),
(39, NULL, 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-16 22:38:21', NULL, '0000-00-00 00:00:00'),
(40, NULL, 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-16 22:39:08', NULL, '0000-00-00 00:00:00'),
(41, NULL, 'B', 1200, 7, 0.7, 0.9, NULL, 0.7, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-16 22:45:26', NULL, '0000-00-00 00:00:00'),
(42, NULL, 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, 12, 1, 2.027776, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-17 18:04:59', NULL, '0000-00-00 00:00:00'),
(43, '69', 'C', 900, 5, 0.5, 0.8, 0, 0.5, 3, 0.53, 2, 0, 0, 0, '', '', 0.85, 90, '[Null]', 'latticed', 'triangular', 'I', '', 0, '2015-11-17 18:26:20', 0, '0000-00-00 00:00:00'),
(44, NULL, 'B', 1200, 7, 0.7, 0.9, 341, 1.40305306039, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-17 18:51:50', NULL, '0000-00-00 00:00:00'),
(47, '64', 'D', 700, 11.5, 1.03, 0.7, 111, 1.45916613712, 3, 0.53, 2, 0, 0, 1, '', '', 0.85, 90, '[Null]', 'latticed', 'triangular', 'I', '', NULL, '2015-11-18 20:11:47', NULL, '0000-00-00 00:00:00'),
(48, '73', 'B', 900, 7, 0.7, 0.9, 11, 0.7, 3, 0.53, 2, 0, 0, 1, '', '', 0.85, 90, '[Null]', '', '', '', '', 0, '2015-11-17 18:52:03', 0, '0000-00-00 00:00:00'),
(49, '73', 'D', 700, 6, 0.6, 0.7, 111, 1.08793856135, 4, 0.72, 1.5, 322, 1.67703462933, 1.69137949508, '', '', 0.85, 90, '[Null]', '', '', '', '', 0, '2015-11-18 20:51:19', 0, '0000-00-00 00:00:00'),
(69, '98', 'D', NULL, 11.5, 1.03, NULL, 0, 1.03, 3, 0.53, 2, 0, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-26 21:09:13', NULL, '0000-00-00 00:00:00'),
(51, '75', 'B', 900, 5, 0.5, 0.8, 1111, 0.5, 3, 0.53, 2, 0, 0, 1, '', '', 0.85, 90, '[Null]', '', '', '', '', 0, '2015-11-18 21:37:51', 0, '0000-00-00 00:00:00'),
(52, '75', 'C', 900, 5, 0.5, 0.8, 0, 0.5, 3, 0.53, 2, 0, NULL, 1, NULL, NULL, 0.85, 90, NULL, '', '', '', NULL, 0, '2015-11-17 18:26:20', 0, '0000-00-00 00:00:00'),
(54, '80', 'C', NULL, 5, 0.5, NULL, 112, 0.873345853665, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, NULL, NULL, NULL, NULL, NULL, '2015-11-19 20:42:36', NULL, '0000-00-00 00:00:00'),
(55, '84', 'B', NULL, 7, 0.7, NULL, 566, 1.6216195349, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-19 21:49:39', NULL, '0000-00-00 00:00:00'),
(56, '72', 'C', NULL, 9.5, 0.85, NULL, 123, 1.3219964515, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-24 17:43:53', NULL, '0000-00-00 00:00:00'),
(57, '85', 'D', NULL, 11.5, 1.03, NULL, 123, 1.48545040598, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-24 21:21:02', NULL, '0000-00-00 00:00:00'),
(58, '86', 'C', NULL, 9.5, 0.85, NULL, NULL, 0.85, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-24 22:19:37', NULL, '0000-00-00 00:00:00'),
(59, '87', 'D', NULL, 11.5, 1.03, NULL, 0, 1.03, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-24 22:22:16', NULL, '0000-00-00 00:00:00'),
(60, '88', 'D', NULL, 11.5, 1.03, NULL, 0, 1.03, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-24 22:23:14', NULL, '0000-00-00 00:00:00'),
(61, '89', 'C', NULL, 9.5, 0.85, NULL, NULL, 0.85, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-24 22:25:31', NULL, '0000-00-00 00:00:00'),
(62, '90', 'C', NULL, 9.5, 0.85, NULL, NULL, 0.85, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-24 22:26:35', NULL, '0000-00-00 00:00:00'),
(63, '91', 'C', NULL, 9.5, 0.85, NULL, NULL, 0.85, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-24 22:29:59', NULL, '0000-00-00 00:00:00'),
(64, '92', 'C', NULL, 9.5, 0.85, NULL, 0, 0.85, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-24 22:35:17', NULL, '0000-00-00 00:00:00'),
(65, '93', 'C', NULL, 9.5, 0.85, NULL, NULL, 0.85, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-24 22:35:57', NULL, '0000-00-00 00:00:00'),
(66, '94', 'C', NULL, 9.5, 0.85, NULL, 0, 0.85, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-24 22:37:25', NULL, '0000-00-00 00:00:00'),
(70, '99', 'C', NULL, 9.5, 0.85, NULL, 45, 1.06978130895, 3, 0.53, 2, 0, 0, 1, NULL, NULL, 0.85, 90, NULL, 'latticed', 'triangular', 'I', NULL, NULL, '2015-11-26 21:48:18', NULL, '0000-00-00 00:00:00');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `userscalc`
--

INSERT INTO `userscalc` (`RcdNo`, `userID`, `projectID`, `CalcID`, `usersname4Calc`, `calcAppName`, `iconText`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(2, 0, '30', '20160204C001', '234', '', '234', '234', 0, '2016-02-04 17:45:31', NULL, '2016-02-04 17:45:31'),
(3, 0, '30', '20160204C002', '444', 'Beam analysis', '444', '444', 0, '2016-02-04 17:53:14', NULL, '2016-02-04 17:53:14'),
(4, 0, '30', '20160204C003', 'eee', 'beam_analysis', 'eee', 'eee', 0, '2016-02-04 18:13:09', NULL, '2016-02-04 18:13:09'),
(5, 0, '25', '20160204C004', '23', 'beam_analysis', '44', '11', 0, '2016-02-04 19:10:31', NULL, '2016-02-04 19:10:31'),
(6, 0, '13', '20160212C001', 'QSC', 'beam_analysis', NULL, NULL, 0, '2016-02-12 17:22:16', NULL, '2016-02-12 17:22:16'),
(7, 0, '13', '20160212C001', 'QSC', 'beam_analysis', NULL, NULL, 0, '2016-02-12 17:22:16', NULL, '2016-02-12 17:22:16'),
(8, 0, '31', '20160217C001', 'xxx', 'beam_analysis', NULL, NULL, 0, '2016-02-17 16:37:21', NULL, '2016-02-17 16:37:21'),
(9, 0, '31', '20160217C001', 'xxx', 'beam_analysis', NULL, NULL, 0, '2016-02-17 16:37:21', NULL, '2016-02-17 16:37:21'),
(10, 0, '31', '20160218C001', 'wsx', 'beam_analysis', NULL, NULL, 0, '2016-02-18 19:21:42', NULL, '2016-02-18 19:21:42'),
(11, 0, '31', '20160219C001', 'RFV', 'beam_analysis', NULL, NULL, 0, '2016-02-20 03:21:08', NULL, '2016-02-20 03:21:08'),
(12, 0, '31', '20160219C001', 'RFV', 'beam_analysis', NULL, NULL, 0, '2016-02-20 03:21:08', NULL, '2016-02-20 03:21:08'),
(13, 0, '31', '20160219C001', 'RFV', 'beam_analysis', NULL, NULL, 0, '2016-02-20 03:21:08', NULL, '2016-02-20 03:21:08'),
(14, 0, '31', '20160222C001', 'Test', 'beam_analysis', NULL, NULL, 0, '2016-02-22 19:44:20', NULL, '2016-02-22 19:44:20');

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
(85, '118', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 00:18:57', NULL, '0000-00-00 00:00:00'),
(84, '117', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 00:18:57', NULL, '0000-00-00 00:00:00'),
(65, '98', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 00:01:42', NULL, '0000-00-00 00:00:00'),
(78, '111', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 00:18:57', NULL, '0000-00-00 00:00:00'),
(76, '109', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 00:18:57', NULL, '0000-00-00 00:00:00'),
(77, '110', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 00:18:57', NULL, '0000-00-00 00:00:00'),
(86, '119', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 00:18:57', NULL, '0000-00-00 00:00:00'),
(103, '137', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 00:43:44', NULL, '0000-00-00 00:00:00'),
(104, '138', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 00:18:57', NULL, '0000-00-00 00:00:00'),
(105, '139', 'C', 900, 5, 0.5, 0.8, 0, 0.5, 3, 0.53, 2, 0, 0, 0, '', '', 0.85, 90, '', '', 0, '2015-11-19 00:18:57', 0, '0000-00-00 00:00:00'),
(93, '126', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 00:43:44', NULL, '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
