-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 10:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `improject`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_save_student` (IN `p_studID` INT, IN `p_fname` VARCHAR(50), IN `p_lname` VARCHAR(50), IN `p_mname` VARCHAR(50), IN `p_bday` DATE, IN `p_gender` VARCHAR(10), IN `p_email` VARCHAR(50), IN `p_phone_number` VARCHAR(20), IN `p_city` VARCHAR(50), IN `p_municipality` VARCHAR(50), IN `p_barangay` VARCHAR(50))  SQL SECURITY INVOKER BEGIN
   IF p_studID = 0 then
          IF NOT EXISTS( SELECT
    *
  FROM students
  WHERE fname = p_fname
  AND mname = p_mname
  AND lname = p_lname) THEN

INSERT INTO students (fname, mname, lname, bday, gender, email, phone_number, city, municipality, barangay)
  VALUES (p_fname, p_mname, p_lname, p_bday, p_gender, p_email, p_phone_number, p_city, p_municipality, p_barangay);

END IF;
ELSE
UPDATE students
SET fname = p_fname,
    lname = p_lname,
    mname = p_mname,
    bday = p_bday,
    gender = p_gender,
    email = p_email,
    phone_number = p_phone_number,
    city = p_city,
    municipality = p_municipality,
    barangay = p_barangay
WHERE stud_id = p_studid;
END IF;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'admin1234');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseID` int(11) NOT NULL,
  `courseNAME` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `courseNAME`, `description`) VALUES
(1, 'BSIT', 'Bachelor of Science in Information Technology'),
(2, 'BSHM', 'Bachelor of Science in Hospitality Management'),
(3, 'BEED', 'Bachelor of Elementary Education'),
(4, 'BSED', 'Bachelor of Secondary Education');

-- --------------------------------------------------------

--
-- Table structure for table `deny_student`
--

CREATE TABLE `deny_student` (
  `id` int(11) NOT NULL,
  `studID` int(11) NOT NULL,
  `denied_by` varchar(255) NOT NULL,
  `denied_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drop_student`
--

CREATE TABLE `drop_student` (
  `dropID` int(11) NOT NULL,
  `studID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `RoomID` int(11) NOT NULL,
  `RoomNumber` varchar(10) NOT NULL,
  `Building` varchar(50) DEFAULT NULL,
  `Capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`RoomID`, `RoomNumber`, `Building`, `Capacity`) VALUES
(101, '101', 'Main Building', 30),
(102, '102', 'Main Building', 40),
(103, '103', 'Science Wing', 25),
(104, '104', 'Science Wing', 35),
(105, '105', 'Tech Hub', 20),
(201, '201', 'Hospitality Hall', 50),
(202, '202', 'Hospitality Hall', 45),
(203, '203', 'Education Wing', 30),
(204, '204', 'Education Wing', 30),
(301, '301', 'Language Center', 20),
(302, '302', 'Math Building', 25),
(303, '303', 'Science Building', 30),
(304, '304', 'Filipino Center', 25);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `ScheduleID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `RoomID` int(11) NOT NULL,
  `Semester` varchar(20) DEFAULT NULL,
  `Day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndTime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`ScheduleID`, `SubjectID`, `RoomID`, `Semester`, `Day`, `StartTime`, `EndTime`) VALUES
