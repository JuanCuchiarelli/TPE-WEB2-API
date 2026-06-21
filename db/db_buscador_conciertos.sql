-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2026 at 12:56 AM
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
-- Database: `db_buscador_conciertos`
--

-- --------------------------------------------------------

--
-- Table structure for table `bandas`
--

CREATE TABLE `bandas` (
  `id_banda` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `genero` varchar(200) NOT NULL,
  `pais_de_origen` varchar(200) NOT NULL,
  `img` varchar(300) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conciertos`
--

CREATE TABLE `conciertos` (
  `id_concierto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `lugar` varchar(200) NOT NULL,
  `ciudad` varchar(200) NOT NULL,
  `id_banda` int(11) NOT NULL,
  `precio_platea` int(11) NOT NULL,
  `precio_campo` int(11) NOT NULL,
  `precio_popular` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bandas`
--
ALTER TABLE `bandas`
  ADD PRIMARY KEY (`id_banda`);

--
-- Indexes for table `conciertos`
--
ALTER TABLE `conciertos`
  ADD PRIMARY KEY (`id_concierto`),
  ADD KEY `id_banda` (`id_banda`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bandas`
--
ALTER TABLE `bandas`
  MODIFY `id_banda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conciertos`
--
ALTER TABLE `conciertos`
  MODIFY `id_concierto` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conciertos`
--
ALTER TABLE `conciertos`
  ADD CONSTRAINT `conciertos_ibfk_1` FOREIGN KEY (`id_banda`) REFERENCES `bandas` (`id_banda`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
