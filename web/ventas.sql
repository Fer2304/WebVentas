-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2020 a las 17:02:54
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
-- Base de datos: `ventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agentes`
--

CREATE TABLE `agentes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `contra` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `puesto` int(11) NOT NULL,
  `id_ciudad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `agentes`
--

INSERT INTO `agentes` (`id`, `nombre`, `contra`, `puesto`, `id_ciudad`) VALUES
(1, 'a', '$2a$07$usesomesillystringforeh6tvwDNOAiEn9PYXfY79K3vDiKj6Ib6', 2, 1),
(2, 'e', '$2a$07$usesomesillystringforeh6tvwDNOAiEn9PYXfY79K3vDiKj6Ib6', 1, 1),
(10, 's', '$2a$07$usesomesillystringforeh6tvwDNOAiEn9PYXfY79K3vDiKj6Ib6', 1, 1),
(11, 'yy', '$2a$07$usesomesillystringforeh6tvwDNOAiEn9PYXfY79K3vDiKj6Ib6', 1, 1),
(12, 'd', '$2a$07$usesomesillystringforeh6tvwDNOAiEn9PYXfY79K3vDiKj6Ib6', 1, 3),
(13, 'ww', '$2a$07$usesomesillystringforeh6tvwDNOAiEn9PYXfY79K3vDiKj6Ib6', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agentes_ventas`
--

CREATE TABLE `agentes_ventas` (
  `id` int(11) NOT NULL,
  `id_agente` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `fecha_venta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `agentes_ventas`
--

INSERT INTO `agentes_ventas` (`id`, `id_agente`, `id_venta`, `fecha_venta`) VALUES
(1, 1, 1, '0000-00-00'),
(2, 1, 1, '0000-00-00'),
(3, 1, 2, '0000-00-00'),
(4, 1, 3, '0000-00-00'),
(5, 2, 1, '0000-00-00'),
(6, 2, 1, '0000-00-00'),
(7, 2, 3, '2020-06-12'),
(8, 1, 1, '2020-06-12'),
(9, 1, 1, '0000-00-00'),
(10, 1, 1, '2000-01-12'),
(11, 1, 2, '2020-06-12'),
(12, 1, 1, '2020-06-12'),
(13, 1, 2, '2020-06-12'),
(14, 1, 3, '2020-06-12'),
(15, 1, 1, '2020-06-12'),
(16, 1, 1, '2020-06-11'),
(17, 12, 1, '2020-06-11'),
(18, 12, 2, '2020-06-11'),
(19, 12, 3, '2020-06-11'),
(20, 12, 4, '2020-06-11'),
(21, 1, 1, '2020-06-13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id_ciudad` int(11) NOT NULL,
  `nom_ciudad` varchar(40) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id_ciudad`, `nom_ciudad`) VALUES
(1, 'valencia'),
(2, 'alicante'),
(3, 'castellon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_venta`
--

CREATE TABLE `tipo_venta` (
  `id_venta` int(11) NOT NULL,
  `nom_venta` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `importe_venta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_venta`
--

INSERT INTO `tipo_venta` (`id_venta`, `nom_venta`, `importe_venta`) VALUES
(1, 'FIJO', 14),
(2, 'MOVIL', 18),
(3, 'FIJO + INTERNET', 28),
(4, 'FIJO + INTERNET + MOVIL (CONVERGENTE)', 30);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agentes`
--
ALTER TABLE `agentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `agentes_ventas`
--
ALTER TABLE `agentes_ventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id_ciudad`);

--
-- Indices de la tabla `tipo_venta`
--
ALTER TABLE `tipo_venta`
  ADD PRIMARY KEY (`id_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agentes`
--
ALTER TABLE `agentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `agentes_ventas`
--
ALTER TABLE `agentes_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_venta`
--
ALTER TABLE `tipo_venta`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
