-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 15, 2017 at 02:19 PM
-- Server version: 5.7.11
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `camagru`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `img_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `comment` varchar(16000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `img_id`, `created_at`, `comment`) VALUES
(91, 2, 4, '2017-09-15 11:37:28', 'Ce feed de genie'),
(92, 2, 5, '2017-09-15 13:05:09', 'Ce feed de genie'),
(93, 2, 2, '2017-09-15 13:05:57', 'Yihhaaaa'),
(94, 2, 7, '2017-09-15 13:24:02', 'Des chevals !'),
(95, 9, 7, '2017-09-15 13:25:02', 'Je suis une licorne hiiihaaaaaaa 🦄'),
(96, 9, 7, '2017-09-15 13:58:26', 'Pour ta gouverne 🤓'),
(97, 3, 6, '2017-09-15 14:02:44', 'Regarde ma langue 👅'),
(98, 2, 6, '2017-09-15 14:03:09', 'IMPRESSIONNANT 😡'),
(99, 10, 8, '2017-09-15 14:05:06', 'Srious code #42born2code 😎'),
(100, 10, 3, '2017-09-15 14:06:03', 'Soit 😨'),
(101, 10, 5, '2017-09-15 14:09:02', '<script>alert(\'je té haké lol\');</script>'),
(102, 10, 4, '2017-09-15 14:10:34', '\';DROP TABLE users;'),
(103, 2, 8, '2017-09-15 14:26:17', 'Parfait 🤑'),
(104, 9, 8, '2017-09-15 14:42:07', 'J\'ai mal au node 😭  🤕'),
(105, 9, 8, '2017-09-15 14:43:26', 'coucou le internet'),
(106, 9, 9, '2017-09-15 14:47:54', 'camagru fusion'),
(107, 2, 11, '2017-09-15 15:02:07', 'Scary screen 😰'),
(108, 2, 9, '2017-09-15 15:02:26', 'I like the swag 👻'),
(109, 11, 9, '2017-09-15 15:27:26', ''),
(110, 11, 9, '2017-09-15 15:27:31', '🤡');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `src` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `src`, `user_id`, `created_at`) VALUES
(2, 'photo-59bb9f2b805f0.png', 2, '2017-09-15 11:36:43'),
(3, 'photo-59bb9f3622c7b.png', 2, '2017-09-15 11:36:54'),
(4, 'photo-59bb9f452a414.png', 2, '2017-09-15 11:37:09'),
(5, 'photo-59bb9f706e4d3.png', 2, '2017-09-15 11:37:52'),
(6, 'photo-59bbb75ab71bd.png', 3, '2017-09-15 13:19:54'),
(7, 'photo-59bbb7c12e036.png', 9, '2017-09-15 13:21:37'),
(8, 'photo-59bbc1d2516c8.png', 10, '2017-09-15 14:04:34'),
(9, 'photo-59bbcbea38bbf.png', 9, '2017-09-15 14:47:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password_reset_hash` varchar(64) DEFAULT NULL,
  `password_reset_expires_at` datetime DEFAULT NULL,
  `activation_hash` varchar(64) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `password_reset_hash`, `password_reset_expires_at`, `activation_hash`, `is_active`) VALUES
(2, 'bendur', 'litab@morsin.com', '$2y$10$etwc8hM3mpyyW9TirmQypezxBf/MQ0BaHr2BvALemf5ACfxGoH45a', NULL, NULL, NULL, 1),
(3, 'pkirsch', 'qljdqwejkdbjfe@eklfwefw.com', '$2y$10$OnRc8LB8TmfRty/iZPjuge12Pb3.9zLzXZQDmU60zM6s/EmUHzH9e', NULL, NULL, 'ef047ec13304ba79de47b67ee7b212ed3b07d0eb3aed2f490b87a538dbd22ec2', 1),
(4, 'jean-pierre', 'woeifweif2e@oierjg.com', '$2y$10$N2SNTdVixtEiD3817NGEFuYBXROe7nU1GzDTB4k81ekjd3v1ugLeW', NULL, NULL, '10d1476045ba03e9324fc9175088779dcd7dd7baa3128cbbb9a8629965846cff', 1),
(5, 'mcgregor', 'owfhwehfwu@fowifiwefwef.com', '$2y$10$WQwYNyvLdXFDZe4UAC7Xj.V2S15dgcaOjcN6X4KpvsKroatbgI5r6', NULL, NULL, 'f3ac7f1f1cb65d443f3e354adaa73e86ff2ba8a5a58d7a45a3db12491e68abdf', 1),
(6, 'mayweather', 'qoedwef@woeifweoif.com', '$2y$10$6YcM01KeRBFeE2UEAJQ.SuVhG5BisJl3OGPPfUME9DPrp4BT3dol6', NULL, NULL, '095c72bcd60fe0bf5b3e955d8ab633653f477523e4c2b0cc1036370f45e890c6', 1),
(7, 'tyson', 'wewefoihf@woiefweifj.com', '$2y$10$pjvXTUpip9Quu2HVdkxu1.0HPavX8CGhxMFR1siPLa7pyAJQgQk6S', NULL, NULL, 'cef1fa5a69ffe81e4cd91a44d062879a29946c2e090de48326a833872c9c6c4d', 1),
(8, 'schumacher', 'woiefjwoifh@woifwoeihfwef.com', '$2y$10$vSKD4wU9yNkYRPH1AGySq.Sb2HibiMns/JfxTWaTTOvxzSkZQ0j4C', NULL, NULL, '513a160712d4e0696db6fb725994f5e74454f41b881a583145a68cb0cffb8521', 1),
(9, 'gduron', 'ebwfiub@woeifjwefj.com', '$2y$10$WfpiFf72D/GQAcQJ3yfaE.IMZcXKm/uCDcOAeuM0n1aq.YQHU5h8e', NULL, NULL, '1fd65fd54dd271adf918e4b2ceaf8d0269ba17863da2fd33c9f83e65f4b166e7', 1),
(10, 'awyart', 'qedweifuew@ohfweohif.com', '$2y$10$TigW9JmlSyg1EVx4Zav9x.hUOf.Q71sNkOHDtr4VEu1xN1L7KP5de', NULL, NULL, '647207658de0f8630437f6051b0de75dda74eb44e5d4d828b1ea854e4b3f10d3', 1),
(11, 'Sabbah', 'solal.sabbah@gmail.com', '$2y$10$XoAdy6j2cUfjecwqtHrYOO6YfwE31GfpfY9gnFvAGca83ISRHAkNW', NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `password_reset_hash` (`password_reset_hash`),
  ADD UNIQUE KEY `activation_hash` (`activation_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
