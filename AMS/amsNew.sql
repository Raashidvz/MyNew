-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 01:06 PM
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

--
-- Dumping data for table `assign_works`
--

INSERT INTO `assign_works` (`W_ID`, `ROLLNO`, `NAMEE`, `SUBJECT_ID`, `NOTE_ID`, `FILE_PATH`, `CREATED_AT`) VALUES
(5, 220157, 'RAASHID V Z', 80, 101, '../notesAndAssignments/WORKS/220157_101_.pdf', 2147483647),
(6, 220168, 'SULFATH P M', 80, 101, '../notesAndAssignments/WORKS/220168_101_.pdf', 2147483647),
(7, 220168, 'SULFATH P M', 80, 100, '../notesAndAssignments/WORKS/220168_100_.pdf', 2147483647);

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

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`BATCH_ID`, `BATCH`, `YEARR`, `CLASS`, `SEMESTER_1`, `SEMESTER_2`, `SEMESTER_3`, `SEMESTER_4`, `SEMESTER_5`, `SEMESTER_6`, `SEMESTER_7`, `SEMESTER_8`) VALUES
(6, 'BCA2022', 2022, 'BCA', 1, 1, 1, 1, 1, 1, 0, 0),
(7, 'BCA2023', 2023, 'BCA', 1, 1, 1, 1, 0, 0, 0, 0);

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

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`NOTE_ID`, `SUBJECT_ID`, `TEACHER_ID`, `MODULE`, `MODULE_NAME`, `DESCRIPTIONN`, `CATEGORY`, `BATCH`, `FILE_NAME`, `UPLOAD_DATE`) VALUES
(96, 84, 154, 1, 'test1php', 'bgcc', 'NOTE', 2023, '../notesAndAssignments/NOTES/WEB PROGRAMING USING PHP_test1php_1_note_2024-11-10_07-54-03 AM.pdf', '2024-11-10 06:54:03'),
(97, 80, 154, 1, 'Introduction to java', 'basics', 'NOTE', 2022, '../notesAndAssignments/NOTES/JAVA PROGRMMING USING LINUX_Introduction to java_1_note_2024-12-13_10-49-26 AM.pdf', '2024-12-13 09:49:26'),
(98, 80, 154, 1, 'Java keywords', 'literals', 'NOTE', 2022, '../notesAndAssignments/NOTES/JAVA PROGRMMING USING LINUX_Java keywords_1_note_2024-12-13_10-53-25 AM.pdf', '2024-12-13 09:53:25'),
(99, 80, 154, 1, 'Data types', 'pre-defined data types, user-defined data types', 'NOTE', 2022, '../notesAndAssignments/NOTES/JAVA PROGRMMING USING LINUX_Data types_1_note_2024-12-13_10-54-07 AM.pdf', '2024-12-13 09:54:07'),
(100, 80, 154, 4, 'Assignment 1', 'Submit before 22-12-2024', 'ASSIGNMENT', 2022, '../notesAndAssignments/ASSIGNMENTS/JAVA PROGRMMING USING LINUX_Assignment 1__assignment_11-09-02 AM.pdf', '2024-12-13 10:09:02'),
(101, 80, 154, 0, 'Assignment 2', 'Submit before 1-01-2025', 'ASSIGNMENT', 2022, '../notesAndAssignments/ASSIGNMENTS/JAVA PROGRMMING USING LINUX_Assignment 2__assignment_11-09-48 AM.pdf', '2024-12-13 10:09:48');

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

--
-- Dumping data for table `routemap`
--

