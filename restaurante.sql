-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2025 a las 13:04:38
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

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
(2, 'Platos principales', 0),
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
(1, 1),
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
  `estado` tinyint(1) NOT NULL,
  `usuario` varchar(9) NOT NULL,
  `nmesa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`idped`, `estado`, `usuario`, `nmesa`) VALUES
(1, 0, '12345678C', 1);

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
(1, 1, 52, 1, NULL, 0),
(2, 1, 52, 1, 'asdf', 0),
(3, 1, 52, 1, 'sadfa', 0),
(4, 1, 52, 1, 'sin cebolla', 0),
(5, 1, 52, 1, 'ewrtw', 0),
(6, 1, 49, 1, 'wwww', 0),
(7, 1, 13, 3, 'pepe', 0),
(8, 1, 13, 2, '', 0);

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
  `estado_cat` tinyint(1) NOT NULL COMMENT '0=disponible 1=bloqueado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idprod`, `nombre`, `precio`, `stock`, `estado`, `categoria`, `estado_cat`) VALUES
(1, 'Ensalada murciana (tomate, cebolla, aceitunas y bacalao desmigado)', 7.50, 30, 0, 1, 0),
(2, 'Zarangollo murciano (revuelto de calabacín, cebolla y huevo)', 7.50, 42, 0, 1, 0),
(3, 'Pimientos asados con ventresca', 9.00, 33, 0, 1, 0),
(4, 'Ensalada de perdiz escabechada', 11.00, 18, 0, 1, 0),
(5, 'Pastel de carne murciano (hojaldre relleno de carne, chorizo y huevo)', 4.50, 47, 0, 1, 0),
(6, 'Michirones (habas secas guisadas con chorizo y panceta)', 6.50, 39, 0, 1, 0),
(7, 'Queso al pimentón de Yecla', 5.50, 44, 0, 1, 0),
(8, 'Croquetas de jamón ibérico', 7.00, 29, 0, 1, 0),
(9, 'Pan con tomate y aceite de la huerta', 3.50, 49, 0, 1, 0),
(10, 'Ensalada templada de alcachofas con jamón', 9.50, 28, 0, 1, 0),
(11, 'Tabla de embutidos murcianos (longaniza, morcón, salchicha seca)', 10.00, 37, 0, 1, 0),
(12, 'Revuelto de setas con ajos tiernos', 8.00, 43, 0, 1, 0),
(13, 'Calabacines rellenos de verduras', 8.50, 30, 0, 1, 0),
(14, 'Buñuelos de bacalao fresco', 5.70, 32, 0, 2, 0),
(15, 'Tostada de sobrasada con miel de azahar', 5.00, 45, 0, 1, 0),
(16, 'Arroz con conejo y caracoles al estilo murciano', 13.50, 33, 0, 2, 0),
(17, 'Arroz caldero del Mar Menor (con pescado y alioli)', 14.00, 40, 0, 2, 0),
(18, 'Guiso de trigo con legumbres y embutido', 12.00, 28, 0, 2, 0),
(19, 'Cordero segureño al horno con patatas', 15.50, 24, 0, 2, 0),
(20, 'Bacalao al ajo colorao', 13.00, 31, 0, 2, 0),
(21, 'Pollo al ajillo con vino blanco', 11.00, 44, 0, 2, 0),
(22, 'Pisto de la huerta con huevo a baja temperatura', 10.00, 39, 0, 2, 0),
(23, 'Conejo al tomillo', 14.00, 35, 0, 2, 0),
(24, 'Lomo a la murciana (con pimientos y tomate frito)', 11.50, 46, 0, 2, 0),
(25, 'Chuletas de cordero segureño con guarnición', 15.00, 38, 0, 2, 0),
(26, 'Gachas murcianas con tropezones', 10.00, 41, 0, 2, 0),
(27, 'Albóndigas de chato murciano con salsa casera', 12.50, 43, 0, 2, 0),
(28, 'Merluza en salsa verde con almejas', 13.50, 36, 0, 2, 0),
(29, 'Estofado de ternera con verduras de temporada', 12.00, 29, 0, 2, 0),
(30, 'Huevos rotos con jamón y patatas de la huerta', 9.50, 48, 0, 2, 0),
(31, 'Paparajotes murcianos (hojas de limón rebozadas en azúcar y canela)', 4.50, 37, 0, 3, 0),
(32, 'Arroz con leche de la abuela', 4.00, 40, 0, 3, 0),
(33, 'Natillas caseras con canela', 3.80, 45, 0, 3, 0),
(34, 'Tocino de cielo', 4.20, 41, 0, 3, 0),
(35, 'Tarta de limón murciano', 5.00, 33, 0, 3, 0),
(36, 'Flan de huevo al baño maría', 3.50, 48, 0, 3, 0),
(37, 'Helado de turrón artesanal', 4.50, 43, 0, 3, 0),
(38, 'Pan de Calatrava', 4.00, 28, 0, 3, 0),
(39, 'Torrijas con miel de romero', 4.50, 31, 0, 3, 0),
(40, 'Leche frita con azúcar y canela', 4.00, 34, 0, 3, 0),
(41, 'Tarta de queso con mermelada de higo', 5.50, 46, 0, 3, 0),
(42, 'Mousse de limón del Valle de Ricote', 4.80, 29, 0, 3, 0),
(43, 'Bizcocho borracho de Jumilla', 4.50, 42, 0, 3, 0),
(44, 'Peras al vino tinto', 4.50, 25, 0, 3, 0),
(45, 'Brownie de chocolate con nueces', 5.00, 37, 0, 3, 0),
(46, 'Vino tinto de Jumilla (copa)', 3.00, 40, 0, 4, 0),
(47, 'Vino blanco de Yecla (copa)', 3.00, 43, 0, 4, 0),
(48, 'Vino rosado de Bullas (copa)', 3.00, 35, 0, 4, 0),
(49, 'Botella vino tinto Jumilla', 12.00, 11, 0, 4, 0),
(50, 'Cerveza artesanal murciana', 3.50, 50, 0, 4, 0),
(51, 'Cerveza sin alcohol', 3.00, 45, 0, 4, 0),
(52, 'Agua mineral', 1.50, 8, 0, 4, 0),
(53, 'Refrescos variados', 2.20, 47, 0, 4, 0),
(54, 'Zumo natural de naranja', 2.80, 33, 0, 4, 0),
(55, 'Mosto de uva blanca', 2.50, 44, 0, 4, 0),
(56, 'Sangría casera', 4.50, 38, 0, 4, 0),
(57, 'Clara con limón', 2.80, 41, 0, 4, 0),
(58, 'Café solo', 1.50, 49, 0, 4, 0),
(59, 'Café bombón murciano (con leche condensada)', 2.00, 33, 0, 4, 0),
(60, 'Té de hierbabuena', 2.20, 39, 0, 4, 0),
(61, 'Chupito de hierbas Ruavieja ', 1.00, 25, 0, 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE `reserva` (
  `dni` varchar(9) NOT NULL,
  `nmesa` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `comensales` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`dni`, `nmesa`, `fecha`, `comensales`) VALUES
('12345678C', 1, '2025-11-19 00:35:50', 3);

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
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `pass` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'bloqueado=1 desbloqueado=0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`dni`, `nombre`, `apellidos`, `rol`, `email`, `telefono`, `direccion`, `pass`, `estado`) VALUES
('12345678A', 'Adrian', 'Vicente Lopez', 2, 'AV@ladepensa.com', '685247480', 'C/Albeniz,26', '1234', 0),
('12345678B', 'Zaraida', 'Aviles Saez', 1, 'ZAS@ladespensa.com', '689235412', 'C/Cabo Salou,41', '1234', 0),
('12345678C', 'Álvaro', 'Martinez Guiterrez', 0, 'AM@ladespensa.com', '685289523', '', '1234', 0);

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
  MODIFY `idped` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  MODIFY `idline` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idprod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

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
