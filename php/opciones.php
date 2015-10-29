<?php
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		global $con;

		function getOpcGrp($opcGrpID)
		{
			global $con;
			
			return fetch_all
			(
				$con->query
				(
					'	SELECT *
						FROM Opciones
						WHERE Grupo='.$opcGrpID
				),
				MYSQLI_ASSOC
			);
		}
		function getOpcGrpModulo($mID)
		{
			global $con;

			return fetch_all
			(
				$con->query
				(
					'	SELECT OpcGrpID, OpcSetsGrpID
						FROM Modulos
						WHERE ID='.fetch_all
						(
							$con->query
							(
								'	SELECT ModuloID
									FROM Secciones
									WHERE ID='.$mID.'
								'
							),
							MYSQLI_NUM
						)[0][0]
				),
				MYSQLI_NUM
			);
		}
		function newVal($opcID , $opcSetsGrpID , $valor)
		{
			global $con;
			
			echo '<pre>newVal:';
			print_r
			(
				'	INSERT INTO OpcSets
					(
						Grupo,
						Opcion,
						Valor
					)
					Values
					(
						'.$opcSetsGrpID.',
						'.$opcID.',
						'.$valor.'
					)
				'
			);
			echo '</pre>';

			$con->query
			(
				'	INSERT INTO OpcSets
					(
						Grupo,
						Opcion,
						Valor
					)
					Values
					(
						'.$opcSetsGrpID.',
						'.$opcID.',
						'.$valor.'
					)
				'
			);
		}
		function getVal($opcID , $opcSetsGrpID)
		{
			global $con;

			return fetch_all
			(
				$con->query
				(
					'	SELECT Valor 
						FROM OpcSets
						WHERE Opcion='.$opcID.'
						AND Grupo='.$opcSetsGrpID
				),
				MYSQLI_NUM
			);
		}
		function setVal($opcID , $opcSetsGrpID , $val)
		{
			global $con;
			echo '<pre>setVal:';
			print_r
			(
				'	UPDATE OpcSets
					SET Valor="'.$val.'"
					WHERE Opcion='.$opcID.'
					AND Grupo='.$opcSetsGrpID
			);
			echo '</pre>';

			$con->query
			(
				'	UPDATE OpcSets
					SET Valor="'.$val.'"
					WHERE Opcion='.$opcID.'
					AND Grupo='.$opcSetsGrpID
			);
		}
		function updVal($opcID , $opcSetsGrpID , $val)
		{
			if
			(
				isset
				(
					getVal
					(
						$opcID ,
						$opcSetsGrpID , 
						$val
					)[0][0]
				)
			)
			{
				setVal
				(
					$opcID ,
					$opcSetsGrpID , 
					$val
				);
			}
			else
			{
				newVal
				(
					$opcID ,
					$opcSetsGrpID , 
					$val
				);
			}
		}
/*
		function getVal($valorID)
		{
			global $con;

			return fetch_all
			(
				$con->query
				(
					'	SELECT Valor
						FROM OpcValores
						WHERE ID='.$valorID[0][0]
				),
				MYSQLI_NUM
			);
		}
*/
?>