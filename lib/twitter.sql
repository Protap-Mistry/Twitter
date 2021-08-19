-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2021 at 07:50 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitter`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `date`) VALUES
(6, 8, 3, 'Well-done!!! bro.', '2021-08-04 06:38:32'),
(7, 3, 3, 'A big welcome from me.', '2021-08-04 06:42:31'),
(8, 1, 3, 'Please, remove it.', '2021-08-04 14:44:32'),
(9, 8, 1, 'Thanks buddy !', '2021-08-04 16:48:45'),
(10, 23, 1, 'Good job, buddy.', '2021-08-05 17:15:41'),
(11, 31, 3, 'Take a  huge love...', '2021-08-07 05:53:38'),
(12, 65, 1, 'Hello!!! buddy', '2021-08-08 16:42:06'),
(13, 65, 1, 'How are you?', '2021-08-08 16:53:21'),
(14, 67, 1, 'hello', '2021-08-08 18:02:44'),
(15, 67, 1, 'sedrftg', '2021-08-08 18:03:01'),
(16, 33, 1, 'Love...', '2021-08-08 19:20:00'),
(17, 60, 1, 'Successfull...', '2021-08-09 05:11:50'),
(18, 33, 6, 'Friends forever...', '2021-08-09 10:05:58'),
(19, 63, 4, 'Yes, @Armaan', '2021-08-09 12:51:26'),
(20, 69, 4, 'well choose...', '2021-08-09 17:03:51');

-- --------------------------------------------------------

--
-- Table structure for table `dislikes`
--

CREATE TABLE `dislikes` (
  `dislike_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dislikes`
--

INSERT INTO `dislikes` (`dislike_id`, `post_id`, `user_id`) VALUES
(1, 68, 1),
(2, 60, 1),
(3, 61, 3),
(4, 60, 3),
(5, 64, 5),
(6, 60, 5),
(7, 62, 4),
(8, 64, 2),
(9, 0, 3),
(10, 0, 3),
(11, 106, 3),
(12, 0, 3),
(13, 104, 3),
(14, 101, 3),
(15, 0, 3),
(16, 82, 3),
(17, 68, 3),
(18, 106, 1);

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `sender_id`, `receiver_id`) VALUES
(10, 3, 1),
(13, 1, 3),
(14, 5, 3),
(15, 5, 1),
(16, 1, 5),
(17, 2, 4),
(18, 4, 2),
(19, 5, 4),
(20, 4, 5),
(21, 1, 6),
(22, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `post_id`, `user_id`) VALUES
(1, 8, 3),
(2, 3, 3),
(3, 23, 1),
(4, 9, 1),
(5, 8, 1),
(6, 24, 1),
(7, 27, 3),
(8, 59, 1),
(9, 58, 2),
(10, 65, 1),
(11, 61, 1),
(12, 67, 1),
(13, 63, 1),
(14, 41, 1),
(15, 43, 1),
(16, 33, 1),
(17, 68, 4),
(18, 69, 4),
(19, 60, 1),
(20, 68, 1),
(21, 64, 4),
(22, 68, 3),
(23, 106, 3),
(24, 104, 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notify_id` int(11) NOT NULL,
  `notify_receiver_id` int(11) NOT NULL,
  `notify_text` text NOT NULL,
  `read_notify` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notify_id`, `notify_receiver_id`, `notify_text`, `read_notify`) VALUES
(5, 4, '<b>Mr. PRO</b> has share new post(s)', 'yes'),
(6, 3, '<b>Armaan</b> has share new post(s)', 'yes'),
(7, 1, '<b>Armaan</b> has share new post(s)', 'yes'),
(8, 4, '<b>Armaan</b> has share new post(s)', 'yes'),
(9, 4, '<b>Armaan</b> has share new post(s)', 'yes'),
(10, 2, '<b>Taha</b> has share new post(s)', 'no'),
(11, 1, '<b>Sarw</b> has share new post(s)', 'yes'),
(12, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(13, 5, '<b>The_PRO</b> has share new post(s)', 'yes'),
(14, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(15, 5, '<b>The_PRO</b> has share new post(s)', 'yes'),
(16, 5, '<b>The_PRO</b> has comment on your post- \"Testing......\"', 'yes'),
(17, 1, '<b>Armaan</b> has repost your post- \"Notification test...\"', 'yes'),
(18, 5, '<b>The_PRO</b> has like your post- \"\r\n...\"', 'yes'),
(19, 5, '<b>The_PRO</b> has like your post- \"\r\n...\"', 'yes'),
(20, 4, '<b>Armaan</b> has follow you.', 'yes'),
(21, 3, '<b>The_PRO</b> has like your post- \"\r\n...\"', 'yes'),
(22, 1, '<b>Pranta</b> has follow you.', 'yes'),
(23, 3, '<b>Pranta</b> has follow you.', 'yes'),
(24, 3, '<b>Pranta</b> has love react your post- \"\r\n...\"', 'yes'),
(25, 3, '<b>Pranta</b> has love react your post- \"\r\n...\"', 'yes'),
(26, 3, '<b>Pranta</b> has comment on your post- \"\r\n...\"', 'yes'),
(27, 5, '<b>Taha</b> has like your post- \"Notification test...\"', 'yes'),
(28, 5, '<b>Taha</b> has comment on your post- \"Hello !!! @Taha...\"', 'yes'),
(29, 2, '<b>Taha</b> has love react your post- \"...\"', 'no'),
(30, 6, '<b>Taha</b> has like your post- \"\r\n...\"', 'yes'),
(31, 6, '<b>Taha</b> has comment on your post- \"\r\n...\"', 'yes'),
(32, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(33, 5, '<b>The_PRO</b> has share new post(s)', 'yes'),
(34, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(35, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(36, 5, '<b>The_PRO</b> has share new post(s)', 'yes'),
(37, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(38, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(39, 5, '<b>The_PRO</b> has share new post(s)', 'yes'),
(40, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(41, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(42, 5, '<b>The_PRO</b> has share new post(s)', 'yes'),
(43, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(44, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(45, 5, '<b>The_PRO</b> has share new post(s)', 'yes'),
(46, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(47, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(48, 5, '<b>The_PRO</b> has share new post(s)', 'yes'),
(49, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(50, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(51, 5, '<b>The_PRO</b> has share new post(s)', 'yes'),
(52, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(53, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(54, 5, '<b>The_PRO</b> has share new post(s)', 'yes'),
(55, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(56, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(57, 5, '<b>The_PRO</b> has share new post(s)', 'yes'),
(58, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(59, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(60, 5, '<b>The_PRO</b> has share new post(s)', 'yes'),
(61, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(62, 5, '<b>The_PRO</b> has like your post- \"Testing......\"', 'yes'),
(63, 5, '<b>The_PRO</b> has like your post- \"Notification test...\"', 'yes'),
(64, 3, '<b>The_PRO</b> has love react your post- \"Hello !!! @The_PRO...\"', 'yes'),
(65, 5, '<b>The_PRO</b> has love react your post- \"Testing......\"', 'yes'),
(66, 5, '<b>The_PRO</b> has love react your post- \"Hello !!! @Taha...\"', 'yes'),
(67, 5, '<b>The_PRO</b> has dislike your post- \"Notification test...\"', 'yes'),
(68, 5, '<b>The_PRO</b> has dislike your post- \"Testing......\"', 'yes'),
(69, 1, '<b>Sarw</b> has dislike your post- \"Notification test...\"', 'yes'),
(70, 5, '<b>Sarw</b> has dislike your post- \"Testing......\"', 'yes'),
(71, 4, '<b>Armaan</b> has dislike your post- \"Hi, @Armaan...\"', 'no'),
(72, 5, '<b>Armaan</b> has dislike your post- \"Testing......\"', 'no'),
(73, 4, '<b>Taha</b> has like your post- \"Hi, @Armaan...\"', 'no'),
(74, 2, '<b>Taha</b> has dislike your post- \"notify check !!!...\"', 'no'),
(75, 4, '<b>Mr. PRO</b> has dislike your post- \"Hi, @Armaan...\"', 'no'),
(76, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(77, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(78, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(79, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(80, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(81, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(82, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(83, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(84, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(85, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(86, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(87, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(88, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(89, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(90, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(91, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(92, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(93, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(94, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(95, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(96, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(97, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(98, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(99, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(100, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(101, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(102, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(103, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(104, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(105, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(106, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(107, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(108, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(109, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(110, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(111, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(112, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(113, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(114, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(115, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(116, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(117, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(118, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(119, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(120, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(121, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(122, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(123, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(124, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(125, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(126, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(127, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(128, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(129, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(130, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(131, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(132, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(133, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(134, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(135, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(136, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(137, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(138, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(139, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(140, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(141, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(142, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(143, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(144, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(145, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(146, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(147, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(148, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(149, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(150, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(151, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(152, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(153, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(154, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(155, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(156, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(157, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(158, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(159, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(160, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(161, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(162, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(163, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(164, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(165, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(166, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(167, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(168, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(169, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(170, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(171, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(172, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(173, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(174, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(175, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(176, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(177, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(178, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(179, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(180, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(181, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(182, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(183, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(184, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(185, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(186, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(187, 3, '<b>The_PRO</b> has share new post(s)', 'yes'),
(188, 5, '<b>The_PRO</b> has share new post(s)', 'no'),
(189, 6, '<b>The_PRO</b> has share new post(s)', 'no'),
(190, 5, '<b>Sarw</b> has like your post- \"Notification test...\"', 'no'),
(191, 1, '<b>Sarw</b> has share new post(s)', 'yes'),
(192, 6, '<b>Sarw</b> has share new post(s)', 'no'),
(193, 1, '<b>Sarw</b> has share new post(s)', 'yes'),
(194, 6, '<b>Sarw</b> has share new post(s)', 'no'),
(195, 1, '<b>Sarw</b> has share new post(s)', 'yes'),
(196, 6, '<b>Sarw</b> has share new post(s)', 'no'),
(197, 1, '<b>Sarw</b> has share new post(s)', 'yes'),
(198, 6, '<b>Sarw</b> has share new post(s)', 'no'),
(199, 1, '<b>Sarw</b> has share new post(s)', 'yes'),
(200, 6, '<b>Sarw</b> has share new post(s)', 'no'),
(201, 3, '<b>Sarw</b> has like your post- \"https://www.youtube.com/...\"', 'yes'),
(202, 3, '<b>Sarw</b> has dislike your post- \"https://www.youtube.com/...\"', 'no'),
(203, 3, '<b>Sarw</b> has dislike your post- \"\r\n...\"', 'no'),
(204, 3, '<b>Sarw</b> has like your post- \"\r\n...\"', 'no'),
(205, 1, '<b>Sarw</b> has dislike your post- \"test update 2...\"', 'yes'),
(206, 1, '<b>Sarw</b> has dislike your post- \"https://twitter.com/Twitter?re...\"', 'yes'),
(207, 5, '<b>Sarw</b> has dislike your post- \"Notification test...\"', 'no'),
(208, 3, '<b>The_PRO</b> has dislike your post- \"https://www.youtube.com/...\"', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post` text NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `post`, `date`) VALUES
(3, 1, 'Another success', '2021-08-02 06:41:16'),
(4, 1, 'Congrats !!!', '2021-08-02 06:47:59'),
(5, 3, 'My first content...', '2021-08-02 17:06:54'),
(6, 1, 'Recent post\r\n', '2021-08-04 04:34:17'),
(7, 3, 'My Second content', '2021-08-04 04:36:25'),
(8, 1, 'Yeah!!! solved it.', '2021-08-04 06:33:35'),
(23, 3, 'Yeah!!! solved it.', '2021-08-05 09:05:42'),
(24, 1, 'Google LLC is an American multinational technology company that specializes in Internet-related services and products, which include online advertising technologies, a search engine, cloud computing, ', '2021-08-06 04:59:18'),
(27, 1, '\r\n<p><img src=\"images/b3.jpg\" class=\"img-responsive img-thumbnail\"></p><br>', '2021-08-06 07:32:35'),
(30, 1, '\r\n<div class=\"embed-responsive embed-responsive-16by9\">\r\n				<video class=\"embed-responsive-item\" controls=\"controls\" src=\"images/17_Prishta_AnyMaza.Com.mp3\"> </video> </div>', '2021-08-07 05:49:21'),
(32, 3, '\r\n<div class=\"embed-responsive embed-responsive-16by9\">\r\n				<video class=\"embed-responsive-item\" controls=\"controls\" src=\"images/PSY_Hyuna_Style_ft_Bestwap_HD.mp4\"> </video> </div>', '2021-08-07 06:09:49'),
(33, 3, '\r\n<p><img src=\"images/we.PNG\" class=\"img-responsive img-thumbnail\"></p>Combination', '2021-08-07 06:11:02'),
(42, 5, 'My first post', '2021-08-07 08:59:00'),
(43, 5, '\r\n<p><img src=\"images/laravel.png\" class=\"img-responsive img-thumbnail\"></p>PHP\'s best framework...', '2021-08-07 08:59:43'),
(44, 5, '\r\n<p><img src=\"images/vuejs.jpg\" class=\"img-responsive img-thumbnail\"></p><br>', '2021-08-07 09:11:55'),
(45, 4, 'My first post here...', '2021-08-07 09:28:13'),
(46, 4, '\r\n<p><img src=\"images/my birthday.PNG\" class=\"img-responsive img-thumbnail\"></p><br>', '2021-08-07 09:28:30'),
(47, 4, '\r\n<p><img src=\"images/google.png\" class=\"img-responsive img-thumbnail\"></p><br>', '2021-08-07 09:29:16'),
(48, 2, '\r\n<p><img src=\"images/laravel2.png\" class=\"img-responsive img-thumbnail\" width=\"100px\" height=\"80px\"></p><br>', '2021-08-07 09:42:50'),
(49, 2, '\r\n<p><img src=\"images/laravel2.png\" class=\"img-responsive img-thumbnail\" width=\"500px\" height=\"300px\"></p><br>', '2021-08-07 09:44:09'),
(58, 2, '<p><a href=\"https://about.twitter.com/en\">https://about.twitter.com/en</a></p><img src=\"https://cdn.cms-twdigitalassets.com/content/dam/about-twitter/global/about-og-image-1200x630.jpg.twimg.768.jpg\" class=\"img-responsive img-thumbnail\"><h3><b>About Twitter | Our company and priorities</b></h3><p>We serve the public conversation. Learn more about Twitter the company, and how we ensure people have a free and safe place to talk.</p>', '2021-08-07 17:04:42'),
(59, 1, '<p><a href=\"https://en.wikipedia.org/wiki/Twitter\">https://en.wikipedia.org/wiki/Twitter</a></p><img src=\"https://upload.wikimedia.org/wikipedia/en/2/20/Twitter_Home_Page_%28Moments_version%2C_countries_without_dedicated_feed%29.png\" class=\"img-responsive img-thumbnail\"><h3><b>Twitter - Wikipedia</b></h3><p>undefined</p>', '2021-08-08 07:29:18'),
(60, 5, 'Testing...', '2021-08-08 07:41:27'),
(61, 1, 'Notification test', '2021-08-08 08:52:19'),
(62, 2, 'notify check !!!', '2021-08-08 08:57:54'),
(63, 5, 'Hello !!! @Taha', '2021-08-08 09:00:11'),
(64, 4, 'Hi, @Armaan', '2021-08-08 09:03:22'),
(65, 3, 'Hey !!! @The_PRO', '2021-08-08 09:06:44'),
(68, 5, 'Notification test', '2021-08-09 05:34:08'),
(69, 6, '\r\n<p><img src=\"images/django.png\" class=\"img-responsive img-thumbnail\" width=\"500px\" height=\"300px\"></p><br>', '2021-08-09 09:55:52'),
(82, 1, 'https://twitter.com/Twitter?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor', '2021-08-13 10:51:49'),
(101, 1, 'test update 2', '2021-08-13 11:59:31'),
(104, 3, '\r\n<p><img src=\"images/s2.JPG\" class=\"img-responsive img-thumbnail\" width=\"500px\" height=\"300px\"></p><br>', '2021-08-15 07:19:14'),
(106, 3, 'https://www.youtube.com/', '2021-08-15 07:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `repost`
--

CREATE TABLE `repost` (
  `repost_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `repost`
--

INSERT INTO `repost` (`repost_id`, `post_id`, `user_id`) VALUES
(9, 8, 3),
(10, 61, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `follower_number` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `image`, `bio`, `follower_number`) VALUES
(1, 'Protap Mistry', 'The_PRO', 'pro.cse4.bu@gmail.com', 'cc7d744dd71d2f11276b6cf44a19efe0', 'images/d8a3142b68.png', '						    							    	Hello!						    	\r\n						    						    						    ', 3),
(2, 'Protap Mistry', 'Mr. PRO', 'protapmstr@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 1),
(3, 'Sarwar Hossain', 'Sarw', 'sarwar.cse4.bu@gmail.com', '80e361830cffb4220e091bd58e1829d4', '', '', 2),
(4, 'Taha Hussain', 'Taha', 'taha@gmail.com', '3499f5efb34d41d7edc25e115d2a6d94', '', '						    							    ', 2),
(5, 'SK Ali Armaan', 'Armaan', 'armaan@gmail.com', 'a048138e82257d2b17a06b5a58cb6499', '', '', 4),
(6, 'Pranta Biswas', 'Pranta', 'pranta.cse4.bu@gmail.com', '577d21f6b8640633a21ced43076a22b6', '', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dislikes`
--
ALTER TABLE `dislikes`
  ADD PRIMARY KEY (`dislike_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notify_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `repost`
--
ALTER TABLE `repost`
  ADD PRIMARY KEY (`repost_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `dislikes`
--
ALTER TABLE `dislikes`
  MODIFY `dislike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notify_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `repost`
--
ALTER TABLE `repost`
  MODIFY `repost_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
