-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 25-09-2014 a las 14:04:02
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
  `IP` int(11) DEFAULT NULL,
  `Usuario` int(11) DEFAULT NULL,
  `Contenido` int(11) DEFAULT NULL,
  `Baneado` bit(1) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Usuario` (`Usuario`),
  KEY `Contenido` (`Contenido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `Contenido`
--

INSERT INTO `Contenido` (`ID`, `Contenido`, `Lenguaje`) VALUES
(1, '<p></p>', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

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
(1, 'Gonzalo García', 'snorkellingcactus', 's2r9v3->149', 'snorkellingcactus@gmail.com', b'0');

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
  ADD CONSTRAINT `Imagenes_ibfk_3` FOREIGN KEY (`Lenguaje`) REFERENCES `Lenguajes` (`ID`),
  ADD CONSTRAINT `Imagenes_ibfk_1` FOREIGN KEY (`Contenido`) REFERENCES `Contenido` (`ID`),
  ADD CONSTRAINT `Imagenes_ibfk_2` FOREIGN KEY (`Comentarios`) REFERENCES `Comentarios` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;