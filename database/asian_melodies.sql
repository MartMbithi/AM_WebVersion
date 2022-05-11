-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 09, 2022 at 03:03 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asian_melodies`
--

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `fav_id` int(200) NOT NULL,
  `fav_logged_in_user_id` int(200) NOT NULL,
  `fav_user_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mailer_settings`
--

CREATE TABLE `mailer_settings` (
  `mailer_host` varchar(200) DEFAULT NULL,
  `mailer_port` varchar(200) DEFAULT NULL,
  `mailer_protocol` varchar(200) DEFAULT NULL,
  `mailer_username` varchar(200) DEFAULT NULL,
  `mailer_mail_from_name` varchar(200) DEFAULT NULL,
  `mailer_mail_from_email` varchar(200) DEFAULT NULL,
  `mailer_password` varchar(200) DEFAULT NULL,
  `id` int(20) NOT NULL,
  `hosted_logo_link` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mailer_settings`
--

INSERT INTO `mailer_settings` (`mailer_host`, `mailer_port`, `mailer_protocol`, `mailer_username`, `mailer_mail_from_name`, `mailer_mail_from_email`, `mailer_password`, `id`, `hosted_logo_link`) VALUES
('', '465', 'ssl', '', 'Asian Melodies', '', '', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `match_id` int(200) NOT NULL,
  `match_first_patner_id` int(200) NOT NULL,
  `match_second_partner_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`) VALUES
(1, 1142073906, 373740161, 'Hey buddy]'),
(2, 1142073906, 373740161, 'Hows Ya ass  living'),
(3, 373740161, 1142073906, 'Living Great buddy'),
(4, 1142073906, 373740161, 'What a nice day'),
(5, 373740161, 1142073906, 'hola'),
(6, 1142073906, 373740161, 'wassup'),
(7, 373740161, 1142073906, 'shiet'),
(8, 1227425642, 1225274256, 'hey'),
(9, 1227425642, 1225274256, 'How you doing'),
(10, 1225274256, 1227425642, 'Hello mart'),
(11, 1225274256, 1227425642, 'I am doing great you?'),
(12, 1227425642, 1225274256, 'Im  great, just checking up on you.'),
(13, 1225274256, 1227425642, 'Thanks, have a lovely day');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(200) NOT NULL,
  `user_name` varchar(200) DEFAULT NULL,
  `user_gender` varchar(200) DEFAULT NULL,
  `user_age` varchar(200) DEFAULT NULL,
  `user_email` varchar(200) DEFAULT NULL,
  `user_password` varchar(200) DEFAULT NULL,
  `user_password_reset_token` varchar(200) DEFAULT NULL,
  `user_profile_picture` longtext DEFAULT NULL,
  `user_biography` longtext DEFAULT NULL,
  `user_address` longtext DEFAULT NULL,
  `user_status` varchar(200) DEFAULT NULL,
  `user_account_status` varchar(200) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_gender`, `user_age`, `user_email`, `user_password`, `user_password_reset_token`, `user_profile_picture`, `user_biography`, `user_address`, `user_status`, `user_account_status`) VALUES
(440616491, 'Martin Mbithi', 'Male', '23', 'demo@gmail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'ac906d9f35f84e94482a3640', '1652100451Wet Devlan Logo Glass.jpg', NULL, 'Machakos', NULL, 'Verified'),
(1227425642, 'Marylinne', 'Female', '20', 'demo@gmail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', NULL, '1651760378Wet Devlan Logo Glass.jpg', 'Collaboratively innovate compelling mindshare after\n                                                                prospective partnerships Competently sereiz long-term\n                                                                high-impact internal or \"organic\" sources via user friendly\n                                                                strategic themesr areas creat Dramatically coordinate\n                                                                premium partnerships rather than standards compliant\n                                                                technologies ernd Dramatically matrix ethical collaboration\n                                                                and idea-sharing through opensource methodologies and\n                                                                Intrinsicly grow collaborative platforms vis-a-vis effective\n                                                                scenarios. Energistically strategize cost effective ideas\n                                                                before the worke unde.a', 'Machakos', 'Offline now', 'Verified');

-- --------------------------------------------------------

--
-- Table structure for table `user_intrests`
--

CREATE TABLE `user_intrests` (
  `user_intrest_id` int(200) NOT NULL,
  `user_intrest_user_id` int(200) NOT NULL,
  `intrest` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`fav_id`),
  ADD KEY `FavouriteMineID` (`fav_logged_in_user_id`),
  ADD KEY `FavouriteUserID` (`fav_user_id`);

--
-- Indexes for table `mailer_settings`
--
ALTER TABLE `mailer_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `MatchUser1ID` (`match_first_patner_id`),
  ADD KEY `MatchUser2ID` (`match_second_partner_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_intrests`
--
ALTER TABLE `user_intrests`
  ADD PRIMARY KEY (`user_intrest_id`),
  ADD KEY `UserIntrests` (`user_intrest_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `fav_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mailer_settings`
--
ALTER TABLE `mailer_settings`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `match_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_intrests`
--
ALTER TABLE `user_intrests`
  MODIFY `user_intrest_id` int(200) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `FavouriteMineID` FOREIGN KEY (`fav_logged_in_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FavouriteUserID` FOREIGN KEY (`fav_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `MatchUser1ID` FOREIGN KEY (`match_first_patner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MatchUser2ID` FOREIGN KEY (`match_second_partner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_intrests`
--
ALTER TABLE `user_intrests`
  ADD CONSTRAINT `UserIntrests` FOREIGN KEY (`user_intrest_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
