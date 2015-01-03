-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-01-2015 a las 08:13:40
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
  `GrupoID` int(11) NOT NULL,
  `GrupoRes` int(11) DEFAULT NULL,
  `Respondido` bit(1) DEFAULT NULL,
  `Fecha` datetime DEFAULT NULL,
  `IP` int(11) DEFAULT NULL,
  `Usuario` int(11) DEFAULT NULL,
  `Contenido` int(11) DEFAULT NULL,
  `Baneado` bit(1) NOT NULL,
  `NombreUsuario` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Usuario` (`Usuario`),
  KEY `Contenido` (`Contenido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `Comentarios`
--

INSERT INTO `Comentarios` (`ID`, `GrupoID`, `GrupoRes`, `Respondido`, `Fecha`, `IP`, `Usuario`, `Contenido`, `Baneado`, `NombreUsuario`) VALUES
(4, 41, NULL, b'1', '2015-01-03 06:35:19', NULL, NULL, 128, b'0', 'Hola'),
(5, 41, 4, b'1', '2015-01-03 06:40:24', NULL, NULL, 129, b'0', 'Pedro'),
(6, 41, 5, NULL, '2015-01-03 07:08:06', NULL, NULL, 130, b'0', 'Capo'),
(7, 41, NULL, NULL, '2015-01-03 07:21:58', NULL, NULL, 131, b'0', 'JJJJ'),
(8, 41, NULL, NULL, '2015-01-03 08:06:00', NULL, NULL, 132, b'0', 'El nuevo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contenido`
--

CREATE TABLE IF NOT EXISTS `Contenido` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Contenido` text COLLATE utf8_unicode_ci,
  `Lenguaje` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Lenguaje` (`Lenguaje`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=133 ;

--
-- Volcado de datos para la tabla `Contenido`
--

INSERT INTO `Contenido` (`ID`, `Contenido`, `Lenguaje`) VALUES
(122, 'Hola', NULL),
(123, 'Drog&oacute;n', NULL),
(124, 'Ufa', NULL),
(125, 'Copada mari', NULL),
(126, 'Si no?', NULL),
(127, 'No.', NULL),
(128, 'Mundo\r\n', NULL),
(129, 'Drog&oacute;n!', NULL),
(130, 'Giles', NULL),
(131, 'Hola', NULL),
(132, 'Nuevo Comentario', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imagenes`
--

CREATE TABLE IF NOT EXISTS `Imagenes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Ancho` int(11) DEFAULT NULL,
  `Alto` int(11) DEFAULT NULL,
  `Alt` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Titulo` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contenido` int(11) DEFAULT NULL,
  `Comentarios` int(11) DEFAULT NULL,
  `Lenguaje` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Contenido` (`Contenido`),
  KEY `Comentarios` (`Comentarios`),
  KEY `Lenguaje` (`Lenguaje`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43 ;

--
-- Volcado de datos para la tabla `Imagenes`
--

INSERT INTO `Imagenes` (`ID`, `Url`, `Ancho`, `Alto`, `Alt`, `Titulo`, `Contenido`, `Comentarios`, `Lenguaje`) VALUES
(41, 'http://localhost/Web/imgsEj/Mariposa-amarilla.jpg', NULL, NULL, 'Mariposa', 'Imagen 1', NULL, NULL, NULL),
(42, 'http://curiosidades.batanga.com/sites/curiosidades.batanga.com/files/imagecache/completa/como-se-forma-la-lluvia-2.jpg', NULL, NULL, 'Foto de lluvia', 'Lluvia', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Lenguajes`
--

CREATE TABLE IF NOT EXISTS `Lenguajes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lenguaje` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Novedades`
--

CREATE TABLE IF NOT EXISTS `Novedades` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Imagen` int(11) DEFAULT NULL,
  `Titulo` int(11) DEFAULT NULL,
  `Descripcion` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Imagen` (`Imagen`),
  KEY `Titulo` (`Titulo`),
  KEY `Descripcion` (`Descripcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
  ADD CONSTRAINT `Comentarios_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `Usuarios` (`ID`),
  ADD CONSTRAINT `Comentarios_ibfk_2` FOREIGN KEY (`Contenido`) REFERENCES `Contenido` (`ID`);

--
-- Filtros para la tabla `Contenido`
--
ALTER TABLE `Contenido`
  ADD CONSTRAINT `Contenido_ibfk_1` FOREIGN KEY (`Lenguaje`) REFERENCES `Lenguajes` (`ID`);

--
-- Filtros para la tabla `Imagenes`
--
ALTER TABLE `Imagenes`
  ADD CONSTRAINT `Imagenes_ibfk_1` FOREIGN KEY (`Contenido`) REFERENCES `Contenido` (`ID`),
  ADD CONSTRAINT `Imagenes_ibfk_2` FOREIGN KEY (`Comentarios`) REFERENCES `Comentarios` (`ID`),
  ADD CONSTRAINT `Imagenes_ibfk_3` FOREIGN KEY (`Lenguaje`) REFERENCES `Lenguajes` (`ID`);

--
-- Filtros para la tabla `Novedades`
--
ALTER TABLE `Novedades`
  ADD CONSTRAINT `Novedades_ibfk_1` FOREIGN KEY (`Imagen`) REFERENCES `Imagenes` (`ID`),
  ADD CONSTRAINT `Novedades_ibfk_2` FOREIGN KEY (`Titulo`) REFERENCES `Contenido` (`ID`),
  ADD CONSTRAINT `Novedades_ibfk_3` FOREIGN KEY (`Descripcion`) REFERENCES `Contenido` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
