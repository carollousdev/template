-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jun 27, 2024 at 11:29 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `templateci3`
--

-- --------------------------------------------------------

--
-- Table structure for table `dashboard`
--

CREATE TABLE `dashboard` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashboard`
--

INSERT INTO `dashboard` (`id`, `name`, `title`, `favicon`, `status`) VALUES
(1, 'Dashboard', 'Template CodeIgniter 3', 'AdminLTELogo.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE `navigation` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `tipe` int(11) NOT NULL,
  `root` varchar(255) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(10) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `short_name`, `create_date`, `status`) VALUES
('ROEv7T351718415158', 'Admin', 'ADM', '2024-06-15 08:32:38', 0),
('ROErGwXN1718771492', 'Staff', 'SF', '2024-06-19 11:32:07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `create_key` text NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `role`, `password`, `create_key`, `create_date`, `status`) VALUES
('USRaIPcc1718746485', 'carollous', 'Carollous Dachi', 'ROEv7T351718415158', '3b7LF7FEjP+riNz9A0hPbDsesxwl3E3jH1nxOgqGSCQaqRuBh7iFhRYJAUAjJJLNM8ZiwSOxf3JMSqzuwGhnvA==', '16luXctBHkKTA', '2024-06-27 04:30:51', 0),
('USRlqLsb1718746516', 'paulusdc', 'Paulus Dachi', 'ROEv7T351718415158', 'l0T3GZOpF5ZbEePSzj9FI45d3CUTQeMIkaPnZb/4YIpXLsFZ80dz5Jg8xYGIdhyzVHYAvbfqcT9eQ6p8cvMArw==', '16luXctBHkKTA', '2024-06-27 04:31:07', 0),
('USRpoop01718747012', 'dirgadc', 'Dirga Dachi', 'ROErGwXN1718771492', '3FtyOLEE7NLiVI3Mhndt4uxCtnsV323gtKJUC497DCDAgaHCyR+c47ioqFxbUhPx8SQe+/0RphGlbNwp0ChOug==', '16luXctBHkKTA', '2024-06-24 02:02:59', 0),
('USRpSfN61719392024', 'josuadc', 'Josua Dachi', 'ROErGwXN1718771492', 'Ns+fB91S5lPvSrMODAFs+kqIt/2SNOWuy8hnk0d5VNW6DP7t7UQdjasgwe9uPA/eSzjakK1ECYVdbKKJLzaRcQ==', '16luXctBHkKTA', '2024-06-26 15:53:44', 0),
('USRtQY5K1718747857', 'ariwau16', 'Ari Wau', 'ROEv7T351718415158', 'JAob+VmPjdEmbIMeNvSbal0yrAQVGnQ1YE+F8fnvbxg0I9XY806SceXJ7NyxFbc6SeO2ZxvZQUQsWd9JDZCQYg==', '162c6K4kyjxFg', '2024-06-21 19:25:25', 0),
('USRy8skP1718747837', 'arifin', 'Arifin Hondro', 'ROEv7T351718415158', 'd62wwLEWqeCSp31sgrTi0qKgeeyKspvqBIjypuP/c1U2C92MFgRM4APER+OzUz7jkZmCZ9bNf0tc3j2VD+c9jA==', '16luXctBHkKTA', '2024-06-21 19:25:28', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dashboard`
--
ALTER TABLE `dashboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
