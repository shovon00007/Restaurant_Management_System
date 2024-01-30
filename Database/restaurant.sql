-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2023 at 06:19 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`username`, `password`) VALUES
('shovon', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `food_id` int(11) NOT NULL,
  `food_name` varchar(100) DEFAULT NULL,
  `category` enum('breakfast','lunch','dinner','drinks') DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`food_id`, `food_name`, `category`, `price`) VALUES
(1, 'Paratha', 'breakfast', 15.00),
(2, 'Dal Vaji', 'breakfast', 40.00),
(3, 'Shingara', 'breakfast', 15.00),
(4, 'Chomucha', 'breakfast', 15.00),
(5, 'Burger', 'breakfast', 200.00),
(6, 'Sandwich', 'breakfast', 50.00),
(7, 'Chicken Roll', 'breakfast', 40.00),
(8, 'Doi Chira', 'breakfast', 50.00),
(9, 'Dom Biriyani', 'dinner', 180.00),
(11, 'Morog Polao', 'dinner', 150.00),
(12, 'Chicken Curry', 'dinner', 100.00),
(13, 'Rui Fish', 'dinner', 100.00),
(14, 'Mutton Chui Jhal', 'dinner', 150.00),
(15, 'Alu Vorta', 'dinner', 20.00),
(16, 'Hilsha Fish', 'dinner', 200.00),
(17, 'Cocacola - 250ml', 'drinks', 30.00),
(18, 'Pepsi - 250ml', 'drinks', 25.00),
(19, '7UP - 250ml', 'drinks', 25.00),
(20, 'Borhani', 'drinks', 70.00),
(21, 'Tea', 'drinks', 25.00),
(22, 'Coffee', 'drinks', 70.00),
(23, 'Dom Biriyani', 'lunch', 180.00),
(24, 'Morog Polao', 'lunch', 150.00),
(25, 'Chicken Curry', 'lunch', 100.00),
(26, 'Kacchi Biriyani', 'lunch', 250.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_info`
--

CREATE TABLE `order_info` (
  `order_id` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `food_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_info`
--

INSERT INTO `order_info` (`order_id`, `username`, `food_id`, `food_name`, `quantity`, `order_date`) VALUES
(1, 'shovon07', 23, 'Dom Biriyani', 2, '2023-09-17 06:39:57'),
(2, 'shovon07', 25, 'Chicken Curry', 1, '2023-09-17 06:39:57'),
(3, 'shovon07', 17, 'Cocacola - 250ml', 1, '2023-09-17 06:39:57'),
(4, 'shovon07', 20, 'Borhani', 1, '2023-09-17 06:39:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(30) NOT NULL,
  `name` char(50) NOT NULL,
  `email` char(40) NOT NULL,
  `gender` char(10) NOT NULL,
  `birthdate` date NOT NULL,
  `pic` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `name`, `email`, `gender`, `birthdate`, `pic`, `password`) VALUES
('shovon07', 'Shovon', 'shovondeb321@gmail.com', 'male', '2001-03-19', 'shovon07_profile.jpg', '1234'),
('shovon321', 'Slasher', 'devshovon6@gmail.com', 'male', '2000-05-05', '35329b4781954aa5b80551582f89dca0.jpg', '12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`food_id`);

--
-- Indexes for table `order_info`
--
ALTER TABLE `order_info`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order_info`
--
ALTER TABLE `order_info`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_info`
--
ALTER TABLE `order_info`
  ADD CONSTRAINT `order_info_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
