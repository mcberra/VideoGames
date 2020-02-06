-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-02-2020 a las 21:26:54
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
-- Base de datos: `tienda`
--
CREATE DATABASE IF NOT EXISTS `tienda` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `tienda`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

DROP TABLE IF EXISTS `direccion`;
CREATE TABLE IF NOT EXISTS `direccion` (
  `email_usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `direccion2` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `codigo_postal` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `pais` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `id_compra` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`email_usuario`, `direccion`, `direccion2`, `ciudad`, `estado`, `codigo_postal`, `pais`, `id_compra`) VALUES
('mcberra16@hotmail.com', 'calle adelfas # 59, Ciudad Real', 'ninguna', 'CIUDAD REAL', 'Ciudad Real', '13005', 'EspaÃ±a', '2020-02-06T08:52:36.000000'),
('invitado', 'calle adelfas # 59, Ciudad Real', 'ninguna', 'CIUDAD REAL', 'Ciudad Real', '13111', 'EspaÃ±a', '2020-02-06T21:00:18.000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `distribuidor` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `descuento` tinyint(5) NOT NULL,
  `stock` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `tipo`, `distribuidor`, `precio`, `descuento`, `stock`, `imagen`) VALUES
(4, 'Fifa 2020', 'consola', 'EA', '62.99', 0, '177', '5bd218eb90341b88c43a2b054f4a42d2.jpeg'),
(5, 'Halo 4', 'consola', 'EA', '55.00', 0, '196', '1bafe20ffec1a73857001831936c87b7.jpeg'),
(7, 'Fall out 4', 'consola', 'EA', '40.00', 5, '87', '0ec39a29f4e5749531451ae9f8925cce.jpeg'),
(8, 'Grant theft auto V', 'consola', 'EA', '85.00', 46, '0', '8341694a9a57471658c08ebfd5306a45.jpeg'),
(12, 'Assasin\'s Creed', 'consola', 'EA', '38.00', 15, '100', '16bc0c7c23ed03189a0352873933ed54.jpeg'),
(14, 'Mortal Combat 11', 'consola', 'EA', '40.00', 0, '99', 'fb76af4f475cced61585bacd6733588d.jpeg'),
(16, 'Fornite', 'consola', 'EA', '32.00', 0, '200', 'db70391fea011e9fab9ecf116c599479.jpeg'),
(17, 'Star Wars: Fallen Order', 'consola', 'EA', '37.00', 20, '97', '5e27a3e8c41909373b559039a5c4ab21.jpeg'),
(18, 'Call Of Duty: Modern Warfare', 'consola', 'EA', '65.00', 10, '198', 'bf4dd1e158a9e8d64e7efd9874d56410.jpeg'),
(19, 'Nba 2K20', 'consola', 'EA', '31.00', 0, '100', '7c6d0554596b620950bfd47ec7062891.jpeg'),
(20, 'god of war', 'consola', 'EA', '35.00', 0, '100', 'e0eb1996d37aa7fcc3e1c76dd1513d7a.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `admin` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`, `apellido`, `admin`, `telefono`, `fecha`, `imagen`) VALUES
(6, 'normal@hotmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'normal', 'normal', 'no', '645-412-400', '22-01-2020', 'ba29b409c1c18bff5572326d0ef49367.jpeg'),
(9, 'mcberra16@hotmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'manuel antonio', 'berra', 'si', '645-400-789', '27-01-2020', '40f3c74c326eb8e7149319ea28f97edf.jpeg'),
(10, 'admin@admin.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin', 'admin', 'si', '645-488-789', '06-02-2020', '34ee037d241b50db940340cfafa1605a.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id_compra` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `email_usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `numero_tarjeta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `total` int(60) NOT NULL,
  `fecha` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_compra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_compra`, `email_usuario`, `numero_tarjeta`, `total`, `fecha`) VALUES
('2020-02-06T08:52:36.000000', 'mcberra16@hotmail.com', 'd67bf3455992e59530ebf36a672a52e7c5f21601891de2f4c8382291e553dd14', 227, '06-02-2020'),
('2020-02-06T21:00:18.000000', 'Invitado', 'd67bf3455992e59530ebf36a672a52e7c5f21601891de2f4c8382291e553dd14', 246, '06-02-2020');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
