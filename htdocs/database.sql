-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2016 at 10:44 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ds`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `idData` bigint(8) NOT NULL,
  `cpf` varchar(11) CHARACTER SET latin1 NOT NULL,
  `idCategory` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `value` decimal(10,0) DEFAULT NULL,
  `title` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`idData`, `cpf`, `idCategory`, `type`, `value`, `title`, `datetime`) VALUES
(11, '02355500099', 8, 0, '1000', '', '2016-04-05 00:00:00'),
(12, '02355500099', 9, 0, '400', '', '2016-04-09 00:00:00'),
(13, '02355500099', 6, 1, '100', '', '2016-05-05 00:00:00'),
(14, '02355500099', 8, 0, '1000', '', '2016-05-05 00:00:00'),
(15, '02355500099', 2, 1, '900', 'Aluguel', '2016-05-09 00:00:00'),
(16, '02355500099', 1, 1, '20', 'RaÃ§Ã£o', '2016-05-09 00:00:00'),
(17, '02355500099', 12, 1, '100', '', '2016-05-09 00:00:00'),
(18, '02355500099', 3, 1, '130', '', '2016-05-09 00:00:00'),
(19, '02355500099', 9, 0, '400', '', '2016-05-09 00:00:00'),
(20, '02355500099', 8, 0, '1000', '', '2016-04-05 00:00:00'),
(21, '02355500099', 9, 0, '400', '', '2016-04-09 00:00:00'),
(22, '02355500099', 6, 1, '100', '', '2016-05-05 00:00:00'),
(23, '02355500099', 8, 0, '1000', '', '2016-05-05 00:00:00'),
(24, '02355500099', 2, 1, '900', 'Aluguel', '2016-05-09 00:00:00'),
(25, '02355500099', 1, 1, '20', 'Ração', '2016-05-09 00:00:00'),
(26, '02355500099', 12, 1, '100', '', '2016-05-09 00:00:00'),
(27, '02355500099', 3, 1, '130', '', '2016-05-09 00:00:00'),
(28, '02355500099', 9, 0, '400', '', '2016-05-09 00:00:00'),
(29, '02355500099', 8, 0, '1000', '', '2016-04-05 00:00:00'),
(30, '02355500099', 9, 0, '400', '', '2016-04-09 00:00:00'),
(31, '02355500099', 6, 1, '100', '', '2016-05-05 00:00:00'),
(32, '02355500099', 8, 0, '1000', '', '2016-05-05 00:00:00'),
(33, '02355500099', 2, 1, '900', 'Aluguel', '2016-05-09 00:00:00'),
(34, '02355500099', 1, 1, '20', 'Ração', '2016-05-09 00:00:00'),
(35, '02355500099', 12, 1, '100', '', '2016-05-09 00:00:00'),
(36, '02355500099', 3, 1, '130', '', '2016-05-09 00:00:00'),
(37, '02355500099', 9, 0, '400', '', '2016-05-09 00:00:00'),
(38, '02355500099', 8, 0, '1000', '', '2016-04-05 00:00:00'),
(39, '02355500099', 9, 0, '400', '', '2016-04-09 00:00:00'),
(40, '02355500099', 6, 1, '100', '', '2016-05-05 00:00:00'),
(41, '02355500099', 8, 0, '1000', '', '2016-05-05 00:00:00'),
(42, '02355500099', 2, 1, '900', 'Aluguel', '2016-05-09 00:00:00'),
(43, '02355500099', 1, 1, '20', 'Ração', '2016-05-09 00:00:00'),
(44, '02355500099', 12, 1, '100', '', '2016-05-09 00:00:00'),
(45, '02355500099', 3, 1, '130', '', '2016-05-09 00:00:00'),
(46, '02355500099', 9, 0, '400', '', '2016-05-09 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`idData`,`cpf`),
  ADD KEY `fk_data_user1_idx` (`cpf`),
  ADD KEY `fk_data_category1_idx` (`idCategory`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `idData` bigint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `fk_data_category1` FOREIGN KEY (`idCategory`) REFERENCES `category` (`idCategory`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_data_user1` FOREIGN KEY (`cpf`) REFERENCES `user` (`cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
