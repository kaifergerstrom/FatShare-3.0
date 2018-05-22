-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2018 at 04:52 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fatshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `sent_by` varchar(8) NOT NULL,
  `sent_to` varchar(8) NOT NULL,
  `chat_id` varchar(8) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `sent_by`, `sent_to`, `chat_id`, `date`) VALUES
(1, '5ae650f9', '2131231', '5ae681c5', '2018-04-29 09:39:01'),
(2, '5ae650f9', '4534535', '5ae681c5', '2018-04-29 09:39:01'),
(3, '5ae650f9', '4534535', '5b037f64', '2018-05-21 09:24:36'),
(4, '5ae650f9', '2131231', '5b037f68', '2018-05-21 09:24:40'),
(5, '5ae650f9', '4534535', '5b037f68', '2018-05-21 09:24:40'),
(6, '5ae650f9', '2131231', '5b037f6c', '2018-05-21 09:24:44');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `comment_id` varchar(8) NOT NULL,
  `comment` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment_id`, `comment`) VALUES
(1, '5ae67fd8', '5ae650f9', '2313213', 'Dude this photo is awesome!'),
(2, '5ae6801d', '5ae650f9', '2313213', 'This photo!');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `sent_by` varchar(8) NOT NULL,
  `sent_to` varchar(8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `sent_by`, `sent_to`, `status`, `date`) VALUES
(1, '5ae650f9', '2131231', 1, '0000-00-00 00:00:00'),
(2, '5ae650f9', '4534535', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `post_id` varchar(8) NOT NULL,
  `file` varchar(60) NOT NULL,
  `type` char(1) NOT NULL DEFAULT 't',
  `description` longtext NOT NULL,
  `date` datetime NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `dislikes` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_id`, `file`, `type`, `description`, `date`, `likes`, `dislikes`) VALUES
(1, '5ae650f9', '5ae67fb7', '1525055416.PNG', 'p', '', '2018-04-29 09:30:15', 0, 0),
(2, '5ae650f9', '5ae67fc2', '1525055427.jpg', 'p', '', '2018-04-29 09:30:26', 0, 0),
(3, '2131231', '5ae67fd8', '1525055449.jpg', 'p', 'noice', '2018-04-29 09:30:48', 0, 0),
(4, '2131231', '5ae67fe1', '', 't', 'I like FatShare a lot\r\n', '2018-04-29 09:30:57', 0, 0),
(5, '5ae650f9', '5ae67fea', '', 't', 'Hahaha', '2018-04-29 09:31:06', 0, 0),
(6, '5ae650f9', '5ae6801d', '1525055517.jpg', 'p', 'look!', '2018-04-29 09:31:57', 0, 0),
(7, '5ae650f9', '5b037f5f', '1526955872.png', 'p', '', '2018-05-21 09:24:31', 0, 0),
(8, '5ae650f9', '5b03816e', '1526956399.png', 'p', '', '2018-05-21 09:33:18', 0, 0),
(9, '5ae650f9', '5b038253', '1526956628.PNG', 'p', '', '2018-05-21 09:37:07', 0, 0),
(10, '5ae650f9', '5b0382e1', '1526956769.PNG', 'p', '', '2018-05-21 09:39:29', 0, 0),
(11, '5ae650f9', '5b0385ca', '1526957514.PNG', 'p', '', '2018-05-21 09:51:54', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` text NOT NULL,
  `profile_img` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `account_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `password`, `firstname`, `lastname`, `email`, `profile_img`, `description`, `locked`, `last_login`, `account_created`) VALUES
(1, '2131231', '44bb5143c5378f1a8ce979547807d082', 'Fake', 'Person', 'john@doe.net', 'dog.jpg', 'Hello i am a bot created by Kai', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, '5ae650f9', '44bb5143c5378f1a8ce979547807d082', 'John', 'Doe', 'kaifergerstrom@gmail.com', 'default.png', '', 0, '0000-00-00 00:00:00', '2018-04-29 06:11:42'),
(6, '4534535', '44bb5143c5378f1a8ce979547807d082', 'Jane', 'Doe', 'Jane@doe.net', 'test.jpg', 'Fake bot 2 by kai', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
