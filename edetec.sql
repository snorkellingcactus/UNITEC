-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 06-05-2015 a las 10:03:24
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

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
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ContenidoID` int(11) DEFAULT NULL,
  `RaizID` int(11) NOT NULL,
  `PadreID` int(11) DEFAULT NULL,
  `Fecha` datetime NOT NULL,
  `Baneado` bit(1) NOT NULL,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Comentarios_ibfk_3` (`ContenidoID`),
  KEY `Comentarios_ibfk_2` (`RaizID`),
  KEY `Comentarios_ibfk_4` (`PadreID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contenidos`
--

CREATE TABLE IF NOT EXISTS `Contenidos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=67 ;

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
(37),
(38),
(39),
(40),
(41),
(42),
(43),
(44),
(49),
(52),
(53),
(54),
(55),
(56),
(57),
(62),
(63);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Eventos`
--

CREATE TABLE IF NOT EXISTS `Eventos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tiempo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DescripcionID` int(11) DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT '1',
  `Prioridad` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `Eventos_ibfk_1` (`DescripcionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=81 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imagenes`
--

CREATE TABLE IF NOT EXISTS `Imagenes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Alt` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TituloID` int(11) NOT NULL,
  `LenguajeID` int(11) DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT '1',
  `Prioridad` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `LenguajeID` (`LenguajeID`),
  KEY `Imagenes_ibfk_1` (`TituloID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=99 ;

--
-- Volcado de datos para la tabla `Imagenes`
--

INSERT INTO `Imagenes` (`ID`, `Url`, `Alt`, `TituloID`, `LenguajeID`, `Visible`, `Prioridad`) VALUES
(95, 'http://localhost/Web/imgsEj/brown-butterfly-wallpaper-2.jpg', 'sax', 37, NULL, 1, 1),
(96, 'http://localhost/Web/imgsEj/Mariposa-amarilla.jpg', 'U', 49, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Lenguajes`
--

CREATE TABLE IF NOT EXISTS `Lenguajes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `Pais` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

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
-- Estructura de tabla para la tabla `Modulos`
--

CREATE TABLE IF NOT EXISTS `Modulos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Archivo` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` text COLLATE utf8_unicode_ci,
  `PadreID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Padre` (`PadreID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

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
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ImagenID` int(11) DEFAULT NULL,
  `TituloID` int(11) DEFAULT NULL,
  `DescripcionID` int(11) DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Visible` tinyint(1) DEFAULT '1',
  `Prioridad` int(11) DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `Novedades_ibfk_1` (`ImagenID`),
  KEY `Novedades_ibfk_2` (`TituloID`),
  KEY `Novedades_ibfk_3` (`DescripcionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `Novedades`
--

INSERT INTO `Novedades` (`ID`, `ImagenID`, `TituloID`, `DescripcionID`, `Fecha`, `Visible`, `Prioridad`) VALUES
(7, 95, 63, 62, '2015-05-06', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Opciones`
--

CREATE TABLE IF NOT EXISTS `Opciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Dominio` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tipo` int(11) DEFAULT NULL,
  `Valor` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Pred` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Secciones`
--

CREATE TABLE IF NOT EXISTS `Secciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ContenidoID` int(11) DEFAULT NULL,
  `ModuloID` int(128) DEFAULT NULL,
  `PadreID` int(11) DEFAULT NULL,
  `Visible` tinyint(1) DEFAULT NULL,
  `Prioridad` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ModuloID` (`ModuloID`),
  KEY `Secciones_ibfk_1` (`ContenidoID`),
  KEY `Secciones_ibfk_3` (`PadreID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=157 ;

--
-- Volcado de datos para la tabla `Secciones`
--

INSERT INTO `Secciones` (`ID`, `ContenidoID`, `ModuloID`, `PadreID`, `Visible`, `Prioridad`) VALUES
(140, NULL, NULL, NULL, 1, 1),
(141, 31, NULL, 140, 1, 1),
(145, NULL, 1, 140, 1, 2),
(146, NULL, NULL, NULL, 1, 2),
(147, NULL, 12, 146, 1, 1),
(148, NULL, NULL, NULL, 1, 3),
(149, NULL, 8, 148, 1, 1),
(151, NULL, NULL, NULL, 1, 4),
(152, NULL, 11, 151, 1, 1),
(153, NULL, NULL, NULL, 1, 5),
(154, NULL, 6, 153, 1, 1),
(155, NULL, NULL, NULL, 1, 6),
(156, NULL, 10, 155, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Traducciones`
--

CREATE TABLE IF NOT EXISTS `Traducciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ContenidoID` int(11) NOT NULL,
  `LenguajeID` int(11) NOT NULL,
  `Texto` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`ID`),
  KEY `LenguajeID` (`LenguajeID`),
  KEY `Traducciones_ibfk_1` (`ContenidoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=73 ;

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
(43, 37, 1, 'axasx'),
(44, 38, 1, 'Mundo\r\n'),
(45, 39, 1, 'mundo'),
(46, 40, 1, 'mundo'),
(47, 41, 1, 'asx'),
(48, 42, 1, 'asx'),
(49, 43, 1, 'as'),
(50, 44, 1, 'as'),
(55, 49, 1, 'Mariposa Amarilla'),
(58, 52, 1, 'lkmlkm'),
(59, 53, 1, 'lkmlkm'),
(60, 54, 1, 'Mundo'),
(61, 55, 1, 'Hola'),
(62, 56, 1, '[list][*]asxsax\r\n[/*][/list]'),
(63, 57, 1, 'asx'),
(68, 62, 1, 'asx'),
(69, 63, 1, 'asx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE IF NOT EXISTS `Usuarios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NombreUsuario` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contrasena` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Baneado` bit(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`ID`, `Nombre`, `NombreUsuario`, `Contrasena`, `Email`, `Baneado`) VALUES
(1, 'Gonzalo García', 'snorkellingcactus', '38f448b51331bdedab93f9a15d2c1635eaf459a7 ', 'snorkellingcactus@gmail.com', b'0');

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
-- Filtros para la tabla `Modulos`
--
ALTER TABLE `Modulos`
  ADD CONSTRAINT `Modulos_ibfk_1` FOREIGN KEY (`PadreID`) REFERENCES `Modulos` (`ID`);

--
-- Filtros para la tabla `Novedades`
--
ALTER TABLE `Novedades`
  ADD CONSTRAINT `Novedades_ibfk_3` FOREIGN KEY (`DescripcionID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Novedades_ibfk_1` FOREIGN KEY (`ImagenID`) REFERENCES `Imagenes` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Novedades_ibfk_2` FOREIGN KEY (`TituloID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Secciones`
--
ALTER TABLE `Secciones`
  ADD CONSTRAINT `Secciones_ibfk_3` FOREIGN KEY (`PadreID`) REFERENCES `Secciones` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Secciones_ibfk_1` FOREIGN KEY (`ContenidoID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Secciones_ibfk_2` FOREIGN KEY (`ModuloID`) REFERENCES `Modulos` (`ID`);

--
-- Filtros para la tabla `Traducciones`
--
ALTER TABLE `Traducciones`
  ADD CONSTRAINT `Traducciones_ibfk_1` FOREIGN KEY (`ContenidoID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Traducciones_ibfk_2` FOREIGN KEY (`LenguajeID`) REFERENCES `Lenguajes` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
