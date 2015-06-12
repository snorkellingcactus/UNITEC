-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-06-2015 a las 16:31:21
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Comentarios`
--

INSERT INTO `Comentarios` (`ID`, `ContenidoID`, `RaizID`, `PadreID`, `Fecha`, `Baneado`, `Nombre`) VALUES
(34, 380, 329, 329, '2015-06-12 11:24:47', b'0', 'sdcsdc'),
(35, 381, 329, 380, '2015-06-12 11:26:21', b'0', 'asxasx'),
(36, 382, 331, 331, '2015-06-12 12:31:22', b'0', 'asxasx'),
(37, 383, 331, 382, '2015-06-12 12:31:26', b'0', 'asxasx'),
(38, 384, 329, 329, '2015-06-12 12:32:45', b'0', 'asxasx'),
(39, 391, 386, 386, '2015-06-12 16:12:55', b'0', 'asxasx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contenidos`
--

CREATE TABLE IF NOT EXISTS `Contenidos` (
  `ID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=392 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(309),
(310),
(311),
(312),
(317),
(318),
(319),
(320),
(321),
(324),
(325),
(326),
(328),
(329),
(330),
(331),
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
(375),
(376),
(379),
(380),
(381),
(382),
(383),
(384),
(385),
(386),
(388),
(389),
(390),
(391);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Eventos`
--

CREATE TABLE IF NOT EXISTS `Eventos` (
  `ID` int(11) NOT NULL,
  `Tiempo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NombreID` int(11) NOT NULL,
  `DescripcionID` int(11) DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT '1',
  `Prioridad` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Eventos`
--

INSERT INTO `Eventos` (`ID`, `Tiempo`, `NombreID`, `DescripcionID`, `Visible`, `Prioridad`) VALUES
(1, '2015-06-12 00:00:00', 390, 389, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imagenes`
--

CREATE TABLE IF NOT EXISTS `Imagenes` (
  `ID` int(11) NOT NULL,
  `Url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AltID` int(11) DEFAULT NULL,
  `TituloID` int(11) NOT NULL,
  `LenguajeID` int(11) DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT '1',
  `Prioridad` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Imagenes`
--

INSERT INTO `Imagenes` (`ID`, `Url`, `AltID`, `TituloID`, `LenguajeID`, `Visible`, `Prioridad`) VALUES
(51, 'http://localhost/Web/imgsEj/img00.jpg', 310, 309, NULL, 1, 10),
(52, 'http://localhost/Web/imgsEj/img02.jpg', 312, 311, NULL, 1, 0),
(53, 'http://1-ps.googleusercontent.com/hk/rerl60fiII0__khD3hloAXMYzk/www.muylinux.com/wp-content/uploads/2015/06/718x479xredhat.jpg.pagespeed.ic.-NMRul9szZ263Iha3BbA.jpg', 332, 331, NULL, 1, 0),
(54, 'http://localhost/Web/imgsEj/img04.jpg', 376, 375, NULL, 1, 0);

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
  `SeccionID` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Url` varchar(256) COLLATE utf8_unicode_ci DEFAULT '#',
  `Prioridad` int(11) DEFAULT NULL,
  `Visible` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Menu`
--

INSERT INTO `Menu` (`ID`, `ContenidoID`, `SeccionID`, `Url`, `Prioridad`, `Visible`) VALUES
(21, 326, 'Nueva', '#Nueva', NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(14, NULL, 'seccs/mapa.css', NULL, 11),
(15, 'Contacto', 'seccs/contacto.php', 'Un formulario de contacto.', NULL),
(16, NULL, 'seccs/contacto.css', NULL, 15);

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Novedades`
--

INSERT INTO `Novedades` (`ID`, `ImagenID`, `TituloID`, `DescripcionID`, `Fecha`, `Visible`, `Prioridad`) VALUES
(18, 52, 329, 328, '2015-06-12', 1, 1),
(20, 52, 386, 385, '2015-06-12', 1, 1);

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
  `HTMLID` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Visible` tinyint(1) DEFAULT NULL,
  `Prioridad` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=393 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Secciones`
--

INSERT INTO `Secciones` (`ID`, `ContenidoID`, `ModuloID`, `PadreID`, `HTMLID`, `Visible`, `Prioridad`) VALUES
(381, NULL, NULL, NULL, NULL, 1, 3),
(382, NULL, NULL, NULL, 'Seccion B', 1, 5),
(383, 324, NULL, 381, NULL, 1, 1),
(384, 325, NULL, 382, NULL, 1, 3),
(386, NULL, 8, 381, NULL, 1, 3),
(387, NULL, NULL, NULL, 'Nueva', 1, 6),
(388, NULL, 12, 382, NULL, 1, 5),
(389, 330, NULL, 387, NULL, 1, 1),
(390, NULL, 1, 387, NULL, 1, 2),
(391, NULL, NULL, NULL, NULL, 1, 7),
(392, NULL, 15, 391, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Traducciones`
--

CREATE TABLE IF NOT EXISTS `Traducciones` (
  `ID` int(11) NOT NULL,
  `ContenidoID` int(11) NOT NULL,
  `LenguajeID` int(11) NOT NULL,
  `Texto` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=461 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(216, 189, 3, 'Algo loco que hacer en espaÃ±ol'),
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
(367, 309, 1, 'Una Gibson SGb'),
(368, 310, 1, ''),
(369, 311, 1, 'Un piano con una florb'),
(370, 312, 1, ''),
(377, 317, 2, 'Hola'),
(378, 318, 2, 'asxasx'),
(379, 319, 2, 'asxasx'),
(380, 320, 2, 'asxasxggg'),
(381, 321, 2, 'Google'),
(384, 324, 2, '            [center][b][size=200]SectionA[/size][/b][/center]'),
(385, 325, 2, '      [center][size=200][b]SectionB1[/b][/size][/center]'),
(386, 326, 2, 'Nueva'),
(387, 324, 1, '               [center][b][size=200]Novedades[/size][/b][/center]'),
(390, 325, 1, '      [center][size=200][b]SeccionB[/b][/size][/center]   '),
(391, 328, 1, '         En este Ãºltimo aÃ±o tres de las mÃ¡s grandes distribuciones GNU/Linux profesionales se han puesto de acuerdo, entre otras cosas, en ofrecer a \r\nlos desarrolladores que las usan una vÃ­a accesible para conseguir [b]las herramientas de programaciÃ³n mÃ¡s demandadas[/b], por lo general, en la forma de repositorios adicionales.\r\nAsÃ­, Canonical presentÃ³ [url=http://www.muylinux.com/2014/12/12/ubuntu-developer-tools-center-ubuntu-make]Ubuntu Make[/url], SUSE sus colecciones, directamente imbuidas en la instalaciÃ³n de [url=http://www.muylinux.com/2014/10/27/suse-linux-enterprise-12-version-final]SUSE Enterprise Linux 12[/url]; y la compaÃ±Ã­a del sombre rojo hizo con [url=http://www.muylinux.com/2014/06/10/red-hat-enterprise-linux-7]RHEL 7[/url] lo propio introduciendo [b]Red Hat Software Collections[/b], cuya segunda versiÃ³n redonda acaba de ser anunciada unos dÃ­as atrÃ¡s.\r\nRed Hat Software Collections 2 incluye un buen conjunto de lenguajes de programaciÃ³n, bases de datos y otro tipo de herramientas orientas al \r\ndesarrollo entre las que cabe destacar Python 2.7, 3.3 y 3.4, PHP 5.6, \r\nRuby 2.2 y Rails 4.1, Node.js 0.10, MySQL 5.6.24, PostgreSQL 9.4.1, \r\nMariaDB 10.0.17 o MongoDB 2.6.9, ademÃ¡s de [b]aplicaciones con Docker[/b], que se estÃ¡n poniendo muy de moda por mÃ©ritos propios.\r\nToda la informaciÃ³n acerca de este lanzamiento y su contenido la podÃ©is encontrar en el [url=http://www.redhat.com/en/about/press-releases/red-hat-software-collections-2-delivers-latest-stable-open-tools-traditional-and-container-based-application-development]anuncio oficial[/url] de Red Hat.'),
(392, 329, 1, 'Disponible Red Hat Software Collections 2'),
(393, 330, 1, '[center][size=200][b]Galer&iacute;a de Im&aacute;genes\r\n[/b][/size][/center]   '),
(394, 331, 1, 'Logo RedHat'),
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
(440, 309, 2, 'Una Gibson SG'),
(441, 310, 2, ''),
(442, 375, 2, 'El piano'),
(443, 376, 2, 'Un piano'),
(446, 379, 1, 'asx'),
(447, 380, 1, 'sdcsdc'),
(448, 381, 1, 'asxasx'),
(449, 382, 1, 'asxasx'),
(450, 383, 1, 'asxasx'),
(451, 384, 1, 'asxasx'),
(452, 385, 1, '   sdcsdc'),
(453, 386, 1, 'sdcsdc'),
(455, 388, 1, 'Hola'),
(457, 388, 2, 'Hello'),
(458, 389, 1, 'Mundo'),
(459, 390, 1, 'Hola'),
(460, 391, 1, 'asxasx');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`ID`, `Nombre`, `NombreUsuario`, `Contrasena`, `Email`, `Baneado`) VALUES
(1, 'Gonzalo García', 'snorkellingcactus', '38f448b51331bdedab93f9a15d2c1635eaf459a7 ', 'snorkellingcactus@gmail.com', b'0'),
(2, 'emi', 'Emilio', '90c8af8db7f253890139189d6e908e86ba25a676', NULL, b'0'),
(3, 'cristina', 'Cristina', '8cb2237d0679ca88db6464eac60da96345513964', NULL, b'0'),
(4, 'flavio', 'Vito', '90c8af8db7f253890139189d6e908e86ba25a676', NULL, b'0');

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
  ADD KEY `Eventos_ibfk_1` (`DescripcionID`),
  ADD KEY `NombreID` (`NombreID`);

--
-- Indices de la tabla `Imagenes`
--
ALTER TABLE `Imagenes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `LenguajeID` (`LenguajeID`),
  ADD KEY `Imagenes_ibfk_1` (`TituloID`),
  ADD KEY `AltID` (`AltID`);

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
  ADD UNIQUE KEY `HTMLID` (`HTMLID`),
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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT de la tabla `Contenidos`
--
ALTER TABLE `Contenidos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=392;
--
-- AUTO_INCREMENT de la tabla `Eventos`
--
ALTER TABLE `Eventos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `Imagenes`
--
ALTER TABLE `Imagenes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT de la tabla `Lenguajes`
--
ALTER TABLE `Lenguajes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `Menu`
--
ALTER TABLE `Menu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `Modulos`
--
ALTER TABLE `Modulos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `Novedades`
--
ALTER TABLE `Novedades`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `Opciones`
--
ALTER TABLE `Opciones`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Secciones`
--
ALTER TABLE `Secciones`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=393;
--
-- AUTO_INCREMENT de la tabla `Traducciones`
--
ALTER TABLE `Traducciones`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=461;
--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
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
  ADD CONSTRAINT `Menu_ibfk_2` FOREIGN KEY (`SeccionID`) REFERENCES `Secciones` (`HTMLID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
