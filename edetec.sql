-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-10-2015 a las 21:26:59
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=93 ;

--
-- Volcado de datos para la tabla `Comentarios`
--

INSERT INTO `Comentarios` (`ID`, `ContenidoID`, `RaizID`, `PadreID`, `Fecha`, `Baneado`, `Nombre`) VALUES
(86, 686, 597, 597, '2015-10-06 20:57:00', b'0', 'asx'),
(91, 691, 597, 686, '2015-10-06 22:10:22', b'0', 'ELGil'),
(92, 692, 597, 597, '2015-10-06 22:11:29', b'0', 'ELGil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contenidos`
--

CREATE TABLE IF NOT EXISTS `Contenidos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=693 ;

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
(146),
(147),
(160),
(161),
(164),
(165),
(168),
(169),
(171),
(181),
(189),
(192),
(196),
(201),
(202),
(203),
(204),
(205),
(208),
(209),
(212),
(215),
(216),
(217),
(218),
(220),
(222),
(225),
(226),
(227),
(228),
(229),
(230),
(231),
(232),
(236),
(237),
(238),
(239),
(240),
(241),
(242),
(243),
(244),
(246),
(247),
(248),
(249),
(255),
(257),
(265),
(266),
(267),
(268),
(269),
(270),
(271),
(272),
(273),
(274),
(275),
(276),
(279),
(281),
(283),
(285),
(287),
(289),
(291),
(293),
(295),
(297),
(299),
(301),
(303),
(306),
(308),
(310),
(312),
(317),
(318),
(319),
(320),
(321),
(328),
(329),
(332),
(335),
(336),
(337),
(339),
(352),
(353),
(354),
(355),
(356),
(376),
(379),
(380),
(381),
(384),
(385),
(386),
(388),
(391),
(397),
(398),
(399),
(400),
(401),
(402),
(403),
(404),
(405),
(406),
(407),
(408),
(409),
(411),
(413),
(414),
(415),
(416),
(417),
(419),
(420),
(421),
(424),
(426),
(427),
(428),
(429),
(434),
(435),
(436),
(437),
(442),
(443),
(445),
(447),
(448),
(449),
(471),
(474),
(475),
(489),
(490),
(491),
(492),
(493),
(494),
(495),
(496),
(499),
(501),
(504),
(505),
(507),
(540),
(541),
(545),
(546),
(547),
(548),
(549),
(550),
(551),
(552),
(553),
(554),
(555),
(556),
(557),
(558),
(559),
(560),
(561),
(562),
(563),
(564),
(565),
(567),
(569),
(571),
(573),
(575),
(577),
(579),
(581),
(583),
(585),
(586),
(587),
(589),
(591),
(593),
(595),
(596),
(597),
(598),
(599),
(601),
(603),
(605),
(607),
(609),
(611),
(613),
(614),
(615),
(616),
(617),
(618),
(619),
(620),
(621),
(622),
(623),
(624),
(625),
(626),
(627),
(628),
(629),
(630),
(631),
(632),
(633),
(634),
(635),
(636),
(637),
(638),
(639),
(640),
(641),
(643),
(644),
(645),
(646),
(647),
(648),
(649),
(650),
(651),
(652),
(653),
(654),
(655),
(656),
(657),
(658),
(659),
(660),
(661),
(662),
(663),
(664),
(665),
(666),
(667),
(668),
(669),
(670),
(671),
(672),
(673),
(674),
(675),
(676),
(677),
(678),
(679),
(680),
(681),
(682),
(683),
(684),
(685),
(686),
(691),
(692);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Eventos`
--

CREATE TABLE IF NOT EXISTS `Eventos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tiempo` datetime NOT NULL,
  `NombreID` int(11) NOT NULL,
  `DescripcionID` int(11) DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT '1',
  `Prioridad` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `Eventos_ibfk_1` (`DescripcionID`),
  KEY `NombreID` (`NombreID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `Eventos`
--

INSERT INTO `Eventos` (`ID`, `Tiempo`, `NombreID`, `DescripcionID`, `Visible`, `Prioridad`) VALUES
(2, '0000-00-00 00:00:00', 436, 435, 0, 0),
(3, '2015-09-11 12:00:00', 547, 546, 0, 20),
(4, '2015-10-07 05:00:00', 648, 647, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imagenes`
--

CREATE TABLE IF NOT EXISTS `Imagenes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AltID` int(11) DEFAULT NULL,
  `TituloID` int(11) NOT NULL,
  `LenguajeID` int(11) DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT '1',
  `Prioridad` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `LenguajeID` (`LenguajeID`),
  KEY `Imagenes_ibfk_1` (`TituloID`),
  KEY `AltID` (`AltID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=89 ;

--
-- Volcado de datos para la tabla `Imagenes`
--

INSERT INTO `Imagenes` (`ID`, `Url`, `AltID`, `TituloID`, `LenguajeID`, `Visible`, `Prioridad`) VALUES
(74, '74.png', 587, 586, NULL, 1, 0),
(76, 'http://image.slidesharecdn.com/itcamp2011-alessandropilotti-optimizingaspnetandphpappsoniis7-5-110602094321-phpapp02/95/itcamp-2011-alessandro-pilotti-optimizing-aspnet-and-php-apps-on-iis-75-3-728.jpg?cb=1307016230', 599, 598, NULL, 1, 10),
(84, 'http://www.fotonat.org/data/media/2/picaflor-negro_MG_6213.jpg', 615, 614, NULL, 1, 0),
(85, '85.jpg', 617, 616, NULL, 1, 0),
(86, 'http://st-listas.20minutos.es/images/2010-03/197674/2159145_640px.jpg?1277399205', 619, 618, NULL, 1, 0),
(87, '87.jpg', 621, 620, NULL, 1, 0),
(88, '88.jpeg', 623, 622, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Lenguajes`
--

CREATE TABLE IF NOT EXISTS `Lenguajes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `Pais` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `Lenguajes`
--

INSERT INTO `Lenguajes` (`ID`, `Nombre`, `Pais`) VALUES
(1, 'Español', 'es_AR'),
(2, 'English', 'en_US'),
(3, 'Rusia', 'rs_RU');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Menu`
--

CREATE TABLE IF NOT EXISTS `Menu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ContenidoID` int(11) NOT NULL,
  `SeccionID` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Url` varchar(256) COLLATE utf8_unicode_ci DEFAULT '#',
  `Atajo` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Prioridad` int(11) DEFAULT NULL,
  `Visible` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Atajo` (`Atajo`),
  KEY `ContenidoID` (`ContenidoID`),
  KEY `SeccionID` (`SeccionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `Menu`
--

INSERT INTO `Menu` (`ID`, `ContenidoID`, `SeccionID`, `Url`, `Atajo`, `Prioridad`, `Visible`) VALUES
(2, 496, 'Galer&iacute;a', '#Galer%C3%ADa', 'G', 0, NULL),
(6, 505, 'Novedades', '#Novedades', 'N', -1, NULL),
(9, 626, 'Eventos', '#Eventos', NULL, 0, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `Modulos`
--

INSERT INTO `Modulos` (`ID`, `Nombre`, `Archivo`, `Descripcion`, `PadreID`) VALUES
(1, 'Galeria', 'seccs/galeria.php', 'Una galería de fotos', NULL),
(2, NULL, 'seccs/galeria.css', NULL, 1),
(8, 'Calendario', 'seccs/calendario.php', NULL, NULL),
(9, NULL, 'seccs/calendario.css', NULL, 8),
(10, 'Atajos', 'seccs/atajos.php', NULL, NULL),
(12, 'Novedades', 'seccs/novedades.php', NULL, NULL),
(13, NULL, 'seccs/novedades.css', NULL, 12),
(17, 'Organigrama', 'seccs/organigrama.php', NULL, NULL),
(18, NULL, 'seccs/organigrama.css', NULL, 17),
(19, NULL, 'seccs/atajos.css', NULL, 10);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `Novedades`
--

INSERT INTO `Novedades` (`ID`, `ImagenID`, `TituloID`, `DescripcionID`, `Fecha`, `Visible`, `Prioridad`) VALUES
(27, 74, 597, 596, '2015-09-16', 1, 1);

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
  `HTMLID` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Visible` tinyint(1) DEFAULT NULL,
  `Prioridad` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `HTMLID` (`HTMLID`),
  KEY `ModuloID` (`ModuloID`),
  KEY `Secciones_ibfk_1` (`ContenidoID`),
  KEY `Secciones_ibfk_3` (`PadreID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=424 ;

--
-- Volcado de datos para la tabla `Secciones`
--

INSERT INTO `Secciones` (`ID`, `ContenidoID`, `ModuloID`, `PadreID`, `HTMLID`, `Visible`, `Prioridad`) VALUES
(381, NULL, NULL, NULL, 'Eventos', 0, 8),
(382, NULL, NULL, NULL, 'Galer&iacute;a', 0, 9),
(386, NULL, 8, 381, NULL, 1, 5),
(397, NULL, NULL, NULL, 'Novedades', 0, 3),
(400, NULL, NULL, NULL, 'Atajos', 0, 7),
(401, NULL, 10, 400, NULL, 1, 0),
(402, NULL, NULL, NULL, 'Organigrama', 0, 5),
(403, NULL, 17, 402, NULL, 1, 0),
(420, NULL, 1, 382, NULL, 0, 6),
(423, NULL, 12, 397, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Traducciones`
--

CREATE TABLE IF NOT EXISTS `Traducciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ContenidoID` int(11) NOT NULL,
  `LenguajeID` int(11) NOT NULL,
  `Texto` text CHARACTER SET utf8,
  PRIMARY KEY (`ID`),
  KEY `LenguajeID` (`LenguajeID`),
  KEY `Traducciones_ibfk_1` (`ContenidoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=795 ;

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
(158, 146, 1, '            asxasx'),
(159, 147, 1, 'asxasx123adcasdc'),
(172, 160, 1, 'Novedades'),
(173, 161, 1, 'Galeria'),
(176, 164, 1, 'Novedades'),
(177, 165, 1, 'Galeria'),
(180, 168, 1, 'Mapa'),
(181, 169, 1, 'Novedades'),
(183, 171, 1, 'Mapa'),
(197, 146, 2, '   Este texto estÃ¡ en inglÃ©s'),
(198, 147, 2, 'En ingles'),
(203, 181, 1, '   Hola Mundo en Espa&ntilde;ol'),
(214, 189, 1, 'Algo loco que hacer en espa&ntilde;ol'),
(215, 189, 2, 'Algo loco que hacer en espaÃ±ol'),
(219, 192, 1, '   ergertretgertgertgretg'),
(223, 196, 1, '   UN texto en esp'),
(235, 201, 2, '      Hola [u]Mundo[/u]'),
(236, 202, 1, '   [center][size=100]ï»¿[/size][b][size=100]Seccion A[/size]\r\n[/b][/center][center]ï»¿[/center]'),
(237, 203, 1, '                     [b]Subtitulo 1\r\n[/b]'),
(238, 204, 1, '   [center][size=200][b]Seccion A\r\n[/b][/size][/center]'),
(239, 205, 1, '      [center][size=200][b]Seccion B\r\n[/b][/size][/center]'),
(244, 204, 2, '      [center][size=200][b]Seccion A\r\n[/b][/size][/center]'),
(245, 208, 1, 'mundo'),
(246, 209, 1, 'Hola'),
(249, 212, 1, '            [size=150]            [font=Times New Roman][size=200][b]   Dejanos Tu sugerencia[/b][/size][/font][/size]'),
(252, 215, 1, '   Las utilidades de conversiÃ³n de formatos de archivos son muy socorridas en muchos escenarios, pero a menudo tenemos que enfrentarnos a\r\n una utilidad por cada tipo de archivo (una para vÃ­deo, otra para \r\nimÃ¡genes, etc), algo que hace ese proceso algo incÃ³modo. \r\nAfortunadamente, tenemos opciones para unificar todas esas tareas de \r\nconversiÃ³n, [b]como por ejemplo la fantÃ¡stica utilidad[/b]\r\nLa hemos descubierto gracias a un correo electrÃ³nico de Cristian Merlos, del grupo JMMING Hackers de El Salvador (Gracias Cristian) y la \r\nverdad es que la capacidad de FF-Multi-Converter es muy interesante, \r\naunque como [url=https://github.com/Ilias95/FF-Multi-Converter/wiki/FF-Multi-Converter/0023e6cf89b1e12db7f66b34d2dbe6a471f347a1]explica su autor[/url] en la [url=https://github.com/Ilias95/FF-Multi-Converter]pÃ¡gina del proyecto en GitHub[/url], en realidad [b]se trata â€œtan soloâ€ de una interfaz grÃ¡fica o GUI para varias utilidades reales[/b] que se combinan y se utilizan segÃºn el caso.\r\nAsÃ­, hace uso del cÃ©lebre [url=http://ffmpeg.org/]ffmpeg[/url] para la [b]conversiÃ³n de ficheros de audio y vÃ­deo[/b], de [url=http://freecode.com/projects/unoconv]unoconv[/url] para la conversiÃ³n de documentos ofimÃ¡ticos) y de la librerÃ­a PIL ([url=http://effbot.org/zone/pil-index.htm]Python Imaging Library[/url]) para la conversiÃ³n de imÃ¡genes.\r\nObviamente [b]necesitarÃ©is instalar no solo FF-Multi-Converter, sino las utilidades de las que hace uso[/b], y otras dependencias como python2 y PyQt4. Para la conversiÃ³n de \r\ndocumentos ofimÃ¡ticos es necesario tener instalado OpenOffice.org o bien\r\n LibreOffice, que incluyen las funciones de conversiÃ³n UNO que usa el \r\nconversor unoconv.\r\n\r\n\r\n[center][url=http://www.muylinux.com/wp-content/uploads/2011/12/ff-multi-converter.png][img width=320,height=310]http://www.muylinux.com/wp-content/uploads/2011/12/ff-multi-converter.png[/img][/url]\r\n[/center]\r\nEn Ubuntu la instalaciÃ³n se puede [b]realizar a travÃ©s de un PPA[/b] con los siguientes comandos\r\nsudo add-apt-repository ppa:ffmulticonverter/stablesudo apt-get update\r\nsudo apt-get install ffmulticonverterOs dejamos con [b]algunas capturas[/b] (enviadas tambiÃ©n por Cristian) para que podÃ¡is comprobar el aspecto de esa interfaz tan \r\nÃºtil para convertir entre formatos de archivos.\r\n[left]      \r\n[url=http://www.muylinux.com/wp-content/uploads/2011/12/ff-multi-converter.png][img width=320,height=310]http://www.muylinux.com/wp-content/uploads/2011/12/ff-multi-converter.png[/img][/url][url=http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-documentos.png][img width=360,height=330]http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-documentos-360x330.png[/img][/url]\r\n[url=http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-Video.png][img width=360,height=330]http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-Video-360x330.png[/img][/url][url=http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-imagen.png][img width=414,height=330]http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-imagen-360x330.png[/img][/url][/left][url=http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-principal.png][img width=360,height=330]http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-principal-360x330.png[/img][/url][url=http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-audio.png][img width=360,height=330]http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-audio-360x330.png[/img][/url]'),
(253, 216, 1, 'FF-Multi-Converter, convierte imÃ¡genes, audio, vÃ­deo y documentos'),
(254, 217, 1, '               Las utilidades de conversi&oacute;n de formatos de archivos son muy socorridas en muchos escenarios, pero a menudo tenemos que enfrentarnos a\r\n una utilidad por cada tipo de archivo (una para v&iacute;deo, otra para \r\nim&aacute;genes, etc), algo que hace ese proceso algo inc&oacute;modo. \r\nAfortunadamente, tenemos opciones para unificar todas esas tareas de \r\nconversi&oacute;n, [b]como por ejemplo la fant&aacute;stica utilidad[/b]\r\nLa hemos descubierto gracias a un correo electr&oacute;nico de Cristian Merlos, del grupo JMMING Hackers de El Salvador (Gracias Cristian) y la \r\nverdad es que la capacidad de FF-Multi-Converter es muy interesante, \r\naunque como [url=https://github.com/Ilias95/FF-Multi-Converter/wiki/FF-Multi-Converter/0023e6cf89b1e12db7f66b34d2dbe6a471f347a1]explica su autor[/url] en la [url=https://github.com/Ilias95/FF-Multi-Converter]p&aacute;gina del proyecto en GitHub[/url], en realidad [b]se trata &ldquo;tan solo&rdquo; de una interfaz gr&aacute;fica o GUI para varias utilidades reales[/b] que se combinan y se utilizan seg&uacute;n el caso.\r\nAs&iacute;, hace uso del c&eacute;lebre [url=http://ffmpeg.org/]ffmpeg[/url] para la [b]conversi&oacute;n de ficheros de audio y v&iacute;deo[/b], de [url=http://freecode.com/projects/unoconv]unoconv[/url] para la conversi&oacute;n de documentos ofim&aacute;ticos) y de la librer&iacute;a PIL ([url=http://effbot.org/zone/pil-index.htm]Python Imaging Library[/url]) para la conversi&oacute;n de im&aacute;genes.\r\nObviamente [b]necesitar&eacute;is instalar no solo FF-Multi-Converter, sino las utilidades de las que hace uso[/b], y otras dependencias como python2 y PyQt4. Para la conversi&oacute;n de \r\ndocumentos ofim&aacute;ticos es necesario tener instalado OpenOffice.org o bien\r\n LibreOffice, que incluyen las funciones de conversi&oacute;n UNO que usa el \r\nconversor unoconv.\r\n\r\n[url=http://www.muylinux.com/wp-content/uploads/2011/12/ff-multi-converter.png][img width=320,height=310]http://www.muylinux.com/wp-content/uploads/2011/12/ff-multi-converter.png[/img][/url]\r\nEn Ubuntu la instalaci&oacute;n se puede [b]realizar a trav&eacute;s de un PPA[/b] con los siguientes comandos\r\nsudo add-apt-repository ppa:ffmulticonverter/stablesudo apt-get update\r\nsudo apt-get install ffmulticonverterOs dejamos con [b]algunas capturas[/b] (enviadas tambi&eacute;n por Cristian) para que pod&aacute;is comprobar el aspecto de esa interfaz tan \r\n&uacute;til para convertir entre formatos de archivos.\r\n[left]      \r\n[url=http://www.muylinux.com/wp-content/uploads/2011/12/ff-multi-converter.png][img width=320,height=310]http://www.muylinux.com/wp-content/uploads/2011/12/ff-multi-converter.png[/img][/url][url=http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-documentos.png][img width=360,height=330]http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-documentos-360x330.png[/img][/url]\r\n[url=http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-Video.png][img width=360,height=330]http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-Video-360x330.png[/img][/url][url=http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-imagen.png][img width=414,height=330]http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-imagen-360x330.png[/img][/url][/left][url=http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-principal.png][img width=360,height=330]http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-principal-360x330.png[/img][/url][url=http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-audio.png][img width=360,height=330]http://www.muylinux.com/wp-content/uploads/2011/12/multiconverter-audio-360x330.png[/img][/url]'),
(255, 218, 1, 'FF-Multi-Converter, convierte im&aacute;genes, audio, v&iacute;deo y documentos'),
(257, 220, 1, ''),
(259, 222, 1, 'Galeria'),
(262, 225, 1, 'mundo'),
(263, 226, 1, 'Gil'),
(264, 227, 1, '               [center][size=200]Galeria[/size][/center]'),
(265, 228, 1, ''),
(266, 229, 1, ''),
(267, 230, 1, ''),
(268, 231, 1, 'asxasx'),
(269, 232, 1, 'Hola'),
(273, 236, 1, 'hola mundo'),
(274, 237, 1, 'Pasant&amp;iacute;a edetec'),
(275, 238, 1, 'Pasant&iacute;a edetec'),
(276, 239, 1, 'Hola'),
(277, 240, 1, 'Hola Mundo'),
(278, 241, 1, 'Hola mundo'),
(279, 242, 1, 'Hola Mundo'),
(280, 243, 1, 'Hola Mundo'),
(281, 244, 1, 'Hola Mundo'),
(283, 246, 1, 'asxasx'),
(284, 247, 1, 'asxasx'),
(285, 248, 1, 'asxasx'),
(286, 249, 1, 'Galer&iacute;a'),
(292, 255, 1, 'Mundo'),
(293, 249, 2, 'Gallery'),
(300, 257, 2, 'Calendar'),
(303, 257, 1, 'Calendario'),
(309, 265, 1, 'Una frase de brother dege'),
(310, 266, 1, 'Lo que pasÃ³ pasÃ³, el pasado pisado.'),
(312, 265, 2, 'A brother Dege phrase.'),
(313, 266, 2, 'What''s happens, hapens Â¿?Â¿?'),
(314, 267, 2, 'Novedades'),
(315, 268, 2, '   [b]Lorem Ipsum[/b] es simplemente el texto de relleno de las imprentas y archivos de \r\ntexto. Lorem Ipsum ha sido el texto de relleno est&aacute;ndar de las \r\nindustrias desde el a&ntilde;o 1500, cuando un impresor (N. del T. persona que \r\nse dedica a la imprenta) desconocido us&oacute; una galer&iacute;a de textos y los \r\nmezcl&oacute; de tal manera que logr&oacute; hacer un libro de textos especimen. No \r\ns&oacute;lo sobrevivi&oacute; 500 a&ntilde;os, sino que tambien ingres&oacute; como texto de relleno\r\n en documentos electr&oacute;nicos, quedando esencialmente igual al original. \r\nFue popularizado en los 60s con la creaci&oacute;n de las hojas &quot;Letraset&quot;, las\r\n cuales contenian pasajes de Lorem Ipsum, y m&aacute;s recientemente con \r\nsoftware de autoedici&oacute;n, como por ejemplo Aldus  PageMaker, el cual \r\nincluye versiones de Lorem Ipsum.\r\nEs un hecho establecido hace demasiado tiempo que un lector se distraer&aacute; \r\ncon el contenido del texto de un sitio mientras que mira su dise&ntilde;o. El \r\npunto de usar Lorem Ipsum es que tiene una distribuci&oacute;n m&aacute;s o menos \r\nnormal de las letras, al contrario de usar textos como por ejemplo \r\n&quot;Contenido aqu&iacute;, contenido aqu&iacute;&quot;. Estos textos hacen parecerlo un \r\nespa&ntilde;ol que se puede leer. Muchos paquetes de autoedici&oacute;n y editores de \r\np&aacute;ginas web usan el Lorem Ipsum como su texto por defecto, y al hacer \r\nuna b&uacute;squeda de &quot;Lorem Ipsum&quot; va a dar por resultado muchos sitios web \r\nque usan este texto si se encuentran en estado de desarrollo. Muchas \r\nversiones han evolucionado a trav&eacute;s de los a&ntilde;os, algunas veces por \r\naccidente, otras veces a prop&oacute;sito (por ejemplo insert&aacute;ndole humor y \r\ncosas por el estilo).'),
(316, 269, 2, 'Una nueva novedad'),
(317, 270, 1, 'mundo'),
(318, 271, 1, 'Nueva seccion'),
(319, 269, 1, 'Una nueva novedad nueva'),
(322, 279, 1, 'Mundo'),
(339, 281, 1, 'Una Gibson SG'),
(341, 283, 1, 'Colores locos'),
(343, 285, 1, 'La m&uacute;sica'),
(345, 287, 1, 'El piano HDR'),
(347, 289, 1, 'Otro piano'),
(349, 291, 1, 'Una Gibson Sg'),
(351, 293, 1, 'El piano y la flor'),
(353, 295, 1, 'Piano en HDR'),
(355, 297, 1, ''),
(357, 299, 1, 'El piano y la flor'),
(359, 301, 1, 'Una Gibson SG'),
(361, 303, 1, 'Un piano con una flor'),
(364, 306, 1, ''),
(366, 308, 1, 'Un piano con una flor'),
(368, 310, 1, ''),
(370, 312, 1, ''),
(377, 317, 2, 'Hola'),
(378, 318, 2, 'asxasx'),
(379, 319, 2, 'asxasx'),
(380, 320, 2, 'asxasxggg'),
(381, 321, 2, 'Google'),
(391, 328, 1, '         En este Ãºltimo aÃ±o tres de las mÃ¡s grandes distribuciones GNU/Linux profesionales se han puesto de acuerdo, entre otras cosas, en ofrecer a \r\nlos desarrolladores que las usan una vÃ­a accesible para conseguir [b]las herramientas de programaciÃ³n mÃ¡s demandadas[/b], por lo general, en la forma de repositorios adicionales.\r\nAsÃ­, Canonical presentÃ³ [url=http://www.muylinux.com/2014/12/12/ubuntu-developer-tools-center-ubuntu-make]Ubuntu Make[/url], SUSE sus colecciones, directamente imbuidas en la instalaciÃ³n de [url=http://www.muylinux.com/2014/10/27/suse-linux-enterprise-12-version-final]SUSE Enterprise Linux 12[/url]; y la compaÃ±Ã­a del sombre rojo hizo con [url=http://www.muylinux.com/2014/06/10/red-hat-enterprise-linux-7]RHEL 7[/url] lo propio introduciendo [b]Red Hat Software Collections[/b], cuya segunda versiÃ³n redonda acaba de ser anunciada unos dÃ­as atrÃ¡s.\r\nRed Hat Software Collections 2 incluye un buen conjunto de lenguajes de programaciÃ³n, bases de datos y otro tipo de herramientas orientas al \r\ndesarrollo entre las que cabe destacar Python 2.7, 3.3 y 3.4, PHP 5.6, \r\nRuby 2.2 y Rails 4.1, Node.js 0.10, MySQL 5.6.24, PostgreSQL 9.4.1, \r\nMariaDB 10.0.17 o MongoDB 2.6.9, ademÃ¡s de [b]aplicaciones con Docker[/b], que se estÃ¡n poniendo muy de moda por mÃ©ritos propios.\r\nToda la informaciÃ³n acerca de este lanzamiento y su contenido la podÃ©is encontrar en el [url=http://www.redhat.com/en/about/press-releases/red-hat-software-collections-2-delivers-latest-stable-open-tools-traditional-and-container-based-application-development]anuncio oficial[/url] de Red Hat.'),
(392, 329, 1, 'Disponible Red Hat Software Collections 2'),
(395, 332, 1, 'Imagen logo de RedHat'),
(398, 335, 2, 'asxasx'),
(399, 336, 2, 'asxasx'),
(400, 337, 2, 'asxasx'),
(402, 339, 2, 'asx'),
(403, 328, 2, '                     En este Ãºltimo aÃ±o tres de las mÃ¡s grandes distribuciones GNU/Linux profesionales se han puesto de acuerdo, entre otras cosas, en ofrecer a \r\nlos desarrolladores que las usan una vÃ­a accesible para conseguir [b]las herramientas de programaciÃ³n mÃ¡s demandadas[/b], por lo general, en la forma de repositorios adicionales.\r\nAsÃ­, Canonical presentÃ³ [url=http://www.muylinux.com/2014/12/12/ubuntu-developer-tools-center-ubuntu-make]Ubuntu Make[/url], SUSE sus colecciones, directamente imbuidas en la instalaciÃ³n de [url=http://www.muylinux.com/2014/10/27/suse-linux-enterprise-12-version-final]SUSE Enterprise Linux 12[/url]; y la compaÃ±Ã­a del sombre rojo hizo con [url=http://www.muylinux.com/2014/06/10/red-hat-enterprise-linux-7]RHEL 7[/url] lo propio introduciendo [b]Red Hat Software Collections[/b], cuya segunda versiÃ³n redonda acaba de ser anunciada unos dÃ­as atrÃ¡s.\r\nRed Hat Software Collections 2 incluye un buen conjunto de lenguajes de programaciÃ³n, bases de datos y otro tipo de herramientas orientas al \r\ndesarrollo entre las que cabe destacar Python 2.7, 3.3 y 3.4, PHP 5.6, \r\nRuby 2.2 y Rails 4.1, Node.js 0.10, MySQL 5.6.24, PostgreSQL 9.4.1, \r\nMariaDB 10.0.17 o MongoDB 2.6.9, ademÃ¡s de [b]aplicaciones con Docker[/b], que se estÃ¡n poniendo muy de moda por mÃ©ritos propios.\r\nToda la informaciÃ³n acerca de este lanzamiento y su contenido la podÃ©is encontrar en el [url=http://www.redhat.com/en/about/press-releases/red-hat-software-collections-2-delivers-latest-stable-open-tools-traditional-and-container-based-application-development]anuncio oficial[/url] de Red Hat.'),
(404, 329, 2, 'Disponible Red Hat Software Collections 2'),
(417, 352, 2, 'Mundo'),
(418, 353, 2, 'Tal'),
(419, 354, 2, 'Tal'),
(420, 355, 2, ''),
(421, 356, 2, 'asx'),
(441, 310, 2, ''),
(443, 376, 2, 'Un piano'),
(446, 379, 1, 'asx'),
(447, 380, 1, 'sdcsdc'),
(448, 381, 1, 'asxasx'),
(451, 384, 1, 'asxasx'),
(452, 385, 1, '   sdcsdc'),
(453, 386, 1, 'sdcsdc'),
(455, 388, 1, 'Hola'),
(457, 388, 2, 'Hello'),
(460, 391, 1, 'asxasx'),
(466, 397, 1, ''),
(467, 398, 1, 'Imagen 1'),
(468, 399, 1, 'Alt Imagen 1'),
(469, 400, 1, 'Imagen 2'),
(470, 401, 1, 'Alt Imagen 2'),
(471, 402, 1, 'Imagen 3'),
(472, 403, 1, 'Alt Imagen 3'),
(473, 404, 1, 'Imagen 4'),
(474, 405, 1, 'Alt Imagen 4'),
(475, 406, 1, 'Imagen 5'),
(476, 407, 1, 'Alt Imagen 5'),
(477, 408, 1, 'Imagen 6'),
(478, 409, 1, 'Alt Imagen 6'),
(480, 411, 1, 'Alt Imagen 7'),
(482, 413, 1, 'Alt Imagen 8'),
(483, 414, 1, 'Novedades'),
(484, 415, 1, '[center][size=200][b]Novedades[/b][/size][/center]   '),
(485, 416, 1, '   Tras quince meses de desarrollo el entorno de escritorio que recogi&oacute; el testigo de GNOME 2 presenta nueva versi&oacute;n estable, [b]MATE 1.10[/b], en la que se anticipa el camino que, ya sab&iacute;amos, iba a tomar el \r\nproyecto: soporte para GTK3, considerado por el momento como \r\nexperimental.Lo cierto es que si obviamos las habituales correcciones o actualizaci&oacute;n de las traducciones, por el [url=http://mate-desktop.org/blog/2015-06-11-mate-1-10-released/]anuncio de lanzamiento[/url] MATE 1.10 apenas trae novedades: el navegador de archivos [b]Caja estrena gestor de complementos[/b], el visor de documentos [b]Atril soporte para ePub[/b] y se introduce una nueva biblioteca para administrar los canales de audio.El tema visual tambi&eacute;n incorpora cambios, pero no est&eacute;ticos, sino de compatibilidad, ampliando el soporte de GTK 3.8 a GTK 3.16, y por ah&iacute; \r\nvan los tiros de gran parte del trabajo de esta versi&oacute;n que no se ve, \r\npero que est&aacute;. Que MATE siga la senda cl&aacute;sica no significa que no \r\napueste por las &uacute;ltimas tecnolog&iacute;as. De hecho, [b]MATE 1.10 con GTK3[/b] ya se puede probar en Arch Linux y Fedora, que tienen paquetes preparados; pero solo probar.Para actualizar al [b]MATE 1.10 estable, el GTK2[/b], deber&aacute;s buscar qu&eacute; posibilidades ofrece tu distribuci&oacute;n, porque en la [i]rolling release[/i] m&aacute;s popular ya est&aacute; disponible. Y si por el contrario prefieres esperar\r\n por algo m&aacute;s sencillito, ten en cuenta que la semana pasada sali&oacute; [url=http://www.muylinux.com/2015/06/02/cinnamon-2-6]Cinnamon 2.6[/url] y con eso est&aacute; todo dicho: Linux Mint 17.2 a la vuelta de la esquina.      \r\n                  [url=http://www.muylinux.com/wp-content/uploads/2015/06/1.jpg][img width=500,height=281]http://1-ps.googleusercontent.com/hk/rerl60fiII0__khD3hloAXMYzk/www.muylinux.com/wp-content/uploads/2015/06/500x281x1-500x281.jpg.pagespeed.ic.I3lHO0l3IyVD4L1OzG2b.jpg[/img][/url]                     [url=http://www.muylinux.com/wp-content/uploads/2015/06/2.jpg][img width=500,height=281]http://1-ps.googleusercontent.com/hk/rerl60fiII0__khD3hloAXMYzk/www.muylinux.com/wp-content/uploads/2015/06/500x281x2-500x281.jpg.pagespeed.ic.A00dftBQi0bdHZGOV-1S.jpg[/img][/url]         \r\n            [url=http://www.muylinux.com/wp-content/uploads/2015/06/3.jpg][img width=500,height=281]http://1-ps.googleusercontent.com/hk/rerl60fiII0__khD3hloAXMYzk/www.muylinux.com/wp-content/uploads/2015/06/500x281x3-500x281.jpg.pagespeed.ic.Ke0l9JiNsJjnLKJeKQYI.jpg[/img][/url]                     [url=http://www.muylinux.com/wp-content/uploads/2015/06/4.jpg][img width=500,height=281]http://1-ps.googleusercontent.com/hk/rerl60fiII0__khD3hloAXMYzk/www.muylinux.com/wp-content/uploads/2015/06/500x281x4-500x281.jpg.pagespeed.ic.MEGD1LiEk5Y_UwyUuwsU.jpg[/img][/url]         '),
(486, 417, 1, 'MATE 1.10 emprende el camino hacia GTK3'),
(488, 419, 1, 'Contacto'),
(489, 420, 1, '      [center][b][size=200]Contactoï»¿[/size][/b][/center]'),
(490, 421, 1, '      [left][size=100]ï»¿[b]Dejanos una sugerencia![/b][/size][/left]'),
(493, 424, 1, '   [size=100][b]O ven&iacute; a vernos![/b][/size]'),
(495, 426, 1, 'GalerÃ­a'),
(496, 427, 1, '      [size=100]Â¿QuÃ© es Unitec?[/size]\r\n[size=85]Las siglas Unitec provienen de Unidad de InvestigaciÃ³n y Desarrollo para la Calidad de la EducaciÃ³n en IngenierÃ­a con orientaciÃ³n al uso de TIC Ãrea Departamental Electrotecnia - Facultad de IngenierÃ­a - UNLP\r\nObjetivos:[/size][list][*][size=85]Impulsar la aplicaciÃ³n de Normas de Calidad en la EducaciÃ³n en Ã¡reas tecnolÃ³gicas y promover la GestiÃ³n de la Calidad Educativa, y Impulsar la aplicaciÃ³n de Normas de Calidad en la EducaciÃ³n en Ã¡reas tecnolÃ³gicas y promover la GestiÃ³n de la Calidad Educativa.\r\n[/size][/*][*][size=85]Abordar cuestiones sobre la posible aplicaciÃ³n actual de las TICS para mejorar la calidad de la actividad docente, su complementaciÃ³n con los medios didÃ¡cticos tradicionales, no solo para un mayor aprovechamiento del tiempo, sino para una mejora integral de la enseÃ±anza, que contribuya a formar profesionales eficientes y con alto sentido de la responsabilidad.\r\n[/size][/*][/list][size=85]MetodologÃ­a para el desarrollo de los objetivos:\r\n[/size][list][*][size=85]Llevar adelante tareas de investigaciÃ³n en el Ã¡rea de innovaciÃ³n y mejoramiento de la Calidad en la EducaciÃ³n y entrenamiento en IngenierÃ­a (EducaciÃ³n basada en competencias, evaluaciÃ³n de aprendizajes, barreras al aprendizaje, etc), incorporando las herramientas de las TecnologÃ­as de la InformaciÃ³n y la ComunicaciÃ³n (TIC).Â [/size][/*][*][size=85]Promover desarrollos tecnolÃ³gicos y asesoramientos a requerimiento de terceros e impulsar tareas de investigaciÃ³n, extensiÃ³n, asesoramiento y capacitaciÃ³n, basados en los objetivos propuestos.[/size][/*][*][size=85]Promover y realizar estudios sobre indicadores para el mejoramiento continuo de la EducaciÃ³n en IngenierÃ­a.[/size][/*][*][size=85]Fomentar actividades de transferencia de conocimientos, a travÃ©s de la capacitaciÃ³n y formaciÃ³n de los miembros de la UID en temas relacionados con las TIC aplicadas a la EducaciÃ³n, otras TecnologÃ­as y al Aseguramiento de la Calidad.[/size][/*][/list]'),
(497, 428, 1, 'Sobre Nosotros'),
(498, 429, 1, 'sdc'),
(503, 434, 1, 'Hola'),
(504, 435, 1, 'Este lunes se concretar&aacute; una reuni&oacute;n con flavio y cristina para ver el estado actual en el que se encuentra la web.'),
(505, 436, 1, 'Charla sobre la web!!'),
(506, 437, 1, 'Inicio'),
(507, 437, 2, 'Home'),
(508, 414, 2, 'News'),
(510, 426, 2, 'Gallery'),
(511, 419, 2, 'Contact Us'),
(513, 415, 2, '   [center][size=200][b]News[/b][/size][/center]   '),
(514, 435, 2, 'On Monday a meeting with Flavio and Cristina will be implemented for the state in which the web is.'),
(515, 436, 2, 'Talk on the web'),
(516, 398, 2, 'Image 1'),
(517, 399, 2, 'Alt Imagen 1'),
(518, 400, 2, 'Image 2'),
(519, 401, 2, 'Alt Imagen 2'),
(520, 402, 2, 'Image 3'),
(521, 403, 2, 'Alt Imagen 3'),
(522, 404, 2, 'Image 4'),
(523, 405, 2, 'Alt Imagen 4'),
(524, 406, 2, 'Image 5'),
(525, 407, 2, 'Alt Imagen 5'),
(526, 408, 2, 'Image 6'),
(527, 409, 2, 'Alt Imagen 6'),
(529, 411, 2, 'Alt Imagen 7'),
(531, 413, 2, 'Alt Imagen 8'),
(532, 420, 2, '            [center][b][size=200]Contact US\r\n[/size][/b][/center]'),
(533, 421, 2, '   [b][size=100]Give us a suggestion![/size][/b][left][size=100][b][/b][/size][/left]'),
(534, 424, 2, '      [size=100][b]Or Come see us![/b][/size]'),
(535, 427, 2, '      [b][size=100][size=85]What is Unitec?[/size][/size][/b]\r\n[size=85]The acronym comes from Unitec Research and Development Unit for Quality Engineering Education oriented to the use of ICT Electrical Department Area - Faculty of Engineering - UNLP.\r\n\r\n[b]Objectives:\r\n[/b]\r\n[/size][list][*][size=85]To promote the application of Quality Standards in Education technology \r\nareas and promote the Educational Quality Management, and \r\npromote the application of Quality Standards in Education technology \r\nareas and promote the Educational Quality Management.\r\n\r\n[/size][/*][*][size=85]Address issues about the current possible application of ICT to improve the \r\nquality of teaching, its complementarity with traditional teaching aids,\r\n not only to make better use of time, but for a comprehensive \r\nimprovement of education, which contributes to train professionals efficient and high sense of responsibility.\r\n[/size][/*][/list][size=85]\r\n[b]Methodology to develop objectives:[/b]\r\n\r\n[/size][list][*][size=85]Carry out research work in the area of â€‹â€‹innovation and improvement of \r\nquality in education and training in Engineering (competency-based \r\nassessment of learning, barriers to learning, education etc), \r\nincorporating the tools of the Information Technology and (ICT).\r\n\r\n[/size][/*][*][size=85]Â Promote technological developments and assessments at the request of third \r\nparties and promoting research activities, outreach, \r\ncounseling and training, based on the objectives.\r\n\r\n[/size][/*][*][size=85]Promote and conduct studies on indicators for continuous improvement of Engineering Education.\r\n\r\n[/size][/*][*][size=85]Promoting knowledge transfer activities, through training and education of \r\nmembers of the UID on issues related to ICT for Education, other \r\ntechnologies and Quality Assurance.\r\n[/size][/*][/list]'),
(536, 428, 2, 'About Us'),
(537, 416, 2, '      After fifteen months of development the desktop environment GNOME picked up the baton 2 presents new stable, [b]MATE 1.10[/b],Â anticipated in the road, we knew, would take the project: support for GTK3 considered experimental at this time. The truth is that if we ignore the usual corrections or update translations, the [url=http://mate-desktop.org/blog/2015-06-11-mate-1-10-released/]release announcement[/url].\r\njust brings news: the file browser opens[b] box ons Manager[/b], [b]Viewer supports \r\nePub[/b] documents lectern and a new library is introduced to manage \r\nchannels audio.The visual theme also incorporates changes, but not \r\naesthetic, but compatibility extending support GTK 3.8 to GTK 3.16, and there\r\nshots go much of the work in this release is not seen,\r\nbut it is. MATE that follow the classical path does not mean that\r\nbet on the latest technology. In fact, [b]MATE 1.10 with GTK3[/b] and can be tested in Arch Linux and Fedora, who have prepared packages; but only update the [b]MATE 1.10 stable[/b] ,[b]the GTK2 version[/b], you must find \r\nthe possibilities offered by your distribution, because the most popular\r\n rolling release is now available. And if instead you prefer to wait\r\nby more sencillito note that last week came [url=http://www.muylinux.com/2015/06/02/cinnamon-2-6]Cinnamon 2.6[/url] and that is all said: Linux Mint 17.2 just around the corner.\r\n      \r\n                  [url=http://www.muylinux.com/wp-content/uploads/2015/06/1.jpg][img width=500,height=281]http://1-ps.googleusercontent.com/hk/rerl60fiII0__khD3hloAXMYzk/www.muylinux.com/wp-content/uploads/2015/06/500x281x1-500x281.jpg.pagespeed.ic.I3lHO0l3IyVD4L1OzG2b.jpg[/img][/url]                     [url=http://www.muylinux.com/wp-content/uploads/2015/06/2.jpg][img width=500,height=281]http://1-ps.googleusercontent.com/hk/rerl60fiII0__khD3hloAXMYzk/www.muylinux.com/wp-content/uploads/2015/06/500x281x2-500x281.jpg.pagespeed.ic.A00dftBQi0bdHZGOV-1S.jpg[/img][/url]         \r\n            [url=http://www.muylinux.com/wp-content/uploads/2015/06/3.jpg][img width=500,height=281]http://1-ps.googleusercontent.com/hk/rerl60fiII0__khD3hloAXMYzk/www.muylinux.com/wp-content/uploads/2015/06/500x281x3-500x281.jpg.pagespeed.ic.Ke0l9JiNsJjnLKJeKQYI.jpg[/img][/url]                     [url=http://www.muylinux.com/wp-content/uploads/2015/06/4.jpg][img width=500,height=281]http://1-ps.googleusercontent.com/hk/rerl60fiII0__khD3hloAXMYzk/www.muylinux.com/wp-content/uploads/2015/06/500x281x4-500x281.jpg.pagespeed.ic.MEGD1LiEk5Y_UwyUuwsU.jpg[/img][/url]         '),
(538, 417, 2, 'MATE 1.10 is on the road to GTK3'),
(543, 442, 2, 'jj'),
(544, 443, 1, 'Holaaaaa'),
(546, 445, 1, 'Hsjdksksbdbxkdjs'),
(548, 447, 2, 'Imagen subida'),
(549, 448, 1, 'Eventos'),
(551, 449, 1, '                  [b][size=100]&iquest;Qu&eacute; es Unitec?\r\n[/size][/b]\r\n[size=85]Las siglas UNITEC provienen de Unidad de Investigaci&oacute;n, Desarrollo, \r\nExtensi&oacute;n y Transferencia para la Calidad de la Educaci&oacute;n en Ingenier&iacute;a \r\ncon orientaci&oacute;n al uso de TIC. &Aacute;rea Departamental Electrotecnia - \r\nFacultad de Ingenier&iacute;a - UNLP\r\n\r\n[b]Objetivos:\r\n\r\n[/b][/size][list][*][size=85]Impulsar la aplicaci&oacute;n de Normas de Calidad en la Educaci&oacute;n en &aacute;reas \r\ntecnol&oacute;gicas y promover la Gesti&oacute;n de la Calidad Educativa, y Impulsar \r\nla aplicaci&oacute;n de Normas de Calidad en la Educaci&oacute;n en &aacute;reas tecnol&oacute;gicas\r\n y promover la Gesti&oacute;n de la Calidad Educativa.[/size][/*][/list][size=85]\r\n[/size][list][*][size=85]Abordar cuestiones sobre la posible aplicaci&oacute;n actual de las TICS para mejorar \r\nla calidad de la actividad docente, su complementaci&oacute;n con los medios \r\ndid&aacute;cticos tradicionales, no solo para un mayor aprovechamiento del \r\ntiempo, sino para una mejora integral de la ense&ntilde;anza, que contribuya a \r\nformar profesionales eficientes y con alto sentido de la \r\nresponsabilidad.[/size][/*][/list][size=85]\r\n[/size]\r\n[size=85][b]Metodolog&iacute;a para el desarrollo de los objetivos:[/b]\r\n\r\n[/size][list][*][size=85]Llevar adelante tareas de investigaci&oacute;n en el &aacute;rea de innovaci&oacute;n y \r\nmejoramiento de la Calidad en la Educaci&oacute;n y entrenamiento en Ingenier&iacute;a\r\n (Educaci&oacute;n basada en competencias, evaluaci&oacute;n de aprendizajes, barreras\r\n al aprendizaje, etc), incorporando las herramientas de las Tecnolog&iacute;as \r\nde la Informaci&oacute;n y la Comunicaci&oacute;n (TIC). \r\n[/size][/*][/list][size=85]\r\n[/size][list][*][size=85]Promover desarrollos tecnol&oacute;gicos y asesoramientos a requerimiento de terceros e\r\n impulsar tareas de investigaci&oacute;n, extensi&oacute;n, asesoramiento y \r\ncapacitaci&oacute;n, basados en los objetivos propuestos.[/size][/*][/list][size=85]\r\n[/size][list][*][size=85]Promover y realizar estudios sobre indicadores para el mejoramiento continuo de la Educaci&oacute;n en Ingenier&iacute;a.[/size][/*][/list][size=85]\r\n[/size][list][*][size=85]Fomentar actividades de transferencia de conocimientos, a trav&eacute;s de la \r\ncapacitaci&oacute;n y formaci&oacute;n de los miembros de la UID en temas relacionados\r\n con las TIC aplicadas a la Educaci&oacute;n, otras Tecnolog&iacute;as y al \r\nAseguramiento de la Calidad.[/size][/*][/list]'),
(573, 471, 1, '      asx'),
(576, 474, 1, '   jj'),
(577, 475, 1, '      bb'),
(591, 489, 1, '                     [b][size=100]&iquest;Qu&eacute; es Unitec?\r\n[/size][/b]\r\n[size=85]Las siglas UNITEC provienen de Unidad de Investigaci&oacute;n, Desarrollo, \r\nExtensi&oacute;n y Transferencia para la Calidad de la Educaci&oacute;n en Ingenier&iacute;a \r\ncon orientaci&oacute;n al uso de TIC. &Aacute;rea Departamental Electrotecnia - \r\nFacultad de Ingenier&iacute;a - UNLP\r\n\r\n[b]Objetivos:\r\n\r\n[/b][/size][list][*][size=85]Impulsar la aplicaci&oacute;n de Normas de Calidad en la Educaci&oacute;n en &aacute;reas \r\ntecnol&oacute;gicas y promover la Gesti&oacute;n de la Calidad Educativa, y Impulsar \r\nla aplicaci&oacute;n de Normas de Calidad en la Educaci&oacute;n en &aacute;reas tecnol&oacute;gicas\r\n y promover la Gesti&oacute;n de la Calidad Educativa.[/size][/*][/list][size=85]\r\n[/size][list][*][size=85]Abordar cuestiones sobre la posible aplicaci&oacute;n actual de las TICS para mejorar \r\nla calidad de la actividad docente, su complementaci&oacute;n con los medios \r\ndid&aacute;cticos tradicionales, no solo para un mayor aprovechamiento del \r\ntiempo, sino para una mejora integral de la ense&ntilde;anza, que contribuya a \r\nformar profesionales eficientes y con alto sentido de la \r\nresponsabilidad.[/size][/*][/list][size=85]\r\n[/size]\r\n[size=85][b]Metodolog&iacute;a para el desarrollo de los objetivos:[/b]\r\n\r\n[/size][list][*][size=85]Llevar adelante tareas de investigaci&oacute;n en el &aacute;rea de innovaci&oacute;n y \r\nmejoramiento de la Calidad en la Educaci&oacute;n y entrenamiento en Ingenier&iacute;a\r\n (Educaci&oacute;n basada en competencias, evaluaci&oacute;n de aprendizajes, barreras\r\n al aprendizaje, etc), incorporando las herramientas de las Tecnolog&iacute;as \r\nde la Informaci&oacute;n y la Comunicaci&oacute;n (TIC). \r\n[/size][/*][/list][size=85]\r\n[/size][list][*][size=85]Promover desarrollos tecnol&oacute;gicos y asesoramientos a requerimiento de terceros e\r\n impulsar tareas de investigaci&oacute;n, extensi&oacute;n, asesoramiento y \r\ncapacitaci&oacute;n, basados en los objetivos propuestos.[/size][/*][/list][size=85]\r\n[/size][list][*][size=85]Promover y realizar estudios sobre indicadores para el mejoramiento continuo de la Educaci&oacute;n en Ingenier&iacute;a.[/size][/*][/list][size=85]\r\n[/size][list][*][size=85]Fomentar actividades de transferencia de conocimientos, a trav&eacute;s de la \r\ncapacitaci&oacute;n y formaci&oacute;n de los miembros de la UID en temas relacionados\r\n con las TIC aplicadas a la Educaci&oacute;n, otras Tecnolog&iacute;as y al \r\nAseguramiento de la Calidad.[/size][/*][/list]'),
(592, 490, 1, 'Nueva Seccion'),
(593, 491, 1, 'Inicio'),
(594, 492, 1, 'Galer&iacute;a'),
(595, 493, 1, 'Galer&iacute;a'),
(596, 494, 1, 'Galer&iacute;a'),
(597, 495, 1, 'Galer&iacute;a'),
(598, 496, 1, 'Galer&iacute;a'),
(601, 499, 1, 'Contacto'),
(603, 501, 1, 'asx'),
(606, 504, 1, 'Novedades'),
(607, 505, 1, 'Novedades'),
(609, 507, 1, 'Unos tiernos gatitos que se brazan'),
(642, 540, 1, ''),
(643, 541, 1, ''),
(647, 545, 1, 'Nueva'),
(648, 546, 1, 'Esta es una prueba'),
(649, 547, 1, 'Nuevo Evento de prueba'),
(650, 548, 1, '&lt;p&gt;Mundo &lt;strong&gt;Boldeado&lt;/strong&gt;&lt;/p&gt;\r\n'),
(651, 549, 1, 'Hola'),
(652, 550, 1, '&lt;p&gt;Worldaa&lt;/p&gt;\r\n'),
(653, 551, 1, 'Hello'),
(654, 552, 1, ''),
(655, 553, 1, ''),
(656, 554, 1, '&lt;p&gt;jjjj&lt;strong&gt;jjjhh&lt;/strong&gt;&lt;/p&gt;\r\n'),
(657, 555, 1, 'Hello World'),
(658, 556, 1, ''),
(659, 557, 1, ''),
(660, 558, 1, '&lt;p&gt;Mun&lt;strong&gt;do&lt;/strong&gt;&lt;/p&gt;\r\n'),
(661, 559, 1, 'Hola'),
(662, 560, 1, ''),
(663, 561, 1, ''),
(664, 562, 1, '&lt;p&gt;Mun&lt;strong&gt;dojj&lt;/strong&gt;&lt;/p&gt;\r\n'),
(665, 563, 1, 'Hola'),
(666, 564, 1, '&lt;p&gt;Wor&lt;strong&gt;ldjj&lt;/strong&gt;&lt;/p&gt;\r\n'),
(667, 565, 1, 'Hello'),
(669, 567, 1, 'Un Fondo Azul'),
(671, 569, 1, 'asxsax'),
(673, 571, 1, 'Un Pescado'),
(675, 573, 1, 'Unas Flores'),
(677, 575, 1, 'Dedicaci&oacute;n de amor'),
(679, 577, 1, 'hola'),
(681, 579, 1, ''),
(683, 581, 1, ''),
(685, 583, 1, ''),
(687, 585, 1, ''),
(688, 586, 1, 'Imagen 00'),
(689, 587, 1, 'Alt 00'),
(691, 589, 1, 'Alt 01'),
(693, 591, 1, ''),
(695, 593, 1, ''),
(697, 595, 1, ''),
(698, 596, 1, '&lt;p&gt;Hola Mun&lt;strong&gt;Do&lt;/strong&gt;&lt;/p&gt;\r\n'),
(699, 597, 1, 'Nueva Novedad'),
(700, 598, 1, 'asxasx'),
(701, 599, 1, 'asxasx'),
(703, 601, 1, 'Un picaflor'),
(705, 603, 1, 'peza'),
(707, 605, 1, 'pezb'),
(709, 607, 1, 'peza'),
(711, 609, 1, 'pica'),
(713, 611, 1, 'a'),
(715, 613, 1, 'b'),
(716, 614, 1, 'A'),
(717, 615, 1, 'a'),
(718, 616, 1, 'B'),
(719, 617, 1, 'b'),
(720, 618, 1, 'C'),
(721, 619, 1, 'c'),
(722, 620, 1, 'D'),
(723, 621, 1, 'd'),
(724, 622, 1, 'Prueba'),
(725, 623, 1, 'prueb'),
(726, 624, 1, 'asxsax'),
(727, 625, 1, 'Hola'),
(728, 626, 1, 'Eventos'),
(729, 627, 1, 'asx'),
(730, 628, 1, 'asx'),
(731, 629, 1, 'asx'),
(732, 630, 1, 'asx'),
(733, 631, 1, 'asx'),
(734, 632, 1, 'asxasx'),
(735, 633, 1, 'saxsax'),
(736, 634, 1, 'asx'),
(737, 635, 1, 'asx'),
(738, 636, 1, 'asx'),
(739, 637, 1, 'sax'),
(740, 638, 1, 'A'),
(741, 639, 1, 'a'),
(742, 640, 1, 'sxs'),
(743, 641, 1, 'primero'),
(745, 643, 1, 'SobreOrganigrama'),
(746, 644, 1, 'Bottom'),
(747, 645, 1, 'Top'),
(748, 646, 1, 'bottom'),
(749, 647, 1, 'Hacer algo'),
(750, 648, 1, 'Ma&ntilde;ana'),
(751, 649, 1, 'asxsx'),
(752, 650, 1, 'asxsx'),
(753, 651, 1, 'asxsx'),
(754, 652, 1, 'asxsx'),
(755, 653, 1, 'asxsx'),
(756, 654, 1, 'asxsx'),
(757, 655, 1, 'asxsx'),
(758, 656, 1, 'asx'),
(759, 657, 1, 'asx'),
(760, 658, 1, 'asx'),
(761, 659, 1, 'asx'),
(762, 660, 1, 'asx'),
(763, 661, 1, 'asx'),
(764, 662, 1, 'asx'),
(765, 663, 1, 'asx'),
(766, 664, 1, 'asx'),
(767, 665, 1, 'asx'),
(768, 666, 1, 'asx'),
(769, 667, 1, 'asx'),
(770, 668, 1, 'asx'),
(771, 669, 1, 'asx'),
(772, 670, 1, 'sdc'),
(773, 671, 1, 'sdc'),
(774, 672, 1, 'sdc'),
(775, 673, 1, 'asxasx'),
(776, 674, 1, 'asxasx'),
(777, 675, 1, 'asxasx'),
(779, 677, 1, 'asx'),
(780, 678, 1, 'asx'),
(781, 679, 1, 'asx'),
(782, 680, 1, 'asx'),
(783, 681, 1, 'asx'),
(784, 682, 1, 'asx'),
(785, 683, 1, 'asx'),
(786, 684, 1, 'asx'),
(787, 685, 1, 'asx'),
(788, 686, 1, 'asx'),
(793, 691, 1, 'Que gil que soy'),
(794, 692, 1, 'Que gil que soy');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`ID`, `Nombre`, `NombreUsuario`, `Contrasena`, `Email`, `Baneado`) VALUES
(1, 'Gonzalo García', 'snorkellingcactus', '38f448b51331bdedab93f9a15d2c1635eaf459a7 ', 'snorkellingcactus@gmail.com', b'0'),
(2, 'Emilio', 'emi', '90c8af8db7f253890139189d6e908e86ba25a676', NULL, b'0'),
(3, 'Cristina', 'cristina', '8cb2237d0679ca88db6464eac60da96345513964', NULL, b'0'),
(4, 'Vito', 'flavio', '90c8af8db7f253890139189d6e908e86ba25a676', NULL, b'0');

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
  ADD CONSTRAINT `Eventos_ibfk_1` FOREIGN KEY (`DescripcionID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Eventos_ibfk_2` FOREIGN KEY (`NombreID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Imagenes`
--
ALTER TABLE `Imagenes`
  ADD CONSTRAINT `Imagenes_ibfk_1` FOREIGN KEY (`TituloID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Imagenes_ibfk_2` FOREIGN KEY (`LenguajeID`) REFERENCES `Lenguajes` (`ID`),
  ADD CONSTRAINT `Imagenes_ibfk_3` FOREIGN KEY (`AltID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Menu`
--
ALTER TABLE `Menu`
  ADD CONSTRAINT `Menu_ibfk_1` FOREIGN KEY (`ContenidoID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Menu_ibfk_2` FOREIGN KEY (`SeccionID`) REFERENCES `Secciones` (`HTMLID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Modulos`
--
ALTER TABLE `Modulos`
  ADD CONSTRAINT `Modulos_ibfk_1` FOREIGN KEY (`PadreID`) REFERENCES `Modulos` (`ID`) ON DELETE CASCADE;

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
