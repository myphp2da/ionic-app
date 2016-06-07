-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1build0.15.04.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 03, 2016 at 07:13 PM
-- Server version: 5.6.28-0ubuntu0.15.04.1
-- PHP Version: 5.6.4-4ubuntu6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `myvegs`
--

-- --------------------------------------------------------

--
-- Table structure for table `mst_access_types`
--

DROP TABLE IF EXISTS `mst_access_types`;
CREATE TABLE IF NOT EXISTS `mst_access_types` (
`id` int(11) NOT NULL,
  `strAccessType` varchar(50) NOT NULL,
  `txtDescription` text,
  `txtModules` text NOT NULL,
  `txtActions` text NOT NULL,
  `tinStatus` tinyint(2) DEFAULT '1' COMMENT '0-Inactive,1-Active, 2-Deleted',
  `dtiCreated` datetime NOT NULL,
  `idCreatedBy` int(10) NOT NULL,
  `dtiModified` datetime NOT NULL,
  `idModifiedBy` int(10) NOT NULL,
  `enmDeleted` enum('0','1') DEFAULT '0' COMMENT '=-Not Deleted, 1=Deleted',
  `dtiDeleted` datetime DEFAULT NULL,
  `idDeletedBy` int(10) DEFAULT NULL,
  `intDesgId` int(10) NOT NULL,
  `strSlug` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_access_types`
--

INSERT INTO `mst_access_types` (`id`, `strAccessType`, `txtDescription`, `txtModules`, `txtActions`, `tinStatus`, `dtiCreated`, `idCreatedBy`, `dtiModified`, `idModifiedBy`, `enmDeleted`, `dtiDeleted`, `idDeletedBy`, `intDesgId`, `strSlug`) VALUES
(1, 'Super Admin', 'Super Admin', 'a:9:{i:0;s:4:"page";i:1;s:11:"access-user";i:2;s:11:"access-type";i:3;s:10:"navigation";i:4;s:6:"master";i:5;s:8:"category";i:6;s:4:"area";i:7;s:8:"quantity";i:8;s:7:"product";}', 'a:9:{s:4:"page";a:3:{s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:4:"list";s:1:"1";}s:11:"access-user";a:3:{s:3:"add";s:1:"1";s:6:"access";s:1:"1";s:4:"list";s:1:"1";}s:11:"access-type";a:4:{s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:4:"list";s:1:"1";s:6:"assign";s:1:"1";}s:10:"navigation";a:3:{s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:4:"list";s:1:"1";}s:6:"master";a:3:{s:11:"access-type";s:1:"1";s:10:"navigation";s:1:"1";s:8:"quantity";s:1:"1";}s:8:"category";a:3:{s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:4:"list";s:1:"1";}s:4:"area";a:3:{s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:4:"list";s:1:"1";}s:8:"quantity";a:3:{s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:4:"list";s:1:"1";}s:7:"product";a:3:{s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:4:"list";s:1:"1";}}', 1, '2013-09-05 03:45:17', 1, '2013-09-05 03:45:17', 1, '0', NULL, NULL, 0, 'super-admin'),
(2, 'Administrator', 'Administrator', 'a:4:{i:0;s:4:"page";i:1;s:10:"navigation";i:2;s:6:"master";i:3;s:8:"category";}', 'a:4:{s:4:"page";a:3:{s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:4:"list";s:1:"1";}s:10:"navigation";a:3:{s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:4:"list";s:1:"1";}s:6:"master";a:2:{s:11:"access-type";s:1:"1";s:10:"navigation";s:1:"1";}s:8:"category";a:3:{s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:4:"list";s:1:"1";}}', 1, '2015-09-22 18:57:23', 1, '2015-09-22 18:57:23', 1, '0', NULL, NULL, 1, 'administrator'),
(3, 'Editor', 'Editor', '', '', 1, '2015-09-22 18:58:59', 1, '2015-09-22 18:58:59', 1, '0', NULL, NULL, 0, 'editor');

-- --------------------------------------------------------

--
-- Table structure for table `mst_accounts`
--

DROP TABLE IF EXISTS `mst_accounts`;
CREATE TABLE IF NOT EXISTS `mst_accounts` (
`id` int(11) NOT NULL,
  `strFirstName` varchar(100) DEFAULT NULL,
  `strMiddleName` varchar(255) DEFAULT NULL,
  `strLastName` varchar(100) DEFAULT NULL,
  `strEmail` varchar(100) DEFAULT NULL,
  `strPassword` varchar(100) NOT NULL,
  `strPincode` int(6) NOT NULL DEFAULT '0',
  `dtBirth` date DEFAULT NULL,
  `strAddress` varchar(255) DEFAULT NULL,
  `strMobile` varchar(11) DEFAULT NULL,
  `strCity` varchar(255) DEFAULT NULL,
  `strState` varchar(255) DEFAULT NULL,
  `strImgurl` varchar(255) DEFAULT NULL,
  `strImageName` varchar(100) DEFAULT NULL,
  `strActivation` varchar(100) DEFAULT NULL,
  `enmActivated` enum('0','1') DEFAULT '0',
  `dtiActivated` datetime DEFAULT NULL,
  `dtiCreated` datetime NOT NULL,
  `idCreatedBy` int(11) NOT NULL,
  `dtiModified` datetime DEFAULT NULL,
  `idModifiedBy` int(11) DEFAULT NULL,
  `tinStatus` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-Disable,1-Enable, 2-Deleted',
  `enmDeleted` enum('0','1') DEFAULT '0' COMMENT '0-No,1-Yes',
  `idDeletedBy` int(11) DEFAULT NULL,
  `dtiDeleted` datetime DEFAULT NULL,
  `idDesg` int(10) NOT NULL DEFAULT '0',
  `dtiLastLogin` datetime DEFAULT NULL,
  `strGender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_accounts`
--

INSERT INTO `mst_accounts` (`id`, `strFirstName`, `strMiddleName`, `strLastName`, `strEmail`, `strPassword`, `strPincode`, `dtBirth`, `strAddress`, `strMobile`, `strCity`, `strState`, `strImgurl`, `strImageName`, `strActivation`, `enmActivated`, `dtiActivated`, `dtiCreated`, `idCreatedBy`, `dtiModified`, `idModifiedBy`, `tinStatus`, `enmDeleted`, `idDeletedBy`, `dtiDeleted`, `idDesg`, `dtiLastLogin`, `strGender`) VALUES
(1, 'Super Administrator', NULL, NULL, 'admin@nascentinfo.net', '3d1d274157bd91fcbb0f5009fe9869390cfb785a', 0, NULL, '', NULL, NULL, NULL, NULL, NULL, '', '1', '2015-09-06 11:25:34', '2015-09-06 11:25:34', 0, '2015-09-06 11:25:34', 0, 1, '0', NULL, NULL, 1, '2015-09-06 11:25:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_areas`
--

DROP TABLE IF EXISTS `mst_areas`;
CREATE TABLE IF NOT EXISTS `mst_areas` (
`id` int(11) NOT NULL,
  `strArea` varchar(50) NOT NULL,
  `idCity` int(11) NOT NULL,
  `idState` int(11) NOT NULL,
  `intPinCode` int(6) NOT NULL,
  `tinStatus` tinyint(2) DEFAULT '1' COMMENT '0-Inactive,1-Active, 2-Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_blocks`
--

DROP TABLE IF EXISTS `mst_blocks`;
CREATE TABLE IF NOT EXISTS `mst_blocks` (
`id` int(10) unsigned NOT NULL,
  `strSlug` varchar(255) NOT NULL DEFAULT '',
  `strContentBlock` varchar(255) NOT NULL,
  `txtDescription` text NOT NULL,
  `dtiCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idCreatedBy` int(11) DEFAULT NULL,
  `dtiModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idModifiedBy` int(11) DEFAULT NULL,
  `enmStatus` enum('0','1') DEFAULT '1' COMMENT '''0''-Inactive,''1''-Active',
  `idDeletedBy` int(10) DEFAULT NULL,
  `enmDeleted` enum('0','1') NOT NULL DEFAULT '0',
  `dtiDeleted` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_blocks`
--

INSERT INTO `mst_blocks` (`id`, `strSlug`, `strContentBlock`, `txtDescription`, `dtiCreated`, `idCreatedBy`, `dtiModified`, `idModifiedBy`, `enmStatus`, `idDeletedBy`, `enmDeleted`, `dtiDeleted`) VALUES
(1, 'text', 'Description', 'Descriptive text block with text formatting', '2016-04-16 10:38:29', 1, '2016-04-16 10:38:29', 1, '1', NULL, '0', NULL),
(2, 'image', 'Image', 'Images upload block with multiple images', '2016-04-16 10:38:29', 1, '2016-04-16 10:38:29', 1, '1', NULL, '0', NULL),
(3, 'social', 'Social Share', 'Social sharing of content for different social networking sites', '2016-04-16 10:38:29', 1, '2016-04-16 10:38:29', 1, '1', NULL, '0', NULL),
(4, 'map', 'Google Map', 'Display google map for latitude longitude provided', '2016-04-16 10:38:29', 1, '2016-04-16 10:38:29', 1, '0', NULL, '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_career`
--

DROP TABLE IF EXISTS `mst_career`;
CREATE TABLE IF NOT EXISTS `mst_career` (
`id` int(10) unsigned NOT NULL,
  `strSlug` varchar(255) NOT NULL DEFAULT '',
  `strTitle` varchar(255) NOT NULL DEFAULT '',
  `strDescription` text,
  `strCode` varchar(255) DEFAULT NULL,
  `strPdfFile` varchar(255) DEFAULT NULL,
  `dtiCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idCreatedBy` int(11) DEFAULT NULL,
  `dtiModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idModifiedBy` int(11) DEFAULT NULL,
  `enmStatus` enum('0','1') DEFAULT '1' COMMENT '''0''-Inactive,''1''-Active',
  `idDeletedBy` int(10) DEFAULT NULL,
  `enmDeleted` enum('0','1') NOT NULL DEFAULT '0',
  `dtiDeleted` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_career`
--

INSERT INTO `mst_career` (`id`, `strSlug`, `strTitle`, `strDescription`, `strCode`, `strPdfFile`, `dtiCreated`, `idCreatedBy`, `dtiModified`, `idModifiedBy`, `enmStatus`, `idDeletedBy`, `enmDeleted`, `dtiDeleted`) VALUES
(1, 'senior-android-developer', 'Senior Android Developer', '<p>Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</p>\r\n', '100', '1460976585_keyurpatel.pdf', '2016-04-18 15:54:17', 1, '2016-04-18 16:19:45', 1, '1', NULL, '0', NULL),
(2, 'senior-php-developer', 'Senior PHP Developer', '<p>Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</p>\r\n', '200', '1460975581_demoform1.pdf', '2016-04-18 16:00:19', 1, '2016-04-18 16:13:53', 1, '1', NULL, '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_categories`
--

DROP TABLE IF EXISTS `mst_categories`;
CREATE TABLE IF NOT EXISTS `mst_categories` (
`id` int(10) unsigned NOT NULL,
  `strCategory` varchar(255) NOT NULL DEFAULT '',
  `txtDescription` text NOT NULL,
  `strImageName` varchar(50) DEFAULT NULL,
  `idParent` int(11) NOT NULL DEFAULT '0',
  `tinStatus` tinyint(2) DEFAULT '1' COMMENT '0-Inactive,1-Active, 2-Deleted',
  `strSlug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_categories`
--

INSERT INTO `mst_categories` (`id`, `strCategory`, `txtDescription`, `strImageName`, `idParent`, `tinStatus`, `strSlug`) VALUES
(1, 'Organically Grown Vegetables', '<p>This is the Content type of News</p>\r\n', '6210578870353715_1463745069_103742.png', 4, 1, 'organically-grown-vegetables'),
(2, 'Events', '<p>This is Content type of Events</p>\r\n', NULL, 0, 1, NULL),
(3, 'Studio', '<p>This is Content type of Studio</p>\r\n', NULL, 0, 1, NULL),
(4, 'Organic Vegetables', '<p>This is content type of Studio</p>\r\n', NULL, 0, 1, 'organic-vegetables'),
(5, 'Research', '<p>This is Content type of Research.</p>\r\n', NULL, 0, 1, NULL),
(6, 'Case studies', '<p>This is Content type of case studies.</p>\r\n', '211575102044301_1463725003_332044.jpg', 3, 1, 'case-studies');

-- --------------------------------------------------------

--
-- Table structure for table `mst_contacts`
--

DROP TABLE IF EXISTS `mst_contacts`;
CREATE TABLE IF NOT EXISTS `mst_contacts` (
`id` int(11) NOT NULL,
  `strName` varchar(100) DEFAULT NULL,
  `strEmail` varchar(255) DEFAULT NULL,
  `strSubject` varchar(200) DEFAULT NULL,
  `txtMessage` text,
  `dtiCreated` datetime DEFAULT NULL,
  `enmStatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0-Disable,1-Enable',
  `enmDeleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0-No,1-Yes',
  `idDeletedBy` int(11) DEFAULT NULL,
  `dtiDeleted` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_contacts`
--

INSERT INTO `mst_contacts` (`id`, `strName`, `strEmail`, `strSubject`, `txtMessage`, `dtiCreated`, `enmStatus`, `enmDeleted`, `idDeletedBy`, `dtiDeleted`) VALUES
(1, 'YogeshRathod', 'yogesh@nascentinfo.net', 'http://www.nascentinfo.com', 'test message', '2016-04-18 19:18:22', 1, '0', NULL, NULL),
(2, 'YogeshRathod', 'yogesh@nascentinfo.net', 'http://www.nascentinfo.com', 'test messge', '2016-04-18 19:21:24', 1, '0', NULL, NULL),
(3, 'Yogeshasdas', 'yogesh@nascentinfo.net', 'http://www.nascentinfo.com', 'test', '2016-04-18 19:23:47', 1, '0', NULL, NULL),
(4, 'YogeshRathod', 'yogesh@nascentinfo.com', 'http://www.nascent.com', 'test msg', '2016-04-18 19:25:29', 1, '0', NULL, NULL),
(5, 'YogeshRathod', 'yogesh@nascentinfo.com', 'http://www.nascent.com', 'test msg', '2016-04-18 19:26:21', 1, '0', NULL, NULL),
(6, 'YogeshRathod', 'yogesh@nascentinfo.net', 'http://www.nascentinfo.com', 'test msg2', '2016-04-18 19:28:47', 1, '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_content`
--

DROP TABLE IF EXISTS `mst_content`;
CREATE TABLE IF NOT EXISTS `mst_content` (
`id` int(10) unsigned NOT NULL,
  `strSlug` varchar(255) NOT NULL DEFAULT '',
  `strTitle` varchar(255) NOT NULL DEFAULT '',
  `strDescription` text,
  `strContentType` char(1) NOT NULL COMMENT 'n-News,p-Product,e-Events,s-Studio,r-Reasearch,c-Case Studies',
  `strUrl` varchar(255) DEFAULT NULL,
  `strPdfFile` varchar(255) DEFAULT NULL,
  `dtContent` date DEFAULT NULL,
  `dtiCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idCreatedBy` int(11) DEFAULT NULL,
  `dtiModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idModifiedBy` int(11) DEFAULT NULL,
  `enmStatus` enum('0','1') DEFAULT '1' COMMENT '''0''-Inactive,''1''-Active',
  `idDeletedBy` int(10) DEFAULT NULL,
  `enmDeleted` enum('0','1') NOT NULL DEFAULT '0',
  `dtiDeleted` datetime DEFAULT NULL,
  `strContentImg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_content`
--

INSERT INTO `mst_content` (`id`, `strSlug`, `strTitle`, `strDescription`, `strContentType`, `strUrl`, `strPdfFile`, `dtContent`, `dtiCreated`, `idCreatedBy`, `dtiModified`, `idModifiedBy`, `enmStatus`, `idDeletedBy`, `enmDeleted`, `dtiDeleted`, `strContentImg`) VALUES
(1, 'how-to-use-technology-disrupt-poverty-worldwide', 'How to Use Technology to Disrupt Poverty Worldwide', '<p>How to Use Technology to Disrupt Poverty Worldwide</p>\r\n', 'n', NULL, NULL, '2016-04-14', '2016-04-14 19:27:50', 1, '2016-04-18 12:10:52', 1, '1', NULL, '0', NULL, NULL),
(2, 'remote-sensing-gis-applications', 'Remote sensing and GIS applications', '<p>Remote sensing and GIS applications</p>\r\n', 'n', NULL, NULL, '2016-04-14', '2016-04-14 19:28:21', 1, '2016-04-18 12:11:11', 1, '1', NULL, '0', NULL, NULL),
(3, 'remote-sensing-gis-applications1', 'Remote sensing and GIS applications1', '<p>Remote sensing and GIS applications</p>\r\n', 'p', NULL, NULL, '2016-04-14', '2016-04-14 19:28:42', 1, '2016-04-18 12:11:43', 1, '1', NULL, '0', NULL, NULL),
(4, 'remote-sensing-gis-applications2', 'Remote sensing and GIS applications2', '<p>Remote sensing and GIS applications2</p>\r\n', 'p', NULL, NULL, '2016-04-14', '2016-04-14 19:29:00', 1, '2016-04-18 12:13:22', 1, '1', NULL, '0', NULL, NULL),
(5, 'how-to-use-technology-disrupt-poverty-worldwide-2', 'How to Use Technology to Disrupt Poverty Worldwide', '<p>How to Use Technology to Disrupt Poverty Worldwide</p>\r\n', 'e', NULL, NULL, '2016-04-14', '2016-04-14 19:29:16', 1, '2016-04-16 11:28:49', 1, '1', NULL, '0', NULL, NULL),
(6, 'how-to-use-technology-disrupt-poverty-worldwide-3', 'How to Use Technology to Disrupt Poverty Worldwide', '<p>How to Use Technology to Disrupt Poverty Worldwide</p>\r\n', 'e', NULL, NULL, '2016-04-14', '2016-04-14 19:29:27', 1, '2016-04-18 12:14:00', 1, '1', NULL, '0', NULL, NULL),
(7, 'remote-sensing-gis-application', 'Remote sensing GIS application.', '<p>Remote sensing GIS application.</p>\r\n', 'r', NULL, NULL, '2016-04-19', '2016-04-15 12:50:08', 1, '2016-04-18 12:15:32', 1, '1', NULL, '0', NULL, '1460704808_linux_ubuntu_ubuntu_804_hardy_heron_1680x1050_wallpaper_Wallpaper_2560x1600_www.wall321.com.jpg'),
(8, 'remote-sensing-gis-application2', 'Remote sensing GIS application2', '<p>Remote sensing GIS application2</p>\r\n', 'r', NULL, NULL, '2016-04-16', '2016-04-16 12:04:57', 1, '2016-04-18 12:14:28', 1, '1', NULL, '0', NULL, NULL),
(9, 'gis-application-for-studio1', 'GIS application for studio1', '<p>GIS application for studio1</p>\r\n', 's', NULL, NULL, '2016-04-16', '2016-04-16 12:08:42', 1, '0000-00-00 00:00:00', NULL, '1', NULL, '0', NULL, NULL),
(10, 'gis-application-for-studio2', 'GIS application for studio2', '<p>GIS application for studio2</p>\r\n', 's', NULL, NULL, '2016-04-16', '2016-04-16 12:09:02', 1, '2016-04-18 12:15:53', 1, '1', NULL, '0', NULL, NULL),
(11, 'how-to-use-technology-disrupt-poverty-worldwide1', 'How to use technology to disrupt poverty worldwide1', '<p>How to use technology to disrupt poverty worldwide1</p>\r\n', 'c', NULL, NULL, '2016-04-15', '2016-04-16 12:15:49', 1, '2016-04-18 12:16:30', 1, '1', NULL, '0', NULL, NULL),
(12, 'how-to-use-technology-disrupt-poverty-worldwide2', 'How to use technology to disrupt poverty worldwide2', '<p>How to use technology to disrupt poverty worldwide2</p>\r\n', 'c', NULL, NULL, '2016-04-16', '2016-04-16 12:16:28', 1, '2016-04-18 12:16:49', 1, '1', NULL, '0', NULL, NULL),
(13, 'rules-get-people-no-where-fantastics', 'rules get people no where fantastics', '<p>rules get people no where fantastics</p>\r\n', 'r', NULL, NULL, '2016-04-13', '2016-04-16 12:41:17', 1, '0000-00-00 00:00:00', NULL, '1', NULL, '0', NULL, NULL),
(14, 'how-to-use-technology-disrupt-poverty-worldwide3', 'How to use technology to disrupt poverty worldwide3', '<p>How to use technology to disrupt poverty worldwide3</p>\r\n', 'c', NULL, NULL, '2016-04-15', '2016-04-16 16:47:41', 1, '2016-04-18 12:17:19', 1, '1', NULL, '0', NULL, NULL),
(15, 'gis-application-for-studio3', 'GIS application for studio3', '<p>GIS application for studio3</p>\r\n', 's', NULL, NULL, '2016-04-12', '2016-04-16 16:48:19', 1, '2016-04-18 12:17:48', 1, '1', NULL, '0', NULL, NULL),
(16, 'demo-tag', 'demo tag', '<p>demo tag</p>\r\n', 'e', NULL, NULL, '2016-04-12', '2016-04-16 16:51:41', 1, '2016-04-18 12:18:16', 1, '1', NULL, '0', NULL, '1460805701_3D-Black-Ubuntu-Widescreen.jpg'),
(17, 'demo-tag-2', 'demo tag 2', '<p>demo tag 2</p>\r\n', 'p', NULL, NULL, '2016-04-13', '2016-04-16 16:53:04', 1, '2016-04-16 17:25:01', 1, '1', NULL, '0', NULL, '1460805784_ubuntu___splat.jpg'),
(18, 'demo-tag-3', 'demo tag 3', '<p>demo tag 3</p>\r\n', 'e', NULL, NULL, '2016-04-13', '2016-04-16 16:55:04', 1, '2016-04-18 12:19:02', 1, '1', NULL, '0', NULL, '1460805904_linux_ubuntu_ubuntu_804_hardy_heron_1680x1050_wallpaper_Wallpaper_2560x1600_www.wall321.com.jpg'),
(19, 'one-music-product', 'one music product', '<p>One music Remote sensing and GIS applications</p>\r\n', 'p', NULL, NULL, '2016-04-15', '2016-04-16 17:16:21', 1, '2016-04-18 12:19:18', 1, '1', NULL, '0', NULL, NULL),
(26, 'how-to-use-technology-disrupt-poverty-worldwide-option-2', 'How to Use Technology to Disrupt Poverty Worldwide option 2', '<p>How to Use Technology to Disrupt Poverty Worldwide option 2</p>\r\n', 'p', NULL, NULL, '2016-04-19', '2016-04-16 19:30:36', 1, '2016-04-18 12:19:57', 1, '1', NULL, '0', NULL, NULL),
(27, 'servicing-gis-application', 'Servicing the GIS application.', '<p>Servicing the GIS Application.</p>\r\n', 's', NULL, NULL, '2016-04-06', '2016-04-18 14:14:17', 1, '0000-00-00 00:00:00', NULL, '1', NULL, '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_customers`
--

DROP TABLE IF EXISTS `mst_customers`;
CREATE TABLE IF NOT EXISTS `mst_customers` (
`id` int(11) NOT NULL,
  `strFirstName` varchar(100) DEFAULT NULL,
  `strLastName` varchar(100) DEFAULT NULL,
  `strEmail` varchar(100) DEFAULT NULL,
  `strPassword` varchar(100) NOT NULL,
  `dtBirth` date DEFAULT NULL,
  `strImageName` varchar(100) DEFAULT NULL,
  `strActivation` varchar(100) DEFAULT NULL,
  `enmActivated` enum('0','1') DEFAULT '0',
  `tinStatus` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0-Disable, 1-Enable, 2-Deleted',
  `dtiLastLogin` datetime DEFAULT NULL,
  `strGender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_errors`
--

DROP TABLE IF EXISTS `mst_errors`;
CREATE TABLE IF NOT EXISTS `mst_errors` (
`id` int(11) NOT NULL,
  `strRequestUri` varchar(255) NOT NULL,
  `intErrorNo` int(11) NOT NULL DEFAULT '0',
  `txtDescription` text NOT NULL,
  `txtSqlQuery` text NOT NULL,
  `dtiCreated` datetime NOT NULL,
  `enmStatus` enum('New','Pending','Closed') NOT NULL DEFAULT 'New'
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_errors`
--

INSERT INTO `mst_errors` (`id`, `strRequestUri`, `intErrorNo`, `txtDescription`, `txtSqlQuery`, `dtiCreated`, `enmStatus`) VALUES
(1, '/myvegs/master/load/data', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''enmStatus'' in ''where clause''<br /> select count(id) as total_rows from mst_categories where enmStatus = ''2''', 'select count(id) as total_rows from mst_categories where enmStatus = ''2''', '2016-05-20 11:26:00', 'New'),
(2, '/myvegs/master/load/data', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''enmStatus'' in ''where clause''<br /> select count(id) as total_rows from mst_categories where enmStatus = ''2''', 'select count(id) as total_rows from mst_categories where enmStatus = ''2''', '2016-05-20 11:26:40', 'New'),
(3, '/myvegs/master/load/data', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''tinStatus'' in ''where clause''<br /> select count(id) as total_rows from mst_access_types where tinStatus != ''2''', 'select count(id) as total_rows from mst_access_types where tinStatus != ''2''', '2016-05-20 12:01:11', 'New'),
(4, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 12:02:34', 'New'),
(5, '/myvegs/product/load/all', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''tinStatus'' in ''where clause''<br /> select count(id) as total_rows from mst_products where tinStatus = ''2''', 'select count(id) as total_rows from mst_products where tinStatus = ''2''', '2016-05-20 12:02:34', 'New'),
(6, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 12:03:06', 'New'),
(7, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 12:05:35', 'New'),
(8, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 15:23:11', 'New'),
(9, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 17:01:58', 'New'),
(10, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 17:09:03', 'New'),
(11, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 17:11:02', 'New'),
(12, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 17:11:38', 'New'),
(13, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 17:12:33', 'New'),
(14, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 17:15:49', 'New'),
(15, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 17:16:27', 'New'),
(16, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 17:19:42', 'New'),
(17, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 17:25:44', 'New'),
(18, '/myvegs/themes/default/assets/advanced-datatable/media/css/demo_product.css', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''mtag.tinStatus'' in ''where clause''<br /> select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', 'select mtag.strTag from mst_content  as mst_cnt\n		join rel_tag as rtag on mst_cnt.id=rtag.intContentID\n		join mst_tag as mtag on mtag.id=rtag.intTagID\n		where mst_cnt.id=14 and  mtag.tinStatus = ''1''\n		and mtag.tinStatus = ''2'' ', '2016-05-20 18:07:36', 'New'),
(19, '/myvegs/master/manager/do', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''strSlug'' in ''where clause''<br /> select count(id) as total_rows from mst_quantities where 1 and strSlug = ''1-kg''', 'select count(id) as total_rows from mst_quantities where 1 and strSlug = ''1-kg''', '2016-06-03 16:21:15', 'New'),
(20, '/myvegs/master/manager/do', 0, 'Undefined column ''dtiLastModified''<br /> select count(id) as total_rows from mst_quantities where strQuantity = ''1 Kg'' and tinStatus != ''2''', 'select count(id) as total_rows from mst_quantities where strQuantity = ''1 Kg'' and tinStatus != ''2''', '2016-06-03 16:21:49', 'New'),
(21, '/myvegs/master/manager/do', 0, 'Undefined column ''dtiLastModified''<br /> select count(id) as total_rows from mst_quantities where strQuantity = ''1 Kg'' and tinStatus != ''2''', 'select count(id) as total_rows from mst_quantities where strQuantity = ''1 Kg'' and tinStatus != ''2''', '2016-06-03 16:22:21', 'New'),
(22, '/myvegs/product/manager/do', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''strShortDescription'' in ''field list''<br /> UPDATE mst_products SET id=:id, strProduct=:strProduct, txtDescription=:txtDescription, strShortDescription=:strShortDescription, idCategory=:idCategory, decPrice=:decPrice, decCurrentPrice=:decCurrentPrice, strImageName=:strImageName WHERE id = 1', 'UPDATE mst_products SET id=:id, strProduct=:strProduct, txtDescription=:txtDescription, strShortDescription=:strShortDescription, idCategory=:idCategory, decPrice=:decPrice, decCurrentPrice=:decCurrentPrice, strImageName=:strImageName WHERE id = 1', '2016-06-03 16:34:10', 'New'),
(23, '/myvegs/product/manager/do', 0, 'Undefined column ''decPrice''<br /> UPDATE mst_products SET id=:id, strProduct=:strProduct, txtDescription=:txtDescription, strShortDescription=:strShortDescription, idCategory=:idCategory, decPrice=:decPrice, decCurrentPrice=:decCurrentPrice, strImageName=:strImageName WHERE id = 1', 'UPDATE mst_products SET id=:id, strProduct=:strProduct, txtDescription=:txtDescription, strShortDescription=:strShortDescription, idCategory=:idCategory, decPrice=:decPrice, decCurrentPrice=:decCurrentPrice, strImageName=:strImageName WHERE id = 1', '2016-06-03 17:13:28', 'New'),
(24, '/myvegs/product/manager/do', 0, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column ''decPrice'' in ''field list''<br /> UPDATE mst_products SET id=:id, strProduct=:strProduct, txtDescription=:txtDescription, strShortDescription=:strShortDescription, idCategory=:idCategory, decPrice=:decPrice, decCurrentPrice=:decCurrentPrice, strImageName=:strImageName WHERE id = 1', 'UPDATE mst_products SET id=:id, strProduct=:strProduct, txtDescription=:txtDescription, strShortDescription=:strShortDescription, idCategory=:idCategory, decPrice=:decPrice, decCurrentPrice=:decCurrentPrice, strImageName=:strImageName WHERE id = 1', '2016-06-03 17:14:19', 'New'),
(25, '/myvegs/product/manager/do', 0, 'SQLSTATE[23000]: Integrity constraint violation: 1048 Column ''idProduct'' cannot be null<br /> INSERT INTO rel_product_quantities (idProduct, idQuantity, decPrice, strRemarks) VALUES (:idProduct, :idQuantity, :decPrice, :strRemarks)', 'INSERT INTO rel_product_quantities (idProduct, idQuantity, decPrice, strRemarks) VALUES (:idProduct, :idQuantity, :decPrice, :strRemarks)', '2016-06-03 17:14:45', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `mst_navigations`
--

DROP TABLE IF EXISTS `mst_navigations`;
CREATE TABLE IF NOT EXISTS `mst_navigations` (
`id` int(11) NOT NULL,
  `strNavigation` varchar(50) NOT NULL,
  `txtDescription` text,
  `enmStatus` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0-Inactive,1-Active',
  `dtiCreated` datetime NOT NULL,
  `idCreatedBy` int(10) NOT NULL,
  `dtiModified` datetime NOT NULL,
  `idModifiedBy` int(10) NOT NULL,
  `enmDeleted` enum('0','1') DEFAULT '0' COMMENT '0-Not Deleted, 1=Deleted',
  `dtiDeleted` datetime DEFAULT NULL,
  `idDeletedBy` int(10) DEFAULT NULL,
  `strSlug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_pages`
--

DROP TABLE IF EXISTS `mst_pages`;
CREATE TABLE IF NOT EXISTS `mst_pages` (
`id` int(10) unsigned NOT NULL,
  `strSlug` varchar(255) NOT NULL DEFAULT '',
  `strTitle` varchar(255) NOT NULL DEFAULT '',
  `txtDescription` text NOT NULL,
  `txtShortDescription` text,
  `strTemplate` varchar(25) DEFAULT NULL,
  `dtiCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idCreatedBy` int(11) DEFAULT NULL,
  `dtiModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idModifiedBy` int(11) DEFAULT NULL,
  `strMetaTitle` text,
  `txtMetaKeywords` text,
  `txtMetaDescription` text,
  `enmStatus` enum('Active','Inactive','Delete') DEFAULT 'Active',
  `enmDeleted` enum('0','1') NOT NULL DEFAULT '0',
  `strContentImg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_pages`
--

INSERT INTO `mst_pages` (`id`, `strSlug`, `strTitle`, `txtDescription`, `txtShortDescription`, `strTemplate`, `dtiCreated`, `idCreatedBy`, `dtiModified`, `idModifiedBy`, `strMetaTitle`, `txtMetaKeywords`, `txtMetaDescription`, `enmStatus`, `enmDeleted`, `strContentImg`) VALUES
(1, 'collaborate-us', 'Collaborate With Us', '<h2>Leave us a message.</h2>\r\n', 'Consectetuer adipiscing elit. Aenean commodo ligula eget dolor.\r\nAenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. ', 'contact-us.php', '2016-04-18 14:49:53', 1, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'Active', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_photo_albums`
--

DROP TABLE IF EXISTS `mst_photo_albums`;
CREATE TABLE IF NOT EXISTS `mst_photo_albums` (
`id` int(11) NOT NULL,
  `strName` varchar(100) CHARACTER SET utf8 NOT NULL,
  `idCategory` int(5) DEFAULT NULL,
  `txtDescription` text NOT NULL,
  `dtPhoto` date DEFAULT NULL,
  `dtiCreated` datetime NOT NULL,
  `idCreatedBy` int(11) NOT NULL DEFAULT '0',
  `dtiModified` datetime DEFAULT NULL,
  `idModifiedBy` int(11) DEFAULT '0',
  `enmStatus` enum('0','1') NOT NULL DEFAULT '1',
  `enmDeleted` enum('0','1') NOT NULL DEFAULT '0',
  `idDeletedBy` int(11) NOT NULL DEFAULT '0',
  `dtiDeleted` datetime DEFAULT NULL,
  `intPosition` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_products`
--

DROP TABLE IF EXISTS `mst_products`;
CREATE TABLE IF NOT EXISTS `mst_products` (
`id` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL DEFAULT '0',
  `strProduct` varchar(50) NOT NULL,
  `txtDescription` text,
  `strShortDescription` varchar(255) DEFAULT NULL,
  `strImageName` varchar(100) DEFAULT NULL,
  `tinStatus` tinyint(2) DEFAULT '1' COMMENT '0-Inactive,1-Active, 2-Deleted'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_products`
--

INSERT INTO `mst_products` (`id`, `idCategory`, `strProduct`, `txtDescription`, `strShortDescription`, `strImageName`, `tinStatus`) VALUES
(1, 1, 'Tomato Local - Organically Grown', '<p>It Is Organically Grown And Handpicked From Farm&nbsp;<br />\r\nProduct image shown is for representation purpose only, the actually product may vary based on season, produce &amp; availability.</p>\r\n', 'Tomato Local - Organically Grown', '7185828325743610_1463744342_3890.jpg', 1),
(2, 1, 'Fresho Potato - Organically Grown', '<p>It is organically grown and handpicked from farm&nbsp;<br />\r\nProduct image shown is for representation purpose only, the actually product may vary based on season, produce &amp; availability.</p>\r\n', '', '3284001355769940_1463744981_3135.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_quantities`
--

DROP TABLE IF EXISTS `mst_quantities`;
CREATE TABLE IF NOT EXISTS `mst_quantities` (
`id` int(10) unsigned NOT NULL,
  `strQuantity` varchar(255) NOT NULL,
  `txtDescription` text NOT NULL,
  `tinStatus` tinyint(2) DEFAULT '1' COMMENT '0-Inactive,1-Active, 2-Deleted',
  `strSlug` varchar(50) DEFAULT NULL,
  `dtiLastUpdated` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_quantities`
--

INSERT INTO `mst_quantities` (`id`, `strQuantity`, `txtDescription`, `tinStatus`, `strSlug`, `dtiLastUpdated`) VALUES
(1, '1 Kg', '<p>1 Kg of the item</p>\r\n', 1, '1-kg', '2016-06-03 16:23:14'),
(2, '500 Grams', '<p>500 grams of item</p>\r\n', 1, '500-grams', '2016-06-03 16:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `mst_quotes`
--

DROP TABLE IF EXISTS `mst_quotes`;
CREATE TABLE IF NOT EXISTS `mst_quotes` (
`id` int(11) NOT NULL,
  `strName` varchar(100) NOT NULL,
  `strEmail` varchar(255) NOT NULL,
  `strMobile` varchar(15) NOT NULL,
  `strService` varchar(100) NOT NULL,
  `txtMessage` text,
  `dtiCreated` datetime DEFAULT NULL,
  `enmStatus` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-Disable,1-Enable',
  `enmDeleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0-No,1-Yes',
  `idDeletedBy` int(11) DEFAULT NULL,
  `dtiDeleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_settings`
--

DROP TABLE IF EXISTS `mst_settings`;
CREATE TABLE IF NOT EXISTS `mst_settings` (
`id` int(10) unsigned NOT NULL,
  `string` varchar(45) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `add_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `enable` enum('0','1') NOT NULL DEFAULT '1',
  `type` varchar(45) NOT NULL,
  `notes` varchar(100) DEFAULT NULL,
  `position` int(10) unsigned NOT NULL,
  `editable` enum('0','1') NOT NULL,
  `loadable` enum('0','1') NOT NULL,
  `group_type` varchar(10) DEFAULT 'MAIN',
  `constant` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_settings`
--

INSERT INTO `mst_settings` (`id`, `string`, `title`, `value`, `add_date`, `enable`, `type`, `notes`, `position`, `editable`, `loadable`, `group_type`, `constant`) VALUES
(1, 'ADMIN_NAME', 'Administrator Name', 'Administrator', '2009-07-07 00:00:00', '1', 'string', '', 1, '1', '1', 'MAIN', '0'),
(2, 'ADMIN_EMAIL', 'Administrator Email', 'mitesh@nascentinfo.net', '2009-07-07 00:00:00', '1', 'email', 'This address is used for admin purposes, like new user notification.', 2, '1', '1', 'MAIN', '0'),
(3, 'SITE_TITLE', 'Site Title', 'Nascent Infotechnologies Pvt. Ltd.', '2009-07-07 00:00:00', '1', 'string', '', 3, '1', '1', 'MAIN', '1'),
(5, 'FROM_EMAIL', 'From E-mail Address', 'mitesh@nascentinfo.net', '2009-07-07 00:00:00', '1', 'email', 'This address is used for all outgoing mails sent from the site.', 6, '1', '1', 'MAIN', '0'),
(8, 'SUPPORT_EMAIL', 'Developer E-mail Address', 'mitesh@nascentinfo.net', '2009-07-07 00:00:00', '1', 'email', 'Developer E-mail Address for all debug information', 4, '0', '1', 'MAIN', '1'),
(9, 'SITE_REPRESENT_TITLE', 'Site Title', 'NASCENT', '2009-07-07 00:00:00', '1', 'string', '', 3, '1', '1', 'MAIN', '1');

-- --------------------------------------------------------

--
-- Table structure for table `mst_tag`
--

DROP TABLE IF EXISTS `mst_tag`;
CREATE TABLE IF NOT EXISTS `mst_tag` (
`id` int(10) unsigned NOT NULL,
  `strSlug` varchar(255) DEFAULT '',
  `strTag` varchar(255) DEFAULT '',
  `txtDescription` text,
  `dtiCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idCreatedBy` int(11) DEFAULT NULL,
  `dtiModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idModifiedBy` int(11) DEFAULT NULL,
  `enmStatus` enum('0','1') DEFAULT '1' COMMENT '''0''-Inactive,''1''-Active',
  `idDeletedBy` int(10) DEFAULT NULL,
  `enmDeleted` enum('0','1') NOT NULL DEFAULT '0',
  `dtiDeleted` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_tag`
--

INSERT INTO `mst_tag` (`id`, `strSlug`, `strTag`, `txtDescription`, `dtiCreated`, `idCreatedBy`, `dtiModified`, `idModifiedBy`, `enmStatus`, `idDeletedBy`, `enmDeleted`, `dtiDeleted`) VALUES
(1, '', 'Technology', '', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', NULL, '1', NULL, '0', NULL),
(2, '', 'Sustanable Developement', '', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', NULL, '1', NULL, '0', NULL),
(23, 'media', 'Media', NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', NULL, '1', NULL, '0', NULL),
(24, 'information-technology', 'Information Technology', NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', NULL, '1', NULL, '0', NULL),
(25, 'studio', 'studio', NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', NULL, '1', NULL, '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_video_albums`
--

DROP TABLE IF EXISTS `mst_video_albums`;
CREATE TABLE IF NOT EXISTS `mst_video_albums` (
`id` int(11) NOT NULL,
  `idCategory` int(5) DEFAULT NULL,
  `strName` varchar(100) CHARACTER SET utf8 NOT NULL,
  `txtUrl` text NOT NULL,
  `enmType` enum('Audio','Video') NOT NULL DEFAULT 'Video',
  `dtVideo` date DEFAULT NULL,
  `dtiCreated` datetime NOT NULL,
  `idCreatedBy` int(11) NOT NULL DEFAULT '0',
  `dtiModified` datetime DEFAULT NULL,
  `idModifiedBy` int(11) DEFAULT '0',
  `enmStatus` enum('0','1') NOT NULL DEFAULT '1',
  `enmDeleted` enum('0','1') NOT NULL DEFAULT '0',
  `idDeletedBy` int(11) NOT NULL DEFAULT '0',
  `dtiDeleted` datetime DEFAULT NULL,
  `intPosition` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_account_login_logs`
--

DROP TABLE IF EXISTS `rel_account_login_logs`;
CREATE TABLE IF NOT EXISTS `rel_account_login_logs` (
`id` int(10) NOT NULL,
  `vId` int(11) NOT NULL,
  `loginDate` datetime NOT NULL,
  `session` varchar(255) NOT NULL,
  `ipAddress` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rel_account_login_logs`
--

INSERT INTO `rel_account_login_logs` (`id`, `vId`, `loginDate`, `session`, `ipAddress`) VALUES
(1, 1, '2016-04-14 15:16:47', 'pbc66alkhc6greujncjqu47ca5', '127.0.0.1'),
(2, 1, '2016-04-14 19:00:41', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(3, 1, '2016-04-15 11:19:32', '8qru95pppr4l93eukcgpq92022', '127.0.0.1'),
(4, 1, '2016-04-15 12:15:38', 'e1hirsb7gp6m0d1b6eissfnbm2', '127.0.0.1'),
(5, 1, '2016-04-15 12:34:31', '8qru95pppr4l93eukcgpq92022', '127.0.0.1'),
(6, 1, '2016-04-15 17:10:24', 'e1hirsb7gp6m0d1b6eissfnbm2', '127.0.0.1'),
(7, 1, '2016-04-16 11:22:26', '6b174udaog209fa7qn7cskdo13', '127.0.0.1'),
(8, 1, '2016-04-16 11:39:42', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(9, 1, '2016-04-16 14:11:42', '6b174udaog209fa7qn7cskdo13', '127.0.0.1'),
(10, 1, '2016-04-16 14:14:26', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(11, 1, '2016-04-16 16:07:00', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(12, 1, '2016-04-16 16:28:53', '6b174udaog209fa7qn7cskdo13', '127.0.0.1'),
(13, 1, '2016-04-16 16:44:01', '8qru95pppr4l93eukcgpq92022', '127.0.0.1'),
(14, 1, '2016-04-16 16:51:38', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(15, 1, '2016-04-16 17:51:58', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(16, 1, '2016-04-16 19:17:43', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(17, 1, '2016-04-18 12:03:14', '7i38df8fl1n2g98tojkkm9jq14', '127.0.0.1'),
(18, 1, '2016-04-18 12:04:40', '7i38df8fl1n2g98tojkkm9jq14', '127.0.0.1'),
(19, 1, '2016-04-18 12:05:23', '8qru95pppr4l93eukcgpq92022', '127.0.0.1'),
(20, 1, '2016-04-18 12:07:30', 'nprj2i57d3a301tsv23h6b3td3', '127.0.0.1'),
(21, 1, '2016-04-18 12:07:33', 'kar2m6kabv71lp0f7ho337mao2', '127.0.0.1'),
(22, 1, '2016-04-18 12:14:28', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(23, 1, '2016-04-18 14:06:40', '7i38df8fl1n2g98tojkkm9jq14', '127.0.0.1'),
(24, 1, '2016-04-18 14:31:03', '8qru95pppr4l93eukcgpq92022', '127.0.0.1'),
(25, 1, '2016-04-18 15:36:53', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(26, 1, '2016-04-18 15:53:52', '8qru95pppr4l93eukcgpq92022', '127.0.0.1'),
(27, 1, '2016-04-18 17:20:36', '7i38df8fl1n2g98tojkkm9jq14', '127.0.0.1'),
(28, 1, '2016-04-18 17:52:40', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(29, 1, '2016-05-20 11:23:41', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(30, 1, '2016-05-20 15:23:08', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(31, 1, '2016-05-20 17:01:56', 'rvdn6656prsc4vpegf4f9vic10', '127.0.0.1'),
(32, 1, '2016-06-03 14:21:33', '0jdkaan2kqbbtb7eeq69dqvag5', '127.0.0.1'),
(33, 1, '2016-06-03 15:39:50', '0jdkaan2kqbbtb7eeq69dqvag5', '127.0.0.1'),
(34, 1, '2016-06-03 16:20:46', '0jdkaan2kqbbtb7eeq69dqvag5', '127.0.0.1'),
(35, 1, '2016-06-03 17:13:07', '0jdkaan2kqbbtb7eeq69dqvag5', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `rel_block_details`
--

DROP TABLE IF EXISTS `rel_block_details`;
CREATE TABLE IF NOT EXISTS `rel_block_details` (
`id` int(10) unsigned NOT NULL,
  `intContentBlockId` int(5) NOT NULL,
  `txtContent` text NOT NULL,
  `decLatitude` decimal(10,2) DEFAULT NULL,
  `decLongitude` decimal(10,2) DEFAULT NULL,
  `intPosition` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rel_block_details`
--

INSERT INTO `rel_block_details` (`id`, `intContentBlockId`, `txtContent`, `decLatitude`, `decLongitude`, `intPosition`) VALUES
(1, 1, '<p>How to Use Technology to Disrupt Poverty Worldwide option 2</p>\r\n', NULL, NULL, 1),
(2, 2, '8461162753742640_1460815236_134210.png', NULL, NULL, 1),
(3, 2, '2054842669348772_1460815236_251610.png', NULL, NULL, 2),
(4, 2, '0911493221005346_1460815236_179804.png', NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `rel_cart`
--

DROP TABLE IF EXISTS `rel_cart`;
CREATE TABLE IF NOT EXISTS `rel_cart` (
`id` int(10) unsigned NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `decAmount` decimal(10,2) NOT NULL,
  `intTotalProducts` tinyint(2) NOT NULL,
  `tinStatus` tinyint(2) NOT NULL COMMENT '0=New, 1=Under Process, 2=Confirmed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_cart_products`
--

DROP TABLE IF EXISTS `rel_cart_products`;
CREATE TABLE IF NOT EXISTS `rel_cart_products` (
`id` int(10) unsigned NOT NULL,
  `idCart` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idQuantity` int(11) NOT NULL,
  `idOffer` int(11) DEFAULT '0',
  `decAmount` decimal(10,2) NOT NULL,
  `decTotalAmount` decimal(10,2) DEFAULT NULL,
  `tinStatus` tinyint(2) NOT NULL COMMENT '0=New, 1=Under Process, 2=Confirmed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_content`
--

DROP TABLE IF EXISTS `rel_content`;
CREATE TABLE IF NOT EXISTS `rel_content` (
`id` int(10) unsigned NOT NULL,
  `intCategoryID` int(5) NOT NULL,
  `intContentID` int(5) NOT NULL,
  `dtiCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idCreatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_content_blocks`
--

DROP TABLE IF EXISTS `rel_content_blocks`;
CREATE TABLE IF NOT EXISTS `rel_content_blocks` (
`id` int(10) unsigned NOT NULL,
  `intBlockId` int(5) NOT NULL,
  `intContentId` int(5) NOT NULL,
  `intPosition` int(11) DEFAULT '0',
  `dtiCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `intCreatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rel_content_blocks`
--

INSERT INTO `rel_content_blocks` (`id`, `intBlockId`, `intContentId`, `intPosition`, `dtiCreated`, `intCreatedBy`) VALUES
(1, 1, 26, 1, '2016-04-16 19:30:36', 1),
(2, 2, 26, 2, '2016-04-16 19:30:36', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rel_customer_addresses`
--

DROP TABLE IF EXISTS `rel_customer_addresses`;
CREATE TABLE IF NOT EXISTS `rel_customer_addresses` (
`id` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `strLabel` varchar(15) NOT NULL,
  `strFirstName` varchar(25) NOT NULL,
  `strLastName` varchar(25) NOT NULL,
  `strAddressLine1` varchar(255) DEFAULT NULL,
  `strAddressLine2` varchar(50) NOT NULL,
  `idArea` int(11) NOT NULL,
  `strCity` varchar(255) DEFAULT NULL,
  `strState` varchar(255) DEFAULT NULL,
  `strPincode` int(6) NOT NULL DEFAULT '0',
  `tinStatus` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0-Disable, 1-Enable, 2-Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_date_logs`
--

DROP TABLE IF EXISTS `rel_date_logs`;
CREATE TABLE IF NOT EXISTS `rel_date_logs` (
`id` int(10) NOT NULL,
  `strType` varchar(25) DEFAULT NULL,
  `strAccountType` varchar(10) DEFAULT 'customer',
  `enmDateType` enum('C','M','D','A') DEFAULT 'C',
  `idAccount` int(11) DEFAULT '0',
  `dtiSystem` datetime NOT NULL,
  `strSession` varchar(255) NOT NULL,
  `strIPAddress` varchar(15) NOT NULL,
  `strRemarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_navigation_links`
--

DROP TABLE IF EXISTS `rel_navigation_links`;
CREATE TABLE IF NOT EXISTS `rel_navigation_links` (
`id` int(10) unsigned NOT NULL,
  `idNavigation` int(10) unsigned DEFAULT '1',
  `enmType` enum('EL','PG','LB','PL') NOT NULL DEFAULT 'PG',
  `idPage` int(10) unsigned NOT NULL DEFAULT '0',
  `strLink` varchar(255) DEFAULT NULL,
  `strTarget` varchar(10) NOT NULL DEFAULT '',
  `strLabel` varchar(255) NOT NULL DEFAULT '',
  `strSlug` varchar(255) NOT NULL DEFAULT '',
  `strIcon` varchar(25) DEFAULT NULL,
  `idLink` int(10) unsigned DEFAULT '0',
  `intPosition` int(10) unsigned NOT NULL DEFAULT '0',
  `enmStatus` enum('0','1') NOT NULL DEFAULT '1',
  `dtiCreated` datetime NOT NULL,
  `idCreatedby` int(10) unsigned NOT NULL DEFAULT '0',
  `dtiModified` datetime DEFAULT NULL,
  `idModifiedBy` int(11) DEFAULT '0',
  `enmDeleted` enum('0','1') DEFAULT '0',
  `dtiDeleted` datetime DEFAULT NULL,
  `idDeletedBy` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_offers`
--

DROP TABLE IF EXISTS `rel_offers`;
CREATE TABLE IF NOT EXISTS `rel_offers` (
`id` int(11) NOT NULL,
  `strOffer` varchar(50) NOT NULL,
  `intPercent` int(11) NOT NULL,
  `strImageName` varchar(100) DEFAULT NULL,
  `tinStatus` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0-Inactive,1-Active, 2-Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_offer_products`
--

DROP TABLE IF EXISTS `rel_offer_products`;
CREATE TABLE IF NOT EXISTS `rel_offer_products` (
`id` int(10) unsigned NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idOffer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_photos`
--

DROP TABLE IF EXISTS `rel_photos`;
CREATE TABLE IF NOT EXISTS `rel_photos` (
`id` int(11) NOT NULL,
  `idPhotoAlbum` int(11) NOT NULL COMMENT 'Ref key of mst_photo_albums',
  `strImageName` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `strDescription` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `intPosition` int(11) DEFAULT NULL,
  `enmStatus` enum('0','1') NOT NULL DEFAULT '1',
  `enmDeleted` enum('0','1') NOT NULL DEFAULT '0',
  `enmDefaultImage` enum('0','1') NOT NULL DEFAULT '0',
  `idCreatedBy` int(11) NOT NULL DEFAULT '0',
  `dtiCreated` datetime NOT NULL,
  `dtiModified` datetime DEFAULT NULL,
  `idModifiedBy` int(11) DEFAULT '0',
  `modified_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_product_quantities`
--

DROP TABLE IF EXISTS `rel_product_quantities`;
CREATE TABLE IF NOT EXISTS `rel_product_quantities` (
`id` int(10) unsigned NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idQuantity` int(11) NOT NULL,
  `strRemarks` varchar(50) DEFAULT NULL,
  `decPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rel_product_quantities`
--

INSERT INTO `rel_product_quantities` (`id`, `idProduct`, `idQuantity`, `strRemarks`, `decPrice`) VALUES
(1, 1, 1, 'Approx. 15 items', '33.90'),
(2, 1, 2, 'Approx. 8 items', '17.00');

-- --------------------------------------------------------

--
-- Table structure for table `rel_tag`
--

DROP TABLE IF EXISTS `rel_tag`;
CREATE TABLE IF NOT EXISTS `rel_tag` (
`id` int(10) unsigned NOT NULL,
  `intTagID` int(5) DEFAULT NULL,
  `intContentID` int(5) NOT NULL,
  `dtiCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idCreatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rel_tag`
--

INSERT INTO `rel_tag` (`id`, `intTagID`, `intContentID`, `dtiCreated`, `idCreatedBy`) VALUES
(24, 17, 17, '0000-00-00 00:00:00', NULL),
(25, 21, 17, '0000-00-00 00:00:00', NULL),
(28, 1, 1, '0000-00-00 00:00:00', NULL),
(29, 2, 1, '0000-00-00 00:00:00', NULL),
(30, 1, 2, '0000-00-00 00:00:00', NULL),
(31, 1, 3, '0000-00-00 00:00:00', NULL),
(32, 2, 3, '0000-00-00 00:00:00', NULL),
(33, 23, 3, '0000-00-00 00:00:00', NULL),
(34, 24, 4, '0000-00-00 00:00:00', NULL),
(35, 1, 4, '0000-00-00 00:00:00', NULL),
(36, 1, 7, '0000-00-00 00:00:00', NULL),
(37, 1, 6, '0000-00-00 00:00:00', NULL),
(38, 1, 8, '0000-00-00 00:00:00', NULL),
(39, 24, 8, '0000-00-00 00:00:00', NULL),
(40, 1, 10, '0000-00-00 00:00:00', NULL),
(41, 24, 10, '0000-00-00 00:00:00', NULL),
(42, 1, 11, '0000-00-00 00:00:00', NULL),
(43, 2, 11, '0000-00-00 00:00:00', NULL),
(44, 2, 12, '0000-00-00 00:00:00', NULL),
(45, 1, 12, '0000-00-00 00:00:00', NULL),
(46, 1, 14, '0000-00-00 00:00:00', NULL),
(47, 1, 15, '0000-00-00 00:00:00', NULL),
(48, 2, 15, '0000-00-00 00:00:00', NULL),
(49, 1, 16, '0000-00-00 00:00:00', NULL),
(50, 24, 16, '0000-00-00 00:00:00', NULL),
(51, 1, 18, '0000-00-00 00:00:00', NULL),
(52, 24, 18, '0000-00-00 00:00:00', NULL),
(53, 24, 19, '0000-00-00 00:00:00', NULL),
(54, 1, 19, '0000-00-00 00:00:00', NULL),
(55, 1, 26, '0000-00-00 00:00:00', NULL),
(56, 24, 26, '0000-00-00 00:00:00', NULL),
(57, 1, 27, '0000-00-00 00:00:00', NULL),
(58, 25, 27, '0000-00-00 00:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_access_types`
--
ALTER TABLE `mst_access_types`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_accounts`
--
ALTER TABLE `mst_accounts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_areas`
--
ALTER TABLE `mst_areas`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_blocks`
--
ALTER TABLE `mst_blocks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_career`
--
ALTER TABLE `mst_career`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_categories`
--
ALTER TABLE `mst_categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_contacts`
--
ALTER TABLE `mst_contacts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_content`
--
ALTER TABLE `mst_content`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_customers`
--
ALTER TABLE `mst_customers`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_errors`
--
ALTER TABLE `mst_errors`
 ADD UNIQUE KEY `error_id` (`id`);

--
-- Indexes for table `mst_navigations`
--
ALTER TABLE `mst_navigations`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_pages`
--
ALTER TABLE `mst_pages`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_photo_albums`
--
ALTER TABLE `mst_photo_albums`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_products`
--
ALTER TABLE `mst_products`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_quantities`
--
ALTER TABLE `mst_quantities`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_quotes`
--
ALTER TABLE `mst_quotes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_settings`
--
ALTER TABLE `mst_settings`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_tag`
--
ALTER TABLE `mst_tag`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_video_albums`
--
ALTER TABLE `mst_video_albums`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_account_login_logs`
--
ALTER TABLE `rel_account_login_logs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_block_details`
--
ALTER TABLE `rel_block_details`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_cart`
--
ALTER TABLE `rel_cart`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_cart_products`
--
ALTER TABLE `rel_cart_products`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_content`
--
ALTER TABLE `rel_content`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_content_blocks`
--
ALTER TABLE `rel_content_blocks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_customer_addresses`
--
ALTER TABLE `rel_customer_addresses`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_date_logs`
--
ALTER TABLE `rel_date_logs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_navigation_links`
--
ALTER TABLE `rel_navigation_links`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_offers`
--
ALTER TABLE `rel_offers`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_offer_products`
--
ALTER TABLE `rel_offer_products`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_photos`
--
ALTER TABLE `rel_photos`
 ADD PRIMARY KEY (`id`), ADD KEY `gallery_id` (`idPhotoAlbum`);

--
-- Indexes for table `rel_product_quantities`
--
ALTER TABLE `rel_product_quantities`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_tag`
--
ALTER TABLE `rel_tag`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_access_types`
--
ALTER TABLE `mst_access_types`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mst_accounts`
--
ALTER TABLE `mst_accounts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mst_areas`
--
ALTER TABLE `mst_areas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_blocks`
--
ALTER TABLE `mst_blocks`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mst_career`
--
ALTER TABLE `mst_career`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mst_categories`
--
ALTER TABLE `mst_categories`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mst_contacts`
--
ALTER TABLE `mst_contacts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mst_content`
--
ALTER TABLE `mst_content`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `mst_customers`
--
ALTER TABLE `mst_customers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_errors`
--
ALTER TABLE `mst_errors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `mst_navigations`
--
ALTER TABLE `mst_navigations`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_pages`
--
ALTER TABLE `mst_pages`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mst_photo_albums`
--
ALTER TABLE `mst_photo_albums`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_products`
--
ALTER TABLE `mst_products`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mst_quantities`
--
ALTER TABLE `mst_quantities`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mst_quotes`
--
ALTER TABLE `mst_quotes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_settings`
--
ALTER TABLE `mst_settings`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `mst_tag`
--
ALTER TABLE `mst_tag`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `mst_video_albums`
--
ALTER TABLE `mst_video_albums`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rel_account_login_logs`
--
ALTER TABLE `rel_account_login_logs`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `rel_block_details`
--
ALTER TABLE `rel_block_details`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rel_cart`
--
ALTER TABLE `rel_cart`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rel_cart_products`
--
ALTER TABLE `rel_cart_products`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rel_content`
--
ALTER TABLE `rel_content`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rel_content_blocks`
--
ALTER TABLE `rel_content_blocks`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rel_customer_addresses`
--
ALTER TABLE `rel_customer_addresses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rel_date_logs`
--
ALTER TABLE `rel_date_logs`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rel_navigation_links`
--
ALTER TABLE `rel_navigation_links`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rel_offers`
--
ALTER TABLE `rel_offers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rel_offer_products`
--
ALTER TABLE `rel_offer_products`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rel_photos`
--
ALTER TABLE `rel_photos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rel_product_quantities`
--
ALTER TABLE `rel_product_quantities`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rel_tag`
--
ALTER TABLE `rel_tag`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
