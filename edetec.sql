-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-12-2014 a las 14:10:31
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
  `NombreUsuario` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Usuario` (`Usuario`),
  KEY `Contenido` (`Contenido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=67 ;

--
-- Volcado de datos para la tabla `Comentarios`
--

INSERT INTO `Comentarios` (`ID`, `GrupoID`, `IP`, `Usuario`, `Contenido`, `Baneado`, `NombreUsuario`) VALUES
(46, 19, NULL, NULL, 30, b'0', NULL),
(47, 8, NULL, NULL, 31, b'0', NULL),
(48, 8, NULL, NULL, 32, b'0', NULL),
(49, 24, NULL, NULL, 33, b'0', NULL),
(50, 23, NULL, NULL, 34, b'0', NULL),
(51, 23, NULL, NULL, 35, b'0', NULL),
(52, 23, NULL, NULL, 36, b'0', NULL),
(53, 26, NULL, NULL, 37, b'0', NULL),
(54, 23, NULL, NULL, 38, b'0', NULL),
(55, 23, NULL, NULL, 39, b'0', NULL),
(56, 26, NULL, NULL, 40, b'0', NULL),
(57, 29, NULL, NULL, 41, b'0', NULL),
(58, 29, NULL, NULL, 42, b'0', NULL),
(59, 29, NULL, NULL, 43, b'0', NULL),
(60, 29, NULL, NULL, 44, b'0', 'Hola'),
(61, 29, NULL, NULL, 45, b'0', 'jjj'),
(62, 29, NULL, NULL, 46, b'0', 'asx'),
(63, 29, NULL, NULL, 47, b'0', 'asx2'),
(64, 29, NULL, NULL, 48, b'0', 'Gonzalo');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

--
-- Volcado de datos para la tabla `Contenido`
--

INSERT INTO `Contenido` (`ID`, `Contenido`, `Lenguaje`) VALUES
(1, '<p></p>', NULL),
(30, '&lt;p&gt;&lt;font color=&quot;white&quot;&gt;Del bueno&lt;/font&gt;&lt;/p&gt;', NULL),
(31, 'Hola', NULL),
(32, 'Alo', NULL),
(33, 'Mariposa', NULL),
(34, 'Fondo Amarillo', NULL),
(35, 'Para un tema amarillo', NULL),
(36, 'Hola', NULL),
(37, 'Hola Mundo', NULL),
(38, 'Hola2', NULL),
(39, 'Hola3', NULL),
(40, 'Lo que sea', NULL),
(41, 'El pimer comentario', NULL),
(42, 'El segundo comentario', NULL),
(43, 'agus te quiere mucho ', NULL),
(44, 'Mundo', NULL),
(45, 'aaa', NULL),
(46, 'asx', NULL),
(47, 'asx', NULL),
(48, 'Primer comentario estable', NULL),
(49, 'Mundo', NULL),
(50, 'Mundo', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Volcado de datos para la tabla `Imagenes`
--

INSERT INTO `Imagenes` (`ID`, `Url`, `Ancho`, `Alto`, `Alt`, `Titulo`, `Contenido`, `Comentarios`, `Lenguaje`) VALUES
(22, 'http://localhost/Web/imgsEj/0DA.jpg', NULL, NULL, 'Un ocaso amarillo', 'Ocaso Amarillo', NULL, NULL, NULL),
(27, 'http://localhost/Web/imgsEj/Mariposa-amarilla.jpg', NULL, NULL, 'Mariposa Amarilla', 'Mariposa Amarilla', NULL, NULL, NULL),
(29, 'http://localhost/Web/imgsEj/noche-azul-1280x1024-127.jpg', NULL, NULL, '', 'Noche Azul', NULL, NULL, NULL),
(31, 'http://www.daswallpaper.de/wallpaper/original/hd-wallpaper-5985-6317-hd-wallpapers.jpg', NULL, NULL, '', 'Otra Imagen', NULL, NULL, NULL);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
