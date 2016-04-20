--
-- Base de datos: `edetec`
--

--
-- Estructura de tabla para la tabla `Contenidos`
--

CREATE TABLE IF NOT EXISTS `Contenidos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
);

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
  FOREIGN KEY (`RaizID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`ContenidoID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`PadreID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE
);

--
-- Estructura de tabla para la tabla `TagsGrp`
--

CREATE TABLE IF NOT EXISTS `TagsGrp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
);

--
-- Estructura de tabla para la tabla `Tags`
--

CREATE TABLE IF NOT EXISTS `Tags` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`NombreID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TagsTarget`
--

CREATE TABLE IF NOT EXISTS `TagsTarget` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TagID` int(11) DEFAULT NULL,
  `GrupoID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`TagID`) REFERENCES `Tags` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`GrupoID`) REFERENCES `TagsGrp` (`ID`)
);

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
  `TagsGrpID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`DescripcionID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`NombreID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`TagsGrpID`) REFERENCES `TagsGrp` (`ID`)
);

--
-- Estructura de tabla para la tabla `Laboratorios`
--

CREATE TABLE IF NOT EXISTS `Laboratorios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Latitud` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Longitud` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DireccionID` int(11) DEFAULT NULL,
  `Mail` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Telefono` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Facebook` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Twitter` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NombreID` int(11) NOT NULL,
  `TagID` int(11) NOT NULL,
  `Organigrama` tinyint(1) DEFAULT NULL,
  `Enlace` tinyint(1) DEFAULT NULL,
  `Color` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PadreID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`NombreID`) REFERENCES `Contenidos` (`ID`),
  FOREIGN KEY (`DireccionID`) REFERENCES `Contenidos` (`ID`),
  FOREIGN KEY (`TagID`) REFERENCES `Tags` (`ID`),
  FOREIGN KEY (`PadreID`) REFERENCES `Laboratorios` (`ID`)
);

--
-- Estructura de tabla para la tabla `PrioridadesGrp`
--

CREATE TABLE IF NOT EXISTS `PrioridadesGrp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
);

--
-- Estructura de tabla para la tabla `Prioridades`
--

CREATE TABLE IF NOT EXISTS `Prioridades` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `LabID` int(11) DEFAULT NULL,
  `Prioridad` int(11) DEFAULT NULL,
  `GrupoID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`GrupoID`) REFERENCES `PrioridadesGrp` (`ID`),
  FOREIGN KEY (`LabID`) REFERENCES `Laboratorios` (`ID`) ON DELETE CASCADE
);

--
-- Estructura de tabla para la tabla `Lenguajes`
--

CREATE TABLE IF NOT EXISTS `Lenguajes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `Pais` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
);

--
-- Estructura de tabla para la tabla `Imagenes`
--

CREATE TABLE IF NOT EXISTS `Imagenes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AltID` int(11) DEFAULT NULL,
  `TituloID` int(11) NOT NULL,
  `LenguajeID` int(11) DEFAULT NULL,
  `Fecha` datetime NOT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT '1',
  `PrioridadesGrpID` int(11) DEFAULT '1',
  `TagsGrpID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`TituloID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`LenguajeID`) REFERENCES `Lenguajes` (`ID`),
  FOREIGN KEY (`AltID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`TagsGrpID`) REFERENCES `TagsGrp` (`ID`),
  FOREIGN KEY (`PrioridadesGrpID`) REFERENCES `PrioridadesGrp` (`ID`)
);

--
-- Estructura de tabla para la tabla `OpcGrp`
--

CREATE TABLE IF NOT EXISTS `OpcGrp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Padre` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`Padre`) REFERENCES `OpcGrp` (`ID`) ON DELETE CASCADE
);

--
-- Estructura de tabla para la tabla `OpcValGrp`
--

CREATE TABLE IF NOT EXISTS `OpcValGrp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
);

--
-- Estructura de tabla para la tabla `OpcValores`
--

CREATE TABLE IF NOT EXISTS `OpcValores` (
  `Nombre` int(11) DEFAULT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Grupo` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`Grupo`) REFERENCES `OpcValGrp` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`Nombre`) REFERENCES `Contenidos` (`ID`)
);

--
-- Estructura de tabla para la tabla `OpcTipos`
--

CREATE TABLE IF NOT EXISTS `OpcTipos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` int(11) DEFAULT NULL UNIQUE,
  PRIMARY KEY (`ID`)
);

--
-- Estructura de tabla para la tabla `Opciones`
--

