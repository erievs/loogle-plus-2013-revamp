-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 17, 2024 at 05:52 PM
-- Server version: 8.0.36-0ubuntu0.23.10.1
-- PHP Version: 8.2.10-2ubuntu1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loogle_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `apiv1_tokens`
--

CREATE TABLE `apiv1_tokens` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `token_name` varchar(255) DEFAULT NULL,
  `token_value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int NOT NULL,
  `post_id` int DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `comment_content` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `communities`
--

CREATE TABLE `communities` (
  `community_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `members` int DEFAULT '0',
  `members_list` text,
  `image_url` varchar(255) DEFAULT NULL,
  `creator_username` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `communities`
--

INSERT INTO `communities` (`community_id`, `name`, `description`, `members`, `members_list`, `image_url`, `creator_username`, `display_name`) VALUES
(1, 'f', '', -5, 'owner,member,member,member,d:member', '', 'd', 'eqeqqe'),
(2, 'ffff_ffffff_', 'ff', 1, 'd:owner', '', 'd', 'fffff ffffff'),
(3, 'Minecraft_Fan_Group', '', 1, 'd:owner', '', 'd', 'minecraft support forup'),
(4, 'eqe', 'qe', 0, 'd:owner', NULL, 'd', 'eqe'),
(5, 'XX', 'xx', 1, 'd:owner', NULL, 'd', 'XX'),
(6, 'Minecraft Cool Group', 'minecraft cool group', 1, 'd:owner', NULL, 'd', 'Minecraft Cool Group'),
(7, 'e', 'e', 1, 'd:owner', NULL, 'd', 'e'),
(8, 'f', 'g', 1, 'd:owner', NULL, 'd', 'f'),
(9, 'u', 'rr', 1, 'd:owner', NULL, 'd', 'u'),
(10, 'bobevans', 'yum', 1, 'KSPortalcraft:owner', NULL, 'KSPortalcraft', 'bobevans'),
(11, 'yest', 'ff', 1, 'KSPortalcraft:owner', NULL, 'KSPortalcraft', 'yest'),
(12, 'ff', 'ff', 1, 'KSPortalcraft:owner', NULL, 'KSPortalcraft', 'ff'),
(13, 'vvv', 'vvvv', 1, 'KSPortalcraft:owner', NULL, 'KSPortalcraft', 'vvv');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int NOT NULL,
  `follower_id` varchar(255) NOT NULL,
  `following_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `follower_id`, `following_id`, `created_at`) VALUES
(366, 'KSPortalcraft', 'ben', '2023-08-31 23:19:26'),
(368, 'KSPortalcraft', 'ben1', '2023-08-31 23:24:17'),
(369, 'KSPortalcraft', 'KSPortalcraft', '2023-09-01 00:12:22'),
(377, 'KSPortalcraft', 'dover', '2023-09-01 00:21:03'),
(378, 'name', 'd', '2023-09-08 02:51:11'),
(379, 'name', 'dover', '2023-09-08 02:51:13'),
(380, 'name', 'ben', '2023-09-08 03:57:52'),
(381, 'root', 'KSPortalcraft', '2023-09-09 05:04:13'),
(382, 'root', 'd', '2023-09-09 05:04:14'),
(383, 'root', 'Ben Dover', '2023-09-09 05:04:15'),
(384, 'root', 'ben', '2023-09-09 05:04:15'),
(385, 'root', 'ben1', '2023-09-09 05:04:16'),
(386, 'root', 'root', '2023-09-09 05:04:17'),
(388, 'root', 'bend', '2023-09-09 05:04:18'),
(389, 'root', 'name', '2023-09-09 05:04:19'),
(390, 'root', 'dover', '2023-09-09 05:04:20'),
(391, 'root', 'ben3', '2023-09-09 05:04:21'),
(392, 'root', 'kspc', '2023-09-09 05:04:22'),
(393, 'd', 'Ben Dover', '2023-09-13 20:45:20'),
(394, 'd', 'ben', '2023-09-13 20:45:20'),
(396, 'd', 'name', '2023-09-13 20:59:18'),
(403, 'd', 'dover', '2023-10-14 05:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `moderators`
--

CREATE TABLE `moderators` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moderators`
--

INSERT INTO `moderators` (`id`, `username`) VALUES
(1, 'd'),
(2, 'name');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_status` tinyint(1) DEFAULT '0',
  `sender` varchar(255) NOT NULL,
  `post_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `recipient`, `content`, `created_at`, `read_status`, `sender`, `post_id`) VALUES
(9, 'd', 'Mentioned you in a post!', '2023-10-18 04:07:57', 1, 'd', 148),
(10, 'd', 'Mentioned you in a post!', '2023-10-18 04:46:56', 1, 'd', 149);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `content` text,
  `image_url` varchar(255) DEFAULT NULL,
  `image_link_url` varchar(255) DEFAULT NULL,
  `post_link_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `username`, `content`, `image_url`, `image_link_url`, `post_link_url`, `created_at`, `post_link`) VALUES
(183, 'test', 'test', NULL, NULL, NULL, '2024-03-17 17:19:38', NULL),
(184, 'test', 'test', NULL, NULL, NULL, '2024-03-17 17:19:42', NULL),
(185, 'dff', 'ass', '', NULL, NULL, '2024-03-17 17:26:42', NULL),
(186, 'dff', 'hi', '', NULL, NULL, '2024-03-17 17:26:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apiv1_tokens`
--
ALTER TABLE `apiv1_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `communities`
--
ALTER TABLE `communities`
  ADD PRIMARY KEY (`community_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moderators`
--
ALTER TABLE `moderators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apiv1_tokens`
--
ALTER TABLE `apiv1_tokens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `communities`
--
ALTER TABLE `communities`
  MODIFY `community_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404;

--
-- AUTO_INCREMENT for table `moderators`
--
ALTER TABLE `moderators`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apiv1_tokens`
--
ALTER TABLE `apiv1_tokens`
  ADD CONSTRAINT `apiv1_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
