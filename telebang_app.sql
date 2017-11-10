-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 17, 2017 at 06:55 PM
-- Server version: 5.6.35
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `telebang_app`
--
-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `tbl_subscription` (
  `id` int(10) UNSIGNED NOT NULL,
  `time` int(20) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `card_number` varchar(250) NOT NULL,
  `user_id` int(20) NOT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CategoryId` smallint(6) NOT NULL,
  `CategoryName` varchar(250) NOT NULL,
  `CategoryImage` varchar(250) DEFAULT NULL,
  `CategoryIcon` varchar(250) DEFAULT NULL,
  `StatusId` tinyint(4) NOT NULL,
  `IsTop` tinyint(4) NOT NULL,
  `DisplayOrder` tinyint(4) NOT NULL,
  `ParentCategoryId` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryId`, `CategoryName`, `CategoryImage`, `CategoryIcon`, `StatusId`, `IsTop`, `DisplayOrder`, `ParentCategoryId`) VALUES
(3, 'Technology', '/Technology.jpg', '/Technology.jpg', 2, 0, 100, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categoryvideos`
--

CREATE TABLE `categoryvideos` (
  `CategoryVideoId` int(11) NOT NULL,
  `VideoId` int(11) NOT NULL,
  `CategoryId` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categoryvideos`
--

INSERT INTO `categoryvideos` (`CategoryVideoId`, `VideoId`, `CategoryId`) VALUES
(4, 5, 3),
(5, 6, 3),
(6, 7, 3),
(7, 8, 3),
(8, 3, 3),
(9, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `ConfigId` tinyint(4) NOT NULL,
  `ConfigCode` varchar(45) NOT NULL,
  `ConfigValue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`ConfigId`, `ConfigCode`, `ConfigValue`) VALUES
(1, 'STATUS_USER', '2'),
(2, 'STATUS_VIDEO', '2'),
(3, 'ADMIN_EMAIL', 'contact@telebang.com'),
(4, 'STATUS_COMMENT', '2');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `RoleId` tinyint(4) NOT NULL,
  `RoleName` varchar(45) NOT NULL,
  `CssClass` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleId`, `RoleName`, `CssClass`) VALUES
(1, 'Admin', 'label-success'),
(2, 'Edittor', 'label-info'),
(3, 'Customer', 'label-warning');

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `id_series` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `thumbnail` text NOT NULL,
  `short_desc` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `completed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staticpages`
--

CREATE TABLE `staticpages` (
  `slug` varchar(2000) NOT NULL,
  `PageTitle` varchar(2000) NOT NULL,
  `PageDesc` varchar(6000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `StatusId` tinyint(4) NOT NULL,
  `StatusName` varchar(45) NOT NULL,
  `CssClass` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`StatusId`, `StatusName`, `CssClass`) VALUES
(1, 'Pending', 'label-info'),
(2, 'Approved', 'label-success'),
(3, 'Suspended', 'label-warning'),
(4, 'Blocked', 'label-danger');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment_video`
--

CREATE TABLE `tbl_comment_video` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `create_at` int(11) NOT NULL,
  `status_comment` int(11) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_comment_video`
--

INSERT INTO `tbl_comment_video` (`id`, `user_id`, `video_id`, `comment`, `create_at`, `status_comment`) VALUES
(1, 2, 4, 'awesome', 1491994920, 2),
(2, 2, 4, 'wow', 1492008335, 2),
(3, 2, 4, 'Nice', 1493756343, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_devices`
--

CREATE TABLE `tbl_devices` (
  `id` int(11) NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_like_video`
--

CREATE TABLE `tbl_like_video` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `create_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_like_video`
--

INSERT INTO `tbl_like_video` (`id`, `user_id`, `video_id`, `create_at`) VALUES
(2, 2, 4, 1493756326),
(3, 2, 3, 1493756579),
(4, 2, 6, 1494878290);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news`
--

CREATE TABLE `tbl_news` (
  `id` int(11) NOT NULL,
  `short_description` text NOT NULL,
  `thumbnail` text NOT NULL,
  `view` int(11) NOT NULL,
  `description` longtext CHARACTER SET utf8 NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `create_at` bigint(20) NOT NULL,
  `update_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news_category_connect`
--

CREATE TABLE `tbl_news_category_connect` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `content_id` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_activity`
--

CREATE TABLE `tbl_user_activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `action` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `create_at` int(11) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video_view`
--

CREATE TABLE `tbl_video_view` (
  `id` int(11) NOT NULL,
  `create_at` date NOT NULL,
  `video_id` int(11) NOT NULL,
  `view_counter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_video_view`
--

INSERT INTO `tbl_video_view` (`id`, `create_at`, `video_id`, `view_counter`) VALUES
(3, '2017-04-12', 3, 9),
(4, '2017-04-12', 4, 10),
(5, '2017-04-12', 6, 3),
(6, '2017-04-12', 5, 1),
(7, '2017-04-12', 7, 7),
(8, '2017-04-12', 8, 3),
(9, '2017-04-13', 8, 4),
(10, '2017-04-13', 4, 5),
(11, '2017-04-13', 3, 3),
(12, '2017-04-13', 5, 3),
(13, '2017-04-13', 7, 3),
(14, '2017-04-13', 6, 2),
(15, '2017-04-14', 6, 1),
(16, '2017-04-14', 5, 1),
(17, '2017-04-14', 4, 1),
(18, '2017-04-14', 3, 1),
(19, '2017-04-14', 7, 1),
(20, '2017-04-14', 8, 1),
(21, '2017-04-15', 7, 1),
(22, '2017-04-15', 6, 1),
(23, '2017-04-15', 3, 1),
(24, '2017-04-15', 4, 1),
(25, '2017-04-15', 5, 1),
(26, '2017-04-15', 8, 1),
(27, '2017-04-16', 6, 1),
(28, '2017-04-16', 5, 1),
(29, '2017-04-16', 4, 1),
(30, '2017-04-16', 3, 1),
(31, '2017-04-16', 7, 1),
(32, '2017-04-16', 8, 1),
(33, '2017-04-17', 6, 1),
(34, '2017-04-17', 8, 1),
(35, '2017-04-17', 3, 1),
(36, '2017-04-17', 4, 1),
(37, '2017-04-17', 5, 1),
(38, '2017-04-17', 7, 1),
(39, '2017-04-19', 4, 3),
(40, '2017-04-19', 8, 2),
(41, '2017-04-19', 5, 2),
(42, '2017-04-19', 6, 2),
(43, '2017-04-19', 3, 2),
(44, '2017-04-19', 7, 2),
(45, '2017-04-20', 6, 3),
(46, '2017-04-20', 8, 3),
(47, '2017-04-20', 7, 3),
(48, '2017-04-20', 5, 3),
(49, '2017-04-20', 4, 3),
(50, '2017-04-20', 3, 3),
(51, '2017-04-21', 7, 1),
(52, '2017-04-21', 8, 1),
(53, '2017-04-21', 6, 1),
(54, '2017-04-21', 5, 1),
(55, '2017-04-21', 4, 1),
(56, '2017-04-21', 3, 1),
(57, '2017-04-22', 7, 1),
(58, '2017-04-22', 8, 1),
(59, '2017-04-22', 5, 1),
(60, '2017-04-22', 6, 1),
(61, '2017-04-22', 3, 1),
(62, '2017-04-22', 4, 1),
(63, '2017-04-24', 5, 2),
(64, '2017-04-24', 4, 2),
(65, '2017-04-24', 8, 2),
(66, '2017-04-24', 7, 2),
(67, '2017-04-24', 6, 2),
(68, '2017-04-24', 3, 2),
(69, '2017-04-25', 8, 1),
(70, '2017-04-25', 5, 1),
(71, '2017-04-25', 7, 1),
(72, '2017-04-25', 6, 1),
(73, '2017-04-25', 3, 1),
(74, '2017-04-25', 4, 1),
(75, '2017-04-26', 7, 1),
(76, '2017-04-27', 7, 1),
(77, '2017-04-27', 6, 1),
(78, '2017-04-27', 3, 1),
(79, '2017-04-27', 4, 1),
(80, '2017-04-27', 5, 1),
(81, '2017-04-27', 8, 1),
(82, '2017-04-28', 7, 4),
(83, '2017-04-28', 6, 3),
(84, '2017-04-28', 8, 2),
(85, '2017-04-28', 3, 1),
(86, '2017-04-28', 4, 2),
(87, '2017-04-28', 5, 2),
(88, '2017-04-29', 4, 3),
(89, '2017-04-29', 5, 3),
(90, '2017-04-29', 7, 3),
(91, '2017-04-29', 8, 3),
(92, '2017-04-29', 3, 4),
(93, '2017-04-29', 6, 3),
(94, '2017-05-01', 5, 1),
(95, '2017-05-01', 7, 1),
(96, '2017-05-01', 6, 1),
(97, '2017-05-01', 8, 1),
(98, '2017-05-01', 4, 1),
(99, '2017-05-01', 3, 1),
(100, '2017-05-02', 7, 2),
(101, '2017-05-02', 8, 1),
(102, '2017-05-02', 5, 1),
(103, '2017-05-02', 4, 1),
(104, '2017-05-02', 6, 1),
(105, '2017-05-02', 3, 1),
(106, '2017-05-03', 3, 8),
(107, '2017-05-03', 8, 3),
(108, '2017-05-03', 4, 8),
(109, '2017-05-03', 7, 2),
(110, '2017-05-03', 5, 3),
(111, '2017-05-03', 6, 4),
(112, '2017-05-04', 3, 3),
(113, '2017-05-04', 7, 1),
(114, '2017-05-04', 8, 1),
(115, '2017-05-04', 5, 1),
(116, '2017-05-04', 4, 2),
(117, '2017-05-04', 6, 1),
(118, '2017-05-05', 4, 1),
(119, '2017-05-05', 5, 1),
(120, '2017-05-05', 8, 1),
(121, '2017-05-05', 3, 1),
(122, '2017-05-05', 7, 1),
(123, '2017-05-05', 6, 1),
(124, '2017-05-07', 6, 1),
(125, '2017-05-07', 3, 1),
(126, '2017-05-07', 8, 2),
(127, '2017-05-07', 7, 1),
(128, '2017-05-07', 5, 1),
(129, '2017-05-07', 4, 1),
(130, '2017-05-08', 3, 1),
(131, '2017-05-08', 6, 1),
(132, '2017-05-08', 7, 1),
(133, '2017-05-08', 5, 1),
(134, '2017-05-08', 4, 1),
(135, '2017-05-08', 8, 1),
(136, '2017-05-10', 5, 2),
(137, '2017-05-10', 3, 1),
(138, '2017-05-10', 6, 1),
(139, '2017-05-10', 4, 1),
(140, '2017-05-10', 7, 1),
(141, '2017-05-10', 8, 1),
(142, '2017-05-11', 7, 1),
(143, '2017-05-11', 5, 1),
(144, '2017-05-12', 7, 2),
(145, '2017-05-12', 6, 1),
(146, '2017-05-12', 8, 2),
(147, '2017-05-12', 4, 2),
(148, '2017-05-12', 3, 2),
(149, '2017-05-12', 5, 2),
(150, '2017-05-14', 4, 1),
(151, '2017-05-14', 8, 1),
(152, '2017-05-15', 5, 1),
(153, '2017-05-15', 6, 2),
(154, '2017-05-15', 8, 1),
(155, '2017-05-15', 3, 2),
(156, '2017-05-15', 4, 2),
(157, '2017-05-15', 7, 1),
(158, '2017-05-16', 6, 2),
(159, '2017-05-16', 7, 2),
(160, '2017-05-16', 8, 1),
(161, '2017-05-16', 3, 1),
(162, '2017-05-16', 5, 1),
(163, '2017-05-16', 4, 1),
(164, '2017-05-17', 5, 6),
(165, '2017-05-17', 6, 2),
(166, '2017-05-17', 8, 3),
(167, '2017-05-17', 7, 16),
(168, '2017-05-17', 4, 8),
(169, '2017-05-17', 3, 21);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_youtube_chanel`
--

CREATE TABLE `tbl_youtube_chanel` (
  `id` int(10) NOT NULL,
  `type` int(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `chanel_id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `auto` int(1) NOT NULL DEFAULT '0',
  `category_ids` text NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_youtube_playlist_subscribe`
--

CREATE TABLE `tbl_youtube_playlist_subscribe` (
  `id` int(11) NOT NULL,
  `chanel_id` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `playlist_id` text NOT NULL,
  `auto` int(11) NOT NULL,
  `category_ids` text NOT NULL,
  `update_at` bigint(20) NOT NULL,
  `create_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbn_news_category`
--

CREATE TABLE `tbn_news_category` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `thumbnail` text NOT NULL,
  `icon` text NOT NULL,
  `update_at` bigint(20) NOT NULL,
  `create_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `UserPass` varchar(45) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `RoleId` tinyint(4) NOT NULL,
  `IsVip` tinyint(4) NOT NULL,
  `StatusId` tinyint(4) NOT NULL,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `Avatar` varchar(250) DEFAULT NULL,
  `Address` varchar(250) DEFAULT NULL,
  `PhoneNumber` varchar(45) DEFAULT NULL,
  `City` varchar(250) DEFAULT NULL,
  `Country` varchar(250) DEFAULT NULL,
  `Zip` varchar(45) DEFAULT NULL,
  `Token` varchar(100) DEFAULT NULL,
  `FacebookId` varchar(45) DEFAULT NULL,
  `oauth_provider` varchar(255) NOT NULL DEFAULT 'default',
  `paystack_auth_code` varchar(255) NOT NULL DEFAULT '',
  `subscribed_type` varchar(2) NOT NULL DEFAULT '',
  `subscribed_date` int(50) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `UserPass`, `Email`, `RoleId`, `IsVip`, `StatusId`, `FirstName`, `LastName`, `Avatar`, `Address`, `PhoneNumber`, `City`, `Country`, `Zip`, `Token`, `FacebookId`, `oauth_provider`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'contact@inspius.com', 1, 1, 2, 'Inspius', 'Admin', 'logo_inspius.png', '14 Robinson Road, #13-00 Far East Finance Building Singapore 048545', '(65) 8575 0171', 'Singapore', 'Singapore', '048545', '2bf486416ea43029b846', NULL, ''),
(2, '10156294377895433', '25f9e794323b453885f5181f1b624d0b', 'folababa@gmail.com', 3, 0, 2, 'Fola', 'Baba', 'https://graph.facebook.com/10156294377895433/picture?width=256&height=256?width=256&height=256', '', '', '', '', '', NULL, '10156294377895433', 'facebook');

-- --------------------------------------------------------

--
-- Table structure for table `uservideos`
--

CREATE TABLE `uservideos` (
  `UserVideoId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `VideoId` int(11) NOT NULL,
  `CrDateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `VideoId` int(11) NOT NULL,
  `VideoTitle` varchar(250) NOT NULL,
  `VideoUrl` varchar(250) NOT NULL,
  `VideoLength` int(11) NOT NULL,
  `Series` varchar(250) DEFAULT NULL,
  `VideoImage` varchar(250) DEFAULT NULL,
  `VideoDesc` text,
  `SocialUrl` varchar(250) DEFAULT NULL,
  `StatusId` tinyint(4) NOT NULL,
  `VideoTypeId` tinyint(4) NOT NULL,
  `IsVip` tinyint(4) NOT NULL,
  `DisplayHome` tinyint(4) NOT NULL,
  `ViewCount` int(11) NOT NULL DEFAULT '0',
  `ShareCount` int(11) NOT NULL DEFAULT '0',
  `LikeCount` int(11) NOT NULL DEFAULT '0',
  `DownloadCount` int(11) NOT NULL DEFAULT '0',
  `UpdateDate` datetime NOT NULL,
  `CrUserId` int(11) NOT NULL,
  `CrDateTime` datetime NOT NULL,
  `IsTrending` int(11) NOT NULL,
  `VideoKey` varchar(255) DEFAULT NULL,
  `episode_no` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`VideoId`, `VideoTitle`, `VideoUrl`, `VideoLength`, `Series`, `VideoImage`, `VideoDesc`, `SocialUrl`, `StatusId`, `VideoTypeId`, `IsVip`, `DisplayHome`, `ViewCount`, `ShareCount`, `LikeCount`, `DownloadCount`, `UpdateDate`, `CrUserId`, `CrDateTime`, `IsTrending`, `VideoKey`, `episode_no`) VALUES
(3, 'LiveScribe Smart Pen', 'https://www.youtube.com/watch?v=7cB2L-ThZXE', 381, '', 'https://i.ytimg.com/vi/7cB2L-ThZXE/maxresdefault.jpg', '<p>A magical pen that will solve all your writing issues.</p>', '', 2, 2, 1, 1, 74, 1, 0, 0, '2017-05-03 00:43:26', 1, '2017-04-12 16:22:42', 1, NULL, 1),
(4, 'Faboo', '/Faboo%20I.mp4', 0, '1', 'faboos_fw.png', '<p>Charging you phone overnight will destroy your phone\'s battery. Is it a fact or a faboo?</p>', '', 2, 1, 1, 1, 66, 2, 0, 0, '2017-05-03 14:04:02', 1, '2017-04-12 17:59:48', 1, NULL, 1),
(5, 'Digital Passion What\'s Up in Tech - Warranty Fraud', 'https://www.youtube.com/watch?v=jK03kblab4I', 1284, '', 'https://i.ytimg.com/vi/jK03kblab4I/hqdefault.jpg', '<p>Warranty fraud is simply a phenomenon where a manufacturer refuse to repair a device, despite the fact that the fault is under the terms and conditions of the warranty. WATCH, as we shed more light on WARRANTY. SUBSCRIBE TO OUR CHANNEL.. MORE POPPING OUT SOON</p>', '', 2, 2, 1, 1, 46, 0, 0, 0, '2017-04-12 18:05:26', 1, '2017-04-12 18:05:19', 0, NULL, 1),
(6, 'Digital Passion What\'s Up in Tech - Over The Top Services (OTT)', 'https://www.youtube.com/watch?v=Pbc_2w3i0UA', 2084, '', 'https://i.ytimg.com/vi/Pbc_2w3i0UA/maxresdefault.jpg', '<p>Would you rather use WhatsApp to make a phone call???? Our discussion this week is on OTT. In recent years, over-the-top communication services have created a ripple worldwide. Whatsapp, Facebook messenger, Skype and Viber &mdash; have gained over a billion users in less than five years. They are fast, easy and affordable and can be used regardless of one&rsquo;s geographical location. Moreover, they are reliable alternatives to SMS &amp; MMS. Join Folababa And Cynthia as they rant over this. SUBSCRIBE TO OUR CHANNEL.. MORE POPPING OUT SOON</p>', '', 2, 2, 1, 1, 44, 0, 0, 0, '2017-04-12 18:16:36', 1, '2017-04-12 18:16:36', 1, NULL, 1),
(7, 'One Minute Tech Tip- Hide your messages', 'https://www.youtube.com/watch?v=6hZXvAakpe4', 123, '', 'https://i.ytimg.com/vi/6hZXvAakpe4/maxresdefault.jpg', '<p>What to do when you need to hide your messages from your hubby? One Minute Tech Tip</p>', '', 2, 2, 0, 1, 65, 1, 0, 0, '2017-04-12 18:38:04', 1, '2017-04-12 18:38:04', 1, NULL, 1),
(8, 'rc car race', '20170412214808', 7, '', 'http://telebang.com/assets/uploads/images/20170412214808_thumbnail', 'car racing my rc car in the sand', '', 2, 1, 0, 1, 46, 0, 0, 0, '2017-04-12 21:48:08', 2, '2017-04-12 21:48:08', 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `videotypes`
--

CREATE TABLE `videotypes` (
  `VideoTypeId` tinyint(4) NOT NULL,
  `VideoTypeName` varchar(45) NOT NULL,
  `CssClass` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `videotypes`
--

INSERT INTO `videotypes` (`VideoTypeId`, `VideoTypeName`, `CssClass`) VALUES
(1, 'UPLOAD', 'label-info'),
(2, 'YOUTUBE', 'label-success'),
(3, 'VIMEO', 'label-warning'),
(4, 'MP3', 'label-info'),
(5, 'FACEBOOK', NULL),
(6, 'DAILY_MOTION', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vidhub_slider`
--

CREATE TABLE `vidhub_slider` (
  `sliderId` int(11) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `type` varchar(45) NOT NULL,
  `value` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vidhub_theme_config`
--

CREATE TABLE `vidhub_theme_config` (
  `site_title` varchar(255) NOT NULL,
  `site_headding` varchar(255) NOT NULL,
  `site_favicon` varchar(255) NOT NULL,
  `header_logo` varchar(255) NOT NULL,
  `footer_logo` varchar(255) NOT NULL,
  `footer_about` varchar(255) NOT NULL,
  `android_url` varchar(255) NOT NULL,
  `ios_url` varchar(255) NOT NULL,
  `facebook_url` varchar(255) NOT NULL,
  `google_url` varchar(255) NOT NULL,
  `twitter_url` varchar(255) NOT NULL,
  `youtube_url` varchar(255) NOT NULL,
  `footer_copyright` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `home_category_1` int(11) NOT NULL,
  `home_category_2` int(11) NOT NULL,
  `jwplayer_key` varchar(255) NOT NULL,
  `upload_enable` int(11) NOT NULL DEFAULT '0',
  `about_url` varchar(255) NOT NULL,
  `videos_limit` int(11) NOT NULL,
  `blogs_limit` int(11) NOT NULL,
  `comment_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vidhub_theme_config`
--

INSERT INTO `vidhub_theme_config` (`site_title`, `site_headding`, `site_favicon`, `header_logo`, `footer_logo`, `footer_about`, `android_url`, `ios_url`, `facebook_url`, `google_url`, `twitter_url`, `youtube_url`, `footer_copyright`, `id`, `home_category_1`, `home_category_2`, `jwplayer_key`, `upload_enable`, `about_url`, `videos_limit`, `blogs_limit`, `comment_limit`) VALUES
('teleBang', 'Videos and shorts', 'no_image_default.png', 'telebang.png', 'tele<span>Bang</span>', 'In this digital generation where information can be easily obtained within seconds, business cards still have retained their importance.', 'https://play.google.com/store/apps/details?id=com.inspius.yo_video', 'https://play.google.com/store/apps/details?id=com.inspius.yo365', 'https://www.facebook.com/telebang/', '#', '#', 'https://www.youtube.com/channel/UCr5CUL8tUxC2xLDcPXlFpbw/videos?view=0&shelf_id=0&sort=dd', 'Copyright © 2017 <a href=\"http://telebang.com/\">teleBang</a>. All Rights Reserved', 1, 0, 0, 'M6asZxu0Z9K3ZuxBx1TUC4VC30JC7vVnSOuIYw', 1, '0', 15, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `viewlogs`
--

CREATE TABLE `viewlogs` (
  `ViewLogId` int(11) NOT NULL,
  `VideoId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `ViewDateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryId`),
  ADD KEY `Categories_Status` (`StatusId`);

--
-- Indexes for table `categoryvideos`
--
ALTER TABLE `categoryvideos`
  ADD PRIMARY KEY (`CategoryVideoId`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`ConfigId`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`RoleId`);

--
-- Indexes for table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id_series`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`StatusId`);

--
-- Indexes for table `tbl_comment_video`
--
ALTER TABLE `tbl_comment_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_devices`
--
ALTER TABLE `tbl_devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_like_video`
--
ALTER TABLE `tbl_like_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_news_category_connect`
--
ALTER TABLE `tbl_news_category_connect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_activity`
--
ALTER TABLE `tbl_user_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_video_view`
--
ALTER TABLE `tbl_video_view`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_youtube_chanel`
--
ALTER TABLE `tbl_youtube_chanel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_youtube_playlist_subscribe`
--
ALTER TABLE `tbl_youtube_playlist_subscribe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbn_news_category`
--
ALTER TABLE `tbn_news_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`),
  ADD KEY `Users_Roles` (`RoleId`),
  ADD KEY `Users_Status` (`StatusId`);

--
-- Indexes for table `uservideos`
--
ALTER TABLE `uservideos`
  ADD PRIMARY KEY (`UserVideoId`),
  ADD KEY `UserVideos_Users` (`UserId`),
  ADD KEY `UserVideos_Videos` (`VideoId`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`VideoId`),
  ADD KEY `Videos_VideoTypes` (`VideoTypeId`),
  ADD KEY `Videos_Users` (`CrUserId`),
  ADD KEY `Videos_Status` (`StatusId`);

--
-- Indexes for table `videotypes`
--
ALTER TABLE `videotypes`
  ADD PRIMARY KEY (`VideoTypeId`);

--
-- Indexes for table `vidhub_slider`
--
ALTER TABLE `vidhub_slider`
  ADD PRIMARY KEY (`sliderId`);

--
-- Indexes for table `vidhub_theme_config`
--
ALTER TABLE `vidhub_theme_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `viewlogs`
--
ALTER TABLE `viewlogs`
  ADD PRIMARY KEY (`ViewLogId`),
  ADD KEY `ViewLogs_Videos` (`VideoId`),
  ADD KEY `ViewLogs_Users` (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryId` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `categoryvideos`
--
ALTER TABLE `categoryvideos`
  MODIFY `CategoryVideoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `series`
--
ALTER TABLE `series`
  MODIFY `id_series` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_comment_video`
--
ALTER TABLE `tbl_comment_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_devices`
--
ALTER TABLE `tbl_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_like_video`
--
ALTER TABLE `tbl_like_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_news`
--
ALTER TABLE `tbl_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_news_category_connect`
--
ALTER TABLE `tbl_news_category_connect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_user_activity`
--
ALTER TABLE `tbl_user_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_video_view`
--
ALTER TABLE `tbl_video_view`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;
--
-- AUTO_INCREMENT for table `tbl_youtube_chanel`
--
ALTER TABLE `tbl_youtube_chanel`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_youtube_playlist_subscribe`
--
ALTER TABLE `tbl_youtube_playlist_subscribe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbn_news_category`
--
ALTER TABLE `tbn_news_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `uservideos`
--
ALTER TABLE `uservideos`
  MODIFY `UserVideoId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `VideoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `vidhub_slider`
--
ALTER TABLE `vidhub_slider`
  MODIFY `sliderId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vidhub_theme_config`
--
ALTER TABLE `vidhub_theme_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `viewlogs`
--
ALTER TABLE `viewlogs`
  MODIFY `ViewLogId` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