CREATE TABLE IF NOT EXISTS `Opciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` int(11) DEFAULT NULL,
  `Descripcion` int(11) DEFAULT NULL,
  `NombreID` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `Grupo` int(11) DEFAULT NULL,
  `ValGrp` int(11) DEFAULT NULL,
  `Tipo` int(11) DEFAULT NULL,
  `Min` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Max` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Predeterminado` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`Nombre`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`Descripcion`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`Grupo`) REFERENCES `OpcGrp` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`ValGrp`) REFERENCES `OpcValGrp` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`Tipo`) REFERENCES `OpcTipos` (`ID`) ON DELETE CASCADE
);

--
-- Estructura de tabla para la tabla `OpcSetsGrp`
--

CREATE TABLE IF NOT EXISTS `OpcSetsGrp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
);

--
-- Estructura de tabla para la tabla `OpcSets`
--

CREATE TABLE IF NOT EXISTS `OpcSets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Opcion` int(11) DEFAULT NULL,
  `Grupo` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`Opcion`) REFERENCES `Opciones` (`ID`),
  FOREIGN KEY (`Grupo`) REFERENCES `OpcSetsGrp` (`ID`) ON DELETE CASCADE
);

--
-- Estructura de tabla para la tabla `Modulos`
--

CREATE TABLE IF NOT EXISTS `Modulos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Archivo` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` text COLLATE utf8_unicode_ci,
  `PadreID` int(11) DEFAULT NULL,
  `OpcGrpID` int(11) DEFAULT NULL,
  `OpcSetsGrpID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`PadreID`) REFERENCES `Modulos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`OpcGrpID`) REFERENCES `OpcGrp` (`ID`) ON DELETE SET NULL,
  FOREIGN KEY (`OpcSetsGrpID`) REFERENCES `OpcSetsGrp` (`ID`)
);

--
-- Estructura de tabla para la tabla `Secciones`
--

CREATE TABLE IF NOT EXISTS `Secciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ContenidoID` int(11) DEFAULT NULL,
  `ModuloID` int(128) DEFAULT NULL,
  `PadreID` int(11) DEFAULT NULL,
  `HTMLID` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL UNIQUE,
  `Visible` tinyint(1) DEFAULT NULL,
  `PrioridadesGrpID` int(11) DEFAULT NULL,
  `OpcSetID` int(11) DEFAULT NULL,
  `TagsGrpID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`ContenidoID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`ModuloID`) REFERENCES `Modulos` (`ID`),
  FOREIGN KEY (`PadreID`) REFERENCES `Secciones` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`OpcSetID`) REFERENCES `OpcSets` (`ID`) ON UPDATE SET NULL,
  FOREIGN KEY (`TagsGrpID`) REFERENCES `TagsGrp` (`ID`),
  FOREIGN KEY (`PrioridadesGrpID`) REFERENCES `PrioridadesGrp` (`ID`)
);

--
-- Estructura de tabla para la tabla `Menu`
--

CREATE TABLE IF NOT EXISTS `Menu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ContenidoID` int(11) NOT NULL,
  `SeccionID` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Url` varchar(256) COLLATE utf8_unicode_ci DEFAULT '#',
  `Atajo` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL UNIQUE,
  `PrioridadesGrpID` int(11) DEFAULT NULL,
  `Visible` tinyint(1) DEFAULT NULL,
  `TagsGrpID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`ContenidoID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`SeccionID`) REFERENCES `Secciones` (`HTMLID`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`TagsGrpID`) REFERENCES `TagsGrp` (`ID`),
  FOREIGN KEY (`PrioridadesGrpID`) REFERENCES `PrioridadesGrp` (`ID`)
);

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
  `PrioridadesGrpID` int(11) DEFAULT '1',
  `TagsGrpID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`ImagenID`) REFERENCES `Imagenes` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`TituloID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`DescripcionID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`TagsGrpID`) REFERENCES `TagsGrp` (`ID`),
  FOREIGN KEY (`PrioridadesGrpID`) REFERENCES `PrioridadesGrp` (`ID`)
);

--
-- Estructura de tabla para la tabla `Traducciones`
--

CREATE TABLE IF NOT EXISTS `Traducciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ContenidoID` int(11) NOT NULL,
  `LenguajeID` int(11) NOT NULL,
  `Texto` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`ContenidoID`) REFERENCES `Contenidos` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`LenguajeID`) REFERENCES `Lenguajes` (`ID`)
);

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
);
