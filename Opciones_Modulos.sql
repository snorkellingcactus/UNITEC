--
-- Volcado de datos para la tabla `Modulos`
--
/*

INSERT INTO `Modulos` (`ID`, `Nombre`, `Archivo`, `Descripcion`, `PadreID`, `OpcGrpID`, `OpcSetsGrpID`) VALUES
(1, 'Galeria', 'seccs/galeria.php', 'Una galería de fotos', NULL, 1, 1),
(2, NULL, '/seccs/galeria.css', NULL, 1, NULL, NULL),
(8, 'Calendario', 'seccs/calendario.php', NULL, NULL, 2, 2),
(9, NULL, '/seccs/calendario.css', NULL, 8, NULL, NULL),
(10, 'Atajos', 'seccs/atajos.php', NULL, NULL, 1, 3),
(12, 'Novedades', 'seccs/novedades.php', NULL, NULL, 1, 4),
(13, NULL, '/seccs/novedades.css', NULL, 12, NULL, NULL),
(17, 'Organigrama', 'seccs/organigrama.php', NULL, NULL, 1, 5),
(18, NULL, '/seccs/organigrama.css', NULL, 17, NULL, NULL),
(19, NULL, '/seccs/atajos.css', NULL, 10, NULL, NULL);

*/

--
-- Volcado de datos para la tabla `OpcGrp`
--

INSERT INTO `OpcGrp` (`ID`, `Padre`) VALUES
(1, NULL),
(2, 1);

#INSERT INTO `Contenidos` () VALUES()
#581
#INSERT INTO `Contenidos` () VALUES()
#582 

 INSERT INTO Traducciones ( `ContenidoID` , `LenguajeID` , `Texto` )
 VALUES ( 581 , 1  , 'Elementos M&aacute;ximos' );

 INSERT INTO Traducciones ( `ContenidoID` , `LenguajeID` , `Texto` )
 VALUES ( 582 , 1  , 'Vista' );
--
-- Volcado de datos para la tabla `Opciones`
--

INSERT INTO `Opciones` (`ID`, `Nombre`, `Descripcion`, `NombreID`, `Grupo`, `ValGrp`, `Tipo`, `Min`, `Max`, `Predeterminado`) VALUES
(1, 581, NULL, 'limit', 1, NULL, 1, '0', '50', '5'),
(2, 582, NULL, 'vista', 2, 1, 3, NULL, NULL, 'true');


--
-- Volcado de datos para la tabla `OpcSets`
--

INSERT INTO `OpcSets` (`ID`, `Valor`, `Opcion`, `Grupo`) VALUES
(2, '6', 1, 1),
(3, '12', 1, 2),
(4, 'true', 2, 2),
(5, '1', 1, 4),
(6, '2', 1, 5);

--
-- Volcado de datos para la tabla `OpcSetsGrp`
--

INSERT INTO `OpcSetsGrp` (`ID`) VALUES
(1),
(2),
(3),
(4),
(5);

/*
	UPDATE Modulos
	SET Modulos.OpcSetsGrpID = 2
	WHERE Modulos.ID=1
*/

--
-- Volcado de datos para la tabla `OpcTipos`
--

INSERT INTO `OpcTipos` (`ID`, `Tipo`) VALUES
(1, 1),
(2, 2),
(3, 3);


--
-- Volcado de datos para la tabla `OpcValGrp`
--

INSERT INTO `OpcValGrp` (`ID`) VALUES
(1);

--
-- Volcado de datos para la tabla `OpcValores`
--
#INSERT INTO `Contenidos` () VALUES()
#583
#INSERT INTO `Contenidos` () VALUES()
#584 
INSERT INTO Traducciones ( `ContenidoID` , `LenguajeID` , `Texto` )
VALUES ( 583 , 1  , 'Anual' );

INSERT INTO Traducciones ( `ContenidoID` , `LenguajeID` , `Texto` )
VALUES ( 584 , 1  , 'Mensual' );

INSERT INTO `OpcValores` (`Nombre`, `ID`, `Valor`, `Grupo`) VALUES
(583, 1, 'false', 1),
(584, 2, 'true', 1);
