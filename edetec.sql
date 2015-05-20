-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 20-05-2015 a las 04:14:56
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `edetec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Comentarios`
--

CREATE TABLE IF NOT EXISTS `Comentarios` (
  `ID` int(11) NOT NULL,
  `ContenidoID` int(11) DEFAULT NULL,
  `RaizID` int(11) NOT NULL,
  `PadreID` int(11) DEFAULT NULL,
  `Fecha` datetime NOT NULL,
  `Baneado` bit(1) NOT NULL,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contenidos`
--

CREATE TABLE IF NOT EXISTS `Contenidos` (
  `ID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Contenidos`
--

INSERT INTO `Contenidos` (`ID`) VALUES
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(33),
(34),
(35),
(38),
(39),
(40),
(41),
(42),
(43),
(44),
(52),
(53),
(54),
(55),
(56),
(57),
(62),
(63),
(74),
(75),
(76),
(79),
(82),
(83),
(89),
(90),
(91),
(92),
(93),
(95),
(96),
(97),
(116),
(117),
(118),
(119),
(120),
(121),
(122),
(123),
(124),
(125),
(126),
(127),
(139),
(140),
(141),
(146),
(147),
(156),
(160),
(161),
(164),
(165),
(168),
(169),
(171),
(172),
(173),
(174);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Eventos`
--

CREATE TABLE IF NOT EXISTS `Eventos` (
  `ID` int(11) NOT NULL,
  `Tiempo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DescripcionID` int(11) DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT '1',
  `Prioridad` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imagenes`
--

CREATE TABLE IF NOT EXISTS `Imagenes` (
  `ID` int(11) NOT NULL,
  `Url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Alt` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TituloID` int(11) NOT NULL,
  `LenguajeID` int(11) DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT '1',
  `Prioridad` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Imagenes`
--

INSERT INTO `Imagenes` (`ID`, `Url`, `Alt`, `TituloID`, `LenguajeID`, `Visible`, `Prioridad`) VALUES
(27, 'http://localhost/Web/imgsEj/img03.jpg', '', 139, 1, 1, 30),
(28, 'http://localhost/Web/imgsEj/img00.jpg', '', 140, 1, 1, 1),
(29, 'http://localhost/Web/imgsEj/img02.jpg', '', 141, 1, 1, 7),
(30, 'http://localhost/Web/imgsEj/img04.jpg', '', 156, 1, 1, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Lenguajes`
--

CREATE TABLE IF NOT EXISTS `Lenguajes` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `Pais` varchar(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Lenguajes`
--

INSERT INTO `Lenguajes` (`ID`, `Nombre`, `Pais`) VALUES
(1, 'Castellano', 'ar'),
(2, 'Ingles', 'us'),
(3, 'Cuba', 'cu'),
(4, 'Afganistán', 'af');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Menu`
--

CREATE TABLE IF NOT EXISTS `Menu` (
  `ID` int(11) NOT NULL,
  `ContenidoID` int(11) NOT NULL,
  `SeccionID` int(11) DEFAULT NULL,
  `Url` varchar(256) COLLATE utf8_unicode_ci DEFAULT '#',
  `Prioridad` int(11) DEFAULT NULL,
  `Visible` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Menu`
--

INSERT INTO `Menu` (`ID`, `ContenidoID`, `SeccionID`, `Url`, `Prioridad`, `Visible`) VALUES
(2, 172, NULL, '#gal', 10, 1),
(3, 173, NULL, '#nov', 20, 1),
(4, 174, NULL, '#mapa', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Modulos`
--

CREATE TABLE IF NOT EXISTS `Modulos` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Archivo` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` text COLLATE utf8_unicode_ci,
  `PadreID` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Modulos`
--

INSERT INTO `Modulos` (`ID`, `Nombre`, `Archivo`, `Descripcion`, `PadreID`) VALUES
(1, 'Galeria', 'seccs/galeria.php', 'Una galería de fotos', NULL),
(2, NULL, 'seccs/galeria.css', NULL, 1),
(6, 'Inicio', 'seccs/sobre_unitec.php', NULL, NULL),
(7, NULL, 'seccs/sobre_unitec.css', NULL, 6),
(8, 'Calendario', 'seccs/calendario.php', NULL, NULL),
(9, NULL, 'seccs/calendario.css', NULL, 8),
(10, 'Atajos', 'seccs/atajos.php', NULL, NULL),
(11, 'Mapa', 'seccs/mapa.php', NULL, NULL),
(12, 'Novedades', 'seccs/novedades.php', NULL, NULL),
(13, NULL, 'seccs/novedades.css', NULL, 12),
(14, NULL, 'seccs/mapa.css', NULL, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Novedades`
--

CREATE TABLE IF NOT EXISTS `Novedades` (
  `ID` int(11) NOT NULL,
  `ImagenID` int(11) DEFAULT NULL,
  `TituloID` int(11) DEFAULT NULL,
  `DescripcionID` int(11) DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Visible` tinyint(1) DEFAULT '1',
  `Prioridad` int(11) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Novedades`
--

INSERT INTO `Novedades` (`ID`, `ImagenID`, `TituloID`, `DescripcionID`, `Fecha`, `Visible`, `Prioridad`) VALUES
(4, 28, 147, 146, '2015-05-12', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Opciones`
--

CREATE TABLE IF NOT EXISTS `Opciones` (
  `ID` int(11) NOT NULL,
  `Dominio` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tipo` int(11) DEFAULT NULL,
  `Valor` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Pred` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Secciones`
--

CREATE TABLE IF NOT EXISTS `Secciones` (
  `ID` int(11) NOT NULL,
  `ContenidoID` int(11) DEFAULT NULL,
  `ModuloID` int(128) DEFAULT NULL,
  `PadreID` int(11) DEFAULT NULL,
  `Visible` tinyint(1) DEFAULT NULL,
  `Prioridad` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Secciones`
--

INSERT INTO `Secciones` (`ID`, `ContenidoID`, `ModuloID`, `PadreID`, `Visible`, `Prioridad`) VALUES
(240, NULL, NULL, NULL, 1, 2),
(241, NULL, 8, 240, 1, 1),
(242, NULL, NULL, NULL, 1, 3),
(243, NULL, 1, 242, 1, 1),
(244, NULL, NULL, NULL, 1, 4),
(245, NULL, 12, 244, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Traducciones`
--

CREATE TABLE IF NOT EXISTS `Traducciones` (
  `ID` int(11) NOT NULL,
  `ContenidoID` int(11) NOT NULL,
  `LenguajeID` int(11) NOT NULL,
  `Texto` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Traducciones`
--

INSERT INTO `Traducciones` (`ID`, `ContenidoID`, `LenguajeID`, `Texto`) VALUES
(12, 5, 1, 'Seccion 1'),
(13, 6, 1, 'Seccion 2'),
(14, 7, 1, 'Seccion 1 Bis'),
(15, 8, 1, 'Seccion 1'),
(16, 9, 1, 'Seccion2'),
(17, 10, 1, 'Seccion 1 bis'),
(18, 11, 1, 'Seccion1'),
(19, 12, 1, 'Seccion2'),
(20, 13, 1, 'Seccion1'),
(21, 14, 1, 'Seccion2'),
(23, 16, 1, 'Seccion1'),
(24, 17, 1, 'Seccion2'),
(25, 18, 1, 'Seccion1'),
(26, 19, 1, 'Seccion2'),
(27, 20, 1, 'Seccion1 bis'),
(28, 21, 1, 'Seccion1'),
(29, 22, 1, 'Seccion2'),
(30, 23, 1, 'Seccion1'),
(31, 24, 1, 'Seccion2'),
(32, 25, 1, 'Seccion1'),
(33, 26, 1, 'Seccion2'),
(34, 27, 1, '1'),
(35, 28, 1, '2'),
(36, 29, 1, '1 bis'),
(37, 30, 1, 'pre 2'),
(38, 31, 1, '[center][size=200]INICIO[/size][/center]'),
(40, 34, 1, 'Hola'),
(41, 35, 1, 'Hola'),
(44, 38, 1, 'Mundo\r\n'),
(45, 39, 1, 'mundo'),
(46, 40, 1, 'mundo'),
(47, 41, 1, 'asx'),
(48, 42, 1, 'asx'),
(49, 43, 1, 'as'),
(50, 44, 1, 'as'),
(58, 52, 1, 'lkmlkm'),
(59, 53, 1, 'lkmlkm'),
(60, 54, 1, 'Mundo'),
(61, 55, 1, 'Hola'),
(62, 56, 1, '[list][*]asxsax\r\n[/*][/list]'),
(63, 57, 1, 'asx'),
(68, 62, 1, 'asx'),
(69, 63, 1, 'asx'),
(80, 74, 1, 'Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam \r\nvocabular. Li lingues differe solmen in li grammatica, li pronunciation e\r\n li plu commun vocabules. Omnicos directe al desirabilite de un nov \r\nlingua franca: On refusa continuar payar custosi traductores. At solmen \r\nva esser necessi far uniform grammatica, pronunciation e plu sommun \r\nparoles. Ma quande lingu'),
(81, 75, 1, 'Lorem'),
(82, 76, 1, 'saxx'),
(85, 79, 1, 'asxasx'),
(88, 82, 1, '   Un [b]Mundo [i]Cruel[u] ssss[/u][/i][/b]'),
(89, 83, 1, 'Hola Mundo'),
(95, 89, 1, 'Mundo'),
(96, 90, 1, 'Hola'),
(97, 91, 1, 'Buena Gibson'),
(98, 92, 1, 'No?'),
(99, 93, 1, 'Una Gibson SG'),
(127, 116, 1, '   asx'),
(128, 117, 1, '   asx'),
(129, 118, 1, '   asxasx'),
(130, 119, 1, '   asxasdc'),
(131, 119, 1, '   asxasdc'),
(132, 120, 1, '   '),
(133, 121, 1, '   asxasxsaxasxasx'),
(134, 122, 1, '   asxasxasx'),
(135, 123, 1, '   asdc'),
(136, 124, 1, '   asxasx'),
(137, 125, 1, '   asxasx'),
(138, 126, 1, '   asxasx'),
(139, 127, 1, '   kkkkkkkkkkkkkkkk'),
(151, 139, 1, 'El Pianito editado'),
(152, 140, 1, 'Una Gibson SG editada'),
(153, 141, 1, 'El Pianito editado'),
(158, 146, 1, '         asxasx'),
(159, 147, 1, 'asxasx123adcasdc'),
(168, 156, 1, 'Otro pianito'),
(172, 160, 1, 'Novedades'),
(173, 161, 1, 'Galeria'),
(176, 164, 1, 'Novedades'),
(177, 165, 1, 'Galeria'),
(180, 168, 1, 'Mapa'),
(181, 169, 1, 'Novedades'),
(183, 171, 1, 'Mapa'),
(184, 172, 1, 'Galeria'),
(185, 173, 1, 'Novedades'),
(186, 174, 1, 'Mapa'),
(193, 173, 2, 'News');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE IF NOT EXISTS `Usuarios` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NombreUsuario` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contrasena` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Baneado` bit(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`ID`, `Nombre`, `NombreUsuario`, `Contrasena`, `Email`, `Baneado`) VALUES
(1, 'Gonzalo García', 'snorkellingcactus', '38f448b51331bdedab93f9a15d2c1635eaf459a7 ', 'snorkellingcactus@gmail.com', b'0');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Comentarios`
--
ALTER TABLE `Comentarios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Comentarios_ibfk_3` (`ContenidoID`),
  ADD KEY `Comentarios_ibfk_2` (`RaizID`),
  ADD KEY `Comentarios_ibfk_4` (`PadreID`);

--
-- Indices de la tabla `Contenidos`
--
ALTER TABLE `Contenidos`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `Eventos`
--
ALTER TABLE `Eventos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Eventos_ibfk_1` (`DescripcionID`);

--
-- Indices de la tabla `Imagenes`
--
ALTER TABLE `Imagenes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `LenguajeID` (`LenguajeID`),
  ADD KEY `Imagenes_ibfk_1` (`TituloID`);

--
-- Indices de la tabla `Lenguajes`
--
ALTER TABLE `Lenguajes`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `Menu`
--
ALTER TABLE `Menu`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ContenidoID` (`ContenidoID`),
  ADD KEY `SeccionID` (`SeccionID`);

--
-- Indices de la tabla `Modulos`
--
ALTER TABLE `Modulos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Padre` (`PadreID`);

--
-- Indices de la tabla `Novedades`
--
ALTER TABLE `Novedades`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Novedades_ibfk_1` (`ImagenID`),
  ADD KEY `Novedades_ibfk_2` (`TituloID`),
  ADD KEY `Novedades_ibfk_3` (`DescripcionID`);

--
-- Indices de la tabla `Opciones`
--
ALTER TABLE `Opciones`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `Secciones`
--
ALTER TABLE `Secciones`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ModuloID` (`ModuloID`),
  ADD KEY `Secciones_ibfk_1` (`ContenidoID`),
  ADD KEY `Secciones_ibfk_3` (`PadreID`);

--
-- Indices de la tabla `Traducciones`
--
ALTER TABLE `Traducciones`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `LenguajeID` (`LenguajeID`),
  ADD KEY `Traducciones_ibfk_1` (`ContenidoID`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Comentarios`
--
ALTER TABLE `Comentarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Contenidos`
--
ALTER TABLE `Contenidos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=179;
--
-- AUTO_INCREMENT de la tabla `Eventos`
--
ALTER TABLE `Eventos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT de la tabla `Imagenes`
--
ALTER TABLE `Imagenes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT de la tabla `Lenguajes`
--
ALTER TABLE `Lenguajes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `Menu`
--
ALTER TABLE `Menu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `Modulos`
--
ALTER TABLE `Modulos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `Novedades`
--
ALTER TABLE `Novedades`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `Opciones`
--
ALTER TABLE `Opciones`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Secciones`
--
ALTER TABLE `Secciones`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=246;
--
-- AUTO_INCREMENT de la tabla `Traducciones`
--
ALTER TABLE `Traducciones`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=194;
--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Comentarios`
--
ALTER TABLE `Comentarios`
  ADD CONSTRAINT `Comentarios_ibfk_2` FOREIGN KEY (`RaizID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Comentarios_ibfk_3` FOREIGN KEY (`ContenidoID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Comentarios_ibfk_4` FOREIGN KEY (`PadreID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Eventos`
--
ALTER TABLE `Eventos`
  ADD CONSTRAINT `Eventos_ibfk_1` FOREIGN KEY (`DescripcionID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Imagenes`
--
ALTER TABLE `Imagenes`
  ADD CONSTRAINT `Imagenes_ibfk_1` FOREIGN KEY (`TituloID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Imagenes_ibfk_2` FOREIGN KEY (`LenguajeID`) REFERENCES `Lenguajes` (`ID`);

--
-- Filtros para la tabla `Menu`
--
ALTER TABLE `Menu`
  ADD CONSTRAINT `Menu_ibfk_1` FOREIGN KEY (`ContenidoID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Menu_ibfk_2` FOREIGN KEY (`SeccionID`) REFERENCES `Secciones` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Modulos`
--
ALTER TABLE `Modulos`
  ADD CONSTRAINT `Modulos_ibfk_1` FOREIGN KEY (`PadreID`) REFERENCES `Modulos` (`ID`);

--
-- Filtros para la tabla `Novedades`
--
ALTER TABLE `Novedades`
  ADD CONSTRAINT `Novedades_ibfk_1` FOREIGN KEY (`ImagenID`) REFERENCES `Imagenes` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Novedades_ibfk_2` FOREIGN KEY (`TituloID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Novedades_ibfk_3` FOREIGN KEY (`DescripcionID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Secciones`
--
ALTER TABLE `Secciones`
  ADD CONSTRAINT `Secciones_ibfk_1` FOREIGN KEY (`ContenidoID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Secciones_ibfk_2` FOREIGN KEY (`ModuloID`) REFERENCES `Modulos` (`ID`),
  ADD CONSTRAINT `Secciones_ibfk_3` FOREIGN KEY (`PadreID`) REFERENCES `Secciones` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Traducciones`
--
ALTER TABLE `Traducciones`
  ADD CONSTRAINT `Traducciones_ibfk_1` FOREIGN KEY (`ContenidoID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Traducciones_ibfk_2` FOREIGN KEY (`LenguajeID`) REFERENCES `Lenguajes` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