INSERT INTO `routemap` (`R_ID`, `TEACHER_ID`, `SUBJECT_NAME`, `CLASS`, `YEARR`) VALUES
(162, 152, 'OPERATING SYSTEMS', 'BCA', 2023),
(163, 153, 'DATA STRUCTURE USING C++', 'BCA', 2023),
(164, 154, 'WEB PROGRAMING USING PHP', 'BCA', 2023),
(165, 154, 'JAVA PROGRMMING USING LINUX', 'BCA', 2022),
(166, 155, 'DESIGN AND ANALYSIS OF ALGORITHM', 'BCA', 2023),
(167, 156, 'COMPUTER GRAPHICS', 'BCA', 2023),
(168, 157, 'LINUX ADMINISTRATION', 'BCA', 2023),
(169, 158, 'IT AND ENVIRONMENT', 'BCA', 2022),
(170, 159, 'COMPUTER NETWORKS', 'BCA', 2022),
(171, 159, 'SYSTEM ANALYSIS AND SOFTWARE ENGINEERING', 'BCA', 2023),
(172, 160, 'MICROPROCESSOR AND PC HARDWARE', 'BCA', 2023),
(173, 161, 'OPERATING SYSTEMS', 'BCA', 2023),
(174, 161, 'MICROPROCESSOR AND PC HARDWARE', 'BCA', 2023),
(175, 161, 'LINUX ADMINISTRATION', 'BCA', 2023);

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

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`STUDENT_ID`, `USER_ID`, `NAMEE`, `CLASS_NAME`, `PARENT_CONTACT`, `BATCH_ID`) VALUES
(216, 382, 'AADIL SAKEER', 'BCA', '9876676511', 6),
(217, 383, 'AAFTHAB K I', 'BCA', '2233445544', 6),
(218, 384, 'ABDULRAUOF', 'BCA', '5466457746', 6),
(219, 385, 'ABHIN K S', 'BCA', '6567768775', 6),
(220, 386, 'ABID NAJEEB', 'BCA', '7788567473', 6),
(221, 387, 'ADITHYA  P V', 'BCA', '7477889364', 6),
(222, 388, 'AFSAL V N', 'BCA', '9967463567', 6),
(223, 389, 'AJMI T S', 'BCA', '3547899546', 6),
(224, 390, 'ALTHAF JAMAL', 'BCA', '7868675657', 6),
(225, 391, 'AMAL SAJI', 'BCA', '7788887776', 6),
(226, 392, 'ANAMIKA V U', 'BCA', '5895644658', 6),
(227, 393, 'ANAND O G', 'BCA', '5757688797', 6),
(228, 394, 'ANJALI PAI T S', 'BCA', '5756435333', 6),
(229, 395, 'ANU M A', 'BCA', '7879654323', 6),
(230, 396, 'APARNA  MOHAN', 'BCA', '4354466777', 6),
(231, 397, 'ARJUN P S', 'BCA', '6666464656', 6),
(232, 398, 'ARYA P S', 'BCA', '4646789988', 6),
(233, 399, 'ASNA T I', 'BCA', '9909868688', 6),
(234, 400, 'AYSHA SANJUNA', 'BCA', '6766788888', 6),
(235, 401, 'BHARATH  K M', 'BCA', '7767689797', 6),
(236, 402, 'DEVI CHANDANA  S', 'BCA', '6890809978', 6),
(237, 403, 'DIYA ZAINAB K A', 'BCA', '8798865645', 6),
(238, 404, 'FABIN PAUL FRANCIS', 'BCA', '4647586887', 6),
(239, 405, 'FAMIS NOUSHAD  T N', 'BCA', '5758687989', 6),
(240, 406, 'FARISA C A', 'BCA', '7466444444', 6),
(241, 407, 'FARISHA N A', 'BCA', '4546666666', 6),
(242, 408, 'FARSANA P S', 'BCA', '5466643555', 6),
(243, 409, 'FATHIMA ASHITHA  P A', 'BCA', '9876676546', 6),
(244, 410, 'FATHIMA C I', 'BCA', '6646677777', 6),
(245, 411, 'FATHIMA K B', 'BCA', '5635334234', 6),
(246, 412, 'FATHIMA K S', 'BCA', '4776544433', 6),
(247, 413, 'FATHIMA P A', 'BCA', '5367788888', 6),
(248, 414, 'FATHIMA SALIM ', 'BCA', '7866677777', 6),
(249, 415, 'FATHIMATH FASMINA V T', 'BCA', '4555556666', 6),
(250, 416, 'GASHIYA NAZRIN ', 'BCA', '7776655555', 6),
(251, 417, 'HARIKRISHNAN  U K', 'BCA', '7778888876', 6),
(252, 418, 'JASNAMOL E S', 'BCA', '4456655556', 6),
(253, 419, 'KADEEJA SHAMEER', 'BCA', '6646577577', 6),
(254, 420, 'KIRAN BABU', 'BCA', '4666677776', 6),
(255, 421, 'MAHIN C R', 'BCA', '7654445546', 6),
(256, 422, 'MALAVIKA SHIBU', 'BCA', '7777611111', 6),
(257, 423, 'MOHAMMED IQBAL  M A', 'BCA', '3323333444', 6),
(258, 424, 'MUHAMAD USMAN', 'BCA', '5555332224', 6),
(259, 425, 'MUHAMMAD P K', 'BCA', '5554333566', 6),
(260, 426, 'MUHAMMED ADHIL K R', 'BCA', '7776655554', 6),
(261, 427, 'MUHAMMED ANEES V N', 'BCA', '7778899998', 6),
(262, 428, 'MUHAMMED SUHAIL A M', 'BCA', '7666788996', 6),
(263, 429, 'MUHAMMED SWALIH  T L', 'BCA', '4333556777', 6),
(264, 430, 'NADIYA IBRAHIM', 'BCA', '5578900998', 6),
(265, 431, 'NAJITHA K N', 'BCA', '9990988877', 6),
(266, 432, 'NEHA T', 'BCA', '8098908789', 6),
(267, 433, 'NIMITHRA T S', 'BCA', '9098899099', 6),
(268, 434, 'PRATHAP', 'BCA', '6600676567', 6),
(269, 435, 'RAASHID V Z', 'BCA', '8877067667', 6),
(270, 436, 'RIHAN A M', 'BCA', '5067657906', 6),
(271, 437, 'RISWANA PARVIN K S', 'BCA', '8907980695', 6),
(272, 438, 'RITHU T R', 'BCA', '7908866079', 6),
(273, 439, 'SAFNA K S', 'BCA', '7909765546', 6),
(274, 440, 'SAFNA V A', 'BCA', '6767098909', 6),
(275, 441, 'SANA FATHIMA P S', 'BCA', '4095867855', 6),
(276, 442, 'SETHULAKSHMI A S', 'BCA', '3409678493', 6),
(277, 443, 'SHAHANA SALIM', 'BCA', '1298490380', 6),
(278, 444, 'SHAMSUDHEEN S', 'BCA', '5867302984', 6),
(279, 445, 'SREETHUMOL P B', 'BCA', '3049804886', 6),
(280, 446, 'SULFATH P M', 'BCA', '3848590303', 6),
(281, 447, 'SUSMIN GEORGE', 'BCA', '5767739003', 6),
(282, 448, 'SWETHA BABU', 'BCA', '5678849947', 6),
(283, 449, 'AKHEEL', 'BCA', '6676789009', 7),
(284, 450, 'SALMAN', 'BCA', '6756789090', 7),
(285, 451, 'FAYIS', 'BCA', '8878878980', 7),
(286, 452, 'JUNAID', 'BCA', '6789889890', 7),
(287, 453, 'ZOHAN', 'BCA', '4444444444', 7),
(288, 454, 'MUEEN', 'BCA', '4567678789', 7),
(289, 455, 'IKRU', 'BCA', '8765435287', 7);

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

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`SUBJECT_ID`, `SUBJECT_NAME`, `CLASS_NAME`, `SEMESTER`, `TOTAL_MODULES`, `TEACHER_ID`, `TEACHER_ID2`) VALUES
(73, 'ADVANCED STATISTICAL METHODS', 'BCA', 3, 4, NULL, NULL),
(74, 'COMPUTER GRAPHICS', 'BCA', 3, 4, 156, NULL),
(75, 'MICROPROCESSOR AND PC HARDWARE', 'BCA', 3, 5, 160, 161),
(76, 'OPERATING SYSTEMS', 'BCA', 3, 5, 152, 161),
(77, 'DATA STRUCTURE USING C++', 'BCA', 3, 5, 153, NULL),
(78, 'COMPUTER NETWORKS', 'BCA', 5, 5, NULL, NULL),
(79, 'IT AND ENVIRONMENT', 'BCA', 5, 5, 158, NULL),
(80, 'JAVA PROGRMMING USING LINUX', 'BCA', 5, 5, 154, NULL),
(81, 'SYSTEM ANALYSIS AND SOFTWARE ENGINEERING', 'BCA', 4, 5, NULL, NULL),
(82, 'LINUX ADMINISTRATION', 'BCA', 4, 5, 157, 161),
(83, 'DESIGN AND ANALYSIS OF ALGORITHM', 'BCA', 4, 5, 155, NULL),
(84, 'WEB PROGRAMING USING PHP', 'BCA', 4, 5, 154, NULL),
(85, 'OPERATION RESEARCH', 'BCA', 4, 4, NULL, NULL);

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

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`TEACHER_ID`, `USER_ID`, `NAMEE`, `DEPARTMENT`, `JOINING_DATE`, `PHONE_NO`) VALUES
(152, 372, 'DR. LEENA C. SEKHAR', 'BCA', 'JULY 14, 2022', '3456777564'),
(153, 373, 'SRI. JOSEPH DERIL K S ', 'BCA', 'JULY 14, 2022', '654545663'),
(154, 374, 'LT. IBRAHIM SALIM M', 'BCA', 'JULY 14, 2022', '6667777'),
(155, 375, 'DR. JASEENA K U', 'BCA', 'JULY 14, 2022', '7474777'),
(156, 376, 'DR. BISMIN', 'BCA', 'JULY 14, 2022', '788654'),
(157, 377, 'DR. SHAREENA V B ', 'BCA', 'JULY 14, 2022', '57456868'),
(158, 378, 'DR. JULIE M DAVID', 'BCA', 'JULY 14, 2022', '685486866'),
(159, 379, 'SRI. JASIR M P', 'BCA', 'JULY 14, 2022', '868685757'),
(160, 380, 'SMT. SUFAIRA SHAMSUDHEEN', 'BCA', 'JULY 14, 2022', '75586878'),
(161, 381, 'JASIM', 'BCA', 'JULY 14,2023', '686576868');

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
(1, 'admin', 'admin', 'admin@gmail.com', 'ADMIN', 'ACTIVE'),
(372, '192022', '192022', 'leena@gmail.com', 'TEACHERS', 'ACTIVE'),
(373, '192023', '192023', 'deril@gmail.com', 'TEACHERS', 'ACTIVE'),
(374, '192024', '192024', 'salim@gmail.com', 'TEACHERS', 'ACTIVE'),
(375, '192025', '192025', 'jaseena@gmail.com', 'TEACHERS', 'ACTIVE'),
(376, '192026', '192026', 'bismin@gmail.com', 'TEACHERS', 'ACTIVE'),
(377, '192027', '192027', 'shareena@gmail.com', 'TEACHERS', 'ACTIVE'),
(378, '192028', '192028', 'julie@gmail.com', 'TEACHERS', 'ACTIVE'),
(379, '192029', '192029', 'jasir@gmail.com', 'TEACHERS', 'INACTIVE'),
(380, '192030', '192030', 'sufaira@gmail.com', 'TEACHERS', 'ACTIVE'),
(381, '192031', '192031', 'jasim@gmail.com', 'TEACHERS', 'ACTIVE'),
(382, '220101', '220101', 'aadilsakeer@gmail.com', 'STUDENTS', 'INACTIVE'),
(383, '220102', '220102', 'aafthab@gmail.com', 'STUDENTS', 'INACTIVE'),
(384, '220103', '220103', 'ABDULRAUOF@gmail.com', 'STUDENTS', 'INACTIVE'),
(385, '220104', '220104', 'ABHIN@gmail.com', 'STUDENTS', 'ACTIVE'),
(386, '220105', '220105', 'ABID@gmail.com', 'STUDENTS', 'ACTIVE'),
(387, '220107', '220107', 'ADITHYA@gmail.com', 'STUDENTS', 'ACTIVE'),
(388, '220108', '220108', 'AFSAL@gmail.com', 'STUDENTS', 'ACTIVE'),
(389, '220109', '220109', 'AJMI@gmail.com', 'STUDENTS', 'ACTIVE'),
(390, '220111', '220111', 'ALTHAF@gmail.com', 'STUDENTS', 'ACTIVE'),
(391, '220112', '220112', 'AMAL@gmail.com', 'STUDENTS', 'ACTIVE'),
(392, '220113', '220113', 'ANAMIKA@gmail.com', 'STUDENTS', 'ACTIVE'),
(393, '220114', '220114', 'ANAND@gmail.com', 'STUDENTS', 'ACTIVE'),
(394, '220115', '220115', 'ANJALI@gmail.com', 'STUDENTS', 'ACTIVE'),
(395, '220116', '220116', 'ANU@gmail.com', 'STUDENTS', 'INACTIVE'),
(396, '220117', '220117', 'APARNA@gmail.com', 'STUDENTS', 'ACTIVE'),
(397, '220118', '220118', 'ARJUN@gmail.com', 'STUDENTS', 'ACTIVE'),
(398, '220119', '220119', 'ARYA@gmail.com', 'STUDENTS', 'ACTIVE'),
(399, '220120', '220120', 'ASNA@gmail.com', 'STUDENTS', 'ACTIVE'),
(400, '220121', '220121', 'AYSHA@gmail.com', 'STUDENTS', 'ACTIVE'),
(401, '220122', '220122', 'BHARATH@gmail.com', 'STUDENTS', 'ACTIVE'),
(402, '220123', '220123', 'DEVI@gmail.com', 'STUDENTS', 'ACTIVE'),
(403, '220124', '220124', 'DIYA@gmail.com', 'STUDENTS', 'ACTIVE'),
(404, '220125', '220125', 'FABIN@gmail.com', 'STUDENTS', 'ACTIVE'),
(405, '220126', '220126', 'FAMIS@gmail.com', 'STUDENTS', 'ACTIVE'),
(406, '220127', '220127', 'FARISA@gmail.com', 'STUDENTS', 'ACTIVE'),
(407, '220128', '220128', 'FARISHA@gmail.com', 'STUDENTS', 'ACTIVE'),
(408, '220129', '220129', 'FARSANA@gmail.com', 'STUDENTS', 'ACTIVE'),
(409, '220130', '220130', 'ASHITHA@gmail.com', 'STUDENTS', 'ACTIVE'),
(410, '220131', '220131', 'CI@gmail.com', 'STUDENTS', 'ACTIVE'),
(411, '220132', '220132', 'KB@gmail.com', 'STUDENTS', 'ACTIVE'),
(412, '220133', '220133', 'KS@gmail.com', 'STUDENTS', 'ACTIVE'),
(413, '220134', '220134', 'PA@gmail.com', 'STUDENTS', 'ACTIVE'),
(414, '220135', '220135', 'SALIM@gmail.com', 'STUDENTS', 'ACTIVE'),
(415, '220136', '220136', 'FASMINA@gmail.com', 'STUDENTS', 'ACTIVE'),
(416, '220137', '220137', 'GASHIYA@gmail.com', 'STUDENTS', 'ACTIVE'),
(417, '220139', '220139', 'HARIKRISHNAN@gmail.com', 'STUDENTS', 'ACTIVE'),
(418, '220140', '220140', 'JASNA@gmail.com', 'STUDENTS', 'INACTIVE'),
(419, '220141', '220141', 'KADEEJA@gmail.com', 'STUDENTS', 'ACTIVE'),
(420, '220142', '220142', 'KIRAN@gmail.com', 'STUDENTS', 'ACTIVE'),
(421, '220143', '220143', 'MAHIN@gmail.com', 'STUDENTS', 'ACTIVE'),
(422, '220144', '220144', 'MALAVIKA@gmail.com', 'STUDENTS', 'ACTIVE'),
(423, '220145', '220145', 'IQBAL@gmail.com', 'STUDENTS', 'ACTIVE'),
(424, '220146', '220146', 'USMAN@gmail.com', 'STUDENTS', 'ACTIVE'),
(425, '220147', '220147', 'PK@gmail.com', 'STUDENTS', 'ACTIVE'),
(426, '220148', '220148', 'ADHILKR@gmail.com', 'STUDENTS', 'ACTIVE'),
(427, '220149', '220149', 'ANEES@gmail.com', 'STUDENTS', 'ACTIVE'),
(428, '220150', '220150', 'SUHAIL@gmail.com', 'STUDENTS', 'ACTIVE'),
(429, '220151', '220151', 'SWALIH@gmail.com', 'STUDENTS', 'INACTIVE'),
(430, '220152', '220152', 'NADIYA@gmail.com', 'STUDENTS', 'ACTIVE'),
(431, '220153', '220153', 'NAJITHA@gmail.com', 'STUDENTS', 'ACTIVE'),
(432, '220154', '220154', 'NEHA@gmail.com', 'STUDENTS', 'ACTIVE'),
(433, '220155', '220155', 'NIMITHRA@gmail.com', 'STUDENTS', 'ACTIVE'),
(434, '220156', '220156', 'PRATHAP@gmail.com', 'STUDENTS', 'INACTIVE'),
(435, '220157', '220157', 'RAASHID@gmail.com', 'STUDENTS', 'ACTIVE'),
(436, '220158', '220158', 'RIHAN@gmail.com', 'STUDENTS', 'ACTIVE'),
(437, '220159', '220159', 'RISWANA@gmail.com', 'STUDENTS', 'ACTIVE'),
(438, '220160', '220160', 'RITHU@gmail.com', 'STUDENTS', 'INACTIVE'),
(439, '220161', '220161', 'SAFNA@gmail.com', 'STUDENTS', 'ACTIVE'),
(440, '220162', '220162', 'SAFNA@gmail.com', 'STUDENTS', 'ACTIVE'),
(441, '220163', '220163', 'SANA@gmail.com', 'STUDENTS', 'ACTIVE'),
(442, '220164', '220164', 'SETHULAKSHMI@gmail.com', 'STUDENTS', 'ACTIVE'),
(443, '220165', '220165', 'SHAHANA@gmail.com', 'STUDENTS', 'ACTIVE'),
(444, '220166', '220166', 'SHAMSUDHEEN@gmail.com', 'STUDENTS', 'INACTIVE'),
(445, '220167', '220167', 'SREETHUMOL@gmail.com', 'STUDENTS', 'ACTIVE'),
(446, '220168', '220168', 'SULFA@gmail.com', 'STUDENTS', 'ACTIVE'),
(447, '220169', '220169', 'SUSMIN@gmail.com', 'STUDENTS', 'ACTIVE'),
(448, '220170', '220170', 'SWETHA@gmail.com', 'STUDENTS', 'INACTIVE'),
(449, '230101', '230101', 'akheel@gmail.com', 'STUDENTS', 'ACTIVE'),
(450, '230102', '230102', 'salman@gmail.com', 'STUDENTS', 'ACTIVE'),
(451, '230103', '230103', 'fayis@gmail.com', 'STUDENTS', 'ACTIVE'),
(452, '230104', '230104', 'junaid@gmail.com', 'STUDENTS', 'ACTIVE'),
(453, '230105', '230105', 'zohan@gmail.com', 'STUDENTS', 'ACTIVE'),
(454, '230106', '230106', 'mueen@gmail.com', 'STUDENTS', 'ACTIVE'),
(455, '230107', '230107', 'ikru@gmail.com', 'STUDENTS', 'ACTIVE');

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
  MODIFY `W_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `BATCH_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `NOTE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `routemap`
--
ALTER TABLE `routemap`
  MODIFY `R_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `STUDENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `SUBJECT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `TEACHER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=456;

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
