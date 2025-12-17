-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-12-2025 a las 04:16:37
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--
CREATE DATABASE IF NOT EXISTS `restaurante` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `restaurante`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `idcat` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL COMMENT '0=disponible 1=bloqueado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcat`, `nombre`, `estado`) VALUES
(1, 'Entrantes', 0),
(2, 'Platos Principales', 0),
(3, 'Postres', 0),
(4, 'Bebidas', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

DROP TABLE IF EXISTS `mesa`;
CREATE TABLE `mesa` (
  `nmesa` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`nmesa`, `estado`) VALUES
(1, 0),
(2, 0),
(3, 0),
(4, 0),
(5, 0),
(6, 0),
(7, 0),
(8, 0),
(9, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE `pedido` (
  `idped` int(11) NOT NULL,
  `usuario` varchar(9) NOT NULL,
  `nmesa` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`idped`, `usuario`, `nmesa`, `estado`, `fecha`) VALUES
(22, '12345678A', 8, 1, '2025-12-17 03:11:23'),
(23, '12345678A', 5, 1, '2025-12-17 03:15:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_producto`
--

DROP TABLE IF EXISTS `pedido_producto`;
CREATE TABLE `pedido_producto` (
  `idline` int(11) NOT NULL,
  `idped` int(11) NOT NULL,
  `idprod` int(11) NOT NULL,
  `cant` int(11) NOT NULL,
  `comentario` varchar(255) DEFAULT NULL,
  `servido` tinyint(1) NOT NULL COMMENT '0=pendiente 1=servido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pedido_producto`
--

INSERT INTO `pedido_producto` (`idline`, `idped`, `idprod`, `cant`, `comentario`, `servido`) VALUES
(71, 22, 10, 5, '', 1),
(72, 22, 8, 3, 'afsdf', 1),
(73, 23, 9, 12, '', 1),
(74, 23, 8, 8, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `idprod` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `categoria` int(11) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idprod`, `nombre`, `precio`, `stock`, `estado`, `categoria`, `imagen`) VALUES
(1, 'Ensalada murciana (tomate, cebolla, aceitunas y huevo)', 12.50, 0, 0, 1, 'E1.png'),
(2, 'Zarangollo murciano (revuelto de calabacín, cebolla)', 7.50, 0, 0, 1, 'E2.png'),
(3, 'Pastel de carne murciano (hojaldre relleno de carne)', 3.00, 0, 0, 1, 'E3.png'),
(4, 'Michirones (habas secas guisadas con chorizo y pan)', 6.50, 0, 0, 1, 'E4.png'),
(5, 'Croquetas de jamón ibérico', 5.00, 0, 0, 1, 'E5.png'),
(6, 'Arroz caldero del Mar Menor (con pescado y alioli)', 14.00, 0, 0, 2, 'PP1.png'),
(7, 'Cordero segureño al horno con patatas', 15.50, 0, 0, 2, 'PP2.png'),
(8, 'Bacalao al ajo colorao', 13.00, 9, 0, 2, 'PP3.png'),
(9, 'Albóndigas de chato murciano con salsa casera', 12.50, 22, 0, 2, 'PP4.png'),
(10, 'Huevos rotos con jamón y patatas de la huerta', 9.50, 29, 0, 2, 'PP5.png'),
(11, 'Paparajotes murcianos (hojas de limón rebozadas en masa tipo churro)', 4.50, 34, 0, 3, 'P1.png'),
(12, 'Arroz con leche de la abuela', 4.00, 33, 0, 3, 'P2.png'),
(13, 'Tocino de cielo', 4.20, 41, 0, 3, 'P3.png'),
(14, 'Tarta de limón murciano', 5.00, 33, 0, 3, 'P4.png'),
(15, 'Pan de Calatrava', 4.00, 22, 0, 3, 'P5.png'),
(16, 'Vino tinto de Jumilla (copa)', 3.00, 40, 0, 4, 'B1.png'),
(17, 'Cerveza artesanal murciana', 3.50, 43, 0, 4, 'B2.png'),
(18, 'Agua mineral', 1.50, 43, 0, 4, 'B3.png'),
(19, 'Sangria casera', 4.50, 33, 0, 4, 'B4.png'),
(20, 'Refrescos', 2.10, 31, 0, 4, 'B5.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE `reserva` (
  `dni` varchar(9) NOT NULL,
  `nmesa` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `comensales` int(11) NOT NULL,
  `estado` int(11) NOT NULL COMMENT '0=en uso 1=terminada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`dni`, `nmesa`, `fecha`, `comensales`, `estado`) VALUES
('12345678A', 5, '2025-12-17 03:15:56', 1, 1),
('12345678A', 8, '2025-12-17 03:11:23', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `rol` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `pass` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'bloqueado=1 desbloqueado=0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`dni`, `nombre`, `apellidos`, `rol`, `email`, `telefono`, `direccion`, `pass`, `estado`) VALUES
('12345678A', 'Antonio', 'Vicente López', 0, 'tonikirosiki@ladespensa.es', '658987453', 'C/Murillo,38', '1234', 0),
('12345678B', 'Alvaro', 'Martinez Sanz', 1, 'alvarodevs@ladespensa.es', '658985913', 'C/Santiago,12', '1234', 0),
('12345678C', 'Adrian', 'Vicente López', 2, 'adrianvincent@ladespensa.es', '685248569', 'C/Albeniz,26', '1234', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcat`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`nmesa`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idped`),
  ADD KEY `usuario` (`usuario`,`nmesa`),
  ADD KEY `nmesa` (`nmesa`);

--
-- Indices de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  ADD PRIMARY KEY (`idline`),
  ADD KEY `idped` (`idped`),
  ADD KEY `idprod` (`idprod`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idprod`),
  ADD KEY `categoria` (`categoria`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`dni`,`nmesa`,`fecha`),
  ADD KEY `dni` (`dni`,`nmesa`),
  ADD KEY `nmesa` (`nmesa`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`dni`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idped` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  MODIFY `idline` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idprod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`nmesa`) REFERENCES `mesa` (`nmesa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  ADD CONSTRAINT `fk_pp_new_pedido` FOREIGN KEY (`idped`) REFERENCES `pedido` (`idped`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pp_new_prod` FOREIGN KEY (`idprod`) REFERENCES `producto` (`idprod`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`idcat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`nmesa`) REFERENCES `mesa` (`nmesa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