(1, 6, 101, '1', 'Monday', '08:00:00', '09:30:00'),
(2, 7, 102, '1', 'Tuesday', '10:00:00', '11:30:00'),
(3, 8, 103, '1', 'Wednesday', '13:00:00', '14:30:00'),
(4, 9, 104, '1', 'Thursday', '15:00:00', '16:30:00'),
(5, 10, 105, '1', 'Friday', '09:00:00', '10:30:00'),
(6, 11, 201, '2', 'Monday', '11:00:00', '12:30:00'),
(7, 12, 202, '2', 'Tuesday', '14:00:00', '15:30:00'),
(8, 13, 203, '2', 'Wednesday', '08:00:00', '09:30:00'),
(9, 14, 204, '2', 'Thursday', '10:00:00', '11:30:00'),
(10, 15, 301, '2', 'Friday', '13:00:00', '14:30:00'),
(11, 16, 302, '1', 'Monday', '15:00:00', '16:30:00'),
(12, 17, 303, '1', 'Tuesday', '09:00:00', '10:30:00'),
(13, 18, 304, '1', 'Wednesday', '11:00:00', '12:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `city` varchar(50) NOT NULL,
  `municipality` varchar(50) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `course` enum('bsit','bshm','beed','bsed') NOT NULL,
  `year` enum('1st','2nd','3rd','4th') NOT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studID`, `firstName`, `mname`, `lname`, `email`, `birthdate`, `gender`, `city`, `municipality`, `barangay`, `course`, `year`, `password`) VALUES
(1, 'eric dave', 'dave', 'estrera', 'estreradave1233@gmail.com', '0000-00-00', 'male', 'awdasd', 'awdasd', 'awdasd', 'bsit', '1st', 'Estrera'),
(2, 'eric dave', 'dave', 'estrera', 'estreradave12333@gmail.com', '0000-00-00', 'male', 'awdasd', 'awdasd', 'awdasd', 'bshm', '3rd', 'Estrera');

-- --------------------------------------------------------

--
-- Table structure for table `student_approval`
--

CREATE TABLE `student_approval` (
  `approvalID` int(11) NOT NULL,
  `studID` int(11) NOT NULL,
  `approval_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_approval`
--

INSERT INTO `student_approval` (`approvalID`, `studID`, `approval_date`, `approved_by`) VALUES
(1, 1, '2024-11-20 08:59:02', 'Admin'),
(2, 2, '2024-11-20 08:59:04', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `SubjectID` int(11) NOT NULL,
  `SubjectName` varchar(100) NOT NULL,
  `Credits` int(11) NOT NULL,
  `Description` text DEFAULT NULL,
  `CourseID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`SubjectID`, `SubjectName`, `Credits`, `Description`, `CourseID`) VALUES
(6, 'Computer Programming', 3, 'Learn the fundamentals of computer programming.', 1),
(7, 'Network Administration', 3, 'Explore the principles of managing and configuring networks.', 1),
(8, 'Web Development', 3, 'Develop web applications using modern technologies.', 1),
(9, 'Database Management', 3, 'Master database design and management techniques.', 1),
(10, 'Cybersecurity', 3, 'Understand the foundations of securing systems and data.', 1),
(11, 'Major in Culinary Entrepreneurship', 3, 'Focuses on entrepreneurial skills in culinary arts.', 2),
(12, 'Major in Hospitality Leadership', 3, 'Develop leadership and management skills in hospitality.', 2),
(13, 'Bachelor in Elementary Education Major in Preschool Education', 3, 'Specializes in early childhood education.', 3),
(14, 'Bachelor in Elementary Education Major in Special Education', 3, 'Focuses on teaching strategies for special needs students.', 3),
(15, 'English', 3, 'Advanced study of language and literature.', 4),
(16, 'Mathematics', 3, 'Comprehensive understanding of mathematics for teaching.', 4),
(17, 'General Science', 3, 'Covers foundational principles of natural sciences.', 4),
(18, 'Filipino', 3, 'Focuses on the Filipino language and literature.', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseID`);

--
-- Indexes for table `deny_student`
--
ALTER TABLE `deny_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `studID` (`studID`);

--
-- Indexes for table `drop_student`
--
ALTER TABLE `drop_student`
  ADD PRIMARY KEY (`dropID`),
  ADD KEY `studID` (`studID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`RoomID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`ScheduleID`),
  ADD KEY `SubjectID` (`SubjectID`),
  ADD KEY `RoomID` (`RoomID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studID`);

--
-- Indexes for table `student_approval`
--
ALTER TABLE `student_approval`
  ADD PRIMARY KEY (`approvalID`),
  ADD KEY `studID` (`studID`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`SubjectID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deny_student`
--
ALTER TABLE `deny_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drop_student`
--
ALTER TABLE `drop_student`
  MODIFY `dropID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ScheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_approval`
--
ALTER TABLE `student_approval`
  MODIFY `approvalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `SubjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deny_student`
--
ALTER TABLE `deny_student`
  ADD CONSTRAINT `deny_student_ibfk_1` FOREIGN KEY (`studID`) REFERENCES `student` (`studID`);

--
-- Constraints for table `drop_student`
--
ALTER TABLE `drop_student`
  ADD CONSTRAINT `drop_student_ibfk_1` FOREIGN KEY (`studID`) REFERENCES `student` (`studID`) ON DELETE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `subject` (`SubjectID`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`);

--
-- Constraints for table `student_approval`
--
ALTER TABLE `student_approval`
  ADD CONSTRAINT `student_approval_ibfk_1` FOREIGN KEY (`studID`) REFERENCES `student` (`studID`) ON DELETE CASCADE;

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `course` (`courseID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
