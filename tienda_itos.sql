-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-06-2024 a las 01:00:46
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
-- Base de datos: `tienda_itos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `idAdmin` int(10) NOT NULL,
  `nombres` varchar(40) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `usuario` varchar(40) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`idAdmin`, `nombres`, `apellidos`, `email`, `usuario`, `password`) VALUES
(1, 'David', 'Mendoza', 'davidm@gmail.com', 'david2024', '$2y$10$CQ1OETxwwg53b0Lg2Bfy5uxgZTV.yYa4TAwUpTqh4rftAUEA8Tzh2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(10) NOT NULL,
  `nombreCategoria` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `nombreCategoria`) VALUES
(1110, 'agricultura'),
(1111, 'piscicultura'),
(1112, 'avicultura'),
(1113, 'ganaderia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(10) NOT NULL,
  `tipoDocumento` varchar(50) NOT NULL,
  `numeroDocumento` int(15) DEFAULT NULL,
  `nombres` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `direccion` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idCliente`, `tipoDocumento`, `numeroDocumento`, `nombres`, `apellidos`, `telefono`, `email`, `direccion`) VALUES
(16, '', 100139, 'eliuth', 'rosario', '273988', 'erosariohernandez@correo.unicordoba.edu.co', 'cr4-cl6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_factura`
--

CREATE TABLE `detalles_factura` (
  `idFactura` int(10) DEFAULT NULL,
  `idProducto` int(10) DEFAULT NULL,
  `nombre` varchar(20) NOT NULL,
  `precio` int(20) DEFAULT NULL,
  `cantidad` int(5) DEFAULT NULL,
  `subtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `detalles_factura`
--

INSERT INTO `detalles_factura` (`idFactura`, `idProducto`, `nombre`, `precio`, `cantidad`, `subtotal`) VALUES
(27, 2, 'Fumigadora RY', 237500, 1, 237500),
(29, 4, 'Maiz', 40000, 1, 40000),
(29, 3, 'Lorsban', 14700, 1, 14700),
(30, 1, 'Tropico', 30000, 1, 30000),
(31, 2, 'Fumigadora RY', 237500, 1, 237500),
(33, 1, 'Tropico', 30000, 1, 30000),
(34, 1, 'Tropico', 30000, 1, 30000),
(34, 3, 'Lorsban', 14700, 1, 14700);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `idFactura` int(10) NOT NULL,
  `idTransaccion` varchar(100) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` varchar(10) NOT NULL,
  `total` double DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `idCliente` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`idFactura`, `idTransaccion`, `fecha`, `estado`, `total`, `email`, `idCliente`) VALUES
(27, '6DS59882CT295591P', '2024-05-08 00:40:45', 'COMPLETED', 237500, 'erosariohernandez@correo.unico', 16),
(29, '2DY69274V69687545', '2024-05-11 15:52:12', 'COMPLETED', 54700, 'erosariohernandez@correo.unico', 16),
(30, '548839667M9904119', '2024-05-11 16:02:35', 'COMPLETED', 30000, 'erosariohernandez@correo.unico', 16),
(31, '27894328PB115354F', '2024-05-11 16:11:54', 'COMPLETED', 237500, 'erosariohernandez@correo.unico', 16),
(33, '22702492F0207412Y', '2024-06-22 06:51:15', 'COMPLETED', 30000, 'erosariohernandez@correo.unico', 16),
(34, '53L960124E083084G', '2024-06-28 00:16:45', 'COMPLETED', 44700, 'erosariohernandez@correo.unico', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(10) NOT NULL,
  `nombreProducto` varchar(20) DEFAULT NULL,
  `precio` int(20) DEFAULT NULL,
  `descuento` int(3) DEFAULT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `idCategoria` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombreProducto`, `precio`, `descuento`, `imagen`, `descripcion`, `idCategoria`) VALUES
(1, 'Tropico', 30000, 0, '../img/images_products/Tropico_1Lt.png', 'Herbicida', 1110),
(2, 'Fumigadora RY', 250000, 5, '../img/images_products/Fumigadora-RoyalCondor.png\r\n', 'Fumigadora Royal Condor', 1110),
(3, 'Lorsban', 15000, 2, '../img/images_products/LORSBAN-POLVO.jpg', 'Lorsban en polvo 1kg', 1110),
(4, 'Maiz', 40000, 0, '../img/images_products/Maiz.jpg', 'Maiz 1kg', 1110),
(5, 'Trilla', 30000, 0, '../img/images_products/Trilla_1Lt.jpg', 'Herbicida trilla', 1110),
(6, 'Hierro plus', 20000, 0, '../img/images_products/Hierro-plus.jpg', 'Hierro plus', 1113),
(7, 'Imizol', 25000, 0, '../img/images_products/Imizol.webp', 'Imizol - solucion inyectable', 1113),
(8, 'Diclofenaco novo', 25000, 0, '../img/images_products/diclofenaco-novo.png', 'Diclofenaco novo 50ml', 1113),
(11, 'Maiz Híbrido', 60000, 2, '../img/images_products/Maiz-Hibrido.webp', 'Kilo de maiz híbrido', 1110),
(12, 'Viruela Aviar', 12000, 0, '../img/images_products/ViruelaAviar.jpg', 'Viruela aviar', 1112),
(13, 'Pez color', 30000, 0, '../img/images_products/pez color pescarina x 1.57oz.jpg', 'pez color pescarina x 1.57', 1111),
(14, 'Oxivet', 15000, 0, '../img/images_products/oxivet-antibiotico-100g.jpg', 'oxivet-antibiotico-100gr', 1112),
(15, 'Nutrimin', 25000, 2, '../img/images_products/nutrimin-500ml.jpg', 'nutrimin-500ml', 1113),
(16, 'Seachem Garlic...', 18000, 0, '../img/images_products/Seachem Garlicguard.jpg', 'Seachem Garlicguard', 1111);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(10) NOT NULL,
  `usuario` varchar(30) DEFAULT NULL,
  `contrasena` varchar(200) DEFAULT NULL,
  `estado` int(2) DEFAULT 0,
  `token` varchar(200) DEFAULT NULL,
  `tokenPassword` varchar(200) DEFAULT NULL,
  `tokenRequest` int(2) NOT NULL,
  `idCliente` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuario`, `contrasena`, `estado`, `token`, `tokenPassword`, `tokenRequest`, `idCliente`) VALUES
(14, 'eliuth', '$2y$10$cic/c8T8p.kI4.KdRAAys.p43VaXlbI9r/9xOEjPUZxOQKcqL47ya', 1, '46213c277bcdbd9b3abed647e4e07c14', NULL, 0, 16);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `detalles_factura`
--
ALTER TABLE `detalles_factura`
  ADD KEY `idFactura` (`idFactura`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`idFactura`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idCliente` (`idCliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `idAdmin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1114;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `idFactura` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_factura`
--
ALTER TABLE `detalles_factura`
  ADD CONSTRAINT `detalles_factura_ibfk_1` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`idFactura`),
  ADD CONSTRAINT `detalles_factura_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`idCategoria`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
