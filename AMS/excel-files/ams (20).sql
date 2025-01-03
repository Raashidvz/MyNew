-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 07:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ams`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign_works`
--

CREATE TABLE `assign_works` (
  `W_ID` int(11) NOT NULL,
  `ROLLNO` int(11) NOT NULL,
  `NAMEE` varchar(255) NOT NULL,
  `SUBJECT_ID` int(11) NOT NULL,
  `NOTE_ID` int(11) NOT NULL,
  `FILE_PATH` varchar(225) NOT NULL,
  `CREATED_AT` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `BATCH_ID` int(11) NOT NULL,
  `BATCH` varchar(200) NOT NULL,
  `YEARR` int(11) NOT NULL,
  `CLASS` varchar(100) NOT NULL,
  `SEMESTER_1` int(11) NOT NULL DEFAULT 0,
  `SEMESTER_2` int(11) NOT NULL DEFAULT 0,
  `SEMESTER_3` int(11) NOT NULL DEFAULT 0,
  `SEMESTER_4` int(11) NOT NULL DEFAULT 0,
  `SEMESTER_5` int(11) NOT NULL DEFAULT 0,
  `SEMESTER_6` int(11) NOT NULL DEFAULT 0,
  `SEMESTER_7` int(11) NOT NULL DEFAULT 0,
  `SEMESTER_8` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `event_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `NOTE_ID` int(11) NOT NULL,
  `SUBJECT_ID` int(11) NOT NULL,
  `TEACHER_ID` int(11) NOT NULL,
  `MODULE` int(11) DEFAULT NULL,
  `MODULE_NAME` varchar(200) NOT NULL,
  `DESCRIPTIONN` varchar(255) NOT NULL,
  `CATEGORY` enum('NOTE','ASSIGNMENT','PAPERPATHWAY') NOT NULL,
  `BATCH` int(11) DEFAULT NULL,
  `FILE_NAME` varchar(255) NOT NULL,
  `UPLOAD_DATE` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routemap`
--

CREATE TABLE `routemap` (
  `R_ID` int(11) NOT NULL,
  `TEACHER_ID` int(11) NOT NULL,
  `SUBJECT_NAME` varchar(225) DEFAULT NULL,
  `CLASS` varchar(225) NOT NULL,
  `YEARR` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `STUDENT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `NAMEE` varchar(100) NOT NULL,
  `CLASS_NAME` varchar(100) NOT NULL,
  `PARENT_CONTACT` varchar(100) NOT NULL,
  `BATCH_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `SUBJECT_ID` int(11) NOT NULL,
  `SUBJECT_NAME` varchar(200) NOT NULL,
  `CLASS_NAME` varchar(200) NOT NULL,
  `SEMESTER` int(11) NOT NULL,
  `TOTAL_MODULES` int(11) NOT NULL,
  `TEACHER_ID` int(11) DEFAULT NULL,
  `TEACHER_ID2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `TEACHER_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `NAMEE` varchar(100) NOT NULL,
  `DEPARTMENT` varchar(100) NOT NULL,
  `JOINING_DATE` varchar(100) DEFAULT NULL,
  `PHONE_NO` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USER_ID` int(11) NOT NULL,
  `USER_NAME` varchar(100) NOT NULL,
  `PASSWORDD` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `ROLEE` enum('ADMIN','TEACHERS','STUDENTS') NOT NULL,
  `STATUSS` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USER_ID`, `USER_NAME`, `PASSWORDD`, `EMAIL`, `ROLEE`, `STATUSS`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 'ADMIN', 'ACTIVE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign_works`
--
ALTER TABLE `assign_works`
  ADD PRIMARY KEY (`W_ID`),
  ADD KEY `SUBJECT_ID` (`SUBJECT_ID`),
  ADD KEY `NOTE_ID` (`NOTE_ID`),
  ADD KEY `STUDENT_ID` (`ROLLNO`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`BATCH_ID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `TEACHER_ID` (`USER_ID`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`NOTE_ID`),
  ADD KEY `SUBJECT_ID` (`SUBJECT_ID`),
  ADD KEY `TEACHER_ID` (`TEACHER_ID`);

--
-- Indexes for table `routemap`
--
ALTER TABLE `routemap`
  ADD PRIMARY KEY (`R_ID`),
  ADD KEY `TEACHER_ID` (`TEACHER_ID`),
  ADD KEY `BATCH_ID` (`CLASS`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`STUDENT_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `BATCH_ID` (`BATCH_ID`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`SUBJECT_ID`),
  ADD KEY `TEACHER_ID` (`TEACHER_ID`),
  ADD KEY `TEACHER_ID2` (`TEACHER_ID2`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`TEACHER_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `USER_NAME` (`USER_NAME`),
  ADD UNIQUE KEY `USER_NAME_2` (`USER_NAME`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign_works`
--
ALTER TABLE `assign_works`
  MODIFY `W_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `BATCH_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `NOTE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `routemap`
--
ALTER TABLE `routemap`
  MODIFY `R_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `STUDENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `SUBJECT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `TEACHER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assign_works`
--
ALTER TABLE `assign_works`
  ADD CONSTRAINT `assign_works_ibfk_1` FOREIGN KEY (`SUBJECT_ID`) REFERENCES `subjects` (`SUBJECT_ID`),
  ADD CONSTRAINT `assign_works_ibfk_2` FOREIGN KEY (`NOTE_ID`) REFERENCES `notes` (`NOTE_ID`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USER_ID`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`SUBJECT_ID`) REFERENCES `subjects` (`SUBJECT_ID`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`TEACHER_ID`) REFERENCES `teachers` (`TEACHER_ID`);

--
-- Constraints for table `routemap`
--
ALTER TABLE `routemap`
  ADD CONSTRAINT `routemap_ibfk_1` FOREIGN KEY (`TEACHER_ID`) REFERENCES `teachers` (`TEACHER_ID`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USER_ID`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`BATCH_ID`) REFERENCES `batches` (`BATCH_ID`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`TEACHER_ID`) REFERENCES `teachers` (`TEACHER_ID`),
  ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`TEACHER_ID2`) REFERENCES `teachers` (`TEACHER_ID`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USER_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
