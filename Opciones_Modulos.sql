--
-- Volcado de datos para la tabla `Modulos`
--
/*


*/

--
-- Volcado de datos para la tabla `OpcGrp`
--

INSERT INTO `OpcGrp` (`ID`, `Padre`) VALUES
(1, NULL),
(2, 1);

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


INSERT INTO `Contenidos` () VALUES();

INSERT INTO Traducciones ( `ContenidoID` , `LenguajeID` , `Texto` )

SELECT ID, 1 , "Elementos M&aacute;ximos"
FROM Contenidos
WHERE 1
ORDER BY ID DESC
LIMIT 1;

INSERT INTO `Opciones` (`ID`, `Nombre`, `Descripcion`, `NombreID`, `Grupo`, `ValGrp`, `Tipo`, `Min`, `Max`, `Predeterminado`)
SELECT 1, ID ,NULL, 'limit', 1, NULL, 1, '0', '50', '5'
FROM Contenidos
WHERE 1
ORDER BY ID DESC
LIMIT 1;




INSERT INTO `Contenidos` () VALUES();

INSERT INTO Traducciones ( `ContenidoID` , `LenguajeID` , `Texto` )

SELECT ID, 1 , "Vista"
FROM Contenidos
WHERE 1
ORDER BY ID DESC
LIMIT 1;
--
-- Volcado de datos para la tabla `Opciones`
--

INSERT INTO `Opciones` (`ID`, `Nombre`, `Descripcion`, `NombreID`, `Grupo`, `ValGrp`, `Tipo`, `Min`, `Max`, `Predeterminado`)

SELECT 2, ID, NULL, 'vista', 2, 1, 3, NULL, NULL, 'true'
FROM Contenidos
WHERE 1
ORDER BY ID DESC
LIMIT 1;

--
-- Volcado de datos para la tabla `OpcSetsGrp`
--

INSERT INTO `OpcSetsGrp` (`ID`) VALUES
(1),
(2),
(3),
(4),
(5);

--
-- Volcado de datos para la tabla `OpcSets`
--

INSERT INTO `OpcSets` (`ID`, `Valor`, `Opcion`, `Grupo`) VALUES
(2, '6', 1, 1),
(3, '12', 1, 2),
(4, 'true', 2, 2),
(5, '1', 1, 4),
(6, '2', 1, 5);

/*
	UPDATE Modulos
	SET Modulos.OpcSetsGrpID = 2
	WHERE Modulos.ID=1
*/



--
-- Volcado de datos para la tabla `OpcValores`
--

INSERT INTO `Contenidos` () VALUES();

INSERT INTO Traducciones ( `ContenidoID` , `LenguajeID` , `Texto` )

SELECT ID, 1 , "Anual"
FROM Contenidos
WHERE 1
ORDER BY ID DESC
LIMIT 1;

INSERT INTO `OpcValores` (`Nombre`, `ID`, `Valor`, `Grupo`)

SELECT ID, 1 , 'false', 1
FROM Contenidos
WHERE 1
ORDER BY ID DESC
LIMIT 1; 


INSERT INTO Traducciones ( `ContenidoID` , `LenguajeID` , `Texto` )

SELECT ID, 1 , "Mensual"
FROM Contenidos
WHERE 1
ORDER BY ID DESC
LIMIT 1;


INSERT INTO `Contenidos` () VALUES();

INSERT INTO `OpcValores` (`Nombre`, `ID`, `Valor`, `Grupo`)
SELECT ID, 2 , 'true', 1
FROM Contenidos
WHERE 1
ORDER BY ID DESC
LIMIT 1;

#DELETE FROM OpcSets WHERE 1;
#DELETE FROM Opciones WHERE 1;
#DELETE FROM OpcSetsGrp WHERE 1;
#DELETE FROM Opciones WHERE 1;
#DELETE FROM OpcValores WHERE 1;
#DELETE FROM OpcValGrp WHERE 1;
#DELETE FROM OpcGrp WHERE 1;
#DELETE FROM OpcTipos WHERE 1;


UPDATE `Modulos`
SET `OpcGrpID` = 1 , `OpcSetsGrpID` =  1 
WHERE `ID` = 1;

UPDATE `Modulos`
SET `OpcGrpID` = 2 , `OpcSetsGrpID` = 2  
WHERE `ID` = 8;

UPDATE `Modulos`
SET `OpcGrpID` = 1 , `OpcSetsGrpID` =   3
WHERE `ID` = 10;

UPDATE `Modulos`
SET `OpcGrpID` = 1 , `OpcSetsGrpID` =   4
WHERE `ID` = 12;

UPDATE `Modulos`
SET `OpcGrpID` = 1 , `OpcSetsGrpID` =   5
WHERE `ID` = 17;
