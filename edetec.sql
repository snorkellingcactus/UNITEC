-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-04-2015 a las 19:48:39
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
  `Contenido` int(11) DEFAULT NULL,
  `Baneado` bit(1) NOT NULL,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Contenido` (`Contenido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `Comentarios`
--

INSERT INTO `Comentarios` (`ID`, `GrupoID`, `GrupoRes`, `Respondido`, `Fecha`, `Contenido`, `Baneado`, `Nombre`) VALUES
(1, 0, NULL, NULL, '2015-04-22 16:46:41', 334, b'0', 'asx'),
(2, 1, NULL, NULL, '2015-04-22 16:47:06', 335, b'0', 'asx'),
(3, 2, NULL, NULL, '2015-04-22 16:49:11', 336, b'0', 'asx'),
(4, 3, NULL, NULL, '2015-04-22 16:52:47', 337, b'0', 'asx'),
(5, 4, NULL, NULL, '2015-04-22 16:53:26', 338, b'0', 'asx'),
(6, 5, NULL, NULL, '2015-04-22 16:54:11', 339, b'0', 'asx'),
(9, 8, NULL, NULL, '2015-04-22 16:59:37', 342, b'0', 'asx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contenido`
--

CREATE TABLE IF NOT EXISTS `Contenido` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Contenido` text COLLATE utf8_unicode_ci,
  `Grupo` int(11) DEFAULT NULL,
  `Lenguaje` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Lenguaje` (`Lenguaje`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=347 ;

--
-- Volcado de datos para la tabla `Contenido`
--

INSERT INTO `Contenido` (`ID`, `Contenido`, `Grupo`, `Lenguaje`) VALUES
(187, 'The standard Lorem Ipsum passage, used since the 1500s', 1, 1),
(188, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 1),
(191, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', 3, 1),
(192, '&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot;', 4, 1),
(197, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. (En ingles)', 3, 2),
(198, '&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot; (en ingles)', 4, 2),
(211, 'asx', NULL, NULL),
(212, 'asxasx', NULL, NULL),
(213, 'asxasx', NULL, NULL),
(214, '&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot;\r\n', NULL, NULL),
(215, '&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot;\r\n', NULL, NULL),
(216, '&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot; ', NULL, NULL),
(217, '&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot; ', NULL, NULL),
(218, 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?', NULL, NULL),
(227, 'wedwed', 5, NULL),
(228, 'wedwed', 6, NULL),
(229, 'wedwed', 7, NULL),
(230, 'Mundo', 8, NULL),
(231, 'Mundo', 9, NULL),
(232, 'Mundo', 10, NULL),
(233, 'Lo que sea', 11, NULL),
(234, 'Este evento', 12, NULL),
(235, '', 13, NULL),
(236, 'Lo que sea', 14, NULL),
(237, 'Este evento', 15, NULL),
(238, '', 16, NULL),
(239, 'Lo que sea', 17, NULL),
(240, 'Este evento', 18, NULL),
(241, '', 19, NULL),
(242, 'Lorem Ipsum dolor sit amet', 20, NULL),
(243, 'asx', 21, NULL),
(244, 'asx', 22, NULL),
(245, 'asx', 23, NULL),
(246, 'asx', 24, NULL),
(247, 'asx', 25, NULL),
(248, 'asx', 26, NULL),
(249, 'Mundo', 27, NULL),
(250, '', 28, NULL),
(251, 'Lorem ipsum dolor sit amet', 29, NULL),
(252, 'asxs', 30, NULL),
(253, 'asxs', 31, NULL),
(254, 'asxs', 32, NULL),
(255, 'asxs', 33, NULL),
(256, 'asxs', 34, NULL),
(257, 'asxs', 35, NULL),
(258, 'asxs', 36, NULL),
(259, 'asxs', 37, NULL),
(260, 'asxs', 38, NULL),
(261, 'asxs', 39, NULL),
(262, 'asxs', 40, NULL),
(263, 'asxs', 41, NULL),
(264, 'asxs', 42, NULL),
(265, 'asxs', 43, NULL),
(266, 'asxs', 44, NULL),
(267, 'asxs', 45, NULL),
(268, 'asxs', 46, NULL),
(269, 'asxs', 47, NULL),
(270, 'asxs', 48, NULL),
(271, 'asxs', 49, NULL),
(272, 'asxs', 50, NULL),
(273, 'asxs', 51, NULL),
(274, 'asxs', 52, NULL),
(275, 'asxs', 53, NULL),
(276, 'asxs', 54, NULL),
(277, 'Lorem ipsum dolor sit amet', 55, NULL),
(280, 'asx', 58, NULL),
(281, 'as', 59, NULL),
(282, 'asxasx', 60, NULL),
(283, 'mundo', NULL, NULL),
(284, 'assas', 61, NULL),
(299, 'Genial', NULL, NULL),
(300, 'asx', NULL, NULL),
(301, 'asxasx', NULL, NULL),
(302, 'asx', NULL, NULL),
(303, 'asx', NULL, NULL),
(304, 'asx', NULL, NULL),
(327, 'munndo', NULL, NULL),
(330, 'asx', 62, NULL),
(331, 'asx', 63, NULL),
(332, 'asx', 64, NULL),
(333, 'asx', 65, NULL),
(334, 'Hola', NULL, NULL),
(335, 'Hola', NULL, NULL),
(336, 'Hola', NULL, NULL),
(337, 'Hola', NULL, NULL),
(338, 'Hola', NULL, NULL),
(339, 'Hola', NULL, NULL),
(340, 'Hola', NULL, NULL),
(341, 'Hola', NULL, NULL),
(342, 'Hola', NULL, NULL),
(343, 'hh', NULL, NULL),
(344, 'mundo', NULL, NULL),
(345, 'Nueva Novedad', 66, NULL),
(346, 'Con contenido de prueba', 67, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Eventos`
--

CREATE TABLE IF NOT EXISTS `Eventos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tiempo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Descripcion` int(11) DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT '1',
  `Prioridad` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `Descripcion` (`Descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=68 ;

--
-- Volcado de datos para la tabla `Eventos`
--

INSERT INTO `Eventos` (`ID`, `Tiempo`, `Nombre`, `Descripcion`, `Visible`, `Prioridad`) VALUES
(34, '2014-12-12 13:12:00', 'asx', 26, 1, 1),
(35, '2015-02-13 05:00:00', 'Hola', 27, 1, 1),
(62, '2015-03-06 06:06:00', 'asxasx', 58, 1, 1),
(63, '2015-03-17 05:00:00', 'Hola Mundo', 61, 1, 1),
(64, '2000-03-27 00:00:00', 'asx', 62, 1, 1),
(65, '2000-03-27 00:00:00', 'asx', 63, 1, 1),
(66, '2015-03-27 22:00:00', 'sx', 64, 1, 1),
(67, '2015-03-27 22:00:00', 'sx', 65, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imagenes`
--

CREATE TABLE IF NOT EXISTS `Imagenes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Alt` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Titulo` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Comentarios` int(11) DEFAULT NULL,
  `Lenguaje` int(11) DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT '1',
  `Prioridad` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `Comentarios` (`Comentarios`),
  KEY `Lenguaje` (`Lenguaje`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=87 ;

--
-- Volcado de datos para la tabla `Imagenes`
--

INSERT INTO `Imagenes` (`ID`, `Url`, `Alt`, `Titulo`, `Comentarios`, `Lenguaje`, `Visible`, `Prioridad`) VALUES
(86, 'http://localhost/Web/imgsEj/Mariposa-amarilla.jpg', 'asxasx', 'asx', 7, NULL, 1, 1);

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
-- Estructura de tabla para la tabla `Novedades`
--

CREATE TABLE IF NOT EXISTS `Novedades` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Imagen` int(11) DEFAULT NULL,
  `Titulo` int(11) DEFAULT NULL,
  `Descripcion` int(11) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Comentarios` int(11) NOT NULL,
  `Visible` tinyint(1) DEFAULT '1',
  `Prioridad` int(11) DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `Titulo` (`Titulo`),
  KEY `Descripcion` (`Descripcion`),
  KEY `Novedades_ibfk_2` (`Imagen`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `Novedades`
--

INSERT INTO `Novedades` (`ID`, `Imagen`, `Titulo`, `Descripcion`, `Fecha`, `Comentarios`, `Visible`, `Prioridad`) VALUES
(1, 86, 66, 67, '2015-04-22', 9, 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Secciones`
--

CREATE TABLE IF NOT EXISTS `Secciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Contenido` int(11) DEFAULT NULL,
  `Visible` tinyint(1) DEFAULT NULL,
  `Prioridad` int(11) DEFAULT NULL,
  `Archivo` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Contenido` (`Contenido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SecInc`
--

CREATE TABLE IF NOT EXISTS `SecInc` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Archivo` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contenido` int(11) DEFAULT NULL,
  `Orden` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Contenido` (`Contenido`)
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
-- Filtros para la tabla `Contenido`
--
ALTER TABLE `Contenido`
  ADD CONSTRAINT `Contenido_ibfk_1` FOREIGN KEY (`Lenguaje`) REFERENCES `Lenguajes` (`ID`);

--
-- Filtros para la tabla `Imagenes`
--
ALTER TABLE `Imagenes`
  ADD CONSTRAINT `Imagenes_ibfk_3` FOREIGN KEY (`Lenguaje`) REFERENCES `Lenguajes` (`ID`);

--
-- Filtros para la tabla `Novedades`
--
ALTER TABLE `Novedades`
  ADD CONSTRAINT `Novedades_ibfk_2` FOREIGN KEY (`Imagen`) REFERENCES `Imagenes` (`ID`);

--
-- Filtros para la tabla `Secciones`
--
ALTER TABLE `Secciones`
  ADD CONSTRAINT `Secciones_ibfk_1` FOREIGN KEY (`Contenido`) REFERENCES `Contenido` (`ID`);

--
-- Filtros para la tabla `SecInc`
--
ALTER TABLE `SecInc`
  ADD CONSTRAINT `SecInc_ibfk_1` FOREIGN KEY (`Contenido`) REFERENCES `Contenido` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
