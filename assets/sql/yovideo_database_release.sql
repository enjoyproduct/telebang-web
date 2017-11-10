-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 12, 2017 at 07:11 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yovideo_release`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `categoryvideos`
--

CREATE TABLE `categoryvideos` (
  `CategoryVideoId` int(11) NOT NULL,
  `VideoId` int(11) NOT NULL,
  `CategoryId` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(3, 'ADMIN_EMAIL', 'contact@inspius.com'),
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
  `oauth_provider` varchar(255) NOT NULL DEFAULT 'default'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `UserPass`, `Email`, `RoleId`, `IsVip`, `StatusId`, `FirstName`, `LastName`, `Avatar`, `Address`, `PhoneNumber`, `City`, `Country`, `Zip`, `Token`, `FacebookId`, `oauth_provider`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'contact@inspius.com', 1, 1, 2, 'Inspius', 'Admin', 'logo_inspius.png', '14 Robinson Road, #13-00 Far East Finance Building Singapore 048545', '(65) 8575 0171', 'Singapore', 'Singapore', '048545', '2bf486416ea43029b846', NULL, '');

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
  MODIFY `CategoryId` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `categoryvideos`
--
ALTER TABLE `categoryvideos`
  MODIFY `CategoryVideoId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `series`
--
ALTER TABLE `series`
  MODIFY `id_series` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_comment_video`
--
ALTER TABLE `tbl_comment_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_like_video`
--
ALTER TABLE `tbl_like_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `tbl_user_activity`
--
ALTER TABLE `tbl_user_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_video_view`
--
ALTER TABLE `tbl_video_view`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbn_news_category`
--
ALTER TABLE `tbn_news_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `uservideos`
--
ALTER TABLE `uservideos`
  MODIFY `UserVideoId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `VideoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `viewlogs`
--
ALTER TABLE `viewlogs`
  MODIFY `ViewLogId` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
