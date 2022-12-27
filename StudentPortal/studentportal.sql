-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2022 at 05:24 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `forum_id` int(5) UNSIGNED NOT NULL,
  `chat_discussions` varchar(500) NOT NULL,
  `subject_id` int(5) UNSIGNED NOT NULL,
  `student_id` int(5) UNSIGNED DEFAULT NULL,
  `teacher_id` int(5) UNSIGNED DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`forum_id`, `chat_discussions`, `subject_id`, `student_id`, `teacher_id`, `timestamp`) VALUES
(1, 'Hello madam. How to solve this question?', 45122, 10001, NULL, '2022-12-23 11:27:57'),
(2, 'Hello messi, you can refer to the page 34 on your textbook.', 45122, NULL, 58932, '2022-12-23 11:28:00'),
(3, 'Thank you madam.', 45122, 10001, NULL, '2022-12-23 12:27:57'),
(10, 'Hello sir. Where to refer to PHP articles?', 45121, 10002, NULL, '2022-12-23 11:33:38'),
(11, 'Hello. You can refer at ChatGPT', 45121, NULL, 58933, '2022-12-23 11:33:38'),
(13, 'Oh is it sir? Thank you sir.', 45121, 10002, NULL, '2022-12-23 11:34:32'),
(14, 'Thank you', 45121, 10001, NULL, '2022-12-24 16:03:42'),
(15, 'Thank you sir', 45121, 10001, NULL, '2022-12-24 16:04:20'),
(16, 'Welcome my students', 45121, NULL, 58932, '2022-12-24 16:05:28');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(5) UNSIGNED NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `password`, `name`, `email`) VALUES
(10001, 'messi12', 'Messi Bin Ronaldo', 'messi45@gmail.com'),
(10002, 'ronaldo34', 'Ronaldo', 'ronaldo67@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(5) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `name`) VALUES
(45121, 'Programming'),
(45122, 'English'),
(45123, 'Science'),
(45124, 'Mathematics');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(5) UNSIGNED NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject_id` int(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `password`, `name`, `email`, `subject_id`) VALUES
(58932, 'peter44', 'Peter Parker', 'peter-spider.man@gmail.com', 45121),
(58933, 'tony77', 'Tony Stark', 'tony00@gmail.com', 45122);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`forum_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `FK_subject_id` (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `forum_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10003;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45125;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58935;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forum`
--
ALTER TABLE `forum`
  ADD CONSTRAINT `forum_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `forum_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `forum_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `FK_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
