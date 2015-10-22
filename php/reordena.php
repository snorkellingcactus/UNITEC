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
/*
		echo '<pre>Colección:';
		print_r($coleccion);
		echo '</pre>';

		echo '<pre>Lugar:';
		print_r($lugar);
		echo '</pre>';
*/
		$seleccionado=0;
		while(isset($coleccion[$seleccionado]) && $coleccion[$seleccionado][$discProp]!=$lugar)
		{
			++$seleccionado;
		}
		
		if(!isset($coleccion[0]))
		{
			//echo '<pre>Reordena: El número'.$seleccionado;echo ' no existe</pre>';
			return 0;
		}

		if($edita)
		{
			$actual=0;
			//echo '<pre>$discProp( '.$coleccion[$actual][$discProp].' ) == $valProp( '.$valProp.' )</pre>';
			while(isset($coleccion[$actual]) && $coleccion[$actual][$discProp]!=$valProp)
			{
				//echo '<pre>$discProp( '.$coleccion[$actual][$discProp].' ) == $valProp( '.$valProp.' )</pre>';
				++$actual;
			}
/*
			echo '<pre>Actual: '.$actual;
			echo '</pre>';
*/
			//La lista de valores posibles en el select comprende
			//todas las secciones EXEPTO la que está siendo editada,
			//lo que hace necesario convertir los índices ya que
			//$coleccion comprende TODAS las secciones.
			if($seleccionado>$actual)
			{
				--$seleccionado;
			}
/*
			echo '<pre>Seleccionado: '.$seleccionado;
			echo '</pre>';
*/
			$desde=$actual;
			$hasta=$seleccionado;

			if($actual==$seleccionado)
			{
				return $coleccion[$actual]['Prioridad'];
			}
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
			$j=$desde+1;
			$jMax=$hasta+1;
			$inc=-1;
		}
		else
		{
			$j=$hasta;
			$jMax=$desde;
			$inc=1;
		}
/*
		echo '<pre>Reordena: Se cambiará del número '.$j.' Al '.$jMax.' con '.$inc;
		echo '</pre>';
*/
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
					)+$inc
				).
				'	WHERE '.$discProp.'='.$coleccion[$j][$discProp]
			);

			++$j;
		}
		return $coleccion[$seleccionado]['Prioridad'];
	}
?>