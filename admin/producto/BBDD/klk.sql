-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2019 a las 09:05:51
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `klk`
--
CREATE DATABASE IF NOT EXISTS `klk` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `klk`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lol`
--

DROP TABLE IF EXISTS `lol`;
CREATE TABLE IF NOT EXISTS `lol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `idioma` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `matricula` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `lenguaje` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `lol`
--

INSERT INTO `lol` (`id`, `dni`, `nombre`, `email`, `password`, `idioma`, `matricula`, `lenguaje`, `fecha`, `imagen`) VALUES
(7, '55552885p', 'bastante peras', 'mc16@hotmail.com', '9775c6463b28711ca83740d98a96e399', 'castellano,ingles,frances', 'modular', 'PYTHON', '20-11-2019', '47635230d4f2b818b15c0c9b767316fd.jpeg'),
(11, '11112885r', 'estafania sanchez perez', 'julio_teran@hotmail.com', '7c747ac83bd29fe80959a99e57de263d', 'castellano', 'modular', 'JAVA', '19/11/2019', '4ba4b53bed84be55d20e224002560d21.jpeg'),
(12, '06622885c', 'tatis jr', 'mcberra16@hotmail.com', '1f6adc340991c47005c9bcbf9ab8bac5', 'castellano', 'modular', 'PHP', '19/11/2019', '113ca7c133d2446922291439dc05259a.jpeg'),
(15, '77722885l', 'eloy jimenez', 'mcberra16@hotmail.com', 'cca6935d62f66d603669d5c4003f4938', 'castellano', 'modular', 'PHP', '19/11/2019', 'eb326ba9af86af6c3bf50180d71e2f82.jpeg'),
(16, '88882885o', 'ronald acuÃ±a jr', 'mcberra16@hotmail.com', 'cca6935d62f66d603669d5c4003f4938', 'castellano, ingles, frances, c', 'modular', 'PHP', '19/11/2019', 'b6bed9186d4f27f68564f8e69da38122.jpeg'),
(18, '11112885i', 'ahora si', 'mcberra16@hotmail.com', 'cca6935d62f66d603669d5c4003f4938', 'castellano,ingles,frances', 'completa', 'C#', '19/11/2019', '24125c683e54e4026ce32d1454f66922.jpeg'),
(19, '06622885y', 'cabomillo', 'mcberra16@hotmail.com', 'cca6935d62f66d603669d5c4003f4938', 'castellano,ingles', 'modular', 'PHP', '19/11/2019', '42e4af76f7d93aab250c2014fdcbdbf1.jpeg'),
(26, '11112880o', 'gordi joeeeeeeeeeeee', 'mcberra16@hotmail.com', 'cca6935d62f66d603669d5c4003f4938', 'castellano', 'modular', 'PHP', '18/11/2019', 'c2cc3e320875a42bff2b475a54b11cf7.jpeg'),
(27, '11112887t', 'cocolauran', 'mcberra16@hotmail.com', 'cca6935d62f66d603669d5c4003f4938', 'chino', 'modular', 'PHP', '19/11/2019', '5d89069aa255e02535d4dcca170cb34a.jpeg'),
(28, '11112866u', 'estafania sanchez', 'mcberra16@hotmail.com', 'cca6935d62f66d603669d5c4003f4938', 'castellano', 'modular', 'PHP', '20-11-2019', 'c3c5f859fb6b53eeb3d03ff715806c5d.jpeg'),
(32, '12417885m', 'imagen size', 'mcberra16@hotmail.com', 'cca6935d62f66d603669d5c4003f4938', 'castellano', 'modular', 'PHP', '20-11-2019', '8295c64de6a54deccdddc3900a315604.jpeg'),
(33, '00002885k', 'coco rulay', 'mcberra16@hotmail.com', 'cca6935d62f66d603669d5c4003f4938', 'castellano', 'modular', 'PHP', '20-11-2019', 'fff75314b7bd999028ae7890a68cbc6d.jpeg'),
(34, '12121212u', 'scythe of lugia', 'shelowshaq16@hotmail.com', 'e33eca8014f708a0eb5001585a3568d6', 'castellano,frances', 'modular', 'PYTHON', '20-11-2019', '099259a677a18d8b5e22523fc792cfad.jpeg'),
(35, '06622885s', 'gordi bonita', 'mcberra16@hotmail.com', 'cca6935d62f66d603669d5c4003f4938', 'castellano,ingles,chino', 'modular', 'PHP', '20-11-2019', 'b63458a78fa8deb296da5119d2175516.jpeg'),
(36, '11112864b', 'gordi close', 'mcberra16@hotmail.com', 'cca6935d62f66d603669d5c4003f4938', 'castellano,ingles', 'modular', 'PHP', '20-11-2019', '9c7bdd8bfb7a1a117a4ecad2ec8a9483.jpeg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
