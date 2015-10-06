<?php
	function reordena($lugar , $sqlObj , $condicion , $discProp, $valProp ,$edita)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		global $con;

		$coleccion=fetch_all
		(
			$con->query
			(
				'	SELECT '.$discProp.', Prioridad
					FROM '.$sqlObj->table.' 
					WHERE '.$condicion.' 
					ORDER BY Prioridad ASC'
			)
			,
			MYSQLI_ASSOC
		);

		$seleccionado=0;
		while(isset($coleccion[$seleccionado]) && $coleccion[$seleccionado][$discProp]!=$lugar)
		{
			++$seleccionado;
		}

		if(!isset($coleccion[0]))
		{
			return 0;
		}

		if($edita)
		{
			$actual=0;
			while(isset($coleccion[$actual]) && $coleccion[$actual][$discProp]!=$valProp)
			{
				++$actual;
			}

			//La lista de valores posibles en el select comprende
			//todas las secciones EXEPTO la que está siendo editada,
			//lo que hace necesario convertir los índices ya que
			//$coleccion comprende TODAS las secciones.
			if($seleccionado>$actual)
			{
				--$seleccionado;
			}

			$con->query
			(
				'	UPDATE '.$sqlObj->table.
				'	SET Prioridad='.
				(
					intVal
					(
						$coleccion[$actual]['Prioridad']
					)
				).
				'	WHERE '.$discProp.'='.$coleccion[$seleccionado][$discProp]
			);

			return $coleccion[$seleccionado]['Prioridad'];
		}
		else
		{
			$hasta=count($coleccion);

			//Si es el último, retorno el máximo.
			if($lugar[0]==='b')
			{
				return intVal($coleccion[$hasta-1]['Prioridad'])+1;
			}
			else
			{
				$desde=$seleccionado;
			}
		}

		if($hasta>$desde)
		{
			$j=$desde;
			$jMax=$hasta;
		}
		else
		{
			$j=$hasta+1;
			$jMax=$desde;
		}

		//Hago un lugar para la nueva seccion desplazando sus siguientes una
		//posición más.
		while($j<$jMax)
		{
			$con->query
			(
				'	UPDATE '.$sqlObj->table.
				'	SET Prioridad='.
				(
					intVal
					(
						$coleccion[$j]['Prioridad']
					)+1
				).
				'	WHERE '.$discProp.'='.$coleccion[$j][$discProp]
			);

			++$j;
		}
		return $coleccion[$seleccionado]['Prioridad'];
	}
?>