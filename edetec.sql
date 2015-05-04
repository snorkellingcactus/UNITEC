-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-05-2015 a las 19:14:31
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
  `Contenido` int(11) DEFAULT NULL,
  `Raiz` int(11) NOT NULL,
  `Padre` int(11) DEFAULT NULL,
  `Baneado` bit(1) NOT NULL,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Contenido` (`Contenido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `Comentarios`
--

INSERT INTO `Comentarios` (`ID`, `Contenido`, `Raiz`, `Padre`, `Baneado`, `Nombre`) VALUES
(13, 388, 211, 211, b'0', 'Hola'),
(14, 191, 211, 211, b'0', 'ComenanteA'),
(16, 197, 211, 211, b'0', 'ComenanteC'),
(17, 198, 211, 191, b'0', 'ComentanteA1'),
(18, 215, 211, 192, b'0', 'ComentanteB1'),
(19, 212, 211, 197, b'0', 'ComentanteC1'),
(20, 236, 211, 191, b'0', 'ComentarioA2'),
(21, 237, 211, 198, b'0', 'ComentarioA1A'),
(26, 393, 211, 198, b'0', 'ComentanteA1B'),
(27, 398, 211, 236, b'0', 'hhhh'),
(28, 399, 211, 236, b'0', 'onono'),
(29, 400, 211, 197, b'0', 'asxasx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contenido`
--

CREATE TABLE IF NOT EXISTS `Contenido` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Contenido` text COLLATE utf8_unicode_ci,
  `Fecha` datetime DEFAULT NULL,
  `Lenguaje` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Lenguaje` (`Lenguaje`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=401 ;

--
-- Volcado de datos para la tabla `Contenido`
--

INSERT INTO `Contenido` (`ID`, `Contenido`, `Fecha`, `Lenguaje`) VALUES
(187, 'The standard Lorem Ipsum passage, used since the 1500s', NULL, 1),
(188, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', NULL, 1),
(197, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. (En ingles)', '2015-04-29 00:00:00', 2),
(198, '&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot; (en ingles)', '2015-04-28 00:00:00', 2),
(211, 'asx', NULL, NULL),
(212, 'asxasx', '2015-04-29 00:00:00', NULL),
(213, 'asxasx', NULL, NULL),
(214, '&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot;\r\n', NULL, NULL),
(215, '&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot;\r\n', '2015-04-28 00:00:00', NULL),
(216, '&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot; ', NULL, NULL),
(217, '&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot; ', NULL, NULL),
(218, 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?', NULL, NULL),
(227, 'wedwed', NULL, NULL),
(228, 'wedwed', NULL, NULL),
(229, 'wedwed', NULL, NULL),
(230, 'Mundo', NULL, NULL),
(231, 'Mundo', NULL, NULL),
(232, 'Mundo', NULL, NULL),
(233, 'Lo que sea', NULL, NULL),
(234, 'Este evento', NULL, NULL),
(235, '', NULL, NULL),
(236, 'Lo que sea', '2015-04-29 00:00:00', NULL),
(237, 'Este evento', '2015-04-29 00:00:00', NULL),
(238, '', NULL, NULL),
(239, 'Lo que sea', NULL, NULL),
(240, 'Este evento', NULL, NULL),
(241, '', NULL, NULL),
(242, 'Lorem Ipsum dolor sit amet', NULL, NULL),
(243, 'asx', NULL, NULL),
(244, 'asx', NULL, NULL),
(245, 'asx', NULL, NULL),
(246, 'asx', NULL, NULL),
(247, 'asx', NULL, NULL),
(248, 'asx', NULL, NULL),
(249, 'Mundo', NULL, NULL),
(250, '', NULL, NULL),
(251, 'Lorem ipsum dolor sit amet', NULL, NULL),
(252, 'asxs', NULL, NULL),
(253, 'asxs', NULL, NULL),
(254, 'asxs', NULL, NULL),
(255, 'asxs', NULL, NULL),
(256, 'asxs', NULL, NULL),
(257, 'asxs', NULL, NULL),
(258, 'asxs', NULL, NULL),
(259, 'asxs', NULL, NULL),
(260, 'asxs', NULL, NULL),
(261, 'asxs', NULL, NULL),
(262, 'asxs', NULL, NULL),
(263, 'asxs', NULL, NULL),
(264, 'asxs', NULL, NULL),
(265, 'asxs', NULL, NULL),
(266, 'asxs', NULL, NULL),
(267, 'asxs', NULL, NULL),
(268, 'asxs', NULL, NULL),
(269, 'asxs', NULL, NULL),
(270, 'asxs', NULL, NULL),
(271, 'asxs', NULL, NULL),
(272, 'asxs', NULL, NULL),
(273, 'asxs', NULL, NULL),
(274, 'asxs', NULL, NULL),
(275, 'asxs', NULL, NULL),
(276, 'asxs', NULL, NULL),
(277, 'Lorem ipsum dolor sit amet', NULL, NULL),
(280, 'asx', NULL, NULL),
(281, 'as', NULL, NULL),
(282, 'asxasx', NULL, NULL),
(283, 'mundo', NULL, NULL),
(284, 'assas', NULL, NULL),
(299, 'Genial', NULL, NULL),
(300, 'asx', NULL, NULL),
(301, 'asxasx', NULL, NULL),
(302, 'asx', NULL, NULL),
(303, 'asx', NULL, NULL),
(304, 'asx', NULL, NULL),
(327, 'munndo', NULL, NULL),
(330, 'asx', NULL, NULL),
(331, 'asx', NULL, NULL),
(332, 'asx', NULL, NULL),
(333, 'asx', NULL, NULL),
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
(345, 'Nueva Novedad', NULL, NULL),
(346, 'Con contenido de prueba', NULL, NULL),
(347, 'asxasxasx', NULL, 1),
(348, 'asxasxasx', NULL, 1),
(349, 'asxasxasx', NULL, 1),
(350, 'asxasxasx', NULL, 1),
(351, 'asxasxasx', NULL, 1),
(352, 'asxasxasx', NULL, 1),
(353, 'asxasxasx', NULL, 1),
(354, 'asxasxasx', NULL, 1),
(355, 'asxasxasx', NULL, 1),
(356, 'asxasxasx', NULL, 1),
(357, 'asxasxasx', NULL, 1),
(358, 'asxasxasx', NULL, 1),
(359, 'asxasxasx', NULL, 1),
(360, 'asxasxasx', NULL, 1),
(361, 'asxasxasx', NULL, 1),
(362, 'asxasxasx', NULL, 1),
(363, 'asxasxasx', NULL, 1),
(364, 'asxasxasx', NULL, 1),
(365, 'asxasxasx', NULL, 1),
(366, 'asxasxasx', NULL, 1),
(367, 'asxasxasx', NULL, 1),
(368, 'asxasxasx', NULL, 1),
(369, 'asxasxas', NULL, 1),
(370, '[center][size=200][b]Galeria[/b][/size][/center]', NULL, 1),
(371, 'Jueves', NULL, 1),
(372, 'jueves', NULL, 1),
(373, 'jueves', NULL, 1),
(374, 'asxasxasxsax', NULL, 1),
(375, 'asx', NULL, 1),
(376, 'asx', NULL, 1),
(377, 'Lunes', NULL, 1),
(378, '[center][size=200][b]Galer&iacute;a[/b][/size][/center]', NULL, 1),
(379, 'asx', NULL, 1),
(380, 'asxa', NULL, 1),
(381, 'jueves1', NULL, 1),
(382, 'jueves2', NULL, 1),
(383, '[center][size=200][b]Galer&iacute;a[/b][/size][/center]', NULL, 1),
(384, 'Hola', '2015-04-29 00:00:00', 1),
(385, 'Hola', '2015-04-29 00:00:00', 1),
(386, 'sxsdc', '2015-04-29 00:00:00', 1),
(387, 'mundo', '2015-04-29 00:00:00', 1),
(388, 'Mundo', '2015-04-29 00:00:00', 1),
(389, 'asxasxas', '2015-04-30 11:28:43', 1),
(390, 'asxasxas', '2015-04-30 11:32:00', 1),
(391, 'asxasx', '2015-04-30 11:32:18', 1),
(392, 'Los comentaios funkan', '2015-05-01 07:33:11', 1),
(393, 'asxas', '2015-05-01 07:41:43', 1),
(394, 'Array', NULL, NULL),
(397, 'Mariposa', NULL, NULL),
(398, 'kjkjnkjn', '2015-05-01 09:55:07', 1),
(399, 'onono', '2015-05-01 09:55:52', 1),
(400, 'asxasx', '2015-05-04 06:03:31', 1);

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
  `Titulo` int(11) NOT NULL,
  `Lenguaje` int(11) DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT '1',
  `Prioridad` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `Lenguaje` (`Lenguaje`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=91 ;

--
-- Volcado de datos para la tabla `Imagenes`
--

INSERT INTO `Imagenes` (`ID`, `Url`, `Alt`, `Titulo`, `Lenguaje`, `Visible`, `Prioridad`) VALUES
(86, 'http://localhost/Web/imgsEj/Mariposa-amarilla.jpg', 'asxasx', 211, NULL, 1, 1),
(90, 'http://localhost/Web/imgsEj/brown-butterfly-wallpaper-2.jpg', 'Mariposa', 397, NULL, 1, 1);

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
  `Padre` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `Modulos`
--

INSERT INTO `Modulos` (`ID`, `Nombre`, `Archivo`, `Descripcion`, `Padre`) VALUES
(1, 'Galeria', 'seccs/galeria.php', 'Una galería de fotos', NULL),
(2, NULL, 'seccs/galeria.css', NULL, 1),
(4, '', 'seccs/sobre_unitec.php', 'El archivo del inicio', NULL),
(5, NULL, 'seccs/sobre_unitec.css', NULL, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Novedades`
--

CREATE TABLE IF NOT EXISTS `Novedades` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Imagen` int(11) DEFAULT NULL,
  `Titulo` int(11) DEFAULT NULL,
  `Descripcion` int(11) DEFAULT NULL,
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

INSERT INTO `Novedades` (`ID`, `Imagen`, `Titulo`, `Descripcion`, `Visible`, `Prioridad`) VALUES
(1, 86, 66, 67, 1, 1);

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
  `Contenido` int(11) DEFAULT NULL,
  `Visible` tinyint(1) DEFAULT NULL,
  `Prioridad` int(11) DEFAULT NULL,
  `Modulo` int(128) DEFAULT NULL,
  `Padre` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Contenido` (`Contenido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Volcado de datos para la tabla `Secciones`
--

INSERT INTO `Secciones` (`ID`, `Contenido`, `Visible`, `Prioridad`, `Modulo`, `Padre`) VALUES
(10, NULL, 1, 1, NULL, NULL),
(11, NULL, 1, 1, 4, 10),
(19, NULL, 1, 2, 1, 3),
(25, 383, 1, 0, NULL, 3),
(27, NULL, 1, 0, NULL, NULL),
(28, NULL, 1, 1, 1, 27);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
