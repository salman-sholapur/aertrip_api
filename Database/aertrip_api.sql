-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2023 at 11:04 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aertrip_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(50) DEFAULT NULL,
  `company_email_id` varchar(50) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `company_email_id`, `contact_number`) VALUES
(1, 'Aertrip', 'admin@aertrip.com', '1234567890');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `dept_name` varchar(50) DEFAULT NULL,
  `dept_number` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `company_id`, `dept_name`, `dept_number`, `created_on`, `modified_on`) VALUES
(1, 1, 'Manager', '7457456', '2023-06-28 00:26:33', '2023-06-28 02:06:04'),
(2, 1, 'HRS', '6346344', '2023-06-28 01:28:02', '2023-06-28 02:03:22'),
(4, 1, 'UI Development', '1864846', '2023-06-28 09:12:42', '2023-06-29 00:01:23'),
(6, 1, 'Sales', '97855', '2023-06-29 02:16:37', '2023-06-29 02:16:37');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `emp_name` varchar(50) DEFAULT NULL,
  `emp_email_id` varchar(120) DEFAULT NULL,
  `emp_salary` decimal(19,2) NOT NULL DEFAULT 0.00,
  `created_on` datetime DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `emp_name`, `emp_email_id`, `emp_salary`, `created_on`, `modified_on`) VALUES
(2, 'Salman', 'salman@mail.com', '50000.00', '2023-06-28 09:42:14', '2023-06-28 09:42:14'),
(4, 'Md Salman', 'md_salman@mail.com', '50000.00', '2023-06-28 09:45:08', '2023-06-28 09:45:08'),
(5, 'Mohammed Salman', 'md_salman@mail.com', '50000.00', '2023-06-28 09:45:33', '2023-06-28 09:45:33'),
(6, 'Kiran Kumar', 'kiran.k@mail.in', '65500.00', '2023-06-29 00:10:43', '2023-06-29 00:11:58');

-- --------------------------------------------------------

--
-- Table structure for table `employee_contact`
--

CREATE TABLE `employee_contact` (
  `contact_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `contact_address` varchar(255) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_contact`
--

INSERT INTO `employee_contact` (`contact_id`, `employee_id`, `contact_number`, `contact_address`, `created_on`, `modified_on`) VALUES
(7, 2, '198464646', '8th Cross, Shivaji Nagar Mumbai - 654515', '2023-06-28 11:40:14', '2023-06-28 11:40:14'),
(8, 2, '198464646', '8th Cross, Shivaji Nagar Mumbai - 654515', '2023-06-29 00:16:10', '2023-06-29 00:16:10'),
(9, 2, '198464646', '8th Cross, Shivaji Nagar Mumbai - 654515', '2023-06-29 02:23:20', '2023-06-29 02:23:20');

-- --------------------------------------------------------

--
-- Table structure for table `emp_works_dept`
--

CREATE TABLE `emp_works_dept` (
  `emp_work_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_works_dept`
--

INSERT INTO `emp_works_dept` (`emp_work_id`, `employee_id`, `department_id`) VALUES
(2, 2, 1),
(3, 2, 2),
(7, 4, 1),
(8, 4, 2),
(9, 5, 1),
(10, 5, 2),
(28, 6, 1),
(29, 6, 2),
(30, 6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) CHARACTER SET utf8 NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text CHARACTER SET utf8 DEFAULT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 0, 'AERTRIP_123', 0, 0, 0, NULL, '2023-02-10 13:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active | 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `employee_contact`
--
ALTER TABLE `employee_contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `emp_works_dept`
--
ALTER TABLE `emp_works_dept`
  ADD PRIMARY KEY (`emp_work_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
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
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employee_contact`
--
ALTER TABLE `employee_contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `emp_works_dept`
--
ALTER TABLE `emp_works_dept`
  MODIFY `emp_work_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`);

--
-- Constraints for table `employee_contact`
--
ALTER TABLE `employee_contact`
  ADD CONSTRAINT `employee_contact_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`);

--
-- Constraints for table `emp_works_dept`
--
ALTER TABLE `emp_works_dept`
  ADD CONSTRAINT `emp_works_dept_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`),
  ADD CONSTRAINT `emp_works_dept_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
