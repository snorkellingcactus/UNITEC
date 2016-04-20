--
-- Base de datos: `edetec`
--

--
-- Volcado de datos para la tabla `Lenguajes`
--

INSERT INTO `Lenguajes` (`ID`, `Nombre`, `Pais`) VALUES
(1, 'Español', 'es_AR'),
(2, 'English', 'en_US'),
(3, 'Rusia', 'ru_RU');

--
-- Volcado de datos para la tabla `Modulos`
--


INSERT INTO `Modulos` (`ID`, `Nombre`, `Archivo`, `Descripcion`, `PadreID`, `OpcGrpID`, `OpcSetsGrpID`) VALUES
(1, 'Galeria', 'Galeria', 'Una galería de fotos', NULL, NULL, NULL),
(2, NULL, '/seccs/galeria.css', NULL, 1, NULL, NULL),
(8, 'Calendario', 'Calendario', NULL, NULL, NULL, NULL),
(9, NULL, '/seccs/calendario.css', NULL, 8, NULL, NULL),
(10, 'Atajos', 'Atajos', NULL, NULL, NULL, NULL),
(12, 'Novedades', 'Novedades', NULL, NULL, NULL, NULL),
(13, NULL, '/seccs/novedades.css', NULL, 12, NULL, NULL),
(17, 'Organigrama', 'Organigrama', NULL, NULL, NULL, NULL),
(18, NULL, '/seccs/organigrama.css', NULL, 17, NULL, NULL),
(19, NULL, '/seccs/atajos.css', NULL, 10, NULL, NULL);

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`ID`, `Nombre`, `NombreUsuario`, `Contrasena`, `Email`, `Baneado`) VALUES
(1, 'Gonzalo García', 'snorkellingcactus', '38f448b51331bdedab93f9a15d2c1635eaf459a7 ', 'snorkellingcactus@gmail.com', b'0'),
(2, 'Emilio', 'emi', '90c8af8db7f253890139189d6e908e86ba25a676', NULL, b'0'),
(3, 'Cristina', 'cristina', '8cb2237d0679ca88db6464eac60da96345513964', NULL, b'0'),
(4, 'Vito', 'flavio', '90c8af8db7f253890139189d6e908e86ba25a676', NULL, b'0');